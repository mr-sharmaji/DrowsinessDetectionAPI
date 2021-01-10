<?php

header('content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $arr_data = array();
    $myFile = "heartRateData.json";
    try {
        $jsondata = file_get_contents($myFile);
        $arr_data = json_decode($jsondata, true);
        echo json_encode($arr_data);
    } catch (Exception $e) {
        echo json_encode("Caught exception");
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $arr_data = array();
    $myFile = "heartRateData.json";
    $t=time();
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $formdata = array(
            'heartRate' =>  $data['heartRate'],
        );
        $jsondata = file_get_contents($myFile);
        $arr_data = json_decode($jsondata, true);
        array_push($arr_data, $formdata);
        $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
        if (file_put_contents($myFile, $jsondata)) {
            echo json_encode(array('data'=>"Data Successfully Added"));
        } else
            echo json_encode(array('data'=>"ERROR"));

    } catch (Exception $e) {
        echo json_encode("Caught exception");
    }
}
