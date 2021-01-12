<?php

header('content-type: application/json');
$con = pg_connect("host=ec2-54-144-196-35.compute-1.amazonaws.com port=5432 dbname=d1k8si0lv5fivd user=wsdkrljactirnp password=a4e7f74aa4c59e000467c2e0ca8db14a1fc13a801b57f43f3839cd5bc32ea362") or die ("Could not connect to server\n");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $arr_data = array();
    try {
        $query = "Select * from time LIMIT 10;";
        $result = pg_query($con, $query) or die("Cannot execute query: $query\n");
        while ($row = pg_fetch_row($result)) {
            array_push($arr_data, ["id" => $row[0] ,"time" => $row[1]]);
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
        $dataTime = $data['time'];
        $query = "INSERT INTO time(created_on) values ('$dataTime');";
        $result = pq_query($con, $query);
        if ($result) {
            echo json_encode(array('data'=>"Data Successfully Added"));
        } else
            echo json_encode(array('data'=>"Error!"));

    } catch (Exception $e) {
        echo json_encode(array('data'=>"Something Went Wrong!"));
    }
    pg_close($con);
}
