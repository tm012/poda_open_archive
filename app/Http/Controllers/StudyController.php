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
use DB;
class StudyController extends Controller
{
    //



    public function create_study()
    {
        $microtime = "S-" . (string) round(microtime(true) * 1000) . "-" . str_random(6);

        //return response()->json(['success'=>$imageName]);
        return view('studies/create_study', ["studyid"=>$microtime]);
    }

    public function my_studies()
    {

        //return response()->json(['success'=>$imageName]);

        $my_studies = Studies::where('user_id', Auth::user()->id)->get();
        return view('studies/my_studies', ["my_studies"=>$my_studies]);

    }

     public function post_study(Request $request)
    {

            // $exists = Storage::disk('s3')->exists('dump/S-1550773295427-nPffh4/tm');
            // dd($exists);
            $date = Carbon::now();// will get you the current date, time


            $bike_save = New Studies;
            $bike_save ->study_id = $request->study_id;
            $bike_save ->study_name = $request->study_name;
            $bike_save ->access_status = "1";
            $bike_save ->created_date = $date->format("Y-d-m");

            $bike_save ->user_id = Auth::user()->id;
            $bike_save ->study_path = 'dump/'.$request->study_id;

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

    public function datasets()
    {
            $date = Carbon::now();// will get you the current date, time

            //dd(Session::get("current_study_id"));
            Session::put("current_dataset_name","");
            Session::put("current_path","");
            $my_datasets = Datasets::where('study_id',  Session::get("current_study_id"))->get();


            return view('studies/datasets', ["my_datasets"=>$my_datasets]);




    }
    public function back_pressed()
    {

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
          $study_path = DB::table('studies')->where('study_id',  Session::get("current_study_id"))->value('study_path');
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
      $contents = FileUpload::where('study_id',  Session::get("current_study_id"))->where('dateset_id', Session::get("current_dataset_name"))->where('path', Session::get("current_path"))->get();


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
            $bike_save ->created_date = $date->format("Y-d-m");

            $bike_save ->user_id = Auth::user()->id;
            $bike_save ->dateset_path = 'dump/' . Session::get("current_study_id") ;

            $bike_save -> save();

            }
            // dd($exists);

            return  "TM";





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
