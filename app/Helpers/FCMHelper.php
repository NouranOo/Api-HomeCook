<?php


namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FCMHelper
{


    /* Example Parameter

        $data = array(
                    'from'=>'Lhe.io',
                    'title'=>'FCM Push Notifications',
                     "body" => "This is a Firebase Cloud Messaging Topic Message!"

         );

        $target = 'single token id or topic name';
        or
        $target = array('token1','token2','...'); // up to 1000 in one request for group sending
    */

    public static function  sendFCMMessage($data, $target)
    {
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';

        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key

        $server_key =
            'AAAA084BsL0:APA91bHhJwimb3BovecpJVquSo_arAgSenM1qeAR9ju0B3WTw4fInrWJWdGTSdJxf1gtnTPVUCDYAm7Psc3puS2SGRSzThwUtEiMeJkjiGi0pEDe24s05fsPh3Hd0D7F-dsX_4SZcmFR';
        $fields = array();
        $fields['notification'] = $data;

        if (is_array($target)) {
            $fields['registration_ids'] = $target;
        } else {
            $fields['to'] = $target;
        }
       $fields['priority']="high";
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='. $server_key
        );

        //CURL request to route notification to FCM connection server (provided by Google)

         $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        $response=json_decode( $result,true);
        return  $response;



   /*  $client = new Client([
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'key='.$server_key,
        ]
    ]);
    $response = $client->post('https://fcm.googleapis.com/fcm/send',
        ['body' => json_encode($fields)]
    );
    dd( $response);


   return   $response->getBody() ; */
}



}
