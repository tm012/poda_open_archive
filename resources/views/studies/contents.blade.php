@extends('default_contents')
@section('content')
  <br> <br><br> <br>
      <br> <br><br> <br> 
@if (Session::has('message'))
<div class="alert alert-info center_div">
 <p align="middle" class="">{{ Session::get('message') }}</p>

</div>
@endif



@php

  $current_path = Session::get("current_path");
  #echo $current_path;
  #echo '-----------------------';


  #$study_id = substr($string_upto_study_id, strrpos($string_upto_study_id, '/') + 1);
  $study_name = DB::table('studies')->where('study_id', '=', Session::get("current_study_id"))->value('study_name');
  # echo $study_name;
  $cars = array("Volvo", "BMW", "Toyota");
  $current_dataset_name =  Session::get("current_dataset_name");
 $array_paths=array();
  $array_basenames=array();
 # array_push($array_paths,'dump/'.Session::get("current_study_id").'');
 #array_push($array_paths,'dump/'.Session::get("current_study_id").'/'.$current_dataset_name.'');


 $output =  $current_path;

 $string_upto_dataset = 'dump/'. Session::get("current_study_id");
 $string_upto_dataset_real = 'dump/'. Session::get("current_study_id").'/'.$current_dataset_name;

 
# echo $string_upto_dataset;
 $i=0;
#echo $current_path;
#echo '          ';

 while( ($string_upto_dataset != $output)){
    if($string_upto_dataset != $output){
      if($i < 1){
        $output=$current_path;
        array_push($array_basenames,basename($output).PHP_EOL);
        array_push($array_paths,$output);
        #echo $i;
      }else{
        $output= dirname($output);
        #echo $output;
        array_push($array_basenames,basename($output).PHP_EOL);
        array_push($array_paths,$output);
        
        #echo $i;
      }
      $i=$i+1;
    }


    
} 
#array_push($array_paths,'dump/'.Session::get("current_study_id").'');
#print_r($array_paths);
#print_r($array_basenames);
$array_paths=array_reverse($array_paths);
$array_basenames = array_reverse($array_basenames);

 

@endphp

<div align="center" class="container">
  <div class="row">
    <div align="right" class="col-sm-12">
@if(Auth::check())
 <a style="text-decoration:none; color:black;"   href="studies/my_studies">{{ $study_name}}/</a>
@else

<a style="text-decoration:none; color:black;"   href="/welcome">{{ $study_name}}/</a>
@endif



 <!--  <a style="text-decoration:none; color:black;"   href="/datesets">{{ Session::get("current_dataset_name")}}/</a> -->
@for ($i = 1; $i <count($array_paths); $i++)
  @if ($string_upto_dataset_real == $array_paths[$i]) 
    <a style="text-decoration:none; color:black;" class="go_to_dataset_breadcrumb" data-value="{{$array_paths[$i]}}" href="/contents">{{$array_basenames[$i]}}</a>/
  @else

  <a style="text-decoration:none; color:black;" class ="bread_tags" data-value="{{$array_paths[$i]}}"onclick='return check()' href="/contents">{{$array_basenames[$i]}}</a>/

  @endif

       
@endfor
</div></div></div>
<div align="center" class="container">
  <div class="row">
    <div align="left" class="col-sm-5">
  <input type="image" src="/img/left_arrow.png" class="back_button" alt="Submit" width="30" height="30">
    </div>
    <div align="right" class="col-sm-7">

        @if(Auth::check())
      	 <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Folder</button>

        <button type="button" class="btn btn-primary upload_files">Upload Files</button>


          <a href="{{ action('FileUploadController@zipcreate_test') }}"> <button    type="button" class="done_btn btn btn btn-link">Download as Zip</button></a> -->
        @endif


        @if(Session::get("current_path") == 'dump/'. Session::get("current_study_id").'/'. Session::get("current_dataset_name"))

     <!--     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Folder</button>

        <button type="button" class="btn btn-primary upload_files">Upload Files</button>
         -->
         @if(Auth::check())

         
          @if($data_mine == "1" )
            <button  class=" btn btn-outline-info" data-toggle="modal" data-target="#myModal_2" type="button" >Upload Key File as CSV</button>
          @endif

         @endif


       <!--   <a href=' {{ $total = DB::table('datasets')->where('study_id', Session::get("current_study_id"))->where('dataset_name', Session::get("current_dataset_name"))->value('dataset_url')}}'><button    type="button" class="done_btn btn btn btn-link">Download Dataset as Zip</button></a> -->

          <a href='/zipcreate'><button    type="button" class="done_btn btn btn btn-link">Download Dataset as Zip</button></a>

       

          @php
            if (DB::table('file_uploads')->where('study_id', '=', Session::get("current_study_id"))->where('dateset_id', '=', Session::get("current_dataset_name"))->where('type', '=', 'key')->exists()) {
              $key_exists = '1';
            }
            else{
              $key_exists = '0';
            }
          @endphp
          @if($key_exists == "1")

            <a href="/smart_search"> <button  type="button" class=" btn btn-outline-info smart_search_cls">Smart Search</button></a>
          @endif
        @endif

    </div>
  </div>

<br><br>
  <div  class="container">
<div class="row">
    <div class="col-sm-6"></div>
    <div align="right" class="col-sm-6">


      <input id="myInput" type="text" placeholder="Search..">
    </div>
  </div>
    <table id="resultTable" class="table table-striped">
      <thead>
        <tr>
            <th></th>
          <th></th>
          <th>Name</th>


          <th>Created At</th>


        </tr>
      </thead>
      <tbody id="myTable">

    @foreach($contents as $my_study=>$value)


      @if($value->type =="folder")
        <tr id="ClickableRow{{$value->id}}">
          <td><i class="fa fa-folder" aria-hidden="true"></i><td/>
          <td>{{$value->filename}}</td>
          <td>{{$value->created_at}}</td>





        </tr>
      @else

      <tr>
        <td><i class="fa fa-file" aria-hidden="true"></i><td/>

        @if(Auth::check())
          <td><a  target="_blank" href="{{$value->file_url}}">{{$value->filename}}</a></td>
        @else
           <td>{{$value->filename}}</td>
        @endif
        <td>{{$value->created_at}}</td>





      </tr>

      @endif

    @endforeach
      </tbody>
    </table>

    <div align="center" class="container">
      {{ $contents->links('vendor.pagination.bootstrap-4') }}
    </div>
  </div>

  <div class="modal fade" id="myModal_2">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Key File as CSV</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="upload_portion">
          <div class="modal-body">
            <form method="post" action="{{url('upload_key_file')}}" enctype="multipart/form-data"
                        >
               <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

               <input name="data_id" type="hidden" value="0"/>

                <input name="path" type="hidden" value="{{Session::get("current_path")}}"/>

              
                <div align="center" class="form-group">
                  <label for="l_zip_file">Key file</label>
                  <input type="file" required  class="form-control" name="zipfile" id="zipfile">
                </div>

                <button type="submit" class="btn btn-outline-success">Submit</button>

               </form>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      <!--     <h4 class="modal-title">Modal Header</h4> -->
        </div>
        <div class="modal-body">

        <div class="form-group">
        <label for="l_data_set_name">Folder Name</label>
        <input type="text" id="create_folder" class="form-control" name="new_folder">
        </div>

        </div>
        <div class="modal-footer">
        <button type="button" id ="submit_task" class="btn btn-default" data-dismiss="modal">Add Folder</button>
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>

        </div>
      </div>

    </div>
  </div>

</div>

@endsection



@section('page-script')

<script type='text/javascript'>

$(".bread_tags").click(function(){
    i=$(this).data("value");
    //alert(i);
    ajax_call_to_set_bread_crumb_path(i) ;
   // ajax_call_go_to_files(i,'1');
    
});
$(".go_to_dataset_breadcrumb").click(function(){
    i=$(this).data("value");
  //alert(i);
//ajax_call_go_to_files(dataset_name);
   // ajax_call_go_to_files(i,'1');
    ajax_call_to_set_bread_crumb_path(i) ;
    
});



function ajax_call_to_set_bread_crumb_path(path) {
  var path = path;






  $.ajax({
    url: "/set_breadcrumb_path",
    data: {
      path: path,
  
      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);
      //window.location.href = "/contents";


    //
    //  $("#sub_category_admin").html(html);


    }
  })




}
</script>
<script>


$( ".upload_files" ).click(function() {
    window.location.href = "/file_upload/file/upload";
});


function ajax_call_to_add_new_folder(folder_name) {






  $.ajax({
    url: "/create_folder",
    data: {
      folder_name: folder_name,

      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);


      window.location.href = "/contents";


    //
    //  $("#sub_category_admin").html(html);


    }
  })




}

$( "#submit_task" ).click(function() {
  var folder_name = $( "#create_folder" ).val();

  ajax_call_to_add_new_folder(folder_name);
});


function ajax_call_go_to_files(dataset_name) {
  var dataset_name = dataset_name;






  $.ajax({
    url: "/go_to_files",
    data: {
      next_destination: dataset_name,
  
      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);
      window.location.href = "/contents";


    //
    //  $("#sub_category_admin").html(html);


    }
  })




}
$('#resultTable tr').click(function (event) {
     // alert($(this).attr('id')); //trying to alert id of the clicked row
     var cls = "#" + $(this).attr('id') ;
     // alert($("#resultTable").find(cls).html());
     // $(cls).find("td:first").css('color', 'green');
     //alert($(cls).find("td:nth-child(3)").text());
     var dataset_name = $(cls).find("td:nth-child(3)").text();
     if (dataset_name != ""){
      ajax_call_go_to_files(dataset_name);
      }


});
// $(document).ready(function(){
//     //Check if the current URL contains '#'
//     if(document.URL.indexOf("#")==-1){
//         // Set the URL to whatever it was plus "#".
//         url = document.URL+"#";
//         location = "#";
//
//         //Reload the page
//         location.reload(true);
//
//     }
// });
$( ".back_button" ).click(function() {

  var msg_tm = "" ;
  var bodyContent = $.ajax({
          url: "/back_pressed",
          global: false,
          type: "GET",
          data: {


            submit_check_1: "submit_check_1"


          },

          async:false,
          success: function(msg){
            //alert(msg);
             msg_tm = msg;

             if(msg == 'files'){
               window.location.href = "/contents";
             }
             else{
               window.location.href = "/datesets";
             }
          }
       }
    ).responseText;


});

</script>

<style type="text/css">
  

  .smart_search_cls {
    font-family: "Comic Sans MS", "Comic Sans", cursive;
    font-size: 1em;
}
</style>

@endsection
