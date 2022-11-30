<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"),true);

        // Check the API credentials
        if($data["userName"]=="Rick" && $data["passWord"]=="MTC_Portal") {
            if($data["appVersion"] != null) {
                // Read the app version file
                $response = file_get_contents("../../response/version.json") or die("Unable to get the JSON file content!");
                // Decode the JSON
                $responseArray = json_decode($response,true);
                // Update the app version
                $responseArray["data"]["appVersion"] = $data["appVersion"];
                // Calculate the present day Date
                $presentDate = date("m-d-Y h:i:sA");
                $responseArray["data"]["lastUpdate"] = $presentDate;
                // Encode the Array
                $response = json_encode($responseArray);
                // Update the app version file
                file_put_contents("../../response/version.json", $response);
                // Read the app version file
                $response = file_get_contents("../../response/version.json") or die("Unable to get the JSON file content!");
                echo $response;
            }
            else {
                // Read the error file
                $response = file_get_contents("../../response/400.json") or die("Unable to get the JSON file content!");
                echo $response;
            }
        }
        else{
            // Read the error file
            $response = file_get_contents("../../response/401.json") or die("Unable to get the JSON file content!");
            echo $response;
        }
    }
    else {
        // Read the error file
        $response = file_get_contents("../../response/405.json") or die("Unable to get the JSON file content!");
        echo $response;
    }
?>