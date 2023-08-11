<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Subscriber;
use Mail;
use App\Mail\EmailManager;

class notificationController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('push_token','!=','')->get();
       
        return view('backend.marketing.notifications.index', compact('users'));
    }

    public function send(Request $request)
    {
       define( 'API_ACCESS_KEY', 'AAAAIvUYmeI:APA91bEQ8wosGszXw2uRl2eFLNZCKnAktwnimOV7wDdh6ASt6MLzSdTIyDR2PACQqiQ2GrY_tQvSe-ZYwuhhDLl3PstJD_H10oasy-TUIQJuNedu-0JWrknnNqpro224gY8O3aRqZPnQ');
	$allTokens = array();

				foreach($request->user_tokens as $token){
					if(!empty($token)){
						$allTokens[] =$token; 
										}	
				}
            //sends newsletter to selected users
        	if ($request->has('user_tokens')) {
               
             

                    try {
					   $msg = array( 
						'body'         =>strip_tags($request->content),
						'content_available'       => true,
						'priority'       => "high",
						"title"       => $request->subject,
						"action" => 'FLUTTER_NOTIFICATION_CLICK',
						'sound' => 'assets/sounds/sound.mp3',
						'alert'=> true,
						'largeIcon' => 'large_icon',
						'smallIcon' => 'small_icon',
						 'vibrate' => 300, 		
			);

			$msg2 = array( 
					 		'body'         =>strip_tags($request->content),
						'content_available'       => true,
						'priority'       => "high",
						"title"       => $request->subject,
						"action" => 'FLUTTER_NOTIFICATION_CLICK',
						'sound' => 'assets/sounds/sound.mp3',
						'alert'=> true,
						'largeIcon' => 'large_icon',
						'smallIcon' => 'small_icon',
						 'vibrate' => 300, 
			
			);
			$fields = array(
				'registration_ids'  => $allTokens,  
				'notification'              => $msg,
				
			  "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
			  "priority"=> "high",
			  "collapse_key"=> "type_a",
				'data'              => $msg2,
			);
			$headers = array(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
			$result="none";
			if(!empty($allTokens)){
				$ch = curl_init();
				curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
				curl_setopt( $ch,CURLOPT_POST, true );
				curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
				curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
				$result = curl_exec($ch );
				curl_close( $ch );
			//	echo $result;
		//exit;
			}
                    } catch (\Exception $e) {
                     //  echo $e;
					  
                    }
            	
            }

      
       
       

    	flash(translate('Notification has been send'))->success();
		
    	return redirect()->route('admin.dashboard');
    }

    public function testEmail(Request $request){
        $array['view'] = 'emails.newsletter';
        $array['subject'] = "SMTP Test";
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = "This is a test email.";

        try {
            Mail::to($request->email)->queue(new EmailManager($array));
        } catch (\Exception $e) {
            dd($e);
        }

        flash(translate('An email has been sent.'))->success();
        return back();
    }
	

}
