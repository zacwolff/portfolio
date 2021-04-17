<?php
ini_set('display_error', 1);
include './includes/const.php';
include './includes/fxns.php';
include './includes/db/mailerModel.php';
@$action = empty($_GET['action']) ? 'default' : $_GET['action'];


switch($action){
    case "sendmsg":
        
        if(IS_AJAX){
            echo "Ajax triggered";

            return json_response("Message sent");
        }

        
        
    break;

    default:
        echo "No command";
    break;
}