<?php

function connectToDBandGetPDOdb(){
$pdo = new PDO("mysql:host:localhost;dbname=projet", "root", "root");
$return $pdo;
}

?>
