<?php

header('content-type: application/json');
$con = pg_connect("host=ec2-54-144-196-35.compute-1.amazonaws.com port=5432 dbname=d1k8si0lv5fivd user=wsdkrljactirnp password=a4e7f74aa4c59e000467c2e0ca8db14a1fc13a801b57f43f3839cd5bc32ea362") or die ("Could not connect to server\n");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $arr_data = array();
    try {
        $query = "Select * from heartrate ORDER BY id DESC LIMIT 10;";
        $result = pg_query($con, $query) or die("Cannot execute query: $query\n");
        while ($row = pg_fetch_row($result)) {
            $a = array(
                "id" => $row[0],
                "heartRate" => $row[1]
            );
            array_push($arr_data, $a);
          }
        echo json_encode($arr_data);
    } catch (Exception $e) {
        echo json_encode(array('data'=>"Something Went Wrong!"));
    }
    pg_close($con);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $arr_data = array();
    $data = json_decode(file_get_contents('php://input'), true);
    try {
        $dataHeartRate = $data['heartRate'];
        $query = "INSERT INTO heartrate(created_on) values ('$dataHeartRate');";
        $result = pg_query($con, $query);
        if ($result) {
            echo json_encode(array('data'=>"Data Successfully Added"));
        } else
            echo json_encode(array('data'=>"Something Went Wrong!"));

    } catch (Exception $e) {
        echo json_encode(array('data'=>"Something Went Wrong!"));
    }
    pg_close($con);
}
