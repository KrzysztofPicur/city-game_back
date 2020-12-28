<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    //
    public function handle(Request $request)
    {

        $lat = 51.20683375317316;
        $lon = 16.15732937698249;

        $client = new \GuzzleHttp\Client();
        //$response = $client->request('GET', 'https://app.geocodeapi.io/api/v1/reverse?point.lat=51.20683375317316&point.lon=16.15732937698249&apikey=1d600dc0-486f-11eb-8945-3122e896ed18');
        $response = $client->request('GET', 'https://app.geocodeapi.io/api/v1/reverse?point.lat='.$lat.'&point.lon='.$lon.'&apikey=1d600dc0-486f-11eb-8945-3122e896ed18');

        $jsonArray = json_decode($response->getBody()->getContents(), true);

        $venues = $jsonArray['features'][0]['properties'];

        //print_r($venues["street"]);

        $street = $venues["street"];

        return $street;




    }
}
