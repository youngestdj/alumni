<?php

define("BASE_URL", 'http://localhost/alumni');
define("ACCESS_LEVEL", "ALL");

function __autoload($class) {

	include_once("classes/class.{$class}.php");

}

?>