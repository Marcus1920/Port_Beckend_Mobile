<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\UserNew;

class UserCController extends Controller
{

    private $user;


    public function __construct(User $user)
    {

        $this->user = $user;

    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }
   public function logout()
   {
  $response = array();
  $api_key   =  \Input::get('api_key');
  $cell     = \Input::get('cell');



    $idi   = UserNew::select('id')->where('api_key','=',$api_key)->first();
    $idi->id  ;
    if($api_key != null && $api_key != "null")

      {

 		  $data    = UserNew::find($idi->id)->first();

          $data->active  =  2 ;
          $data->save() ;
          $response ['msg'] = "You Have Successfully Logged out";
 				   return \Response::json($response ,200);
 			}
 				 else
 				{
      $response ['msg'] = "You Have Successfully Logged out";
 			return \Response::json($data ,200);
 				}
}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(User $user, Request $request)
    {

        $response   = array();
        $cell       = \Input::get('cell');
        $password   = \Input::get('password');
        $email      = \Input::get('email');
        $firstName  = \Input::get('firstName');
        $name       = \Input::get('name');
        $ID         = \Input::get('ID');
        $result     = User::where('cellphone','=',$cell)->first();


        if (sizeof($result) > 0)
        {
            $response["error"]   = TRUE;
            $response["message"] = "Sorry, this user already exists";
        }
        else {

            $newUser             = new User();
         //   $newUser->surname      = $firstname;
            $newUser->name      = $name;
            $newUser->email      = $email;
            $newUser->password   = $password;
            $newUser->id_number   = $ID;
            $newUser->cellphone      = $cell;
            $newUser->api_user   = 1;
            $newUser->star_user  = 1;
            $newUser->Status     = 'Active';
            $newUser->api_key    = uniqid();
            $newUser->save();
            $response["error"]   = FALSE;
            $response["message"] = "You are successfully registered";

        }

         return \Response::json($response);

    }

	public  function  jslogin (){

	//	$login    =  User::all();
	$login    = User::select('id','cellphone', 'password', 'api_key')->get();
		 return \Response::json($login);

	}

    public function login(User $user, Request $request)
    {


         $response = array();
         $cell     = \Input::get('cell');
         $password = \Input::get('password');
		 $token     = \Input::get('token');
         $data     = UserNew::where('cellphone','=',$cell)->first();
         $device   = \Request::header('User-Agent');




         if (sizeof($data) > 0 ) {

            $key = $data->api_key;


         }
         else {

            $key = "no key";
         }


         if (sizeof($data) > 0 )
         {
            $response["error"]     = false;
            $response['name']      = $data->name;
            $response['cell_no']   = $data->cellphone;
            $response['apiKey']    = $data->api_key;
            $response['api_key']   = $key;
			$response['token']   = $token;
            $response['createdAt'] = $data->created_at;

            \Log::info("Login Device:".$device.", User Cell:".$cell.", User Names:".$data->name);

         }
         else {

            $response['error']   = true;
            $response['message'] = 'Login failed. Incorrect credentials';


         }

         return \Response::json($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function forgot(User $user)
    {

         $response = array();
         $cell     = \Input::get('cell');
         $password = \Input::get('password');
         \Log::info('Password Change: User '.$cell ."New Password".$password );
         $userNew  = UserNew::where('cellphone','=',$cell)->first();


         if (sizeof($userNew) > 0)
         {

            $userNew->password   = \Hash::make($password);
            $userNew->save();
            $response["error"]   = false;
            $response["message"] = "You have successfully changed your password";

         }
         else {
              $response["error"]   = true;
              $response["message"] = "Sorry, you have not registered yet";
         }

          return \Response::json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
