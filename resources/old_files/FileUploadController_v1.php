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


    public function test_tm(Request $request)
    {

//       $fileContents= 'TM';
//
//    Storage::disk('ftp')->put('1', $fileContents, 'public');
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
      $imageName = $image->getClientOriginalName() ;

      $tm = Storage::disk('ftp')->put('dump/'.Session::get("current_study_id").'/'.$imageName, $image, 'public');


      // dd($tm);

      //Storage::disk('public')->put($imageName, $image );

        $image->move(public_path('files'),$imageName);

        $ext = pathinfo($imageName, PATHINFO_EXTENSION);
        $filename_tm = pathinfo($imageName, PATHINFO_FILENAME);
        // dd(  $filename_tm);
        if($ext == "zip"){




          Zipper::make(public_path('/files'.'/'.$imageName))->extractTo(public_path('/files'));
        //  dd("tm");
          $source_disk = 'public';
          $source_path =  $filename_tm;

          $file_names = Storage::disk($source_disk)->allfiles($source_path);

          $dataset_path_tm = 'dump/'. Session::get("current_study_id") .'/' .$source_path;
          $exists = Storage::disk('ftp')->exists($dataset_path_tm);

          if($exists){


          }
          else{
          // $zip = new Filesystem(new ZipArchiveAdapter(public_path('/files/archive_'.Auth::user()->id.'.zip')));
            $bike_save = New Datasets;
            $bike_save ->study_id = Session::get("current_study_id");
            $bike_save ->dataset_name = $filename_tm;
            $bike_save ->task_related = $request->task_name_m;
            $bike_save ->created_date = $date->format("Y-m-d");
            $bike_save ->dataset_url = "http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" . $tm ;

            $bike_save ->user_id = Auth::user()->id;
            $bike_save ->dateset_path = 'dump/' . Session::get("current_study_id") ;

            $bike_save -> save();
//             foreach($file_names as $file_name){
//                 $file_content = Storage::disk($source_disk)->get($file_name);
//                 //$zip->put($file_name, $file_content);
//                 // dd( $file_name);
//                 $source_path = 'dump/'. Session::get("current_study_id") .'/' ;
//                 $source_path =  $source_path .$file_name;
//                 //$storagePath = Storage::disk('ftp')->put($source_path, $file_content, 'public');
//
//                 $current_path_check = $source_path;
//                 $c_file_name = basename($current_path_check).PHP_EOL;
//
//
//
//               //  if (substr(rtrim($current_path_check), -1) == "/") {
//                     // Do stuff
//               $modified_path = $current_path_check;
//
//               if (substr(rtrim(Session::get("current_path")), -1) == "/") {
//                   // Do stuff
//
//                     $modified_path = substr($current_path_check, 0, strlen($current_path_check)-1);
//
//
//                 }
//
//
//               $modified_path = dirname($modified_path);
//               $size = 0;
//               try{
//
//                 $size = Storage::disk('public')->size($file_name);
//
//
//                 $size = (float) $size;
//                 $size = ((float)(1/125000) * $size);
//                 if(is_float ( $size )){
//
//
//                 }else{
//                   $size = 0;
//                 }
//               }
//               catch(Exception $e){
//
//
//               }
//
//
//               $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));
//
//               // $fileContents= 'TM';
//
//               $tm_temp =  str_replace("dump/".Session::get("current_study_id")."/","",$source_path);
//
//
//               $fileContents = Storage::disk('public')->get($tm_temp);
//
//               // $path = $fileContents->storeAs(
//               //   $modified_path, #$path
//               //   "tm", #$fileName
//               //   ['disk'=>'ftp', 'visibility'=>'public'] #$options
//               // );
//               // dd('s');
//
//               $localFile = File::get(public_path().'/files/'.$tm_temp);
//
//
//               //Storage::disk('ftp')->put('path/to/distant-file.ext', $localFile);
//
//               // $path = $localFile->storeAs(
//               //   $modified_path, #$path
//               //   "tm", #$fileName
//               //   ['disk'=>'ftp', 'visibility'=>'public'] #$options
//               // );
//
// //echo("dsd");
//             $tm = Storage::disk('ftp')->put($modified_path.'/'.$c_file_name,$localFile, 'public');
// //             Storage::disk('ftp')->download('http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/S-1551306856758-LEGIip/DataSet2/folder5/1');
// // dd("stopo");
// // echo('http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/'.$modified_path.'/'.$c_file_name);
//         //    $url = Storage::disk('ftp')->url($modified_path.'/'.$c_file_name);
//
//
//
//               //dd($url);
//               $file_ul_tm  = 'http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/'.$modified_path.'/'.$c_file_name;
//               // echo "---------------------- "."file url".$file_ul_tm. '<br>';
//               //
//               // dd($c_file_name  .' ' .$modified_path . ' '.str_replace("dump/".Session::get("current_study_id")."/","",public_path().'/files/'.$source_path));
//
//               $imageUpload = new FileUpload();
//               $imageUpload->filename = $c_file_name;
//               // $imageUpload->data_id = $request->data_id;
//               $imageUpload->path = $modified_path;
//               $imageUpload->dateset_id = $filename_tm;
//               $imageUpload->study_id = Session::get("current_study_id");
//               $imageUpload->file_url = $file_ul_tm;
//               //"http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$source_path;
//               $imageUpload->file_size = $size;
//
//               $imageUpload->type = "file";
//               $imageUpload ->user_id = Auth::user()->id;
//               $imageUpload->save();
//               $break_loop = 0;
//               $check_path_folder = $modified_path;
//               // echo '<br>' .'<br>'. '-------------S-------------';
//               // echo '<br>' .'<br>' .$modified_path .'<br>' .'<br>';
//               while($break_loop < 1) {
//                 $c_file_name_folder = basename($check_path_folder).PHP_EOL;
//                 $c_file_name_folder = trim(preg_replace('/\s+/', ' ', $c_file_name_folder));
//               //  dd($c_file_name_folder);
//                 if($c_file_name_folder == $filename_tm){
//                   // echo "dataset found".'<br>';
//                   $break_loop = 1;
//                 }
//                 else{
//
//                   //$exists = Storage::disk('ftp')->exists($check_path_folder);
//
//                 //  if (FileUpload::where('study_id', Session::get("current_study_id"))->where('type', 'folder')->where('path', $check_path_folder)->where('user_id', Auth::user()->id)->where('filename', $c_file_name_folder)->where('dateset_id', $filename_tm)->exists()){
//                   $row_count =FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->count();
// // echo '<br>' .'<br>' .'row counts  '.$row_count . '<br>';
//                   $user = FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->first();
//                   if ($row_count < 1) {
//                      // user doesn't exist
//
//
//                      // echo "folder found ".$c_file_name_folder .'   <br>' .$check_path_folder. '<br>';
//                      $check_path_folder = dirname($check_path_folder);
//                      // echo "db_path ".$check_path_folder. '<br>';
//
//                      $array_same  = FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->where('type', 'folder')->get();
//                       // echo "---------------------- ".sizeof($array_same). '<br>';
//
//                     if(sizeof($array_same) < 1){
//
//                       // echo "---------------------- "."Entry". '<br>';
//
//
//                        $bike_save = New FileUpload;
//                        $bike_save ->study_id = Session::get("current_study_id");
//                        $bike_save ->dateset_id = $filename_tm;
//                        $bike_save ->type ="folder";
//                        $bike_save ->filename =$c_file_name_folder;
//
//
//
//
//                        $bike_save ->user_id = Auth::user()->id;
//                        $bike_save ->path =  $check_path_folder;
//
//                        $bike_save -> save();
//                      }
//
//   //                    $deleteDuplicates = DB::table('file_uploads as n1')
//   // ->join('file_uploads as n2', 'n1.id', '<', 'n2.id')
//   //   ->where('n1.path', '=', 'n2.path') ->where('n1.filename', '=', 'n2.filename')->delete();
//                       $array_same  = FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->where('type', 'folder')->get();
//
//                       for ($x = 1; $x <sizeof($array_same); $x++) {
//                         // echo '<br>' .'<br>' .'row counts  '.$array_same[$x]["id"] . '<br>';
//
//                         DB::delete('delete from file_uploads where id = ?',[$array_same[$x]["id"]]);
//
//                       }
//
//                       $row_count =FileUpload::where('path', '=', $check_path_folder)->where('filename', $c_file_name_folder)->count();
//
//
//                      // $m = DB:delete('delete from file_uploads where path = ? type = ? filename = ? limit ?', array($check_path_folder, 'folder'.$c_file_name_folder, ($row_count - 1)));
//                   }
//
//
//
//
//
//                 }
//               //  $check_path_folder = dirname($check_path_folder);
//               }
//
//
//
//
//               $deleteDuplicates =
//
//                                   DB::table('file_uploads as n1')
//                                   ->join('file_uploads as n2', 'n1.id', '<', 'n2.id')
//                                     ->where('n1.path', '=', 'n2.path') ->delete();
//
//    // echo '<br>' .'<br>'. '--------------------------';
//               //$storagePath = Storage::disk('ftp')->put($source_path, $file_content, 'public');
//                // echo '<br>' .'<br>' .$source_path . '<br>' . $c_file_name . '<br>'.$modified_path. '<br>'.$size. '<br>'. '<br>';
//    // echo '<br>' .'<br>'. '--------------E------------';
//
//             }


            $filePath=public_path().'/files/'.$imageName;


            $zip = zip_open($filePath);

            if ($zip) {
              while ($zip_entry = zip_read($zip)) {
                // echo"<br>";
                // echo "Name:               " . zip_entry_name($zip_entry) . "\n";
                // echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\n";
                // echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\n";
                // echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\n";

                if((int)zip_entry_filesize($zip_entry) > 0){

                  $type = 'file';

                  $c_file_name = basename(zip_entry_name($zip_entry)).PHP_EOL;

                  $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));

                  $check_path_folder = dirname(zip_entry_name($zip_entry));

                  // echo "File Name: " . $c_file_name . "\n";
                  //
                  // echo "Path: " . $check_path_folder . "\n";

                  if ($check_path_folder != "") {
                    // code...
                    $localFile = File::get(public_path().'/files/'.zip_entry_name($zip_entry));
                  //  dump/S-1551306856758-LEGIip/DataSet2/folder5

                    $modified_path = 'dump/'.Session::get("current_study_id").'/'.$check_path_folder;

                    $tm = Storage::disk('ftp')->put($modified_path.'/'.$c_file_name,$localFile, 'public');

                    $file_ul_tm  = 'http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/dump/'.Session::get("current_study_id").'/'.zip_entry_name($zip_entry);
                    // echo "---------------------- "."file url".$file_ul_tm. '<br>';
                    //
                    // dd($c_file_name  .' ' .$modified_path . ' '.str_replace("dump/".Session::get("current_study_id")."/","",public_path().'/files/'.$source_path));

                    $imageUpload = new FileUpload();
                    $imageUpload->filename = $c_file_name;
                    // $imageUpload->data_id = $request->data_id;
                    $imageUpload->path = 'dump/'.Session::get("current_study_id").'/'.$check_path_folder;
                    $imageUpload->dateset_id = $filename_tm;
                    $imageUpload->study_id = Session::get("current_study_id");
                    $imageUpload->file_url = $file_ul_tm;
                    //"http://challenge.cls.mtu.edu/challenge.cls.mtu.edu/poda_storage/" .$source_path;
                    // $imageUpload->file_size = (float) zip_entry_filesize($zip_entry);

                    $imageUpload->type = "file";
                    $imageUpload ->user_id = Auth::user()->id;
                    $imageUpload->save();
                  }


                }
                else{
                  $type = 'folder';

                  if (substr(rtrim(zip_entry_name($zip_entry)), -1) == "/") {
                    // Do stuff

                    $modified_path = substr(zip_entry_name($zip_entry), 0, strlen(zip_entry_name($zip_entry))-1);


                  }



                  $c_file_name = basename($modified_path).PHP_EOL;

                  $c_file_name = trim(preg_replace('/\s+/', ' ', $c_file_name));

                  $check_path_folder = dirname($modified_path);

                  $modified_path = 'dump/'.Session::get("current_study_id").'/'.$check_path_folder;


                  // echo "Folder Name: " . $c_file_name . "\n";
                  //
                  // echo "Path: " . $check_path_folder . "\n";

                  if ($check_path_folder != "" && ($filename_tm !=$c_file_name) ) {
                    // code...

                    $bike_save = New FileUpload;
                    $bike_save ->study_id = Session::get("current_study_id");
                    $bike_save ->dateset_id = $filename_tm;
                    $bike_save ->type ="folder";
                    $bike_save ->filename =$c_file_name;




                    $bike_save ->user_id = Auth::user()->id;
                    $bike_save ->path =  $modified_path;

                    $bike_save -> save();
                  }

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

          $path=public_path().'/files/'.$imageName;
          //bytes

          if (file_exists($path)) {
              unlink($path);
              Storage::disk('public')->deleteDirectory($filename_tm);
          }

          // $path=public_path().'/files/'.$filename_tm;
          // //bytes
          //
          // if (file_exists($path)) {
          //     unlink($path);
          // }
        }

      return Redirect::to('/datesets');

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
       $source_disk = 'ftp';
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
       return response()->download(public_path('/files/archive_'.Auth::user()->id.'.zip'));



    }



    public function check_for_filename(Request $request)
    {
      $imageName = $request->file_name;
      $exists = Storage::disk('ftp')->exists(Session::get("current_path") .'/'.$imageName);
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
            $exists = Storage::disk('ftp')->exists(Session::get("current_path") .'/'.$filename_check);
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

        $storagePath = Storage::disk('ftp')->put($path .$imageName, $contnets, 'public');


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

        Storage::disk('ftp')->delete($path);

        FileUpload::where('filename',$filename)->where('user_id',  Auth::user()->id)->where('study_id',  Session::get("current_study_id"))->where('dateset_id',  Session::get("current_dataset_name"))->delete();
        return $filename;
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
