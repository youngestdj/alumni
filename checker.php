<?php

include('config.php');

$db=new Database();

$query = "CREATE table users(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
email VARCHAR(60),
date VARCHAR(100),
password VARCHAR(100),
firstname VARCHAR(20),
lastname VARCHAR(20),
gender VARCHAR(20),
activation_key VARCHAR(100),
class_of VARCHAR(4),
location VARCHAR(30)
)";
$create = $db->pdo->prepare($query);
$create->execute();


?>