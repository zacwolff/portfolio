<?php
ini_set('display_error', 1);
include './includes/const.php';
include './includes/fxns.php';
include './includes/settings.php';

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include './includes/db/mailerModel.php';



include 'vendor/autoload.php';

@$action = empty($_GET['action']) ? 'default' : $_GET['action'];


switch($action){
    case "sendmsg":

        if($_POST){
            $info = $_POST;
            print_r($info);
            print_r($config['mailer']);

            //Setting Up PHPMailer
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.outlook.com';
            $mail->SMTPAuth = true;
            $mail->Username = ''; 
            $mail->Password = ''; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;
            $mail->isHTML(true);

            $mail->setFrom($config['mailer']['from'], $config['mailer']['name']);
            $mail->addReplyTo($config['mailer']['reply'], $config['mailer']['name']);
            $mail->addAddress($info['email']);
            $mail->Subject = $info['subject'];
            $mail->Body = $info['message'];

            if($mail->send()){
                echo 'Message has been sent';
            }else{
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
            
        }
        
        if(IS_AJAX){
            return json_response("Message sent");
        }

       
        
    break;

    default:
        echo "No command";
    break;
}