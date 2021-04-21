<?php
$config = 
    //mailer config 
    [
        'mailer'=>[
            'host' => '',
            'from' => 'studio@zacwolff.com',
            'name' => 'Zac Wolff',
            'reply' => 'studio@zacwolff.com',
            'incoming' => 'zacwolff.com',
            'outgoing' => 'zacwolff.com',
            'smtp_in' => 993,
            'smtp_out' => 465,
            'pop' => 995,
            'user' => 'admin@zacwolff.com',
            'pass' => ''
        ],

        'messages' => [
            'success' => "Your message has been successfully sent.",
            'error' => "Sorry a problem occured. Please try again later"
        ]
     ];