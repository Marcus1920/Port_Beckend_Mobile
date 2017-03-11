<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



    Route::group(array('prefix' => 'api/v1'), function() {

     Route::post('login', 'UserCController@login');
     Route::post('pedingcases', 'ReportController@Pendingcases');
     Route::post('allocatecase','ReportController@Allocatercase');
     Route::post('referecases', 'ReportController@Referecases');
     Route::get('getallusers', 'ReportController@Getallusers');
     Route::post('acceptedcases','ReportController@Acceptedcases');
     Route::post('declinsecase','ReportController@Declinsecase');



        Route::get('categoriess', 'DepartController@index');
    Route::get('myreport', 'ReportCController@myReport');
    Route::post('report', 'ReportsController@store');

    Route::get('messagenofication','CaseNotesController@messagenofication');
    Route::post('mobilecaeCreate','CasesController@mobilecaeCreate');


    Route::post('newmessagenofication','CaseNotesController@newmessagenofication');

    Route::get('showcontactmobile','AddressBookController@showcontactmobile');


    Route::post('requestcloser','ReportCController@requestcloser');
    Route::post('updatecasemobile','ReportCController@updatecasemobile');





    Route::get('statuss', 'ReportCController@statuss');



    Route::post('mobilerallocate', 'CasesController@mobilerallocate');

    Route::post('actionteken', 'DepartController@action');
    Route::post('Casetype', 'DepartController@castype');
    Route::get('mobiledepartement', 'DepartController@mobiledepartement');
    Route::get('subcategories', 'DepartController@mobilesubcategories');
    Route::get('subsubcategories', 'DepartController@mobilesusubbcategories');

    Route::get('categories', 'DepartController@mobilecategories');







    Route::get('mobilecalendarListPerUser', 'CasesController@mobilecalendarListPerUser');
    Route::post('reportImage','ReportCController@saveReportImage');
    Route::post('createincident','ReportCController@creatReport');

    Route::post('closeIncidentmobile', 'ReportCController@closeIncidentmobile');
    Route::post('login', 'UserCController@login');
    Route::post('forgot', 'UserCController@forgot');

});
