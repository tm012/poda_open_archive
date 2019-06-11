<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Cookie;
use DateTime;
use Session;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Studies;
use App\Datasets;
use App\authors;
use App\search_tags;
use DB;
use App\file_upload_queue;
use File;
use App\tasks;

class AdminController extends Controller
{

	public function feature_change(Request $request)
    {	

    	if (Studies::where('study_id', '=',  Session::get("current_study_id"))->where('featured', '=',  "0")->exists()) {
   			// user found

   			$updateDetails=array(

              'featured' => '1',
           
            );
		}
		else{

			$updateDetails=array(

              'featured' => '0',
           
            );
		}



    	DB::table('studies')
            ->where('study_id',  Session::get("current_study_id") )
            ->update($updateDetails);
    }
       
}