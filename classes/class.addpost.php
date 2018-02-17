<?php
/**
* 
*/
class Addpost extends Database {
	
	function __construct($title, $content, $tags, $email) {
		
		parent::__construct();
		$date=Datemanager::prefDate();
		$db = $this->insert(array("title" => "$title",
			"content" => "$content",
			"tags" => "$tags",
			"date" => "$date",
			"email" => "$email"), "posts");

	}

}