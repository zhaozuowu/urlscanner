<?php
/**
 * Created by PhpStorm.
 * User: zhaozuowu
 * Date: 2018/12/29
 * Time: 下午12:56
 */

namespace Stephen\UrlScanner\Url;


use GuzzleHttp\Client;

class Scanner
{
    /**
     * @var Client
     */
    private $client;
    private $ruls;

    public function __construct(Client $client, $ruls)
    {
        $this->client = $client;

        $this->ruls = $ruls;
    }

    /**
     * @param $url
     * @return int
     */
    public function getStatusCodeFormUrl($url)
    {
        $httpResponse = $this->client->get($url);
        return $httpResponse->getStatusCode();
    }

    /**
     * @return array
     */
    public function getInvalidateUrl()
    {
        $invlidateUrl = [];

        foreach ($this->ruls as $url) {

            try {
                $statusCode = $this->getStatusCodeFormUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
                array_push($invlidateUrl, ['url' => $url, 'statusCode' => $statusCode]);
            }
        }

        return $invlidateUrl;
    }

}