@extends('default_contents')
@section('content')
@if (Session::has('message'))
<div class="alert alert-info center_div">
 <p align="middle" class="">{{ Session::get('message') }}</p>

</div>
@endif
<input type="hidden" id="file_list_strings" name="file_list_strings" class="cls_file_list_strings" value="{{$files_string}}">
<div align="center" class="container">
  <div class="row">
    <div align="left" class="col-sm-8">
  <!-- <input type="image" src="/img/left_arrow.png" class="back_button" alt="Submit" width="30" height="30"> -->
    </div>
    <div align="right" class="col-sm-4">

       <a href="{!! route('switch', ['files_string'=>$files_string]) !!}"><button    type="button" class="done_btn btn btn btn-link">Download Files as Zip</button></a>

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

         <!--  <button  class=" btn btn-outline-info" data-toggle="modal" data-target="#myModal_2" type="button" >Upload Key File as CSV</button> -->
         @endif


         <!-- <a href=' {{ $total = DB::table('datasets')->where('study_id', Session::get("current_study_id"))->where('dataset_name', Session::get("current_dataset_name"))->value('dataset_url')}}'><button    type="button" class="done_btn btn btn btn-link">Download Dataset as Zip</button></a> -->

        <!--   <a href="{{ action('FileUploadController@zipcreate_test') }}"> <button    type="button" class="done_btn btn btn btn-link">Download as Zip</button></a> -->
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

      @if(in_array($value->filename, $array_files_final))
        @if($value->type =="folder")
          <!-- <tr id="ClickableRow{{$value->id}}"> -->
          <tr>
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
      @endif

    @endforeach
      </tbody>
    </table>

    <div align="center" class="container">
      
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

@endsection