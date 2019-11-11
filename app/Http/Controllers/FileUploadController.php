<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Cookie;
use Zipper;
use DateTime;
use Session;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Carbon\Carbon;
use App\Studies;
use App\Datasets;
use DB;
use File;
use App\col_names_key;
use App\col_row_key;
use App\file_upload_queue;
use App\authors;
use App\relation_study_id_key;

use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
class FileUploadController extends Controller
{
    //

    public function fileCreate()
    {
      $folder_name = "folder 1";
        return view('file_upload/fileupload', ["folder_name"=>$folder_name]);
    }
    public function update_signed_url()
    {

      $rows = DB::table('file_uploads')->where('type',  'file' )->orWhere('type', '=', 'key' )->get();

      for ($j = 0; $j <count($rows); $j++) {
        $path = $rows[$j]->path.'/'.$rows[$j]->filename;

        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+10000 minutes";

        $command = $client->getCommand('GetObject', [
            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
            'Key'    => $path
        ]);

        $request_tm = $client->createPresignedRequest($command, $expiry);
        $path_s3 = (string) $request_tm->getUri();
        $file_ul_tm = $path_s3;

         $updateDetails=array(
            'file_url' => $file_ul_tm
          );
         DB::table('file_uploads')
        ->where('id', $rows[$j]->id)
        ->update($updateDetails);


      }
   
    }


    public function key_file_upload_queue()
    {

      if (file_upload_queue::where('uploading_done', '=', "0")->where('file_type', '=', "key")->exists()) {

         
        if (file_upload_queue::where('uploading', '=', "1")->where('file_type', '=', "key")->exists()) {
         

        
        }
        else{


          $image = DB::table('file_upload_queues')->where('file_type', '=', "key")->where('uploading_done', '=', "0")->first();
          // $image = DB::table('authors')->first();
          // dd($image->author_name);
          $study_id = $image->study_id;
          $imageName = $image->file_name_with_ext;
          $ext = $image->file_ext;
          $filename_tm = $image->file_name;

          $file_url = $image->file_url;
          $user_id = $image->user_id;
          $task_name= $image->task_name;


            $updateDetails=array(

              'uploading' => '1'

            );

            DB::table('file_upload_queues')
            ->where('id', $image->id)
            ->update($updateDetails);

          ///////////////////////////////////////////
          ///////////////////////////////////////////
          ///////////////////////////////////////////
          ////////////////////////////////////////////////
          ////////////////////////////////////////////
          /////////////////////////////////////
          //////////////////////////////////////////
          //////////////////////////////////////////////

          $data_id = $current_dataset_name = $task_name; //current_dataset_name is actuaklly key_id

          #DB::table('datasets')->where('study_id', $study_id)->value('dataset_name');
          // $data_id=Datasets::where('study_id',  $study_id)->where('dataset_name', $current_dataset_name)->value('id');


          // $path=FileUpload::where('study_id',  $study_id)->where('dateset_id', $current_dataset_name)->where('type', "key")->value('path');

          // if ($path !="") {
          //   # code...

          //   $filename_key  =FileUpload::where('study_id',  $study_id)->where('dateset_id', $current_dataset_name)->where('type', "key")->value('filename');

          //   $file_path_storage = $path.'/'.$filename_key ;

          //   Storage::disk('s3')->delete($file_path_storage);
          //   DB::table('col_names_key')->where('data_id', '=', $data_id)->delete();
          //   DB::table('col_row_key')->where('data_id', '=', $data_id)->delete();
          //   FileUpload::where('study_id',  $study_id)->where('dateset_id', $current_dataset_name)->where('type', "key")->delete();
          // }

          

         
          if (col_names_key::where('data_id', '=', $data_id)->exists()) {
             // user found



           

          }
          else{

            if($ext == "csv"){

            $file_n = Storage::disk('public')->path('keys/'.$study_id.'/'.$current_dataset_name .'/'.$imageName);

            $file = fopen($file_n, "r");
             $all_data = array();

             //dd( count(fgetcsv($file, 200, ",")));
             $no_of_columns = count(fgetcsv($file, 200, ","));
             $file = fopen($file_n, "r");
             $got_col_names = 0;
             $row_no =0;


            


             while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ){
               $start_point  = 0;

               if($got_col_names<1){


                  for ($x = 0; $x < $no_of_columns; $x++) {
                        if($x == $start_point){
                           echo $data[$x] . " - col_names" . " - col_no ".$x. " - row_no 0";
                           echo '<br>';
                           $c_column_name = $data[$x];


                          $imageUpload = new col_names_key();
                          $imageUpload->col_name = $c_column_name ;
                          // $imageUpload->data_id = $request->data_id;
                         
                          $imageUpload->data_id = $data_id;
                          $imageUpload->col_no = $x;
                          $imageUpload->row_no = 0;
         

                          $imageUpload->save();                    
                        }

                        else{
                          echo $data[$x];

                        }
                        $start_point = $start_point +1;
                        $got_col_names = 1;

                         
                  } 
                }

                else{

                      for ($x = 0; $x < $no_of_columns; $x++) {
                        if($x == $start_point){
                           echo $data[$x] . " - col_no ".$start_point. " - row_no ".$row_no;
                           echo '<br>';
                           $c_column_name = $data[$x];
                          $imageUpload = new col_row_key();
                          $imageUpload->name = $c_column_name ;
                          // $imageUpload->data_id = $request->data_id;
                         
                          $imageUpload->data_id = $data_id;
                          $imageUpload->col_no = $start_point;
                          $imageUpload->row_no = $row_no;
         

                          $imageUpload->save();                       
                        }

                        else{
                          echo $data[$x];

                        }
                        $start_point = $start_point +1;

                         
                  } 


                }
                echo '<br>';
                echo '<br>';
                $row_no =$row_no+1;

              
                 // $all_data = $name. " ".$city;

                 // array_push($array, $all_data);
              }
              
              fclose($file);

              $file_ul_tm  = 'http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/'.$study_id.'/'.$current_dataset_name.'/'.$imageName ;


             


              $imageUpload = new FileUpload();
              $imageUpload->filename = $imageName;
              // $imageUpload->data_id = $request->data_id;
              $imageUpload->path = $file_url;
              $imageUpload->dateset_id = $current_dataset_name;
              $imageUpload->study_id = $study_id;
              $imageUpload->file_url = $file_ul_tm;
              //"http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$source_path;
              // $imageUpload->file_size = (float) zip_entry_filesize($zip_entry);
              $imageUpload->path = 'dump/'.$study_id.'/'.$current_dataset_name;

              $imageUpload->type = "key";
              $imageUpload ->user_id = $user_id;
              $imageUpload->save();

              $currently_upload_id= $imageUpload ->id;

              $localFile = File::get(public_path().'/files/keys/'.$study_id.'/'.$current_dataset_name .'/'.$imageName);
                        //  dump/S-1551306856758-LEGIip/DataSet2/folder5

              $modified_path = 'dump/'.$study_id.'/'.$current_dataset_name ;
              #$file_url;

              $tm = Storage::disk('s3')->put($modified_path.'/'.$imageName,$localFile, 'private');

              $s3 = \Storage::disk('s3');
              $client = $s3->getDriver()->getAdapter()->getClient();
              $expiry = "+10000 minutes";

              $command = $client->getCommand('GetObject', [
                  'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
                  'Key'    => 'dump/'.$study_id.'/'.$current_dataset_name.'/'.$imageName
              ]);

              $request_tm = $client->createPresignedRequest($command, $expiry);
              $path_s3 = (string) $request_tm->getUri();
              $file_ul_tm = $path_s3;

               $updateDetails=array(
                  'file_url' => $file_ul_tm
                );
               DB::table('file_uploads')
              ->where('id', $currently_upload_id)
              ->update($updateDetails);


                // $path=public_path().'/files/'.$imageName;
                $path=public_path().'/files/keys/'.$study_id.'/'.$current_dataset_name .'/'.$imageName;
                //bytes

                if (file_exists($path)) {
                    unlink($path);

                    File::deleteDirectory(public_path('/files/keys/'.$study_id.'/'.$current_dataset_name));

                }
              } 
          } 


          ////////////
          ///////////////////////
          ////////////////////////////////
          ////////////////////////////
          //////////////////////////////////////
          ////////////////////////////////////////////
          /////////////////////////////////////////// 

          $updateDetails=array(

              'uploading' => '-1',
              'uploading_done' => '1'

            );

            DB::table('file_upload_queues')
            ->where('id', $image->id)
            ->update($updateDetails); 

        }
      }
      else{


      }
    }
    public function test(Request $request)
    {
              // $file_url='dump/S-1559278014751-IygPDN/DataSet2';
              // $imageName = 'index.php';
              // $id='8';
              // $s3 = \Storage::disk('s3');
              // $client = $s3->getDriver()->getAdapter()->getClient();
              // $expiry = "+10000 minutes";

              // $command = $client->getCommand('GetObject', [
              //     'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
              //     'Key'    => $file_url.'/'.$imageName
              // ]);

              // $request_tm = $client->createPresignedRequest($command, $expiry);
              // $path_s3 = (string) $request_tm->getUri();
              // $file_ul_tm = $path_s3;

              //  $updateDetails=array(
              //     'file_url' => $file_ul_tm
              //   );
              //  DB::table('file_uploads')
              // ->where('id', $id)
              // ->update($updateDetails);
      return view('test');
    }    

    public function upload_key_file(Request $request)
    {

      






      ///////////////////////////////
      ///////////////////////////
      /////////////////////////////
      /////////////////////////////////
     // if (file_upload_queue::where('study_id', '=', Session::get("current_study_id"))->where('file_type', '=', 'key' )->where('uploading_done', '=', '0' )->exists()) {
     //    Session::flash('message', "A key file is uploading");

     //    return Redirect::to('/datasets');


     // }

      #else {

        $key_id = $microtime_dataset_name = "key-" . (string) round(microtime(true) * 1000) . "-" . str_random(6);

        $image = $request->file('zipfile');
        $imageName = $image->getClientOriginalName() ;
        $image->move(public_path('files/keys/'.Session::get("current_study_id").'/'.$key_id ),$imageName);
        $ext = pathinfo($imageName, PATHINFO_EXTENSION);
        $filename_tm = pathinfo($imageName, PATHINFO_FILENAME);

        $bike_save = New file_upload_queue;
        $bike_save ->study_id = Session::get("current_study_id");
        $bike_save ->file_name_with_ext = $imageName;
        $bike_save ->file_ext = $ext;
        $bike_save ->file_name = $filename_tm ;
        $bike_save ->file_type = "key";
        $bike_save ->file_url = $request->path;

        $bike_save ->user_id = Auth::user()->id;
        $bike_save ->task_name =$key_id ;

        

        $bike_save -> save();
        Session::flash('message', "We are uploading the file(s), check back later");

        return Redirect::to('/datasets');
     # }


      ///////////////////////////////////
      /////////////////////////////
      /////////////////////////////////
      //////////////////////////////////////////
      /////////////////////////////////////////
      // dd(  $filename_tm);
      // $data_id=Datasets::where('study_id',  Session::get("current_study_id"))->where('dataset_name', Session::get("current_dataset_name"))->value('id');


      // $path=FileUpload::where('study_id',  Session::get("current_study_id"))->where('type', "key")->value('path');

      // if ($path !="") {
      //   # code...

      //   $filename_key  =FileUpload::where('study_id',  Session::get("current_study_id"))->where('type', "key")->value('filename');

      //   $file_path_storage = $path.'/'.$filename_key ;

      //   Storage::disk('s3')->delete($file_path_storage);
      //   DB::table('col_names_key')->where('data_id', '=', $data_id)->delete();
      //   DB::table('col_row_key')->where('data_id', '=', $data_id)->delete();
      //   FileUpload::where('study_id',  Session::get("current_study_id"))->where('type', "key")->delete();
      // }

      

     
      // if (col_names_key::where('data_id', '=', $data_id)->exists()) {
      //    // user found



       

      // }
      // else{

      //   if($ext == "csv"){

      //   $file_n = Storage::disk('public')->path($imageName);

      //   $file = fopen($file_n, "r");
      //    $all_data = array();

      //    //dd( count(fgetcsv($file, 200, ",")));
      //    $no_of_columns = count(fgetcsv($file, 200, ","));
      //    $file = fopen($file_n, "r");
      //    $got_col_names = 0;
      //    $row_no =0;


        


      //    while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ){
      //      $start_point  = 0;

      //      if($got_col_names<1){


      //         for ($x = 0; $x < $no_of_columns; $x++) {
      //               if($x == $start_point){
      //                  echo $data[$x] . " - col_names" . " - col_no ".$x. " - row_no 0";
      //                  echo '<br>';
      //                  $c_column_name = $data[$x];


      //                 $imageUpload = new col_names_key();
      //                 $imageUpload->col_name = $c_column_name ;
      //                 // $imageUpload->data_id = $request->data_id;
                     
      //                 $imageUpload->data_id = $data_id;
      //                 $imageUpload->col_no = $x;
      //                 $imageUpload->row_no = 0;
     

      //                 $imageUpload->save();                    
      //               }

      //               else{
      //                 echo $data[$x];

      //               }
      //               $start_point = $start_point +1;
      //               $got_col_names = 1;

                     
      //         } 
      //       }

      //       else{

      //             for ($x = 0; $x < $no_of_columns; $x++) {
      //               if($x == $start_point){
      //                  echo $data[$x] . " - col_no ".$start_point. " - row_no ".$row_no;
      //                  echo '<br>';
      //                  $c_column_name = $data[$x];
      //                 $imageUpload = new col_row_key();
      //                 $imageUpload->name = $c_column_name ;
      //                 // $imageUpload->data_id = $request->data_id;
                     
      //                 $imageUpload->data_id = $data_id;
      //                 $imageUpload->col_no = $start_point;
      //                 $imageUpload->row_no = $row_no;
     

      //                 $imageUpload->save();                       
      //               }

      //               else{
      //                 echo $data[$x];

      //               }
      //               $start_point = $start_point +1;

                     
      //         } 


      //       }
      //       echo '<br>';
      //       echo '<br>';
      //       $row_no =$row_no+1;

          
      //        // $all_data = $name. " ".$city;

      //        // array_push($array, $all_data);
      //             }
          
      //     fclose($file);

      //     $file_ul_tm  = 'http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/'.Session::get("current_study_id").'/'.Session::get("current_dataset_name").'/'.$imageName ;


      //     $imageUpload = new FileUpload();
      //     $imageUpload->filename = $imageName;
      //     // $imageUpload->data_id = $request->data_id;
      //     $imageUpload->path = $request->path;
      //     $imageUpload->dateset_id = Session::get("current_dataset_name");
      //     $imageUpload->study_id = Session::get("current_study_id");
      //     $imageUpload->file_url = $file_ul_tm;
      //     //"http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$source_path;
      //     // $imageUpload->file_size = (float) zip_entry_filesize($zip_entry);

      //     $imageUpload->type = "key";
      //     $imageUpload ->user_id = Auth::user()->id;
      //     $imageUpload->save();

      //     $localFile = File::get(public_path().'/files/'.$imageName);
      //               //  dump/S-1551306856758-LEGIip/DataSet2/folder5

      //     $modified_path = $request->path;

      //     $tm = Storage::disk('s3')->put($modified_path.'/'.$imageName,$localFile, 'public');


      //       $path=public_path().'/files/'.$imageName;
      //       //bytes

      //       if (file_exists($path)) {
      //           unlink($path);

      //       }
      //     } 
      // } 
      // dd($image. ' '. $imageName );

    }

    public function test_file_up_queue(){

      // $bike_save = New authors;
      // $bike_save ->study_id = "1";
      // $bike_save ->author_name = "1";
      // $bike_save ->created_at = "2019-05-19 22:56:04";
      // $bike_save ->updated_at = "2019-05-19 22:56:04";

      // $bike_save -> save();
      $date = Carbon::now();

      if (file_upload_queue::where('uploading_done', '=', "0")->where('file_type', '=', "dataset")->exists()) {
         
        if (file_upload_queue::where('uploading', '=', "1")->where('file_type', '=', "dataset")->exists()) {
         

        
        }

        else{

          $image = DB::table('file_upload_queues')->where('file_type', '=', "dataset")->where('uploading_done', '=', "0")->first();
          // $image = DB::table('authors')->first();
          // dd($image->author_name);
          $study_id = $image->study_id;
          $imageName = $image->file_name_with_ext;
          $ext = $image->file_ext;
          $filename_tm = $image->file_name;

          $file_url = $image->file_url;
          $user_id = $image->user_id;
          $task_name= $image->task_name;
          $file_size= $image->file_size;



            $updateDetails=array(

              'uploading' => '1'

            );

            DB::table('file_upload_queues')
            ->where('id', $image->id)
            ->update($updateDetails);

          ///////////////////////////////////////////
          ///////////////////////////////////////////
          ///////////////////////////////////////////
          ////////////////////////////////////////////////
          ////////////////////////////////////////////
          /////////////////////////////////////
          //////////////////////////////////////////
          //////////////////////////////////////////////

          if($ext == "zip"){




            // Zipper::make(public_path('/files/'.$study_id.'/'.$imageName))->extractTo(public_path('/files/'.$study_id));
          //  dd("tm");
            $zipper = new \Chumper\Zipper\Zipper;
            $zipper->make(public_path('/files/'.$study_id.'/'.$imageName))->extractTo(public_path('/files/'.$study_id.'/'.$filename_tm ));
            $zipper->close();
            $source_disk = 'public';
            $source_path =  $study_id.'/'.$filename_tm;

            $file_names = Storage::disk($source_disk)->allfiles($source_path);

            $dataset_path_tm = 'dump/'. $study_id .'/' .$source_path;
            $exists = Storage::disk('s3')->exists($dataset_path_tm);

            if($exists){


            }
            else{

            // $zip = new Filesystem(new ZipArchiveAdapter(public_path('/files/archive_'.Auth::user()->id.'.zip')));
              $bike_save = New Datasets;
              $bike_save ->study_id = $study_id;
              $bike_save ->dataset_name = $filename_tm;
              $bike_save ->task_related = $task_name;
              $bike_save ->created_date = $date->format("Y-m-d");
              $bike_save ->dataset_url = $file_url ;
              $bike_save ->file_size = $file_size;

              $bike_save ->user_id = $user_id;
              $bike_save ->dateset_path = 'dump/' . $study_id ;

              $bike_save -> save();

              $dataset_id = $bike_save ->id;
              $first_folder_check = "0";
            



              $filePath=public_path().'/files/'.$study_id.'/'.$imageName;


              $zip = zip_open($filePath);


              if ($zip) {
                while ($zip_entry = zip_read($zip)) {
                  echo"<br>";
                  echo "Name:               " . zip_entry_name($zip_entry) . "\n";
                  echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\n";
                  echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\n";
                  echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\n";
                  echo"<br>";


                  if((int)zip_entry_filesize($zip_entry) > 0){

                  

             #

                    $string = zip_entry_name($zip_entry);
                    $folder_string = dirname($string);

              //echo $folder_string;
                //echo('<br>');
                    $folder_array = explode("/",$folder_string);
                    if($folder_string != "."){
                          for($i=count($folder_array) -1; $i>=0;$i--){

                              $folder_name = $folder_array[$i];
                              $empty_string='dump/'.$study_id.'/'.$filename_tm.'/';
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

                              if (FileUpload::where('study_id', '=', $study_id)->where('dateset_id', '=', $filename_tm)->where('type', '=', 'folder')->where('filename', '=', $folder_name)->where('path', '=', rtrim($empty_string, '/'))->where('user_id', '=', $user_id)->exists()) {
                              }
                              else{
                                $bike_save = New FileUpload;
                                $bike_save ->study_id = $study_id;
                                $bike_save ->dateset_id = $filename_tm;
                                $bike_save ->type ="folder";
                                $bike_save ->filename =$folder_name;




                                $bike_save ->user_id =  $user_id;
                                $bike_save ->path =  rtrim($empty_string, '/');
                                $bike_save->save();


                              }
   // user found




                          }
                    }


                    $type = 'file';

                    $c_file_name = basename(zip_entry_name($zip_entry)).PHP_EOL;

                    $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));

                    $check_path_folder = $filename_tm.'/'.dirname(zip_entry_name($zip_entry));

                    // echo "File Name: " . $c_file_name . "\n";
                    //
                    // echo "Path: " . $check_path_folder . "\n";

                    if ($check_path_folder != "") {
                      // code...
                      $localFile = File::get(public_path().'/files/'.$study_id.'/'.$filename_tm.'/'.zip_entry_name($zip_entry));
                    //  dump/S-1551306856758-LEGIip/DataSet2/folder5

                      $modified_path = 'dump/'.$study_id.'/'.$check_path_folder;
                      $exists = Storage::disk('s3')->exists($modified_path.'/'.$c_file_name);
                      if($exists){

                      }
                      else{
                        $tm = Storage::disk('s3')->put($modified_path.'/'.$c_file_name,$localFile, 'private');
                      }
                      

                      $file_ul_tm  = 'http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/'.$study_id.'/'.zip_entry_name($zip_entry);
                      // echo "---------------------- "."file url".$file_ul_tm. '<br>';
                      //
                      // dd($c_file_name  .' ' .$modified_path . ' '.str_replace("dump/".Session::get("current_study_id")."/","",public_path().'/files/'.$source_path));

                      if (FileUpload::where('filename', '=', $c_file_name)->where('path', '=', 'dump/'.$study_id.'/'.$check_path_folder)->where('dateset_id', '=',  $filename_tm)->where('study_id', '=',  $study_id)->where('type', '=',  "file")->where('user_id', '=',  $user_id)->exists()) {
                         // user found
                      }
                      else{

                        $imageUpload = new FileUpload();
                        $imageUpload->filename = $c_file_name;
                        // $imageUpload->data_id = $request->data_id;
                        $imageUpload->path = rtrim('dump/'.$study_id.'/'.$check_path_folder, './');
                        
                        $imageUpload->dateset_id = $filename_tm;
                        $imageUpload->study_id = $study_id;
                        $imageUpload->file_url = $file_ul_tm;
                        //"http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$source_path;
                        // $imageUpload->file_size = (float) zip_entry_filesize($zip_entry);

                        $imageUpload->type = "file";
                        $imageUpload ->user_id = $user_id;
                        $imageUpload->save();
                        $currently_upload_id= $imageUpload ->id;
                        
                        $s3 = \Storage::disk('s3');
                        $client = $s3->getDriver()->getAdapter()->getClient();
                        $expiry = "+10000 minutes";

                        $command = $client->getCommand('GetObject', [
                            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
                            'Key'    => 'dump/'.$study_id.'/'.$check_path_folder.'/'.$c_file_name
                        ]);

                        $request_tm = $client->createPresignedRequest($command, $expiry);
                        $path_s3 = (string) $request_tm->getUri();
                        $file_ul_tm = $path_s3;

                         $updateDetails=array(
                            'file_url' => $file_ul_tm
                          );
                         DB::table('file_uploads')
                        ->where('id', $currently_upload_id)
                        ->update($updateDetails);
                      }
                    }


                  }
                  else{
                   //  $type = 'folder';
                   //  $dont_upload_it = "0";

                   //  if (substr(rtrim(zip_entry_name($zip_entry)), -1) == "/") {
                   //    // Do stuff

                   //    $modified_path = substr(zip_entry_name($zip_entry), 0, strlen(zip_entry_name($zip_entry))-1);


                   //  }



                   //  $c_file_name = basename($modified_path).PHP_EOL;

                   //  $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));

                   //  $check_path_folder = dirname($modified_path);

                   //  $modified_path = 'dump/'.$study_id.'/'.$filename_tm.'/'.$check_path_folder;

                   // # dd($modified_path);


                   //  // echo "Folder Name: " . $c_file_name . "\n";
                   //  //
                   //  // echo "Path: " . $check_path_folder . "\n";

                   //  if ($check_path_folder != "" && ($filename_tm !=$c_file_name) ) {
                   //    // code...
                   //    if($first_folder_check == "0"){
                   //      $first_folder_check = "1";

                   //      if(substr($modified_path, -1) == "."){
                        
                   //        $filename_tm = $c_file_name;
                   //        $updateDetails=array(
                   //          'dataset_name' => $filename_tm
                   //        );
                   //         DB::table('datasets')
                   //        ->where('id', $dataset_id )
                   //        ->update($updateDetails);
                   //        $dont_upload_it = "1";

                   //        if (Datasets::where('study_id', '=', $study_id)->where('dataset_name', '=', $filename_tm)->exists()) {
                   //           // user found
                   //            //DB::table('datasets')->where('id',  $dataset_id )->delete();
                   //        }
                   //         #DB::table('datasets')->where('id',  $dataset_id )->delete();
                   //      }
                       
                   //    }
                   //    if (FileUpload::where('study_id', '=',$study_id)->where('dateset_id', '=',$filename_tm)->where('type', '=','folder')->where('filename', '=',$c_file_name)->where('user_id', '=',$user_id)->where('path', '=',$modified_path)->exists()) {
                   //       // user found
                   //    }
                   //    else{
                   //      if( $dont_upload_it == "0"){
                   //        $bike_save = New FileUpload;
                   //        $bike_save ->study_id = $study_id;
                   //        $bike_save ->dateset_id = $filename_tm;
                   //        $bike_save ->type ="folder";
                   //        $bike_save ->filename =$c_file_name;




                   //        $bike_save ->user_id =  $user_id;
                   //        $bike_save ->path =  rtrim('.',$modified_path);
                          

                   //        $bike_save -> save();
                   //        $dont_upload_it = "0";

                   //      }


                   //    }


                   //  }

                  }

                  if (zip_entry_open($zip, $zip_entry, "r")) {
                    //  echo "File Contents:\n";
                    $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    //  echo "$buf\n";

                    zip_entry_close($zip_entry);
                  }
                //  echo "\n";

                }

                zip_close($zip);

              }


            }

            $path=public_path().'/files/'.$study_id.'/'.$imageName;
            //bytes

            if (file_exists($path)) {

              

                
               // Storage::disk('public')->deleteDirectory($filename_tm);
                // File::deleteDirectory(public_path('/files/'.$study_id.'/'.$filename_tm));
                if (file_upload_queue::where('study_id', '=', $study_id)->where('uploading_done', '=', '0')->exists()) {
                   // user found
                }
                else{

                  
                  
                  Storage::disk('public')->deleteDirectory($study_id);
                  
                }
                unlink($path);
                Storage::disk('public')->deleteDirectory($study_id.'/'.$filename_tm);
                
            }

            // $path=public_path().'/files/'.$filename_tm;
            // //bytes
            //
            // if (file_exists($path)) {
            //     unlink($path);
            // }
          }











          /////////////////////////////////////////////
          ////////////////////////////////////////////
          ///////////////////////////////////////////////
          //////////////////////////////////////////////
          //////////////////////////////////////////////////
          /////////////////////////////////////////////////
          ///////////////////////////////////////////////////
          ///////////////////////////////////////////////////
          /////////////////////////////////////////////////////
          $updateDetails=array(

              'uploading' => '-1',
              'uploading_done' => '1'

            );

            DB::table('file_upload_queues')
            ->where('id', $image->id)
            ->update($updateDetails);

        }

      }
      
      return view('test_file_up_queue');


    }

    public function dataset_file_upload_queue()
    {

      $date = Carbon::now();

      if (file_upload_queue::where('uploading_done', '=', "0")->where('file_type', '=', "dataset")->exists()) {
         
        if (file_upload_queue::where('uploading', '=', "1")->where('file_type', '=', "dataset")->exists()) {
         

        
        }

        else{

          $image = DB::table('file_upload_queues')->where('file_type', '=', "dataset")->where('uploading_done', '=', "0")->first();
          // $image = DB::table('authors')->first();
          // dd($image->author_name);
          $study_id = $image->study_id;
          $imageName = $image->file_name_with_ext;
          $ext = $image->file_ext;
          $filename_tm = $image->file_name;

          $file_url = $image->file_url;
          $user_id = $image->user_id;
          $task_name= $image->task_name;
          $file_size= $image->file_size;



            $updateDetails=array(

              'uploading' => '1'

            );

            DB::table('file_upload_queues')
            ->where('id', $image->id)
            ->update($updateDetails);

          ///////////////////////////////////////////
          ///////////////////////////////////////////
          ///////////////////////////////////////////
          ////////////////////////////////////////////////
          ////////////////////////////////////////////
          /////////////////////////////////////
          //////////////////////////////////////////
          //////////////////////////////////////////////

          if($ext == "zip"){




            // Zipper::make(public_path('/files/'.$study_id.'/'.$imageName))->extractTo(public_path('/files/'.$study_id));
          //  dd("tm");
            $zipper = new \Chumper\Zipper\Zipper;
            $zipper->make(public_path('/files/'.$study_id.'/'.$imageName))->extractTo(public_path('/files/'.$study_id.'/'.$filename_tm ));
            $zipper->close();
            $source_disk = 'public';
            $source_path =  $study_id.'/'.$filename_tm;

            $file_names = Storage::disk($source_disk)->allfiles($source_path);

            $dataset_path_tm = 'dump/'. $study_id .'/' .$source_path;
            $exists = Storage::disk('s3')->exists($dataset_path_tm);

            if($exists){


            }
            else{
          $dataset_given_name= explode(".",$file_url);

         
            // $zip = new Filesystem(new ZipArchiveAdapter(public_path('/files/archive_'.Auth::user()->id.'.zip')));
              $bike_save = New Datasets;
              $bike_save ->study_id = $study_id;
              $bike_save ->dataset_name = $filename_tm;
              $bike_save ->task_related = $task_name;
              $bike_save ->created_date = $date->format("Y-m-d");
              $bike_save ->dataset_url = $file_url ;
              $bike_save ->file_size = $file_size;
              $bike_save ->dateset_id = $dataset_given_name[0];
              $bike_save ->user_id = $user_id;
              $bike_save ->dateset_path = 'dump/' . $study_id ;



              $bike_save -> save();

              $dataset_id = $bike_save ->id;
              $first_folder_check = "0";
            



              $filePath=public_path().'/files/'.$study_id.'/'.$imageName;


              $zip = zip_open($filePath);


              if ($zip) {
                while ($zip_entry = zip_read($zip)) {
                  echo"<br>";
                  echo "Name:               " . zip_entry_name($zip_entry) . "\n";
                  echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\n";
                  echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\n";
                  echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\n";
                  echo"<br>";


                  if((int)zip_entry_filesize($zip_entry) > 0){

                  

             #

                    $string = zip_entry_name($zip_entry);
                    $folder_string = dirname($string);

              //echo $folder_string;
                //echo('<br>');
                    $folder_array = explode("/",$folder_string);
                    if($folder_string != "."){
                          for($i=count($folder_array) -1; $i>=0;$i--){

                              $folder_name = $folder_array[$i];
                              $empty_string='dump/'.$study_id.'/'.$filename_tm.'/';
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

                              if (FileUpload::where('study_id', '=', $study_id)->where('dateset_id', '=', $filename_tm)->where('type', '=', 'folder')->where('filename', '=', $folder_name)->where('path', '=', rtrim($empty_string, '/'))->where('user_id', '=', $user_id)->exists()) {
                              }
                              else{
                                $bike_save = New FileUpload;
                                $bike_save ->study_id = $study_id;
                                $bike_save ->dateset_id = $filename_tm;
                                $bike_save ->type ="folder";
                                $bike_save ->filename =$folder_name;




                                $bike_save ->user_id =  $user_id;
                                $bike_save ->path =  rtrim($empty_string, '/');
                                $bike_save->save();


                              }
   // user found




                          }
                    }


                    $type = 'file';

                    $c_file_name = basename(zip_entry_name($zip_entry)).PHP_EOL;

                    $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));

                    $check_path_folder = $filename_tm.'/'.dirname(zip_entry_name($zip_entry));

                    // echo "File Name: " . $c_file_name . "\n";
                    //
                    // echo "Path: " . $check_path_folder . "\n";

                    if ($check_path_folder != "") {
                      // code...
                      $localFile = File::get(public_path().'/files/'.$study_id.'/'.$filename_tm.'/'.zip_entry_name($zip_entry));
                    //  dump/S-1551306856758-LEGIip/DataSet2/folder5

                      $modified_path = 'dump/'.$study_id.'/'.$check_path_folder;
                      $exists = Storage::disk('s3')->exists($modified_path.'/'.$c_file_name);
                      if($exists){

                      }
                      else{
                        $tm = Storage::disk('s3')->put($modified_path.'/'.$c_file_name,$localFile, 'private');
                      }
                      

                      $file_ul_tm  = 'http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/'.$study_id.'/'.zip_entry_name($zip_entry);
                      // echo "---------------------- "."file url".$file_ul_tm. '<br>';
                      //
                      // dd($c_file_name  .' ' .$modified_path . ' '.str_replace("dump/".Session::get("current_study_id")."/","",public_path().'/files/'.$source_path));

                      if (FileUpload::where('filename', '=', $c_file_name)->where('path', '=', 'dump/'.$study_id.'/'.$check_path_folder)->where('dateset_id', '=',  $filename_tm)->where('study_id', '=',  $study_id)->where('type', '=',  "file")->where('user_id', '=',  $user_id)->exists()) {
                         // user found
                      }
                      else{

                        $imageUpload = new FileUpload();
                        $imageUpload->filename = $c_file_name;
                        // $imageUpload->data_id = $request->data_id;
                        $imageUpload->path = rtrim('dump/'.$study_id.'/'.$check_path_folder, './');
                        
                        $imageUpload->dateset_id = $filename_tm;
                        $imageUpload->study_id = $study_id;
                        $imageUpload->file_url = $file_ul_tm;
                        //"http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$source_path;
                        // $imageUpload->file_size = (float) zip_entry_filesize($zip_entry);

                        $imageUpload->type = "file";
                        $imageUpload ->user_id = $user_id;
                        $imageUpload->save();
                        $currently_upload_id= $imageUpload ->id;
                        
                        $s3 = \Storage::disk('s3');
                        $client = $s3->getDriver()->getAdapter()->getClient();
                        $expiry = "+10000 minutes";

                        $command = $client->getCommand('GetObject', [
                            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
                            'Key'    => 'dump/'.$study_id.'/'.$check_path_folder.'/'.$c_file_name
                        ]);

                        $request_tm = $client->createPresignedRequest($command, $expiry);
                        $path_s3 = (string) $request_tm->getUri();
                        $file_ul_tm = $path_s3;

                         $updateDetails=array(
                            'file_url' => $file_ul_tm
                          );
                         DB::table('file_uploads')
                        ->where('id', $currently_upload_id)
                        ->update($updateDetails);
                      }
                    }


                  }
                  else{
                   //  $type = 'folder';
                   //  $dont_upload_it = "0";

                   //  if (substr(rtrim(zip_entry_name($zip_entry)), -1) == "/") {
                   //    // Do stuff

                   //    $modified_path = substr(zip_entry_name($zip_entry), 0, strlen(zip_entry_name($zip_entry))-1);


                   //  }



                   //  $c_file_name = basename($modified_path).PHP_EOL;

                   //  $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));

                   //  $check_path_folder = dirname($modified_path);

                   //  $modified_path = 'dump/'.$study_id.'/'.$filename_tm.'/'.$check_path_folder;

                   // # dd($modified_path);


                   //  // echo "Folder Name: " . $c_file_name . "\n";
                   //  //
                   //  // echo "Path: " . $check_path_folder . "\n";

                   //  if ($check_path_folder != "" && ($filename_tm !=$c_file_name) ) {
                   //    // code...
                   //    if($first_folder_check == "0"){
                   //      $first_folder_check = "1";

                   //      if(substr($modified_path, -1) == "."){
                        
                   //        $filename_tm = $c_file_name;
                   //        $updateDetails=array(
                   //          'dataset_name' => $filename_tm
                   //        );
                   //         DB::table('datasets')
                   //        ->where('id', $dataset_id )
                   //        ->update($updateDetails);
                   //        $dont_upload_it = "1";

                   //        if (Datasets::where('study_id', '=', $study_id)->where('dataset_name', '=', $filename_tm)->exists()) {
                   //           // user found
                   //            //DB::table('datasets')->where('id',  $dataset_id )->delete();
                   //        }
                   //         #DB::table('datasets')->where('id',  $dataset_id )->delete();
                   //      }
                       
                   //    }
                   //    if (FileUpload::where('study_id', '=',$study_id)->where('dateset_id', '=',$filename_tm)->where('type', '=','folder')->where('filename', '=',$c_file_name)->where('user_id', '=',$user_id)->where('path', '=',$modified_path)->exists()) {
                   //       // user found
                   //    }
                   //    else{
                   //      if( $dont_upload_it == "0"){
                   //        $bike_save = New FileUpload;
                   //        $bike_save ->study_id = $study_id;
                   //        $bike_save ->dateset_id = $filename_tm;
                   //        $bike_save ->type ="folder";
                   //        $bike_save ->filename =$c_file_name;




                   //        $bike_save ->user_id =  $user_id;
                   //        $bike_save ->path =  rtrim('.',$modified_path);
                          

                   //        $bike_save -> save();
                   //        $dont_upload_it = "0";

                   //      }


                   //    }


                   //  }

                  }

                  if (zip_entry_open($zip, $zip_entry, "r")) {
                    //  echo "File Contents:\n";
                    $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    //  echo "$buf\n";

                    zip_entry_close($zip_entry);
                  }
                //  echo "\n";

                }

                zip_close($zip);

              }


            }

            $path=public_path().'/files/'.$study_id.'/'.$imageName;
            //bytes

            if (file_exists($path)) {

              

                
               // Storage::disk('public')->deleteDirectory($filename_tm);
                // File::deleteDirectory(public_path('/files/'.$study_id.'/'.$filename_tm));
                if (file_upload_queue::where('study_id', '=', $study_id)->where('uploading_done', '=', '0')->exists()) {
                   // user found
                }
                else{

                  
                  
                  Storage::disk('public')->deleteDirectory($study_id);
                  
                }
                unlink($path);
                Storage::disk('public')->deleteDirectory($study_id.'/'.$filename_tm);
                
            }

            // $path=public_path().'/files/'.$filename_tm;
            // //bytes
            //
            // if (file_exists($path)) {
            //     unlink($path);
            // }
          }











          /////////////////////////////////////////////
          ////////////////////////////////////////////
          ///////////////////////////////////////////////
          //////////////////////////////////////////////
          //////////////////////////////////////////////////
          /////////////////////////////////////////////////
          ///////////////////////////////////////////////////
          ///////////////////////////////////////////////////
          /////////////////////////////////////////////////////
          $updateDetails=array(

              'uploading' => '-1',
              'uploading_done' => '1'

            );

            DB::table('file_upload_queues')
            ->where('id', $image->id)
            ->update($updateDetails);

        }

      }
    }

  public function change_dataset_name(Request $request)
    {

      


       $updateDetails=array(

              'dateset_id' => $request->new_dataset_name

            );
       if ((Datasets::where('study_id', '=', Session::get("current_study_id"))->where('dateset_id', '=', $request->new_dataset_name )->exists()) || (file_upload_queue::where('study_id', '=', Session::get("current_study_id"))->where('file_url', '=', $request->new_dataset_name.'zip')->where('file_type', '=', 'dataset' )->where('uploading_done', '=', '0' )->exists())) {
       }
       else{
            DB::table('datasets')
            ->where('study_id',  Session::get("current_study_id") )->where('dataset_name',  $request->data_id )
            ->update($updateDetails);
       }




            return Redirect::to('/contents');
    }

    public function delete_dataset(Request $request)
    {
      
      DB::table('datasets')->where('study_id',  Session::get("current_study_id") )->where('dataset_name',  $request->dataset_name )->delete();
      DB::table('file_uploads')->where('study_id',  Session::get("current_study_id") )->where('dateset_id',  $request->dataset_name )->delete();
      DB::table('file_upload_queues')->where('study_id',  Session::get("current_study_id") )->where('file_name',  $request->dataset_name )->where('file_type',  'dataset' )->delete();
      Storage::disk('s3')->deleteDirectory('dump/'.Session::get("current_study_id").'/'. $request->dataset_name);

    }

  

   
    


    public function test_tm(Request $request)
    {

//       $fileContents= 'TM';
//
//    Storage::disk('s3')->put('1', $fileContents, 'public');
//
//
// // http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/files/1
//       // $path = $fileContents->storeAs(
//       //   'dump', #$path
//       //   "tm", #$fileName
//       //   ['disk'=>'ftp', 'visibility'=>'public'] #$options
//       // );
//
//       dd("d");

      // $za = new ZipArchive();

      // $za->open(public_path().'/files/DataSet2.zip');

      // for( $i = 0; $i < $za->numFiles; $i++ ){
      //     $stat = $za->statIndex( $i );
      //     echo('<br>');
      //     echo( basename( $stat['name'] ) . PHP_EOL );
      // }









      $date = Carbon::now();

      ini_set('post_max_size', '100M'); 
      ini_set('upload_max_filesize', '100M'); 
      ini_set('memory_limit', '1000M'); 
      ini_set('max_execution_time', '1920'); 


      $image = $request->file('zipfile');

      $zip_file_real_name = $imageName = $image->getClientOriginalName() ;
      try{
         $file_size = filesize($image);
        }
        catch(\Exception $e){

          $file_size= "0";
        }
      #for ftp

      // $tm = Storage::disk('s3')->put('dump/'.Session::get("current_study_id").'/'.$imageName, $image, 'private');

        $microtime_dataset_name = "D-" . (string) round(microtime(true) * 1000) . "-" . str_random(6);
       // dd($tm);
        $filename_tm = pathinfo($imageName, PATHINFO_FILENAME);

       // dd($imageName);

      //Storage::disk('public')->put($imageName, $image );
      if ((Datasets::where('study_id', '=', Session::get("current_study_id"))->where('dateset_id', '=', $filename_tm )->exists()) || (file_upload_queue::where('study_id', '=', Session::get("current_study_id"))->where('file_url', '=', $imageName )->where('file_type', '=', 'dataset' )->where('uploading_done', '=', '0' )->exists())) {
   // user found
        Session::flash('message', "Same dataset name exists in your study");
      } 
      else{

        
        $image->move(public_path('files/'.Session::get("current_study_id")),$imageName);

        $ext = pathinfo($imageName, PATHINFO_EXTENSION);
        $filename_tm = pathinfo($imageName, PATHINFO_FILENAME);

      // $zip-> Zipper::make(public_path().'/files/' . Session::get("current_study_id") .'/'. $imageName)->extractTo(public_path().'/files/' . Session::get("current_study_id") );
         Zipper::make(public_path().'/files/' . Session::get("current_study_id") .'/'. $imageName)->extractTo(public_path().'/files/' . Session::get("current_study_id") .'/'. $microtime_dataset_name);

      // dd($$zip);


      $files = $directories = $directories = Storage::disk('public')->directories(Session::get("current_study_id") .'/'. $microtime_dataset_name );

      $file = basename($files[0]);
      rename (public_path().'/files/' . Session::get("current_study_id") .'/'. $microtime_dataset_name .'/' . $file, public_path().'/files/' . Session::get("current_study_id") .'/'. $microtime_dataset_name .'/' .$microtime_dataset_name);

     
      # File::move(public_path().'/files/' . Session::get("current_study_id") .'/'. 'tm/', public_path().'/files/' . Session::get("current_study_id"));
// dd($file);
      $files = glob( public_path().'/files/' . Session::get("current_study_id") .'/'. $microtime_dataset_name.'/'. $microtime_dataset_name);
      \Zipper::make( public_path().'/files/' . Session::get("current_study_id") .'/'. $microtime_dataset_name.'.'.$ext)->add($files)->close();

   

      Storage::disk('public')->deleteDirectory(Session::get("current_study_id") .'/'. $microtime_dataset_name );
      Storage::disk('public')->delete(Session::get("current_study_id") .'/'. $imageName);



        $bike_save = New file_upload_queue;
        $bike_save ->study_id = Session::get("current_study_id");
        $bike_save ->file_name_with_ext = $microtime_dataset_name.'.'.$ext;
        $bike_save ->file_ext = $ext;
        $bike_save ->file_name = $microtime_dataset_name ;
        $bike_save ->file_type = "dataset";
        $bike_save ->file_url =  $zip_file_real_name ;
        $bike_save ->file_size = $file_size ;

        $bike_save ->user_id = Auth::user()->id;
        $bike_save ->task_name = $request->task_name_m;

        

        $bike_save -> save();
        

        // dd(  $filename_tm);
//         if($ext == "zip"){




//           Zipper::make(public_path('/files'.'/'.$imageName))->extractTo(public_path('/files'));
//         //  dd("tm");
//           $source_disk = 'public';
//           $source_path =  $filename_tm;

//           $file_names = Storage::disk($source_disk)->allfiles($source_path);

//           $dataset_path_tm = 'dump/'. Session::get("current_study_id") .'/' .$source_path;
//           $exists = Storage::disk('s3')->exists($dataset_path_tm);

//           if($exists){


//           }
//           else{
//           // $zip = new Filesystem(new ZipArchiveAdapter(public_path('/files/archive_'.Auth::user()->id.'.zip')));
//             $bike_save = New Datasets;
//             $bike_save ->study_id = Session::get("current_study_id");
//             $bike_save ->dataset_name = $filename_tm;
//             $bike_save ->task_related = $request->task_name_m;
//             $bike_save ->created_date = $date->format("Y-m-d");
//             $bike_save ->dataset_url = "http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" . $tm ;

//             $bike_save ->user_id = Auth::user()->id;
//             $bike_save ->dateset_path = 'dump/' . Session::get("current_study_id") ;

//             $bike_save -> save();
// //             foreach($file_names as $file_name){
// //                 $file_content = Storage::disk($source_disk)->get($file_name);
// //                 //$zip->put($file_name, $file_content);
// //                 // dd( $file_name);
// //                 $source_path = 'dump/'. Session::get("current_study_id") .'/' ;
// //                 $source_path =  $source_path .$file_name;
// //                 //$storagePath = Storage::disk('s3')->put($source_path, $file_content, 'public');
// //
// //                 $current_path_check = $source_path;
// //                 $c_file_name = basename($current_path_check).PHP_EOL;
// //
// //
// //
// //               //  if (substr(rtrim($current_path_check), -1) == "/") {
// //                     // Do stuff
// //               $modified_path = $current_path_check;
// //
// //               if (substr(rtrim(Session::get("current_path")), -1) == "/") {
// //                   // Do stuff
// //
// //                     $modified_path = substr($current_path_check, 0, strlen($current_path_check)-1);
// //
// //
// //                 }
// //
// //
// //               $modified_path = dirname($modified_path);
// //               $size = 0;
// //               try{
// //
// //                 $size = Storage::disk('public')->size($file_name);
// //
// //
// //                 $size = (float) $size;
// //                 $size = ((float)(1/125000) * $size);
// //                 if(is_float ( $size )){
// //
// //
// //                 }else{
// //                   $size = 0;
// //                 }
// //               }
// //               catch(Exception $e){
// //
// //
// //               }
// //
// //
// //               $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));
// //
// //               // $fileContents= 'TM';
// //
// //               $tm_temp =  str_replace("dump/".Session::get("current_study_id")."/","",$source_path);
// //
// //
// //               $fileContents = Storage::disk('public')->get($tm_temp);
// //
// //               // $path = $fileContents->storeAs(
// //               //   $modified_path, #$path
// //               //   "tm", #$fileName
// //               //   ['disk'=>'ftp', 'visibility'=>'public'] #$options
// //               // );
// //               // dd('s');
// //
// //               $localFile = File::get(public_path().'/files/'.$tm_temp);
// //
// //
// //               //Storage::disk('s3')->put('path/to/distant-file.ext', $localFile);
// //
// //               // $path = $localFile->storeAs(
// //               //   $modified_path, #$path
// //               //   "tm", #$fileName
// //               //   ['disk'=>'ftp', 'visibility'=>'public'] #$options
// //               // );
// //
// // //echo("dsd");
// //             $tm = Storage::disk('s3')->put($modified_path.'/'.$c_file_name,$localFile, 'public');
// // //             Storage::disk('s3')->download('http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/S-1551306856758-LEGIip/DataSet2/folder5/1');
// // // dd("stopo");
// // // echo('http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/'.$modified_path.'/'.$c_file_name);
// //         //    $url = Storage::disk('s3')->url($modified_path.'/'.$c_file_name);
// //
// //
// //
// //               //dd($url);
// //               $file_ul_tm  = 'http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/'.$modified_path.'/'.$c_file_name;
// //               // echo "---------------------- "."file url".$file_ul_tm. '<br>';
// //               //
// //               // dd($c_file_name  .' ' .$modified_path . ' '.str_replace("dump/".Session::get("current_study_id")."/","",public_path().'/files/'.$source_path));
// //
// //               $imageUpload = new FileUpload();
// //               $imageUpload->filename = $c_file_name;
// //               // $imageUpload->data_id = $request->data_id;
// //               $imageUpload->path = $modified_path;
// //               $imageUpload->dateset_id = $filename_tm;
// //               $imageUpload->study_id = Session::get("current_study_id");
// //               $imageUpload->file_url = $file_ul_tm;
// //               //"http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$source_path;
// //               $imageUpload->file_size = $size;
// //
// //               $imageUpload->type = "file";
// //               $imageUpload ->user_id = Auth::user()->id;
// //               $imageUpload->save();
// //               $break_loop = 0;
// //               $check_path_folder = $modified_path;
// //               // echo '<br>' .'<br>'. '-------------S-------------';
// //               // echo '<br>' .'<br>' .$modified_path .'<br>' .'<br>';
// //               while($break_loop < 1) {
// //                 $c_file_name_folder = basename($check_path_folder).PHP_EOL;
// //                 $c_file_name_folder = trim(preg_replace('/\s+/', ' ', $c_file_name_folder));
// //               //  dd($c_file_name_folder);
// //                 if($c_file_name_folder == $filename_tm){
// //                   // echo "dataset found".'<br>';
// //                   $break_loop = 1;
// //                 }
// //                 else{
// //
// //                   //$exists = Storage::disk('s3')->exists($check_path_folder);
// //
// //                 //  if (FileUpload::where('study_id', Session::get("current_study_id"))->where('type', 'folder')->where('path', $check_path_folder)->where('user_id', Auth::user()->id)->where('filename', $c_file_name_folder)->where('dateset_id', $filename_tm)->exists()){
// //                   $row_count =FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->count();
// // // echo '<br>' .'<br>' .'row counts  '.$row_count . '<br>';
// //                   $user = FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->first();
// //                   if ($row_count < 1) {
// //                      // user doesn't exist
// //
// //
// //                      // echo "folder found ".$c_file_name_folder .'   <br>' .$check_path_folder. '<br>';
// //                      $check_path_folder = dirname($check_path_folder);
// //                      // echo "db_path ".$check_path_folder. '<br>';
// //
// //                      $array_same  = FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->where('type', 'folder')->get();
// //                       // echo "---------------------- ".sizeof($array_same). '<br>';
// //
// //                     if(sizeof($array_same) < 1){
// //
// //                       // echo "---------------------- "."Entry". '<br>';
// //
// //
// //                        $bike_save = New FileUpload;
// //                        $bike_save ->study_id = Session::get("current_study_id");
// //                        $bike_save ->dateset_id = $filename_tm;
// //                        $bike_save ->type ="folder";
// //                        $bike_save ->filename =$c_file_name_folder;
// //
// //
// //
// //
// //                        $bike_save ->user_id = Auth::user()->id;
// //                        $bike_save ->path =  $check_path_folder;
// //
// //                        $bike_save -> save();
// //                      }
// //
// //   //                    $deleteDuplicates = DB::table('file_uploads as n1')
// //   // ->join('file_uploads as n2', 'n1.id', '<', 'n2.id')
// //   //   ->where('n1.path', '=', 'n2.path') ->where('n1.filename', '=', 'n2.filename')->delete();
// //                       $array_same  = FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->where('type', 'folder')->get();
// //
// //                       for ($x = 1; $x <sizeof($array_same); $x++) {
// //                         // echo '<br>' .'<br>' .'row counts  '.$array_same[$x]["id"] . '<br>';
// //
// //                         DB::delete('delete from file_uploads where id = ?',[$array_same[$x]["id"]]);
// //
// //                       }
// //
// //                       $row_count =FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->count();
// //
// //
// //                      // $m = DB:delete('delete from file_uploads where path = ? type = ? filename = ? limit ?', array($check_path_folder, 'folder'.$c_file_name_folder, ($row_count - 1)));
// //                   }
// //
// //
// //
// //
// //
// //                 }
// //               //  $check_path_folder = dirname($check_path_folder);
// //               }
// //
// //
// //
// //
// //               $deleteDuplicates =
// //
// //                                   DB::table('file_uploads as n1')
// //                                   ->join('file_uploads as n2', 'n1.id', '<', 'n2.id')
// //                                     ->where('n1.path', '=', 'n2.path') ->delete();
// //
// //    // echo '<br>' .'<br>'. '--------------------------';
// //               //$storagePath = Storage::disk('s3')->put($source_path, $file_content, 'public');
// //                // echo '<br>' .'<br>' .$source_path . '<br>' . $c_file_name . '<br>'.$modified_path. '<br>'.$size. '<br>'. '<br>';
// //    // echo '<br>' .'<br>'. '--------------E------------';
// //
// //             }


//             $filePath=public_path().'/files/'.$imageName;


//             $zip = zip_open($filePath);

//             if ($zip) {
//               while ($zip_entry = zip_read($zip)) {
//                 // echo"<br>";
//                 // echo "Name:               " . zip_entry_name($zip_entry) . "\n";
//                 // echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\n";
//                 // echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\n";
//                 // echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\n";

//                 if((int)zip_entry_filesize($zip_entry) > 0){

//                   $type = 'file';

//                   $c_file_name = basename(zip_entry_name($zip_entry)).PHP_EOL;

//                   $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));

//                   $check_path_folder = dirname(zip_entry_name($zip_entry));

//                   // echo "File Name: " . $c_file_name . "\n";
//                   //
//                   // echo "Path: " . $check_path_folder . "\n";

//                   if ($check_path_folder != "") {
//                     // code...
//                     $localFile = File::get(public_path().'/files/'.zip_entry_name($zip_entry));
//                   //  dump/S-1551306856758-LEGIip/DataSet2/folder5

//                     $modified_path = 'dump/'.Session::get("current_study_id").'/'.$check_path_folder;

//                     $tm = Storage::disk('s3')->put($modified_path.'/'.$c_file_name,$localFile, 'public');

//                     $file_ul_tm  = 'http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/'.Session::get("current_study_id").'/'.zip_entry_name($zip_entry);
//                     // echo "---------------------- "."file url".$file_ul_tm. '<br>';
//                     //
//                     // dd($c_file_name  .' ' .$modified_path . ' '.str_replace("dump/".Session::get("current_study_id")."/","",public_path().'/files/'.$source_path));

//                     $imageUpload = new FileUpload();
//                     $imageUpload->filename = $c_file_name;
//                     // $imageUpload->data_id = $request->data_id;
//                     $imageUpload->path = 'dump/'.Session::get("current_study_id").'/'.$check_path_folder;
//                     $imageUpload->dateset_id = $filename_tm;
//                     $imageUpload->study_id = Session::get("current_study_id");
//                     $imageUpload->file_url = $file_ul_tm;
//                     //"http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$source_path;
//                     // $imageUpload->file_size = (float) zip_entry_filesize($zip_entry);

//                     $imageUpload->type = "file";
//                     $imageUpload ->user_id = Auth::user()->id;
//                     $imageUpload->save();
//                   }


//                 }
//                 else{
//                   $type = 'folder';

//                   if (substr(rtrim(zip_entry_name($zip_entry)), -1) == "/") {
//                     // Do stuff

//                     $modified_path = substr(zip_entry_name($zip_entry), 0, strlen(zip_entry_name($zip_entry))-1);


//                   }



//                   $c_file_name = basename($modified_path).PHP_EOL;

//                   $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));

//                   $check_path_folder = dirname($modified_path);

//                   $modified_path = 'dump/'.Session::get("current_study_id").'/'.$check_path_folder;


//                   // echo "Folder Name: " . $c_file_name . "\n";
//                   //
//                   // echo "Path: " . $check_path_folder . "\n";

//                   if ($check_path_folder != "" && ($filename_tm !=$c_file_name) ) {
//                     // code...

//                     $bike_save = New FileUpload;
//                     $bike_save ->study_id = Session::get("current_study_id");
//                     $bike_save ->dateset_id = $filename_tm;
//                     $bike_save ->type ="folder";
//                     $bike_save ->filename =$c_file_name;




//                     $bike_save ->user_id = Auth::user()->id;
//                     $bike_save ->path =  $modified_path;

//                     $bike_save -> save();
//                   }

//                 }

//                 if (zip_entry_open($zip, $zip_entry, "r")) {
//                   //  echo "File Contents:\n";
//                   $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
//                   //  echo "$buf\n";

//                   zip_entry_close($zip_entry);
//                 }
//               //  echo "\n";

//               }

//               zip_close($zip);

//             }


//           }

//           $path=public_path().'/files/'.$imageName;
//           //bytes

//           if (file_exists($path)) {
//               unlink($path);
//               Storage::disk('public')->deleteDirectory($filename_tm);
//           }

//           // $path=public_path().'/files/'.$filename_tm;
//           // //bytes
//           //
//           // if (file_exists($path)) {
//           //     unlink($path);
//           // }
//         }
    Session::flash('message', "We are uploading the file(s), check back later");
  }

    return Redirect::to('/datasets');

    }

    public function zipcreate_test()
    {
        if(Auth::check()){
          $path=public_path().'/files/archive_'.Auth::user()->id.'.zip';
          //bytes

          if (file_exists($path)) {
              unlink($path);
          }
        }
      // see laravel's config/filesystem.php for the source disk
       $source_disk = 's3';
       $source_path = Session::get("current_path");
       if ($source_path == "") {
         # code...
        $source_path = 'dump/'. Session::get("current_study_id");
       }


       $file_names = Storage::disk($source_disk)->allfiles($source_path);

       $zip = new Filesystem(new ZipArchiveAdapter(public_path('/files/archive_'.Auth::user()->id.'.zip')));

       foreach($file_names as $file_name){
           $file_content = Storage::disk($source_disk)->get($file_name);
           $zip->put($file_name, $file_content);


       }

       $zip->getAdapter()->getArchive()->close();

       $path=public_path().'/archive.zip';

       //dd($path);
     







      // return redirect('archive.zip');
       return response()->download(public_path('/files/archive_'.Auth::user()->id.'.zip'))->deleteFileAfterSend(true);




    }



    public function check_for_filename(Request $request)
    {
      $imageName = $request->file_name;
      $exists = Storage::disk('s3')->exists(Session::get("current_path") .'/'.$imageName);
      if($exists){

        $i = 1;
        $break_loop = 0;

        while($break_loop < 1) {

            // $ext = pathinfo('dump/S-1551143309306-qcoVdc/DataSet1/17540945678_26b2d5e37d_o.jpg', PATHINFO_EXTENSION);
            //
            // $filename_tm = pathinfo('dump/S-1551143309306-qcoVdc/DataSet1/17540945678_26b2d5e37d_o.jpg', PATHINFO_FILENAME);
            //

            $ext = pathinfo(Session::get("current_path") .'/'.$imageName, PATHINFO_EXTENSION);
            $filename_tm = pathinfo(Session::get("current_path") .'/'.$imageName, PATHINFO_FILENAME);
            $filename_check = $filename_tm . "(" .(string) $i .').'.$ext;
            $exists = Storage::disk('s3')->exists(Session::get("current_path") .'/'.$filename_check);
            if($exists){}
            else{
                $imageName = $filename_check ;
                $break_loop = 1;
            }
            $i ++;
        }


      }

      return $imageName;


    }

    public function fileStore(Request $request)
    {

      // dd($request->all());
         $image = $request->file('file');
         // dd($image);
        $imageName = $image->getClientOriginalName() ;





        $image->move(public_path('files'),$imageName);

       // $tm = file_get_contents($request->file('file'));
        $contnets = Storage::disk('public')->get($imageName);



        $path = $request->path .'/';

        $storagePath = Storage::disk('s3')->put($path .$imageName, $contnets, 'private');


        $path=public_path().'/files/'.$imageName;
        //bytes
        $size = Storage::disk('public')->size($imageName);

        $size = (float) $size;
        $size = ((float)(1/125000) * $size);
        if (file_exists($path)) {
            unlink($path);
        }



// http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/files/1

        $imageUpload = new FileUpload();
        $imageUpload->filename = $imageName;
        // $imageUpload->data_id = $request->data_id;
        $imageUpload->path = $request->path;
        $imageUpload->dateset_id = Session::get("current_dataset_name");
        $imageUpload->study_id = Session::get("current_study_id");
        $imageUpload->file_url = "http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$request->path . "/". $imageName;
        $imageUpload->file_size = $size;

        $imageUpload->type = "file";
        $imageUpload ->user_id = Auth::user()->id;
        $imageUpload->save();
        //return response()->json(['success'=>$imageName]);
    }

     public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');

        $path=public_path().'/files/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }

        $path = Session::get("current_path") .'/'.$filename;

        Storage::disk('s3')->delete($path);

        FileUpload::where('filename',$filename)->where('user_id',  Auth::user()->id)->where('study_id',  Session::get("current_study_id"))->where('dateset_id',  Session::get("current_dataset_name"))->delete();
        return $filename;
    }

    public function smart_search_zip_creation(Request $request,$files_string)
    {
      $arr=explode(",",$files_string);
      // $random_id = uniqid();   
     
     

      #################################3
      #################
      if(Auth::check()){
        $path=public_path().'/files/archive_'.Auth::user()->id.'.zip';
        //bytes

        if (file_exists($path)) {
            unlink($path);
        }
      }
    // see laravel's config/filesystem.php for the source disk
     $source_disk = 's3';
     $source_path = Session::get("current_path");
     if ($source_path == "") {
       # code...
      $source_path = 'dump/'. Session::get("current_study_id");
     }




    $file_names = Storage::disk($source_disk)->allfiles($source_path);

    $zip = new Filesystem(new ZipArchiveAdapter(public_path('/files/archive_'.Auth::user()->id.'.zip')));
    

     foreach($file_names as $file_name){



         // echo $file_name;
         // echo '<br>';

        for ($x = 0; $x <count($arr); $x++) {
         # $c_folder_name = preg_replace('/\s+/', ' ', $arr[$x]);
          $c_folder_name = trim(preg_replace('/\s+/',' ', $arr[$x]));
          // echo $c_folder_name;
          // echo '<br>';

          if (strpos($file_name, '/'.$c_folder_name.'/') !== false) {
            
            // echo $file_name;

            // echo '<br>';
            $file_content = Storage::disk($source_disk)->get($file_name);
            $zip->put($file_name, $file_content);
          }
        }
         // $file_content = Storage::disk($source_disk)->get($file_name);
         // $zip->put($file_name, $file_content);


     }









    $zip->getAdapter()->getArchive()->close();

     $path=public_path().'/archive.zip';
      // dd($arr);

      // dd($files_string);

     return response()->download(public_path('/files/archive_'.Auth::user()->id.'.zip'))->deleteFileAfterSend(true);
      ###############################
      ##########################
    }

    



    public function zipcreate(Request $request)
    {

      // Issues https://github.com/Chumper/Zipper/issues/118
      // https://stackoverflow.com/questions/38104348/install-php-zip-on-php-5-6-on-ubuntu
        // $files = glob(public_path('files/files1'));
        // \Zipper::make(public_path('test.zip'))->add($files)->close();





        dd($zip);
        //return response()->download(public_path('test.zip'));
    }
}
