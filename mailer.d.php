<?php
include './includes/const.php';
include './includes/db/mailerModel.php';
$action = empty($_GET['action']) ? $_GET['action'] : 'default';


echo $action;