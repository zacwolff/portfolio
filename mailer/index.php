<?php
ini_set('display_error', 1);
include './includes/const.php';
include './includes/fxns.php';
include './includes/db/mailerModel.php';

include 'vendor/autoload.php';

@$action = empty($_GET['action']) ? 'default' : $_GET['action'];


switch($action){
    case "sendmsg":

        if($_POST){
            $info = $_POST;
            print_r($info);
        }
        
        if(IS_AJAX){
            echo json_response("Message sent");
        }

       
        
    break;

    default:
        echo "No command";
    break;
}