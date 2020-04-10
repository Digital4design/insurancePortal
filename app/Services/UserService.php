<?php

namespace App\Services;

class UserService
{
    public function handleUserLogin()
    {
        $API_URL = env('API_URL');
        $this->updateUserActivityTime();
        $this->updateUserLastSeen();
        // $this->callAPI($API_URL);
    }
    private function updateUserLastSeen()
    {
        $now = now();
        logger("User last seen { $now }");
    }
    private function updateUserActivityTime()
    {
        $now = now();
        logger("User last activity was at { $now }");
    }
    public function callAPI($requestURL)
    {
        $API_URL = env('API_URL');
        $realUrl = $API_URL . $requestURL;
        // dd($realUrl);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $realUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        
        return $response = json_decode($response, true); //because of true, it's in an array
    }
    public function user_info($requestURL)
    {
        $API_URL = env('API_URL');
        $realUrl = $API_URL . $requestURL;
        // dd($realUrl);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $realUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        // $now = now();
        // logger("user info { $now }  response { $response } ");
        return $response = json_decode($response, true); //because of true, it's in an array
    }
    public function user_data($requestURL)
    {
        $API_URL = env('API_URL');
        $realUrl = $API_URL . $requestURL;
        // dd($realUrl);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $realUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        // $now = now();
        // logger("user info { $now }  response { $response } ");
        return $response = json_decode($response, true); //because of true, it's in an array
    }
    public function postAPI($requestURL, $postData)
    {
        $API_URL = env('API_URL');
        $realUrl = $API_URL . $requestURL;
        // dd($postData);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $realUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response = json_decode($response, true); //because of true, it's in an array
    }

    public function getTrackerList($requestURL)
    {
        $API_URL = env('API_URL');
        $realUrl = $API_URL . $requestURL;
        // dd($realUrl);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $realUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        //dd($response);
        return $response = json_decode($response, true); //because of true, it's in an array

        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $realUrl,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         "cache-control: no-cache",
        //     ),
        // ));
        // $response = curl_exec($curl);
        // //dd($response);
        // return $response = json_decode($response, true);
    }
}
