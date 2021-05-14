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

$action = empty($_GET['action']) ? 'default' : $_GET['action'];

if(!$_POST){ echo json_response("Forbidden", 403); die();}
if(!IS_AJAX){ echo json_response("Forbidden", 403); die();}

switch($action){
    case "sendmsg":
        $Log = new Log;
        $MailerModel = new Mailer;

            $info = $_POST;
           

            //Setting Up PHPMailer
            $mail = new PHPMailer();
            //$mail->SMTPDebug = 3; //Uncomment to debug in browser console
            $mail->isSMTP();
            $mail->Host = $config['mailer']['outgoing'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['mailer']['user']; 
            $mail->Password = $config['mailer']['pass']; 
            //$mail->SMTPSecure = 'tls';
            $mail->Port = $config['mailer']['smtp_out'];
            $mail->isHTML(true);

            $mail->setFrom($info['email'], $info['name']);
            $mail->addReplyTo($info['email'], $info['name']);
            $mail->addAddress($config['mailer']['from']);
            $mail->Subject = $info['subject'];
            $mail->Body = $info['message'];

            if($mail->send()){

                $MailerModel->email = $info['email'];
                $MailerModel->name = $info['name'];
                $MailerModel->phone = $info['phone'];

                if(isset($info['subscribed']) && $info['subscribed']== 'on')
                {$MailerModel->subscribed = '1';}
                else
                {$MailerModel->subscribed = '0';}

                    $sub = $MailerModel->query("SELECT email, id FROM subscriptions WHERE email = '$info[email]'");
                    if(isset($sub[0])){
                        $MailerModel->save($sub[0]['id']);
                }else{
                $MailerModel->create();
                }
                
                //Send feed back to user mail
                $mail->setFrom($config['mailer']['from'], $config['mailer']['name']);
            	$mail->addReplyTo($config['mailer']['reply'], $config['mailer']['name']);
            	$mail->addAddress($info['email']);
            	$mail->Subject = $config['messages']['success'];
            	$mail->Body = "Your mail has been recieved. You will be contaced shortly";
            	//$mail->send()

                $response = $config['messages']['success'];
                $code = 200;
            }else{
                $response = $config['messages']['error'];
                $code = 422;
                $Log->write('Mailer Error: ' . $mail->ErrorInfo);
            }
  
            echo json_response($response, $code);
    break;

    default:
        echo "No command";
    break;
}