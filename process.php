<?php

if(!empty($_POST["send"])) {
	$name = $_POST["userName"];
    $email = $_POST["userEmail"];
    $phone = $_POST["userPhone"];
	$subject = $_POST["subject"];
	$message = $_POST["message"];
	$toEmail = "admin@zacwolff.com";
	$mailHeaders = "From: " . $name . "<". $email .">\r\n";
	if(mail($toEmail, $subject, $content, $mailHeaders)) {
	    $message = "Your contact information is received successfully.";
	    $type = "success";
	}
}
require_once "contact-view.php";
?>