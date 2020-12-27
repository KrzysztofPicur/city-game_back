<?php

namespace App\Classes;

class Retriving_street {



    function setLocal($latitude, $longitude) {

        $street = null;
        $response = null;

        $client = new \GuzzleHttp\Client;

        $response = $client->request('GET', 'https://app.geocodeapi.io/api/v1/reverse?point.lat='.$latitude.'&point.lon='.$longitude.'&apikey=1d600dc0-486f-11eb-8945-3122e896ed18');

        $jsonArray = json_decode($response->getBody()->getContents(), true);

        $venues = $jsonArray['features'][0]['properties'];

        $this->street = $venues["street"];

    }

    function getStreet() {
        return $this->street;
    }
}



