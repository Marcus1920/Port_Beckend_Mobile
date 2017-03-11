<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Department;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\User;
use App\UserNew;
class DepartController extends Controller
{



    private $categorys;


    public function __construct(Category $categorys)
    {

        $this->category = $categorys;

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
	 
	 
	  public   function  mobiledepartement ()
	 
	 {
		 
		 $mobiledepartement   =   Department::all() ; 
		 
		 return  Response()->json($mobiledepartement);
		 
	 }
	 
	 
	 public   function  mobilecategories ()
	 
	 {
		 
		 $mobiecategories   =   Category::all() ; 
		 
		 return  Response()->json($mobiecategories);
		 
	 }
	 
	 
	 public   function  mobilesubcategories ()
	 
	 {
		 
		 $mobieSubCategories   =   SubCategory::all() ; 
		 
		 return  Response()->json($mobieSubCategories);
		 
	 }
	 
	  public   function  mobilesusubbcategories ()
	 
	 {
		 
		 $mobilesusubbcategories   =   SubSubCategory::all() ; 
		 
		 return  Response()->json($mobilesusubbcategories);
		 
	 }
	 
	 
	 
        public function index()
    {
        $headers  = apache_request_headers();
        $response = array();

      $toke  = "12";
			
            if ($toke=="12") {

                    $categories          = $this->category->groupBy('name')->get();
                    $subCategories       = array();
                    foreach ($categories as $categorys) {

                        $subCategories['id']     = $categorys['id'];
                        $subCategories['name']   = $categorys['name'];
                        $otherSubCats           = Category::where('name','=',$categorys['name'])
                                                                        ->select('id')
                                                                        ->get();


                        $subCatsIds = array();

                        if (sizeof($otherSubCats) >= 1 ) {


                            foreach ($otherSubCats as $value) {

                                $subCatsIds[] = $value->id;

                            }


                        }

                        $subCats                 = SubCategory::whereIn('category',$subCatsIds)->get();
                        $tmpArrayAll             = [];

                        foreach ($subCats as $subCat) {

                            $tmpArray['cat_id'] = $categorys['id'];
                            $tmpArray['id']     = $subCat['id'];
                            $tmpArray['name']   = $subCat['name'];


                            $otherSubSubCats    = SubCategory::where('name','=', $subCat['name'])
                                                                        ->select('id')
                                                                        ->get();


                            $subSubCatsIds = array();

                            if (sizeof($otherSubSubCats) >= 1 ) {


                                foreach ($otherSubSubCats as $value) {

                                    $subSubCatsIds[] = $value->id;

                                }


                            }




                            $subsubCats         = SubSubCategory::whereIn('sub_category',$subSubCatsIds)->get();
                            $tmpArrayAll2       = [];

                            foreach ($subsubCats as $subsubCat) {

                                $tmpA['cat_id'] = $subCat['id'];
                                $tmpA['id']     = $subsubCat['id'];
                                $tmpA['name']   = $subsubCat['name'];
                                $tmpArrayAll2[] = $tmpA;

                            }
                            $tmpArray['subs'] = $tmpArrayAll2;
                            $tmpArrayAll[]    = $tmpArray;
                        }
                        $subCategories['subs'] = $tmpArrayAll;
                        $tmp[]                 = $subCategories;
                    }
					
                    $response['categories'] = $tmp;
                    $response['error'] = FALSE;
                    return \Response::json($response,201);
            }
            else {
                $response['message'] = 'Access Denied. Invalid Api key';;
                $response['error'] = TRUE;
                return \Response::json($response,401);
        }
    
}



}
