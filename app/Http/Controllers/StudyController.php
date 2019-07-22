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
use App\news;
use App\tasks;
use App\User;
use App\Licence;
use Zipper;
use App\relation_study_id_key;



class StudyController extends Controller
{
    //

  public function delete_key_file(Request $request)
  {

    //dd($request->key_id);
    DB::table('col_names_key')->where('data_id',  $request->key_id)->delete();
    DB::table('col_row_key')->where('data_id',  $request->key_id)->delete();
    DB::table('file_uploads')->where('dateset_id',  $request->key_id)->where('type',  'key')->delete();
    DB::table('file_upload_queues')->where('task_name',  $request->key_id)->where('file_type',  'key')->delete();

    Storage::disk('s3')->deleteDirectory('dump/'.Session::get("current_study_id") . '/'. $request->key_id);
   // return Redirect::to('datasets');
  }

  public function keys(Request $request)
  {
      $keys = DB::table('file_uploads')->where('type',  'key')->where('study_id',  Session::get("current_study_id"))->get();

      return view('studies/keys', ["keys"=>$keys]); 
  }

  public function submit_post_key_dataset(Request $request)
  {
   
    for ($x = 0; $x < count($request->keys); $x++) {
        echo $request->keys[0];

        if ( $request->check_boxs1[$x] == "1") {
          # code...
          if (DB::table('relation_study_id_key')->where('key_id',  $request->keys[$x])->where('dataset_id',  $request->dataset_name)->exists()) {
              
           }  
           else{

            $bike_save = New relation_study_id_key;
            $bike_save ->key_id =  $request->keys[$x];
            $bike_save ->dataset_id =  $request->dataset_name;
         
            $bike_save -> save();
           }            

        }
        else{


          DB::table('relation_study_id_key')->where('key_id',  $request->keys[$x])->where('dataset_id',  $request->dataset_name)->delete();
           

        }
    } 

    // dd($request->all());
    return Redirect::to('studies/dataset_key');
  }

    public function dataset_key(){
      #return view('/dataset_key', ["my_studies"=>$my_studies]);


      
      

      $datasets = DB::table('datasets')->where('study_id',  Session::get("current_study_id"))->get();
      $keys = DB::table('file_uploads')->where('type',  'key')->where('study_id',  Session::get("current_study_id"))->get();

      return view('studies/dataset_key', ["datasets"=>$datasets,"keys"=>$keys]);
    }

    public function search_home(Request $request)
    {
        $search_type = $request->search_type;
        if($search_type == "study"){

          $services = DB::table('studies')->where('studies.admin_approved', '1')->where('studies.archived_status', '0')->distinct()->get();

           return  $services;



        }

        if($search_type == "task"){

          // $services = DB::table('studies')->distinct()->get();


          $services = DB::table('studies')
              ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')->where('studies.archived_status', '0')->where('studies.admin_approved', '1')
              ->select('datasets.task_related')
              ->distinct()->get();

           return  $services;



        }


        if($search_type == "dataset"){

          // $services = DB::table('studies')->distinct()->get();


          $services = DB::table('studies')
              ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')->where('studies.archived_status', '0')->where('studies.admin_approved', '1')
              ->select('datasets.dataset_name')
              ->distinct()->get();

           return  $services;



        }

        if($search_type == "author_name"){

          $services = DB::table('authors')
              // ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')
              ->select('authors.author_name')
              ->distinct()->get();
          return  $services;



        }
        if($search_type == "tag"){
          $services = DB::table('search_tags')
          // ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')
          ->select('search_tags.search_tag')
          ->distinct()->get();
          return  $services;



        }        
        //return response()->json(['success'=>$imageName]);
        //return view('studies/create_study', ["studyid"=>$microtime]);
    }

    public function edit_account(Request $request)
    {

      $p_users = User::where('id','=', Auth::user()->id)->get();

    

      return view('/edit_account', ["p_users"=>$p_users]);
    }

    public function post_edit_account(Request $request)
    {

  

          $updateDetails=array(

              'name' => $request->name,
               'institution_name' => $request->institution_name,
                'designation' => $request->designation,
                 'phone_number' => $request->phone_number,
           
            );

            DB::table('users')
            ->where('id',  Auth::user()->id )
            ->update($updateDetails);
Session::flash('message', "Updated");
          
          return Redirect::to('/edit_account');

     

    }    

    public function search_home_with_param(Request $request)
    {
       

        $search_param = $request->search;
        if (Datasets::where('task_related', '=', $search_param)->exists()) {
           // user found

           $my_studies = DB::table('studies')
               ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')
               ->select('studies.id' , 'studies.study_id' ,'studies.study_name' , 'studies.access_status', 'studies.created_date' ,'studies.user_id','studies.study_path','studies.created_at','studies.updated_at')
               ->where('datasets.task_related', $search_param)
               ->where('studies.admin_approved', '1')->where('studies.archived_status', '0')
               ->paginate(10);
               return view('/welcome', ["my_studies"=>$my_studies]);
        }
        else if (Studies::where('study_name', '=', $search_param)->exists()) {
          $my_studies = Studies::where('study_name', $search_param)->where('admin_approved', '1')->where('studies.archived_status', '0') ->paginate(10);
          return view('/welcome', ["my_studies"=>$my_studies]);

        }
        else if (Datasets::where('dataset_name', '=', $search_param)->exists()) {
          $my_studies = DB::table('studies')
              ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')
              ->select('studies.id' , 'studies.study_id' ,'studies.study_name' , 'studies.access_status', 'studies.created_date' ,'studies.user_id','studies.study_path','studies.created_at','studies.updated_at')->where('studies.archived_status', '0')
              ->where('datasets.dataset_name', $search_param)->where('studies.admin_approved', '1')
              ->paginate(10);
              return view('/welcome', ["my_studies"=>$my_studies]);

        }
        else if (DB::table('authors')->where('author_name', '=', $search_param)->exists()) {
          $my_studies = DB::table('studies')
              ->join('authors', 'studies.study_id', '=', 'authors.study_id')
              ->select('studies.id' , 'studies.study_id' ,'studies.study_name' , 'studies.access_status', 'studies.created_date' ,'studies.user_id','studies.study_path','studies.created_at','studies.updated_at')
              ->where('authors.author_name', $search_param)->where('studies.admin_approved', '1')->where('studies.archived_status', '0')
              ->paginate(10);
              return view('/welcome', ["my_studies"=>$my_studies]);

        }
        else if (DB::table('search_tags')->where('search_tag', '=', $search_param)->exists()) {
          $my_studies = DB::table('studies')
              ->join('search_tags', 'studies.study_id', '=', 'search_tags.study_id')
              ->select('studies.id' , 'studies.study_id' ,'studies.study_name' , 'studies.access_status', 'studies.created_date' ,'studies.user_id','studies.study_path','studies.created_at','studies.updated_at')
              ->where('search_tags.search_tag', $search_param)->where('studies.admin_approved', '1')->where('studies.archived_status', '0')
              ->paginate(10);
              return view('/welcome', ["my_studies"=>$my_studies]);

        }
        else{
          $my_studies = Studies::where('studies.archived_status', '0')->paginate(10);
          return view('/welcome', ["my_studies"=>$my_studies]);

        }
    }
    public function reg_result(){
      Auth::logout();
      return view('/reg_result');
    }



    public function create_study()
    {
        $microtime = "S-" . (string) round(microtime(true) * 1000) . "-" . str_random(6);
        $licences = Licence::get();

        //return response()->json(['success'=>$imageName]);
        return view('studies/create_study', ["studyid"=>$microtime,"licences"=>$licences]);
    }
    public function tasks()
    {
      $tasks = DB::table('tasks')
              // ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')
              
             ->paginate(10);

        //return response()->json(['success'=>$imageName]);
        return view('studies/tasks', ["tasks"=>$tasks]);
    }
    public function edit_task_name(Request $request)
    {
      


        $task_name = $request->task_name;
        $id = $request->id;
        if (DB::table('tasks')->where('task_name', '=', $task_name )->exists()) {
           // user found
        }
        else{
            $updateDetails=array(

              'task_name' => $request->task_name,
           
            );

            DB::table('tasks')
            ->where('id',  $id )
            ->update($updateDetails);

        }
      //  $tasks = DB::table('tasks')
      //         // ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')
              
      //        ->paginate(10);        
      //   //return response()->json(['success'=>$imageName]);
      // return view('studies/tasks', ["tasks"=>$tasks]);
    }
    public function delete_task_name(Request $request){
       //do stuffs here with $prisw and $secsw

      DB::delete('delete  from tasks where id = ?',[$request->id]);
    }
    public function post_task(Request $request)
    {

      


       $myArray = explode(',', $request->search_tags);
        for($x=0;$x<count($myArray);$x++){

          // echo $myArray[$x];
          if (tasks::where('task_name', '=', $myArray[$x])->exists()) {
             // user found
          }
          else{
            $bike_save = New tasks;
            $bike_save ->task_name = $myArray[$x];
         
            $bike_save -> save();

          }


        }
      return Redirect::to('studies/tasks');


    }


    public function edit_study()
    {   

        

        $study_content = Studies::where('study_id',  Session::get("current_study_id"))->where('archived_status',  "0")->get();
        //dd( $study_content);
        $licences = Licence::get();

        $microtime = "S-" . (string) round(microtime(true) * 1000) . "-" . str_random(6);

        // $authors = "Amsterdam,Washington,Sydney,Beijing,Cairo";
        // $search_tags = "Amsterdam1,Washington1,Sydney1,Beijing1,Cairo1";

        //return response()->json(['success'=>$imageName]);
        return view('studies/edit_study', ["studyid"=>$microtime,"study_content"=>$study_content,"licences"=>$licences]);
    }


    public function my_studies()
    {

        //return response()->json(['success'=>$imageName]);

        $my_studies = Studies::where('user_id', Auth::user()->id)->where('archived_status',  "0")->paginate(10);
        return view('studies/my_studies', ["my_studies"=>$my_studies]);


    }
    public function approval_requests()
    {

        //return response()->json(['success'=>$imageName]);

        $my_studies = Studies::where('archived_status',  "0")->where('admin_approved',  "0")->paginate(10);
        return view('studies/approval_requests', ["my_studies"=>$my_studies]);


    }

    public function landing_page(){




      $featured_list = Studies::where('archived_status',  "0")->where('admin_approved',  "1")->where('featured',  "1")->get();
      $featuredCount = $featured_list->count();
      if ($featuredCount == 1) {
        # code...
        $featured_studies = $featured_list->random(1);
      }
      elseif ($featuredCount == 2) {
        # code...
        $featured_studies = $featured_list->random(2);
      }

      elseif ($featuredCount == 3) {
        # code...
        $featured_studies = $featured_list->random(3);
      }
      elseif ($featuredCount > 3) {
        # code...
        $featured_studies = $featured_list->random(4);
      }
      else{
        $featured_studies = [];
      }

      $latest_studies = Studies::where('archived_status',  "0")->where('admin_approved',  "1")->orderBy('created_at', 'desc')->limit(4)->get();
      $latest_studies_count = $latest_studies->count();

      $latest_news = news::orderBy('created_at', 'desc')->limit(3)->get();
      $latest_news_studies_count = $latest_news->count();

      // $featured_studies = Studies::where('archived_status',  "0")->where('admin_approved',  "1")->where('featured',  "1")->get()->random(4);;

      // dd($featured_studies[0]["study_id"]);

      return view('landing_page', ["featuredCount"=>$featuredCount,"featured_studies"=>$featured_studies,"latest_studies"=>$latest_studies,"latest_studies_count"=>$latest_studies_count,"latest_news"=>$latest_news,"latest_news_studies_count"=>$latest_news_studies_count]);

      // return view('landing_page');

    }

    public function welcome()
    {    
      // $path = 'news_images/Psychology.jpg';
      //         $s3 = \Storage::disk('s3');
      //   $client = $s3->getDriver()->getAdapter()->getClient();
      //   $expiry = "+10000 minutes";

      //   $command = $client->getCommand('GetObject', [
      //       'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
      //       'Key'    => $path
      //   ]);

      //   $request_tm = $client->createPresignedRequest($command, $expiry);
      //   $path_s3 = (string) $request_tm->getUri();
       //  //
       // <!--   <img src="{!! url($path_s3 ) !!}" alt="Smiley face" width="42" height="42"> -->
      // https://stackoverflow.com/questions/39095691/how-to-display-image-from-aws-s3-in-blade-laravel-5-2

      // $file_n = Storage::disk('public')->path('sample_csv_test.csv');

      // $file = fopen($file_n, "r");
      //  $all_data = array();

      //  //dd( count(fgetcsv($file, 200, ",")));

      //  while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ){

      //      echo $name = $data[0];
      //      echo '<br>';
      //      echo $city = $data[1];
      //      echo '<br>';
      //      // $all_data = $name. " ".$city;

      //      // array_push($array, $all_data);
      //   }
      //   fclose($file);
        #Storage::disk('s3')->deleteDirectory('dump/tm');
      #dd(public_path().'/files/S-1562448123818-s7xlS9/DataSet2.zip');

      

      // Zipper::make(public_path().'/files/S-1562448123818-s7xlS9/data-antisaccade.zip')->extractTo(public_path().'/files/S-1562448123818-s7xlS9');
      // rename (public_path().'/files/S-1562448123818-s7xlS9/data-antisaccade', public_path().'/files/S-1562448123818-s7xlS9/tm7');
      // $files = glob(public_path().'/files/S-1562448123818-s7xlS9/tm7');
      // \Zipper::make(public_path().'/files/S-1562448123818-s7xlS9/tm7.zip')->add($files)->close();

      $string = 'folder5/folder7/folder6/1';
      $folder_string = dirname($string);

//echo $folder_string;
  //echo('<br>');
      $folder_array = explode("/",$folder_string);
      if($folder_string != "."){
            for($i=count($folder_array) -1; $i>=0;$i--){

                $folder_name = $folder_array[$i];
                $empty_string="dump/tm/tttt/";
                // echo('<br>'.'----------S i--------------');
               // echo $i;
               // echo('<br>'.'----------E i--------------');
                for($j=0; $j < $i;$j++){
                //  echo('<br>'.'---------------------S j------------------');
      //echo $j;
                //echo('<br>'.'-------E j----------------------');
                  $empty_string = $empty_string . $folder_array[$j] . '/';
                }

      //           echo($folder_name);
      //            echo('<br>');
      // echo (rtrim($empty_string, '/'));
      //         echo('<br>');

            }
          }

         

      // dd($folder_array);

      // while($folder_string != ".") {

      //   echo 'dump/tm/'.basename($folder_string);
      //   echo('<br>');
      //   $folder_string = dirname($folder_string);
      // }
      // dd('');



      


      

        if(Auth::check()){
          $path=public_path().'/files/archive_'.Auth::user()->id.'.zip';
          //bytes

          if (file_exists($path)) {
              unlink($path);
          }

            if(Auth::user()->user_approval_status == "0")
            {
              Auth::logout();
            }
        }
     

        
          $my_studies = Studies::where('archived_status',  "0")->where('admin_approved',  "1")->paginate(10);
          return view('/welcome', ["my_studies"=>$my_studies]);

        




    }

     public function post_edit_study(Request $request)
    {

            // DB::delete('delete  from authors where study_id = ?',[Session::get("current_study_id")]);
            // DB::delete('delete from search_tags where study_id = ?',[Session::get("current_study_id")]);

            DB::table('search_tags')->where('study_id',  Session::get("current_study_id"))->delete();
            DB::table('authors')->where('study_id',  Session::get("current_study_id"))->delete();




            // search_tags::where('study_id', '=', Session::get("current_study_id"))->delete();
            // authors::where('study_id', '=', Session::get("current_study_id"))->delete();
            $myArray = explode(',', $request->authors_input);
            for($x=0;$x<count($myArray);$x++){

              // echo $myArray[$x];
              $bike_save = New authors;
              $bike_save ->study_id = Session::get("current_study_id");
              $bike_save ->author_name = $myArray[$x];
              $bike_save -> save();
            }
            $myArray = explode(',', $request->search_tags);
            for($x=0;$x<count($myArray);$x++){

              // echo $myArray[$x];
              $bike_save = New search_tags;
              $bike_save ->study_id = Session::get("current_study_id");
              $bike_save ->search_tag = $myArray[$x];
              $bike_save -> save();
            }


            $updateDetails=array(

              'study_name' => $request->study_name,
              'study_description' => $request->study_description,
              'study_licence' => $request->study_licence,
              'authors' => $request->authors_input,
              'publication_name' => $request->publication_name,
              'publication_time' => $request->publication_time,
              'contact_info' => $request->contact_info,
              'search_tags' => $request->search_tags
            );

            DB::table('studies')
            ->where('study_id', Session::get("current_study_id"))
            ->update($updateDetails);
            return Redirect::to('/datasets');
    }



     public function post_study(Request $request)
    {

            // $exists = Storage::disk('s3')->exists('dump/S-1550773295427-nPffh4/tm');
            // dd($exists);

            $myArray = explode(',', $request->authors_input);
            for($x=0;$x<count($myArray);$x++){

              // echo $myArray[$x];
              $bike_save = New authors;
              $bike_save ->study_id = $request->study_id;
              $bike_save ->author_name = $myArray[$x];
              $bike_save -> save();
            }
            $myArray = explode(',', $request->search_tags);
            for($x=0;$x<count($myArray);$x++){

              // echo $myArray[$x];
              $bike_save = New search_tags;
              $bike_save ->study_id = $request->study_id;
              $bike_save ->search_tag = $myArray[$x];
              $bike_save -> save();
            }

            // dd($myArray[0]);

            // dd($request->all());
            $date = Carbon::now();// will get you the current date, time


            $bike_save = New Studies;
            $bike_save ->study_id = $request->study_id;
            $bike_save ->study_name = $request->study_name;
            $bike_save ->access_status = "1";
            $bike_save ->created_date = $date->format("Y-m-d");

            $bike_save ->user_id = Auth::user()->id;
            $bike_save ->study_path = 'dump/'.$request->study_id;

            $bike_save ->study_description = $request->study_description;
            $bike_save ->study_licence = $request->study_licence;
            $bike_save ->authors = $request->authors_input;
            $bike_save ->publication_name = $request->publication_name;
            $bike_save ->publication_time = $request->publication_time;
            $bike_save ->contact_info = $request->contact_info;
            $bike_save ->search_tags = $request->search_tags;


            $bike_save -> save();
            $fileContents= 'TM';

            Storage::disk('s3')->put('dump/'.$request->study_id.'/1', $fileContents);
            //Storage::disk('s3')->delete('dump/'.$request->study_id.'/1');
            return Redirect::to('studies/my_studies');
    }

    public function go_to_study_page(Request $request)
    {
            $date = Carbon::now();// will get you the current date, time

            $study_id  = $request->study_id;
            Session::put("current_study_id",$study_id);
            $study_path = DB::table('studies')->where('study_id', $study_id)->value('study_path');
            $study_name = DB::table('studies')->where('study_id', $study_id)->value('study_name');
             Session::put("current_path",$study_path);
             Session::put("current_study_name",$study_name);
             return "TAUSEEF";





    }
    public function study_archived()
    {

         $updateDetails=array(

              'archived_status' => "1"
            );

            DB::table('studies')
            ->where('study_id', Session::get("current_study_id"))
            ->update($updateDetails);
      return Redirect::to('studies/my_studies');
    }
    public function approval_rejection_study(Request $request)
    {

      if($request->status == "1"){
          $updateDetails=array(

                  'admin_approved' => "1"
                );

                DB::table('studies')
                ->where('study_id', Session::get("current_study_id"))
                ->update($updateDetails);
      }
      elseif ($request->status == "0") {
        # code..
        $updateDetails=array(

                  'admin_approved' => "-1",
                  'archived_status' => "1"
                );

                DB::table('studies')
                ->where('study_id', Session::get("current_study_id"))
                ->update($updateDetails);


                // DB::table('authors')->where('study_id',  Session::get("current_study_id"))->delete();


                // Storage::disk('s3')->deleteDirectory('dump/'.Session::get("current_study_id"));
      }

    }




    public function datasets()
    {
            $date = Carbon::now();// will get you the current date, time

            //dd(Session::get("current_study_id"));
            Session::put("current_dataset_name","");
            Session::put("current_path","");
            $my_datasets = Datasets::where('study_id',  Session::get("current_study_id"))->paginate(10);
            $study_content = Studies::where('study_id',  Session::get("current_study_id"))->where('archived_status',  "0")->get();

            if (Auth::check())
              {
                  // The user is logged in...
                  $study_user_id =  DB::table('studies')->where('study_id',  Session::get("current_study_id"))->where('archived_status',  "0")->value('user_id');
                  if ($study_user_id == Auth::user()->id) {
                    # code...
                    $data_mine = "1";
                  }
                  else{
                    $data_mine = "0";
                  }
              }
            else{
                  $data_mine = "0";
            }

            $tasks = DB::table('tasks')->orderBy('task_name')->get();



            


            return view('studies/datasets', ["my_datasets"=>$my_datasets,"study_content"=>$study_content,"data_mine"=>$data_mine,"tasks"=>$tasks]);




    }

    public function users_waiting(){
      
      $users = DB::table('users')->where('user_approval_status',  "0")->paginate(10);

      return view('users_waiting', ["users"=>$users]);
    }
    public function user_approval_rejection(Request $request){


      if($request->status == "1"){

                $updateDetails=array(

                  'user_approval_status' => "1"
           
                );
      }
      elseif ($request->status == "0") {
        # code...

        $updateDetails=array(

                  'user_approval_status' => "-1"
 
                );
      }
      else{
          $updateDetails=array(

                  'user_approval_status' => "0"
           
                );

      }


       

                DB::table('users')
                ->where('id', $request->user_id)
                ->update($updateDetails);

      return "1";
    }
    public function back_pressed()
    {
      if(Auth::check()){

        $path=public_path().'/files/archive_'.Auth::user()->id.'.zip';
        //bytes

        if (file_exists($path)) {
            unlink($path);
        }
      }

      if (substr(rtrim(Session::get("current_path")), -1) == "/") {
          // Do stuff

            $modified_path = substr(Session::get("current_path"), 0, strlen(Session::get("current_path"))-1);
            Session::put("current_path",$modified_path);
          //dd( Session::get("current_study_id") . " " . Session::get("current_dataset_name") . " ". Session::get("current_path"));

        }


        $str = Session::get("current_path");
        $char = '/';
        $reversed_string = strrev($str);
        $char_pos = strpos($reversed_string, $char);
        if ($char_pos === false) return $str; // character not present
        $trim = substr($reversed_string, $char_pos);

        $folder = strrev($trim);
        Session::put("current_path",$folder);


        if (substr(rtrim(Session::get("current_path")), -1) == "/") {
            // Do stuff

              $modified_path = substr(Session::get("current_path"), 0, strlen(Session::get("current_path"))-1);
              Session::put("current_path",$modified_path);

            //dd( Session::get("current_study_id") . " " . Session::get("current_dataset_name") . " ". Session::get("current_path"));

          }
          $dataset_path = "";


          $dataset_path = DB::table('datasets')->where('study_id',  Session::get("current_study_id"))->where('dataset_name',  Session::get("current_dataset_name"))->value('dateset_path');
          $study_path = DB::table('studies')->where('study_id',  Session::get("current_study_id"))->where('archived_status',  "0")->where('admin_approved',  "1")->value('study_path');
          if ($dataset_path == Session::get("current_path")) {
             // user found
             return "datasets";
          }

          elseif ($study_path == Session::get("current_path")) {
            // code...
            return "studies";
          }
          else{
            return "files";
          }

    }







    public function contents()
    {


    //  dd("TM");
    //dd( Session::get("current_study_id") . " " . Session::get("current_dataset_name") . " ". Session::get("current_path"));


    if (substr(rtrim(Session::get("current_path")), -1) == "/") {
        // Do stuff


          $modified_path = substr(Session::get("current_path"), 0, strlen(Session::get("current_path"))-1);
        Session::put("current_path",$modified_path);

        //dd( Session::get("current_study_id") . " " . Session::get("current_dataset_name") . " ". Session::get("current_path"));

      }
      $contents = FileUpload::where('study_id',  Session::get("current_study_id"))->where('dateset_id', Session::get("current_dataset_name"))->where('path', Session::get("current_path"))->groupBy('filename')->paginate(10);
      


      if (Auth::check())
        {
            // The user is logged in...
            $study_user_id =  DB::table('studies')->where('study_id',  Session::get("current_study_id"))->where('archived_status',  "0")->value('user_id');
            if ($study_user_id == Auth::user()->id) {
              # code...
              $data_mine = "1";
            }
            else{
              $data_mine = "0";
            }
        }
      else{
            $data_mine = "0";
      }


      return view('studies/contents', ["contents"=>$contents,"data_mine"=>$data_mine]);



    }

 public function set_breadcrumb_path(Request $request)
    {       

      Session::put("current_path",$request->path);
      return $request->path;
    }


    public function go_to_files(Request $request)
    {       


          
      $date = Carbon::now();// will get you the current date, time
      $next_destination = $request->next_destination;
      //dd(Session::get("current_study_id"));
      if (Session::get("current_dataset_name") == '')
      {
        Session::put("current_dataset_name",$next_destination);

        $path = 'dump/' . Session::get("current_study_id") .'/'. Session::get("current_dataset_name") ;
        Session::put("current_path",$path);
      }

      else{

        $path = Session::get("current_path") .'/'. $next_destination ;
        Session::put("current_path",$path);


      }
      // $contents = FileUpload::where('study_id',  Session::get("current_study_id"))->get();
      //
      //
      // return view('studies/files', ["contents"=>$contents]);
      return $path;
          




    }
     public function create_dataset(Request $request)
    {
            $date = Carbon::now();// will get you the current date, time

            //dd(Session::get("current_study_id"));
            $task_name  = $request->task_name;
            $dataset_name  = $request->dataset_name;
            $path = 'dump/' . Session::get("current_study_id") .'/'.$dataset_name ;

            $exists = Storage::disk('s3')->exists($path);

            if($exists){


            }
            else{

            $date = Carbon::now();// will get you the current date, time
            $fileContents= 'TM';
            Storage::disk('s3')->put($path .'/1', $fileContents);



            $bike_save = New Datasets;
            $bike_save ->study_id = Session::get("current_study_id");
            $bike_save ->dataset_name = $request->dataset_name;
            $bike_save ->task_related = $request->task_name;
            $bike_save ->created_date = $date->format("Y-m-d");

            $bike_save ->user_id = Auth::user()->id;
            $bike_save ->dateset_path = 'dump/' . Session::get("current_study_id") ;

            $bike_save -> save();

            }
            // dd($exists);

            return  "TM";





    }


    public function partial_view_smart_search_drops(Request $request){
            $status = $request->status;

            $data_id = DB::table('datasets')->where('study_id', Session::get("current_study_id"))->where('dataset_name', Session::get("current_dataset_name"))->value('id');

            // return view('partial_cart.sub_category_admin',['exists'=>  '0','service_id'=>  $service_id]);
        return view('partials.partial_view_smart_search_drops',['status'=>  $status,'data_id'=>  $data_id]);
    }
    public function partial_view_get_keys_dataset(Request $request){
            $status = $request->status;

            $array_dataset_id=array();

            $d =  DB::table('relation_study_id_key')->where('dataset_id',  $status)->get();

            foreach ($d as $ds=>$value){ 
            // Code Here
              array_push($array_dataset_id,$value->key_id);
            }



             $keys = DB::table('file_uploads')->where('type',  'key')->where('study_id',  Session::get("current_study_id"))->get();
             #$connected_keys = 



            // return view('partial_cart.sub_category_admin',['exists'=>  '0','service_id'=>  $service_id]);
        return view('partials.partial_view_get_keys_dataset',['keys'=>  $keys,'dataset_id'=>  $status,'array_dataset_id'=>  $array_dataset_id]);
    }
    public function submit_final_smart_search(Request $request)
    {
      // dd(count($request->col_nos));
      // dd($request->all());

      // dd($request->col_nos[0]);
      $data_id = $request->dataid;
      $study_id = Session::get("current_study_id");
      $dataset_name = Session::get("current_dataset_name");
      $array_files_final=[];

      for ($x = 0; $x <count($request->col_nos); $x++) {

        $current_col_no = $request->col_nos[$x];
        $current_selection = $request->selections[$x];
        $array_files[$x]=[];




        // if($x < 1){
          // dd($current_col_no.' '. $current_selection);
          $rows = DB::table('col_row_key')->where('data_id',  $data_id )->where('col_no', $current_col_no )->where('name',  $current_selection )->get();

          for ($j = 0; $j <count($rows); $j++) {
            $c_row = $rows[$j]->row_no;
            // dd($rows[0]->row_no);
            $c_file_name = DB::table('col_row_key')->where('data_id',  $data_id )->where('col_no', '1')->where('row_no',  $c_row)->value("name");
            if ($c_file_name !=""){
              if (in_array($c_file_name, $array_files[$x]))
              {
                // echo "Match found";
              }
              else{

                // echo $c_file_name;
                // echo '<br>';
                array_push($array_files[$x],$c_file_name);
                array_push($array_files_final,$c_file_name);
              }
            }
          }

        // }
        // else{


        // }

        // dd($array_files[$x][0]);
        //dd($array_files[$x]);
 
      }

      $array_files_final = array_unique($array_files_final);
      for ($x = 0; $x <count($request->col_nos); $x++) {
        $array_files_final=array_intersect($array_files_final,$array_files[$x]);
      }

      ///////////////////////////////////
      //////////////////////////////////////
      ///////////////////////////////////////
      ///////////////////////////////////

      if (substr(rtrim(Session::get("current_path")), -1) == "/") {
        // Do stuff

        $modified_path = substr(Session::get("current_path"), 0, strlen(Session::get("current_path"))-1);
        Session::put("current_path",$modified_path);

        //dd( Session::get("current_study_id") . " " . Session::get("current_dataset_name") . " ". Session::get("current_path"));

      }
      $contents = FileUpload::where('study_id',  Session::get("current_study_id"))->where('dateset_id', Session::get("current_dataset_name"))->where('path', Session::get("current_path"))->get();

      
       $tags = implode(', ', $array_files_final);
      // dd($tags);

      // print_r($array_files_final);
      return view('submit_final_smart_search', ["contents"=>$contents,"files_string"=>$tags,"array_files_final"=>$array_files_final]);


      //////////////////////////////
      //////////////////////////////
      ///////////////////////////////
      ///////////////////////////////////////

     
      //return view('smart_search', ["array_files_final"=>$array_files_final]);




    }

    public function smart_search()
    {

      
      $data_id = DB::table('datasets')->where('study_id', Session::get("current_study_id"))->where('dataset_name', Session::get("current_dataset_name"))->value('id');
      $col_names = DB::table('col_names_key')->where('data_id', $data_id )->distinct()->get();

      // dd($col_names[0]->col_name);

      return view('smart_search', ["col_names"=>$col_names]);
    }

     public function permanently_delete_data(){


        $rows = DB::table('studies')->where('admin_approved',  '-1' )->orWhere('admin_approved',  '1' )->where('archived_status', '=', '1' )->get();

        for ($j = 0; $j <count($rows); $j++) {

          $current_study_id = $rows[$j]->study_id;

          $data_ids = DB::table('datasets')->where('study_id',  $current_study_id )->get();
          for ($k = 0; $k <count($data_ids); $k++) {

            $current_data_id= $data_ids[$k]->id;
            DB::table('col_names_key')->where('data_id', $current_data_id)->delete();
            DB::table('col_row_key')->where('data_id', $current_data_id)->delete();


          }
          DB::table('authors')->where('study_id',  $current_study_id )->delete();
          DB::table('datasets')->where('study_id',  $current_study_id )->delete();
          DB::table('file_upload_queues')->where('study_id',  $current_study_id )->delete();
          DB::table('file_uploads')->where('study_id',  $current_study_id )->delete();
          DB::table('search_tags')->where('study_id',  $current_study_id )->delete();
          DB::table('studies')->where('study_id',  $current_study_id )->delete();


          Storage::disk('s3')->deleteDirectory('dump/'.$current_study_id);


        }
     }


    public function create_folder(Request $request)
   {
           $date = Carbon::now();// will get you the current date, time

           //dd(Session::get("current_study_id"));
           $folder_name  = $request->folder_name;

           $path = Session::get("current_path") .'/'. $folder_name ;

           $exists = Storage::disk('s3')->exists($path);

           if($exists){


           }
           else{

           $date = Carbon::now();// will get you the current date, time
           $fileContents= 'TM';
           Storage::disk('s3')->put($path .'/1', $fileContents);



           $bike_save = New FileUpload;
           $bike_save ->study_id = Session::get("current_study_id");
           $bike_save ->dateset_id = Session::get("current_dataset_name");
           $bike_save ->type ="folder";
           $bike_save ->filename =$folder_name;



           $bike_save ->user_id = Auth::user()->id;
           $bike_save ->path =  Session::get("current_path");

           $bike_save -> save();

           }
           // dd($exists);

           return   $path;

   }





}