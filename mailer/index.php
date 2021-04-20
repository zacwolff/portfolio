<?php
ini_set('display_error', 1);
include './includes/const.php';
include './includes/fxns.php';
include './includes/settings.php';
include './includes/db/easyCRUD/mailerModel.php';

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



include 'vendor/autoload.php';

@$action = empty($_GET['action']) ? 'default' : $_GET['action'];


switch($action){
    case "sendmsg":
        $Log = new Log;
        $MailerModel = new Mailer;

        if($_POST){
            $info = $_POST;
           

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

                $MailerModel->email = $info['email'];
                $MailerModel->name = $info['name'];
                $MailerModel->phone = $info['phone'];
                
                if(isset($info['subscribed']) && $info['subscribed']== 'on')
                {$MailerModel->subscribed = '1';}

                    $sub = $MailerModel->query("SELECT email, id FROM subscriptions WHERE email = '$info[email]'");
                    if(isset($sub[0])){
                        $MailerModel->save($sub[0]['id']);
                }else{
                        $MailerModel->create();
                    }

                $response = $config['messages']['success'];
                $code = 200;
            }else{
                $response = $config['messages']['error'];
                $code = 422;
                $Log->write('Mailer Error: ' . $mail->ErrorInfo);
            }
            
        }
        
        if(IS_AJAX){
            echo json_response($response, $code);
            return;
        }

    

       
        
    break;

    default:
        echo "No command";
    break;
}