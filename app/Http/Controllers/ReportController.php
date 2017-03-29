<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Report;
//use App\DepartmentCategory;
//use App\Department;
//use App\DepartmentSubCategory;
//use App\DepartmentSubSubCategory;
use App\Department;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\User;
use DB;
use App\Allocate_mobs;
use App\CaseReport;
use App\CaseResponder;
use App\CaseOwner;
use App\CasePriority;
use App\CaseStatus;
use App\UserNew;
use DateTime;
use App\CaseNote ;
use  App\CaseActivity;
use  App\Student_pancak_books;
use  App\CaseEscalator ;

use App\UserReportdetails;

class ReportController extends Controller
{


    private $report;


    public function __construct(Report $report)
    {

        $this->report = $report;

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $reports  = $this->report->get();

        return $reports;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */


	 public  function   closeIncidentmobile(){
		 $response = array  () ;
		 $ID_id   = \Input::get('ID_id');

		 $api_key   = \Input::get('api_key');

		 if($api_key){

			  $userNew = UserNew::where('api_key','=',$api_key)->first();

             if(sizeof($userNew) > 0) {

		      $closeincident           = CaseReport::where('id' ,'=',$ID_id)->first();
		      $closeincident ->Status  =  3;
		  $closeincident ->save () ;
		  $response['message'] = 'Incident close';
          $response['case_id']=$closeincident->id;
		   $response['status']=$closeincident->Status;
          $response['error']   = false; // error must be false here otherwise consumer might think there was some error
          return \Response::json($response,200);

			 }
		 }

		 else  {
	     $response['message'] = 'No key  found ';
         $response['error']   = true; // error must be false here otherwise consumer might think there was some error
         return \Response::json($response,200);

		 }

	 }



// Function for resizing jpg, gif, or png image files
public function ak_img_resize($target, $newcopy, $w, $h, $ext)
{ list($w_orig, $h_orig) = getimagesize($target); $scale_ratio = $w_orig / $h_orig; if (($w / $h) > $scale_ratio) { $w = $h * $scale_ratio; } else { $h = $w / $scale_ratio; } $img = ""; $ext = strtolower($ext); if ($ext == "gif"){ $img = imagecreatefromgif($target); } else if($ext =="png"){ $img = imagecreatefrompng($target); } else { $img = imagecreatefromjpeg($target); } $tci = imagecreatetruecolor($w, $h); // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig); imagejpeg($tci, $newcopy, 80); }


public function  CaseReportjs(){
	$cases =  CaseReport::all()   ;
	//$cases    = CaseReport::select('id','nuberof_person_involve', 'name_person_involve', 'color','surname_person_involve','phone_person_involve' ,'email_person_involve' , 'description' , 'gps_lat','gps_lng' ,'img_url','category','sub_category','sub_sub_category','name_pain','cell_pain','addressHotel_pain','numberOfpeople_pain')->get();

	 return \Response::json($cases,201);

}

public function  CaseReportjss(){


	   $myReports = \DB::table('cases')
                ->leftjoin('departments', 'cases.department', '=', 'departments.id')
                ->join('categories', 'cases.category', '=', 'categories.id')
                ->join('sub_categories', 'cases.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
                //->join('cases_priorities', 'cases.priority', '=', 'cases_priorities.id')
                ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')
                ->join('users', 'cases.user', '=', 'users.id')
              //  ->where('cases.user','=',$user->id)
                ->select(\DB::raw("cases.id ,cases.description ,cases.user ,cases.department,
				       cases.province ,cases.ref_no,cases.district,cases.municipality,cases.ward ,cases_statuses.id as status ,cases_statuses.name as status,
			cases.addressbook,cases.reporter,cases.severity,cases.busy,cases.accepted_at,cases.referred_at  ,
			cases.escalated_at,cases.source,cases.location,cases.gps_lat,cases.gps_lng ,

	cases.resolved_at ,cases.closed_at,cases.active,cases.created_at,cases.updated_at,cases.gps_lng ,cases.gps_lng ,cases.img_url
 ,cases.agent,cases.house_holder_id,cases.case_type,cases.case_sub_type,cases.saps_case_number,
 cases.client_reference_number ,cases.allocated_at  ,cases.email_person_involve ,cases.actiontaken , cases.nuberof_person_involve ,
	cases.name_person_involve,cases.phone_person_involve,cases.cell_pain,cases.incident_date_time,cases.color,cases.img_url,
categories.name as category, categories.id as category_id,`sub_categories`.name as sub_category,
`sub_categories`.id as sub_category_id, `sub_sub_categories`.name as sub_sub_category,
`sub_sub_categories`.id as sub_sub_category_id ,cases.name_pain,cases.addressHotel_pain,cases.numberOfpeople_pain,cases.incident_date_time,cases.cases_type"))
               ->get();
				 return \Response::json($myReports,201);



}


    public function store(Report $report, Request $request)
    {


        \Log::info("Request ".$request);

         \Log::info("Request ".$request);
         $category         = \Input::get('category');
         \Log::info('GET Category ' .$category);
         $sub_category     = \Input::get('sub_category');
         \Log::info('GET Sub Category ' .$sub_category);
         $sub_sub_category = \Input::get('sub_sub_category');
         \Log::info('GET Sub Sub Category ' .$sub_sub_category);
         $sub_sub_category = (empty($sub_sub_category))? " " : $sub_sub_category;
         $description      = \Input::get('description');
         \Log::info('Get Description :'.$description);
         $description      = (empty($description))? " " : $description;
         $gps_lat          = \Input::get('gps_lat');
         \Log::info('GPS Lat :' .$gps_lat);
         $gps_lng          = \Input::get('gps_lng');
         \Log::info('GPS Lng :' .$gps_lng);
         $user_email       = \Input::get('user_email');
         \Log::info('Email :' .$user_email);
         $priority         = \Input::get('priorities');
         $priority         = (empty($priority))? 1 : $priority;
         \Log::info('Priority :' .$priority);
         $headers          = apache_request_headers();
         $response         = array();

        \Log::info("Request ".$request);
        if (count($_FILES) > 0) {

            $files = $_FILES['img'];
            $name  = uniqid('img-'.date('Ymd').'-');
            $temp  = explode(".",$files['name']);
            $name  = $name . '.'.end($temp);


            if (file_exists("uploads/".$name))
            {
                echo $_FILES["img"]["name"]."already exists. ";
            }
            else
            {

                $img_url      = "uploads/".$name;
                $target_file  = "uploads/$name";
                $resized_file = "uploads/$name";
                $wmax         = 600;
                $hmax         = 480;
                $fileExt      = 'jpg';

                if(move_uploaded_file($_FILES["img"]["tmp_name"],$img_url))
                {

                     $this->ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);

                }

            }
        }


       $img_url = isset($img_url)? $img_url : "uploads/noimage.png";


        if (isset($headers['api_key'])) {


              $userNew = UserNew::where('api_key','=',$headers['api_key'])->first();

             if(sizeof($userNew) > 0) {


                 $objCat                           = Category::where('name','=',$category)->first();
                 \Log::info('Category Object :'.$objCat);

                 $objSubCat                        = SubCategory::where('name','=',$sub_category)->first();
                 $SubCatName                       = (sizeof($objSubCat) > 0)? $objSubCat->name : "";

                 if(strlen($sub_sub_category) > 1) {

                     $objSubSubCat =SubSubCategory::where('name','=',$sub_sub_category)->first();
                     $objSubSub    = $objSubSubCat->id;

                 }
                 else {

                     $objSubSubCat = 0;
                     $objSubSub    = 0;
                 }

                 $objPriority            = CasePriority::where('name','=',$priority)->first();
                 $priority               = (sizeof($objPriority) == 0)? 1 : $objPriority->id;

                 $case                   = New CaseReport();
                 $case->description      = $description;
                 $case->user             = $userNew->id;
                 $case->reporter         = $userNew->id;
                 $case->department       = $objCat->department;
                 $case->category         = $objCat->id;
                // $case->sub_category     = $objSubCat->id;
                // $case->sub_sub_category = $objSubSub;
                 $case->province         = $userNew->province;
                 $case->district         = $userNew->district;
                 $case->municipality     = $userNew->municipality;
                 $case->ward             = $userNew->ward;
                 $case->area             = $userNew->area;
                 $case->priority         = $priority;
                 $case->status           = 1; //Pending
                 $case->gps_lat          = $gps_lat;
                 $case->img_url          = $img_url;
                 $case->gps_lng          = $gps_lng;
                 $case->source           = 2; //Mobile
                 $case->save();

                 $caseOwner              = new CaseOwner();
                 $caseOwner->user        = $userNew->id;
                 $caseOwner->case_id     = $case->id;
                 $caseOwner->type        = 0;
                 $caseOwner->active      = 1;
                 $caseOwner->save();

                 $response["message"]          = "Report created successfully";
                 $response['error']            = FALSE;

                $data = array(

                    'name'      =>$userNew->name,
                    'caseID'    =>$case->id,
                    'caseDesc'  =>$case->description
                );

          /**      \Mail::send('emails.sms',$data, function($message) use ($userNew) {

                    $message->from('info@Ensky.net', 'Ensky');
                    $message->to($userNew->email)->subject("Ensky Notification - New Case Reported:");

                });**/






                if (is_object($objSubSubCat)) {

                    $firstRespondersObj  = CaseResponder::where("sub_sub_category",'=',$objSubSubCat->id)
                                                ->select('first_responder')->first();

                    if (sizeof($firstRespondersObj) > 0) {


                        $case->status      = 1;
                        $case->referred_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                        $case->save();

                        $firstResponders  = explode(",",$firstRespondersObj->first_responder);

                        if($firstRespondersObj->first_responder > 0) {

                            foreach ($firstResponders as $firstResponder) {


                                $firstResponderUser = UserNew::find($firstResponder);
                                $caseOwner          = new CaseOwner();
                                $caseOwner->user    = $firstResponder ;
                                $caseOwner->case_id = $case->id;
                                $caseOwner->type    = 1;
                                $caseOwner->active  = 1;
                                $caseOwner->save();

                                 $data = array(
                                        'name'   =>$firstResponderUser->name,
                                        'caseID' =>$case->id,
                                        'caseDesc' => $case->description,
                                        'caseReporter' => $case->description,
                                    );

                             /*   \Mail::send('emails.responder',$data, function($message) use ($firstResponderUser) {

                                    $message->from('info@redfrogs.net', 'Redfrogs');
                                    $message->to($firstResponderUser->email)->subject("Redfrogs Notification - New Case Reported:");

                                });
*/
                                $cellphone = $firstResponderUser->email;

                               /* \Mail::send('emails.caseEscalatedSMS',$data, function($message) use ($cellphone)
                                {
                                    $message->from('redfrogs.net', 'redfrogs');
                                    $message->to('cooluma@siyaleader.net')->subject("REFER: $cellphone" );

                                });*/



                            }


                        }
                    }

                }






                if (sizeof($objSubCat) > 0 && $objSubSubCat == "") {



                     $allObjSubCats  = SubCategory::where('name','=',$sub_category)->get();
                     \Log::info(sizeof($allObjSubCats));
                     \Log::info($allObjSubCats);


                     foreach ($allObjSubCats as $value) {


                        $firstRespondersObj  = CaseResponder::where("sub_category",'=',$value->id)
                                                ->select('first_responder')->first();

                        if (sizeof($firstRespondersObj) > 0) {

                            $case->status = 1;
                            $case->referred_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                            $case->save();

                            $firstResponders  = explode(",",$firstRespondersObj->first_responder);

                            if($firstRespondersObj->first_responder > 0) {

                                foreach ($firstResponders as $firstResponder) {


                                        $firstResponderUser = UserNew::find($firstResponder);
                                        $caseOwner          = new CaseOwner();
                                        $caseOwner->user    = $firstResponder ;
                                        $caseOwner->case_id = $case->id;
                                        $caseOwner->type    = 1;
                                        $caseOwner->active  = 1;
                                        $caseOwner->save();

                                         $data = array(
                                                'name'          =>$firstResponderUser->name,
                                                'caseID'        =>$case->id,
                                                'caseDesc'      =>$case->description,
                                                'caseReporter'  =>$case->description,
                                            );

                                     /*   \Mail::send('emails.responder',$data, function($message) use ($firstResponderUser) {
                                            $message->from('info@ecin.net', 'Ecin');
                                            $message->to($firstResponderUser->email)->subject("Ecin Notification - New Case Reported:");

                                        });*/

                                        $cellphone = $firstResponderUser->cellphone;

                                    /*   \Mail::send('emails.caseEscalatedSMS',$data, function($message) use ($cellphone)
                                        {
                                            $message->from('info@ecin.net', 'Ecin');
                                            $message->to('cooluma@ecin.net')->subject("REFER: $cellphone" );

                                        });*/

                                }



                            }
                        }


                    }


                }

                return \Response::json($response,201);
             }

             else
             {

                $response['message'] = 'Access Denied. Ensure that all fields are correctly filled in';
                $response['error']   = TRUE;
                return \Response::json($response,401);

             }

        }
        else
        {
             $response['message'] = 'Access Denied. Invalid Api key';
             $response['error']   = TRUE;
             return \Response::json($response,401);
        }

    }

    /**
     * Accept Cases that  have  been  allocate  to user  .
     *
     * @param   string    api_key
     * @param   int       id
     * @return Response "ok" stuatus  200
     */

	 public  function   Acceptedcases  () {

        		 $case_id   =    \Input::get('id');
        		 $api_key   =   \Input::get('api_key');
        		 $id   = CaseReport::select('id')->where('id','=',$case_id )->first();
        	   $cases  =  CaseReport::where('id','=',$case_id )->first();
             $cases->status = 4 ;
             $cases->save() ;

        		 return  "ok" ;

	 }


	  // dicline    case   from   mobile
	 public  function   Declinsecase  ()
   {
     $case_id_id   =    \Input::get('id');

     $case_id   =  intval($case_id_id) ;


		    $api_key   =   \Input::get('api_key');
		    $id   = CaseReport::select('id')->where('id','=',$case_id )->first();

   		  $cases  =  CaseReport::where('id','=',$case_id )->first();
        $cases->status = 1 ;
        $cases->save() ;
        $CaseEscalator  =   CaseEscalator::where('id' , '=' ,$case_id )->first() ;
		     $CaseEscalator->delete() ;
		     return  "ok" ;
	 }




	 //request   closoer  of   the  case

	 public   function    requestcloser  (){



	     $response   =  array()  ;
	     $api_key      = \Input::get('api_key');
         $case_id      = \Input::get('id');

		 $not     = \Input::get('note');




	  if ( $not==null){

		  $use_id  = UserNew::select('id')->where('api_key','=',$api_key)->first();
		  $cases  =  CaseReport::where('id','=',$case_id )->first();

          $cases->status = 3 ;
          $cases->save() ;


		  return "ok" ;

	  } else {
          $use_id  = UserNew::select('id')->where('api_key','=',$api_key)->first();
		  $cases  =  CaseReport::where('id','=',$case_id )->first();

          $cases->status = 3 ;
          $cases->save() ;





        $caseOwners = CaseOwner::where('case_id','=',$use_id->id)->get();
        $author     = User::find($use_id->id);

        $caseNote         = new CaseNote();
        $caseNote->note   = $not  ;
        $caseNote->user   =  $use_id->id;
        $caseNote->case_id = $case_id;
        $caseNote->save();

        $caseActivity              = New CaseActivity();
        $caseActivity->case_id     =$case_id;
        $caseActivity->user        = $use_id->id;
        $caseActivity->addressbook = 0;
        $caseActivity->note        = "New Case Noted Added by ".$author->name ." ".$author->surname;
        $caseActivity->save();



        foreach ($caseOwners as $caseOwner) {

            $user = User::find($caseOwner->user);

            $data = array(
                            'name'     => $user->name,
                            'caseID'   => $case_id,
                            'caseNote' => $not ,
                            'author'   => $author->name .' '.$author->surname
                        );

            \Mail::send('casenotes.email',$data, function($message) use ($user)
            {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($user->email)->subject("Siyaleader Notification - New Case Note: ");

            });

        }

		$response['msg'] = "case  secefully  update";

	    return \Response::json($response,201);

		  }



		// return  "ok" ;


}

	 // update  case  from  mobile   test
public   function   updatecasemobile  (){



	     $response   =  array()  ;
	     $api_key      = \Input::get('api_key');
         $case_id      = \Input::get('id');

		 $not   =    \Input::get('note');

          $use_id  = UserNew::select('id')->where('api_key','=',$api_key)->first();
	     $cases  =  CaseReport::where('id','=',$case_id )->first();
          $cases->status = 4 ;
         $cases->save() ;





        $caseOwners = CaseOwner::where('case_id','=',$use_id->id)->get();
        $author     = User::find($use_id->id);

        $caseNote         = new CaseNote();
        $caseNote->note   = $not  ;
        $caseNote->user   =  $use_id->id;
        $caseNote->case_id = $case_id;
        $caseNote->save();

        $caseActivity              = New CaseActivity();
        $caseActivity->case_id     =$case_id;
        $caseActivity->user        = $use_id->id;
        $caseActivity->addressbook = 0;
        $caseActivity->note        = "New Case Noted Added by ".$author->name ." ".$author->surname;
        $caseActivity->save();



        foreach ($caseOwners as $caseOwner) {

            $user = User::find($caseOwner->user);

            $data = array(
                            'name'     => $user->name,
                            'caseID'   => $case_id,
                            'caseNote' => $not ,
                            'author'   => $author->name .' '.$author->surname
                        );

            \Mail::send('casenotes.email',$data, function($message) use ($user)
            {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($user->email)->subject("Siyaleader Notification - New Case Note: ");

            });

        }

		$response['msg'] = "case  secefully  update";

	    return \Response::json($response,201);
}



	 public  function   Allocatercase (Request   $request){

		   $response = array();
		  \Log::info("api_key".$request);
		   $headers          = apache_request_headers();
       $api_key     =  \Input::get('api_key');
       if ($api_key )
       {

          $user  = UserNew::where('api_key','=',$api_key )->first();
          $to_id    =  \DB::table('cases_escalations')
      	 ->select('to')
      	 ->where('to','=',$user->id)->first();


           if(sizeof( $user ) > 0)
             {
                 $myReports = \DB::table('cases_escalations')
                ->join('categories', 'cases_escalations.category', '=', 'categories.id')
                ->join('sub_categories', 'cases_escalations.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases_escalations.status', '=', 'cases_statuses.id')
                ->join('departments', 'cases_escalations.department', '=', 'departments.id')
              //  ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')
                ->where('cases_escalations.to','=',$user->id )
                ->select(\DB::raw("
        				cases_escalations.id,
        				cases_escalations.case_id,
        				cases_escalations.created_at,
        				departments.name as department ,
        			  categories.name as category,
        				sub_categories.name as sub_category,
        				cases_escalations.description,
        				cases_statuses.name as status
				       ")) ->get();

                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,201);
		   	 }
		  }
	 }




	      public function  Referecases(Report $report)
    {
         $response = array();
         $api_key         = \Input::get('api_key');
        if ($api_key )
        {

         $user  = UserNew::where('api_key','=',$api_key )->first();
			   $user  = User::where('api_key','=',$api_key )->first();
         if(sizeof($user) > 0)
           {
           $myReports = \DB::table('cases_activities')
          ->join('categories', 'cases_activities.category', '=', 'categories.id')
          ->join('sub_categories', 'cases_activities.sub_category', '=', 'sub_categories.id')
          ->join('cases_statuses', 'cases_activities.status', '=', 'cases_statuses.id')
          ->join('departments', 'cases_activities.department', '=', 'departments.id')
			    ->where('to','=',$user->id)
          ->select(\DB::raw("
            				cases_activities.case_id,
            				cases_activities.id,
            				cases_activities.to,
            				cases_activities.created_at,
            				cases_statuses.name as status,
            				categories.name as category,
            				sub_categories.name as sub_category,
            				departments.name as department,
            				cases_activities.description
                 "))  ->get();

                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,201);
             }
             else
              {


				         $msg  = array () ;
                 $response = $msg ;
                return \Response::json($response,401);
             }
        }
        else
            {
                $response['message'] = 'Access Denied. Invalid Api key';
                $response['error']   = TRUE;
                return \Response::json($response,401);
            }
    }





	 public function  Getallusers(Report $report)
    {
        $myReports = \DB::table('users')
        ->select(\DB::raw("
      				users.id,
      				users.name,
      				users.surname,
      				users.email,
      				users.cellphone
				"))  ->get();

                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,201);
    }




	     public function  Pendingcases(Report $report)
    {

             $response = array();
            $api_key         = \Input::get('api_key');

            if ($api_key ) {
             $user  = UserNew::where('api_key','=',$api_key )->first();
             if(sizeof($user) > 0)
             {
              $myReports = \DB::table('cases')

               ->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
                ->join('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
                ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
               ->join('departments', 'cases.department', '=', 'departments.id')
              //  ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')
                ->join('users', 'cases.user', '=', 'users.id')
                ->where('cases.user','=',$user->id)
		        		->where('cases.status','=',1)
                ->select(\DB::raw("
        				cases.id,
        				cases.created_at,
        				cases_statuses.name as status,
        				departments.name as department,
        				cases_types.name as category,
        				cases_sub_types.name as sub_category,
        				cases.description
			        	"))->get();
                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,201);
             }
             else {

                $response['message'] = 'Access Denied. Invalid Api key';;
                $response['error']   = TRUE;
                return \Response::json($response,401);
             }
        }
        else
        {
            $response['message'] = 'Access Denied. Invalid Api key';;
            $response['error']   = TRUE;
            return \Response::json($response,401);
        }
    }





    public function myReport(Report $report , Request $request)
    {

         $response = array();



		  \Log::info("api_key".$request);
           $api_key         = \Input::get('api_key');
          $user_id     = UserNew::where('api_key' , '=' , $api_key )->first();

           $status ;

        if ($api_key) {


         if ($status=7 && $status=1){

           $user    = UserNew::where('api_key' , '=' ,$api_key )->first();

	///	  $user->id);
		 // dd($user->id);


             if(sizeof($user) > 0)
             {



                 $myReports = \DB::table('cases')

                ->join('categories', 'cases.category', '=', 'categories.id')
            //    ->join('sub_categories', 'cases.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
                ->join('cases_priorities', 'cases.priority', '=', 'cases_priorities.id')
              //  ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')
                ->join('users', 'cases.user', '=', 'users.id')
                ->where('cases.user','=',$user->id)
			//	->where('cases.status','=',1)


          ->select(\DB::raw("
        cases.id ,
        cases.created_at ,
				cases_statuses.name as status,
				cases.description,

				cases.img_url,
        cases_priorities.name  as  priority ,
				categories.name as category


				"))
               ->groupBy('cases.created_at')->get();







                $response["error"]   = FALSE;
                $response["reports"] = $myReports;


				//$response["alloctereports"] = $AllocateReports;

			//	AllocateReports
                return \Response::json($response,200);

			 }
          }  elseif($status=7){


			if(sizeof($user) > 0)
             {

                 $myReports = \DB::table('cases')
                ->leftjoin('departments', 'cases.department', '=', 'departments.id')
                ->join('categories', 'cases.category', '=', 'categories.id')
                ->join('sub_categories', 'cases.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
                //->join('cases_priorities', 'cases.priority', '=', 'cases_priorities.id')
                ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')
                ->join('users', 'cases.user', '=', 'users.id')
                ->where('cases.user','=',$user->id)
		        		->where('cases.status', '=' ,7)
                ->select(\DB::raw("cases.id ,cases_statuses.name as status,cases.description,cases.location,cases.gps_lat ,cases.gps_lng ,cases.actiontaken , cases.nuberof_person_involve ,cases.name_person_involve,cases.surname_person_involve ,cases.phone_person_involve,cases.email_person_involve,cases.incident_date_time,cases.img_url,categories.name as category, categories.id as category_id,`sub_categories`.name as sub_category,  `sub_categories`.id as sub_category_id, `sub_sub_categories`.name as sub_sub_category,`sub_sub_categories`.id as sub_sub_category_id"))
               ->groupBy('cases.created_at')->get();

                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,200);

			 }
		  }
             else {

                $response['message'] = 'Access Denied. Invalid Api key';;
                $response['error']   = TRUE;
                return \Response::json($response,401);
             }
        }
        else
        {
            $response['message'] = 'Access Denied. Invalid Api keyss';;
            $response['error']   = TRUE;
            return \Response::json($response,401);
        }



    }
	
	
// Function for resizing jpg, gif, or png image files



 public function saveReportImage()
    {
       

         

		  $name            = \Input::get('name');
		  $email           = \Input::get('email');
		  $cellphone       = \Input::get('cellphone');
		  $duedate         = \Input::get('duedate');
		  $duetime         = \Input::get('duetime');
		  $etimatdate      = \Input::get('etimatdate');
		  $etimatime       = \Input::get('etimatime');
		  $depart          = \Input::get('depart');
		  $cat             = \Input::get('cat');
		  $to             = \Input::get('to');
		  $subcat          = \Input::get('subcat');
		  $message         = \Input::get('message');
		  $description     = \Input::get('description');
		 $headers          = apache_request_headers();
         $response         = array();
         $files            = $_FILES['img'];
         
		  
            if (count($_FILES) > 0) {

            $files = $_FILES['img'];
            $name  = uniqid('img-'.date('Ymd').'-');
            $temp  = explode(".",$files['name']);
            $name  = $name . '.'.end($temp);


            if (file_exists("uploads/".$name))
            {
                echo $_FILES["img"]["name"]."already exists. ";
            }
            else
            {

                $img_url      = "uploads/".$name;
                $target_file  = "uploads/$name";
                $resized_file = "uploads/$name";
                $wmax         = 600;
                $hmax         = 480;
                $fileExt      = 'jpg';

                if(move_uploaded_file($_FILES["img"]["tmp_name"],$img_url))
                {

                     $this->ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);

                }

            }
        }


       $img_url = isset($img_url)? $img_url : "uploads/noimage.png";
		 // $idi   = UserNew::select('id')->where('api_key','=',$api_key)->first();
		  
         $idi = UserNew::where('api_key','=',$headers['api_key_new'])->first();

          $idi->id  ;
		 
		$dueDate					 =  $duedate;
		
		$department_internal		 = $depart;
		$category_internal			 = $cat;
		$sub_category				 =   $subcat;
		
	
	//	$sub_sub_category     		 = $request['sub_sub_category'];
		$estimatedDate   			 =  $etimatdate;
		$estimateTime 					= $etimatime  ;
		
		$dep_internal = Department::where('name','=',$department_internal)->first();
		$cat_internal = Category::where('name','=',$category_internal)->first();
	    $sub_cat_internal = SubCategory::where('name','=',$sub_category)->first();
		
	    $dep_id;
		$cat_id;
		$sub_cat_id;
		
		if($dep_internal == null){
			$dep_id = 0;
		}else{
			$dep_id = $dep_internal->id;
		}
		
		if($cat_internal == null){
			$cat_id = 0;
		}else{
			$cat_id = $cat_internal->id;
		}
		
		if($sub_cat_internal == null){
			$sub_cat_id = 0;
		}else{
			$sub_cat_id = $sub_cat_internal->id;
		}
		// $sub_cat = \DB::table('sub_categories')->where('name','=',$sub_category)->first();
            
		//$sub_sub_cat = Department::where('name','=',$sub_sub_category)->first();
		 
                $newCase                        = New CaseReport();
                $newCase->created_at            = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                $newCase->user                  = $idi->id;
                $newCase->reporter              = $idi->id;
                $newCase->img_url               = $img_url;
                $newCase->description           = $description ;
				$newCase->department			=  $dep_id;
				$newCase->category				= $cat_id;
				$newCase->sub_category		    = $sub_cat_id;
		        $newCase->case_type             = $sub_cat_id;
               
                $newCase->due_date              =  $duedate ;
           
                $newCase->investigation_officer =  $name ;
                $newCase->investigation_cell    =  $cellphone ;
                $newCase->investigation_email   =  $email; 
                $newCase->investigation_note    =  $message ;
  
                $newCase->status          = 4;
                $newCase->addressbook     = 0;
                $newCase->source          = 2; //Mobile
                $newCase->active          = 1;
               
                $newCase->save();
				
				
				
					/*-------------------------------------------------------------*/
				$caseEscalationObj          = New CaseEscalator();
				$caseEscalationObj->case_id =$newCase->id;
				$caseEscalationObj->from    = $idi->id;
				$caseEscalationObj->to      = $to; 
				//$caseEscalationObj->type    = $type;
				$caseEscalationObj->message =$message;
				$caseEscalationObj->due_date = $dueDate ;
				$caseEscalationObj->title    = "Case ID: " .$newCase->id;
				$caseEscalationObj->start    = date("Y-m-d");
				$caseEscalationObj->end      = $dueDate;
				$caseEscalationObj->color    = "#4caf50";
			
				
			
				
			    $caseEscalationObj->created_at              = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                $caseEscalationObj->user                    = $idi->id;
                $caseEscalationObj->reporter                = $idi->id;
               
                $caseEscalationObj->description             = $description ;
				$caseEscalationObj->department		        =  $dep_id;
				$caseEscalationObj->category				= $cat_id;
				$caseEscalationObj->sub_category		    = $sub_cat_id;
		        $caseEscalationObj->case_type               = $sub_cat_id;
               
                $caseEscalationObj->due_date                 =  $duedate ;
           
                $caseEscalationObj->investigation_officer    =  $name ;
                $caseEscalationObj->investigation_cell    =  $cellphone ;
                $caseEscalationObj->investigation_email   =  $email; 
                $caseEscalationObj->investigation_note    =  $message ;
  
                $caseEscalationObj->status          = 4;
                $caseEscalationObj->addressbook     = 0;
                $caseEscalationObj->source          = 2; //Mobile
                $caseEscalationObj->active          = 1;
				
			    $caseEscalationObj->save();
				/*-------------------------------------------------------------*/
				
				
				
						
	   $Messagenotifications  = new  Messagenotifications() ; 
	   $Messagenotifications->from             =$idi->id;
	   $Messagenotifications->to               =  $to ; 
	   $Messagenotifications->message          = $message ;
	   $Messagenotifications->case_id          =  $newCase->id;
	   $Messagenotifications->title          =  $newCase->id;
	   $Messagenotifications->case_escalator_id=$newCase->id;
	   $Messagenotifications-> save() ;
				
		//		$caseId			= CaseReport::where('description','=',$description)->first();
			
			
			    $caseOwner              = new CaseOwner();
                $caseOwner->user        = $idi->id;
                $caseOwner->case_id     = $newCase->id;
                $caseOwner->type        = 0;
                $caseOwner->active      = 1;
                $caseOwner->save();


                $destinationFolder = 'files/case_'.$newCase->id;

                if(!\File::exists($destinationFolder)) {
                     $createDir         = \File::makeDirectory($destinationFolder,0777,true);
                }




                $response["message"]      = "Case created successfully";
                $response["error"]        = FALSE;
                $response["caseID"]       = $newCase->id;

                return \Response::json($response,201);
		
		
		
		
		
		
		
         if (isset($headers['api_key'])) {

             $$user  = User::where('api_key','=',$headers['api_key'])->first();

            
           

        }
       
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
