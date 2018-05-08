<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/text", true);


$Input_From_Python =  $_POST['Input_From_Python'];

echo $Input_From_Python;


?>