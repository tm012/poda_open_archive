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


class StudyController extends Controller
{
    //

    public function search_home(Request $request)
    {
        $search_type = $request->search_type;
        if($search_type == "study"){

          $services = DB::table('studies')->where('studies.admin_approved', '1')->distinct()->get();

           return  $services;



        }

        if($search_type == "task"){

          // $services = DB::table('studies')->distinct()->get();


          $services = DB::table('studies')
              ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')->where('studies.admin_approved', '1')
              ->select('datasets.task_related')
              ->distinct()->get();

           return  $services;



        }


        if($search_type == "dataset"){

          // $services = DB::table('studies')->distinct()->get();


          $services = DB::table('studies')
              ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')->where('studies.admin_approved', '1')
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

    public function search_home_with_param(Request $request)
    {
       

        $search_param = $request->search;
        if (Datasets::where('task_related', '=', $search_param)->exists()) {
           // user found

           $my_studies = DB::table('studies')
               ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')
               ->select('studies.id' , 'studies.study_id' ,'studies.study_name' , 'studies.access_status', 'studies.created_date' ,'studies.user_id','studies.study_path','studies.created_at','studies.updated_at')
               ->where('datasets.task_related', $search_param)
               ->where('studies.admin_approved', '1')
               ->paginate(10);
               return view('/welcome', ["my_studies"=>$my_studies]);
        }
        else if (Studies::where('study_name', '=', $search_param)->exists()) {
          $my_studies = Studies::where('study_name', $search_param)->where('admin_approved', '1') ->paginate(10);
          return view('/welcome', ["my_studies"=>$my_studies]);

        }
        else if (Datasets::where('dataset_name', '=', $search_param)->exists()) {
          $my_studies = DB::table('studies')
              ->join('datasets', 'studies.study_id', '=', 'datasets.study_id')
              ->select('studies.id' , 'studies.study_id' ,'studies.study_name' , 'studies.access_status', 'studies.created_date' ,'studies.user_id','studies.study_path','studies.created_at','studies.updated_at')
              ->where('datasets.dataset_name', $search_param)->where('studies.admin_approved', '1')
              ->paginate(10);
              return view('/welcome', ["my_studies"=>$my_studies]);

        }
        else if (DB::table('authors')->where('author_name', '=', $search_param)->exists()) {
          $my_studies = DB::table('studies')
              ->join('authors', 'studies.study_id', '=', 'authors.study_id')
              ->select('studies.id' , 'studies.study_id' ,'studies.study_name' , 'studies.access_status', 'studies.created_date' ,'studies.user_id','studies.study_path','studies.created_at','studies.updated_at')
              ->where('authors.author_name', $search_param)->where('studies.admin_approved', '1')
              ->paginate(10);
              return view('/welcome', ["my_studies"=>$my_studies]);

        }
        else if (DB::table('search_tags')->where('search_tag', '=', $search_param)->exists()) {
          $my_studies = DB::table('studies')
              ->join('search_tags', 'studies.study_id', '=', 'search_tags.study_id')
              ->select('studies.id' , 'studies.study_id' ,'studies.study_name' , 'studies.access_status', 'studies.created_date' ,'studies.user_id','studies.study_path','studies.created_at','studies.updated_at')
              ->where('search_tags.search_tag', $search_param)->where('studies.admin_approved', '1')
              ->paginate(10);
              return view('/welcome', ["my_studies"=>$my_studies]);

        }
        else{
          $my_studies = Studies::paginate(10);
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

        //return response()->json(['success'=>$imageName]);
        return view('studies/create_study', ["studyid"=>$microtime]);
    }

    public function edit_study()
    {   

        

        $study_content = Studies::where('study_id',  Session::get("current_study_id"))->where('archived_status',  "0")->where('admin_approved',  "1")->get();
        //dd( $study_content);

        $microtime = "S-" . (string) round(microtime(true) * 1000) . "-" . str_random(6);

        // $authors = "Amsterdam,Washington,Sydney,Beijing,Cairo";
        // $search_tags = "Amsterdam1,Washington1,Sydney1,Beijing1,Cairo1";

        //return response()->json(['success'=>$imageName]);
        return view('studies/edit_study', ["studyid"=>$microtime,"study_content"=>$study_content]);
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

    public function welcome()
    {

        //return response()->json(['success'=>$imageName]);
        // $ext = pathinfo(Session::get("current_path") .'/'.$imageName, PATHINFO_EXTENSION);
        // $filename_tm = pathinfo('filename.md.txt', PATHINFO_FILENAME);

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
            return Redirect::to('studies/edit_study');
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

            Storage::disk('ftp')->put('dump/'.$request->study_id.'/1', $fileContents);
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



            


            return view('studies/datasets', ["my_datasets"=>$my_datasets,"study_content"=>$study_content,"data_mine"=>$data_mine]);




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
      $contents = FileUpload::where('study_id',  Session::get("current_study_id"))->where('dateset_id', Session::get("current_dataset_name"))->where('path', Session::get("current_path"))->paginate(10);


      return view('studies/contents', ["contents"=>$contents]);



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

            $exists = Storage::disk('ftp')->exists($path);

            if($exists){


            }
            else{

            $date = Carbon::now();// will get you the current date, time
            $fileContents= 'TM';
            Storage::disk('ftp')->put($path .'/1', $fileContents);



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

      // print_r($array_files_final);
      return view('submit_final_smart_search', ["contents"=>$contents,"array_files_final"=>$array_files_final]);


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


    public function create_folder(Request $request)
   {
           $date = Carbon::now();// will get you the current date, time

           //dd(Session::get("current_study_id"));
           $folder_name  = $request->folder_name;

           $path = Session::get("current_path") .'/'. $folder_name ;

           $exists = Storage::disk('ftp')->exists($path);

           if($exists){


           }
           else{

           $date = Carbon::now();// will get you the current date, time
           $fileContents= 'TM';
           Storage::disk('ftp')->put($path .'/1', $fileContents);



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
