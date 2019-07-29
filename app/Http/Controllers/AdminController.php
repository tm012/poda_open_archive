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
use App\news;

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
  public function add_news(Request $request)
  {
     return view('admin/add_news');
  }
  public function news_details($news_id)
  { 
     $news = DB::table('news')->where('id', $news_id)->get();
     return view('news_details', ["news"=>$news]);
  }


  public function news_list(Request $request)
  {
    $news = DB::table('news')->paginate(10);
    
    return view('admin/news_list', ["news"=>$news]);
  }  
  public function news(Request $request)
  {
    $news = DB::table('news')->paginate(10);
    
    return view('news', ["news"=>$news]);
  }  
  public function edit_news($news_id){
       //do stuffs here with $prisw and $secsw
    //dd($news_id);
    $news = DB::table('news')->where('id', $news_id)->get();
    return view('admin/edit_news', ["news"=>$news]);
  }

  public function user_list(Request $request){

     $users = DB::table('users')->where('user_approval_status',  "1")->paginate(10);

      return view('admin/user_list', ["users"=>$users]);

  }
  public function post_edit_news(Request $request){
    
    $id = $request->id;


    $image = $request->file('pic');
    $microtime = (string) round(microtime(true) * 1000).'_'.str_random(6);

   

    if ($image != '')
    { 
      $study_path = DB::table('news')->where('id', $id)->value('news_image_path_storage');
      $modified_path = dirname($study_path);
      

      Storage::disk('s3')->deleteDirectory($modified_path);
      //dd($modified_path );
      $imageName = $image->getClientOriginalName() ;
      $tm = Storage::disk('s3')->put('news_images/'.$microtime , $image, 'private'); 
        $updateDetails=array(

        'news_title' => $request->study_name,
        'news_description' => $request->study_description,
       
        'news_author' => $request->authors_input,
        'news_image_path_storage' =>$tm,

        );   
    }
    else{

        $updateDetails=array(

        'news_title' => $request->study_name,
        'news_description' => $request->study_description,
       
        'news_author' => $request->authors_input,

        );
    }
    DB::table('news')
    ->where('id', $id )
    ->update($updateDetails);
    $news = DB::table('news')->where('id', $id)->get();
    return view('admin/edit_news', ["news"=>$news]);
  }



  
  public function post_news(Request $request)
  {
    $image = $request->file('pic');
    $microtime = (string) round(microtime(true) * 1000).'_'.str_random(6);

   

    if ($image != '')
    {
       $imageName = $image->getClientOriginalName() ;
       $tm = Storage::disk('s3')->put('news_images/'.$microtime , $image, 'private');
       // dd(basename($path));
       // $file_name = basename($tm);
       // dd($tm);

        $bike_save = New news;
        $bike_save ->news_title = $request->study_name;
        $bike_save ->news_description = $request->study_description;
        $bike_save ->news_author = $request->authors_input;
        $bike_save ->news_image_path_storage=$tm ;
        $bike_save -> save();       
    }
    else{
        $bike_save = New news;
        $bike_save ->news_title = $request->study_name;
        $bike_save ->news_description = $request->study_description;
        $bike_save ->news_author = $request->authors_input;
        // $bike_save ->news_image_path_storage='news_images/'.$microtime .'/'.$imageName;
        $bike_save -> save();
    }
    return Redirect::to('admin/news_list');

     //return view('admin/news_list');
  }       
}