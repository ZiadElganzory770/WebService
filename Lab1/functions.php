<?php


function get_cities(){
        ini_set('memory_limit', '-1');
        $string = file_get_contents(__JSON_FILE__);
        $json_cities = json_decode($string, true);
        $cities = []; 
        foreach ($json_cities as $city) {
            if ($city['country'] === "EG") {
            
                $cities[] = array(
                    $city['id']=>$city['name']
                );
            }
        }

    return $cities;
}


function get_weather(){
     $information=[];
    if(isset($_POST["submit"])){
        $city_id = $_POST["city"];
        $api_URL = __API_URL__. $city_id ."&appid=".__API_KEY__;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_URL,$api_URL);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response,true);  
        return $data;
    }


}



?>