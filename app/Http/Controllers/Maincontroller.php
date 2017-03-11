<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input as Input;
use Mail;


class Maincontroller extends Controller
{

    /**
     function   to  send  email   to  serve
     */
    public  function  Sendemail(Request $request) {

        $name   =     $request->get('name');
        $email  =     $request->get('email');
        $phone  =     $request->get('phone');
        $message  =   $request->get('message');



        $input = $request->all();
        Mail::send([], ['input' => $input],function($message) use ($input)
        {

            $message->to('greg@connectumedia.co.za');
            $message->subject('Client Details');
            $message->from('greg@connectumedia.co.za');
            $message->setBody('Name :'.$input['name'] ."\r\n".
                'Email  :'.$input['email']."\r\n".
                'Phone :'.$input['phone']."\r\n".
                'Message :'.$input['message']."\r\n"


            );
        });




        return redirect('contactus')->with('status', 'Your  Request was  successfully submitted ');
    }
}
