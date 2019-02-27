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


      $image = $request->file('zipfile');
      $imageName = $image->getClientOriginalName() ;



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

            foreach($file_names as $file_name){
                $file_content = Storage::disk($source_disk)->get($file_name);
                //$zip->put($file_name, $file_content);
                // dd( $file_name);
                $source_path = 'dump/'. Session::get("current_study_id") .'/' ;
                $source_path =  $source_path .$file_name;


                $storagePath = Storage::disk('ftp')->put($source_path, $file_content, 'public');
                echo $source_path . '<br>';

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
