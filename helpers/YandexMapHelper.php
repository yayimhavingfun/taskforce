<?php

namespace app\helpers;

use Yandex\Geo\Api;
use Yandex\Geo\Exception;

class YandexMapHelper
{
    /**
     * @var Api
     */
    private $api_client;

    /**
     * YandexMapHelper constructor
     * @param $key;
     */
    public function __construct($key)
    {
        $this->api_client = new Api();
        $this->api_client->setToken($key);
    }

    public function getCoordinates($city, $location)
    {
        $result = [];
        $query = $city . ',' . $location;

        try {
            $this->api_client->setQuery($query);
            $this->api_client->load();

            $response = $this->api_client->getResponse();
            $results = $response->getList();

            if ($results) {
                $geo_obj = $results[0];
                $result = [$geo_obj->getLatitude(), $geo_obj->getLongitude()];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }

        return $result;
    }
}