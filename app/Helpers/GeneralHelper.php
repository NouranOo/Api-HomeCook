<?php 
namespace App\Helpers;

use App\Models\User;
use App\Models\Notfication;
use Carbon\Carbon;
// use Sichikawa\LaravelSendgridDriver\SendGrid;
class GeneralHelper
{
    protected static $currentUser;

    public static function SetCurrentUser($apitoken)
    {
        self::$currentUser = User::where('ApiToken', $apitoken)->first();
        // self::$currentUser->last_active= Carbon::parse(Carbon::now())->diffForHumans();
        self::$currentUser->save();

    }

    public static function getcurrentUser()
    {
        // self::$currentUser->last_active= Carbon::parse(Carbon::now())->diffForHumans() ;
        self::$currentUser->save();

        return self::$currentUser;
    }
    public static  function SetNotfication($title,$body,$model,$User_id,$notify_target_id,$type)
    {
        $Notfiy = new Notfication();
        $Notfiy->Title=$title;
        $Notfiy->Body=$body;
        $Notfiy->User_id=$User_id;
        $Notfiy->notify_target_id=$notify_target_id;
        $Notfiy->Type=$type;
        $Notfiy->Seen=0;
        $Notfiy->save();         
    }
    public static function verifyEmail($user){
        require '../vendor/autoload.php';
        // dd(new \SendGrid\Mail\Mail());
        $email = new \SendGrid\Mail\Mail(); 
        
        $email->setFrom("anouran888@gmail.com", "Home Cook App");
        $email->setSubject("Welcome to Home Cook Registerarion");
        $email->addTo($user->Email,$user->UserName);
        $email->addContent("text/plain", " Let's Verify Your Email");
        
         
        $email->addContent(
            "text/html",  view('mail')->with('user',$user)->render()
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
      
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
    public static function testSendGrid($user){
        require '../vendor/autoload.php';
        $APP_KEY = "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";
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("anouran888@gmail.com", "Home Cook");
        $email->setSubject("Welcome to Home Cook Registerarion");
        $email->addTo($user->Email,$user->UserName);
        $email->addContent("text/plain", "Let's verify your mail");
        $email->addContent(
            "text/html",view('mail')->with('user',$user)->render()
        );
        $sendgrid = new \SendGrid(getenv($APP_KEY));
        try {
            $response = $sendgrid->send($email);
            if($sendgrid->send($email)){
                echo "Email sent successfuly";
            }
            // $response = $sendgrid->send($email);
            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
    
 public static function RecoveryEmail($user){

        require '../vendor/autoload.php';
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("anouran888@gmail.com", "Home Cook App");
        $email->setSubject("Welcome to Home Cook Registerarion");
        $email->addTo($user->Email,$user->UserName);
        $email->addContent("text/plain", " Let's Verify Your Email");
        
         
        $email->addContent(
            "text/html",  view('mailRecovery')->with('user',$user)->render()
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
      
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
            }
        

}