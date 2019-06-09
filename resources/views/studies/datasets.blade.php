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



  #$study_id = substr($string_upto_study_id, strrpos($string_upto_study_id, '/') + 1);
  $study_name = DB::table('studies')->where('study_id', '=', Session::get("current_study_id"))->value('study_name');
@endphp
<div align="center" class="container">
  <div class="row">
    <div align="right" class="col-sm-12">
      @if(Auth::check())
       <a style="text-decoration:none; color:black;"   href="studies/my_studies">{{ $study_name}}/</a>
      @else

      <a style="text-decoration:none; color:black;"   href="/welcome">{{ $study_name}}/</a>
      @endif

</div></div></div>

<!--   <a style="text-decoration:none; color:black;"   href="/datesets">{{ Session::get("current_dataset_name")}}/</a> -->
<div align="center" class="container">
  <div class="row">
    <div align="left" class="col-sm-5">
      <input type="image" src="/img/left_arrow.png" class="back_button" alt="Submit" width="30" height="30">


      @if(Auth::check())
        @if((Auth::user()->admin_status == "1") and ($study_content[0]["admin_approved"]=="0"))

          <button style="margin-left: 15px;" type="button" class="btn btn-outline-success approve_study">Approve</button>
          <button type="button" class="btn btn-outline-danger reject_study">Decline</button>
        @endif
      @endif
       
    </div>
    <div align="right" class="col-sm-7">
      @if(Auth::check())
        @if($data_mine == "1" )
      	<!--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Dataset</button> -->

         <!--  <a href="{{ action('FileUploadController@zipcreate_test') }}"> <button    type="button" class="done_btn btn btn btn-link">Download as Zip</button></a> -->
         <button  class=" btn btn-outline-warning" onclick="window.location='{{ url("studies/edit_study") }}'" type="button" >Edit Study</button>
         <button  class=" btn btn-outline-danger" data-toggle="modal" data-target="#myModal_3" type="button" >Delete Study</button>
          <button  class=" btn btn-outline-info" data-toggle="modal" data-target="#myModal_2" type="button" >Upload Dataset as Zip</button>
        @else
          <button  class=" btn btn-outline-info" data-toggle="modal" data-target="#myModal_4" type="button" >Study info</button>
        @endif
      @endif
    </div>
  </div>
</div>
  <input type="hidden" id="auth_check" class="form-control" name="auth_check" value="{{Auth::check()}}">

<br><br>
  <div  class="container">
    <div class="row">
        <div class="col-sm-6"></div>
        <div align="right" class="col-sm-6">


          <input id="myInput" type="text" placeholder="Search..">
        </div>
      </div>
      <br>
    <table data-bg-color="#edf2f4" id="resultTable" class="table table-striped">
      <thead>
        <tr>
            <th></th>
          <th></th>
          <th>Dataset Name</th>
          <th>Related Task</th>
          <th>Folder Size (Bytes)</th>


          <th>Created At</th>


        </tr>
      </thead>
      <tbody id="myTable">
  	@foreach($my_datasets as $my_study=>$value)
        <tr id="ClickableRow{{$value->id}}">
          <td><i class="fa fa-database" aria-hidden="true"></i><td/>
          <td>{{$value->dataset_name}}</td>
          <td>{{$value->task_related}}</td>
          <td>{{$value->file_size}}</td>




          <td>{{$value->created_at}}</td>
        </tr>
  	@endforeach
      </tbody>
    </table>

    <div align="center" class="container">
      {{ $my_datasets->links('vendor.pagination.bootstrap-4') }}
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
			  <label for="l_data_set_name">Dataset Name</label>
			  <input type="text" id="create_dataset" class="form-control" name="new_dataset">
		    </div>
          <div class="form-group">
			  <label for="l_name_task">Task Related to the Dataset</label>
          <select id="create_task" class="form-control" name="new_task"">
             
            <option>Select Task</option>
              
                       
              @foreach ($tasks as $key => $value)
               
                  <option value="{{$value->task_name}}">{{$value->task_name}}</option>
                
              @endforeach
              
          </select>

          <!-- https://itsolutionstuff.com/post/laravel-set-selected-option-in-dropdown-menuexample.html -->

			 <!--  <input type="text" id="create_task" class="form-control" name="new_task"> -->
		    </div>
        </div>
        <div class="modal-footer">
        <button type="button" id ="submit_task" class="btn btn-default" data-dismiss="modal">Create Dataset</button>
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>

        </div>
      </div>

    </div>
  </div>

  <!-- The Modal -->
  <div class="modal fade" id="myModal_1">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Notice</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <button type="button" id ="go_home" class="btn btn-default" data-dismiss="modal">Go Home</button>
          <button type="button" id ="go_my_studies" class="btn btn-default" data-dismiss="modal">Go to My Studies</button>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal fade" id="myModal_2">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload dataset folder as zip</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="upload_portion">
          <div class="modal-body">
            <form method="post" action="{{url('test_tm')}}" enctype="multipart/form-data"
                        >
               <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

               <input name="data_id" type="hidden" value="0"/>

                <input name="path" type="hidden" value="{{Session::get("current_path")}}"/>

                <div class="form-group">
                  <label for="l_task_name_m">Task Related to The Dataset</label>
                  <!-- <input type="text" class="form-control" name="task_name_m" id="task_name_m" required> -->

          <select id="task_name_m" class="form-control" name="task_name_m" required="true">
             
         <!--    <option>Select Task</option> -->
              
                       
              @foreach ($tasks as $key => $value)
               
                  <option value="{{$value->task_name}}">{{$value->task_name}}</option>
                
              @endforeach
              
          </select>


                </div>
                <div align="center" class="form-group">
                  <label for="l_zip_file">Zip file</label>
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


    <!-- The Modal -->
  <div class="modal fade" id="myModal_3">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Are you sure?</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="upload_portion">
          <div class="modal-body">


            <button type="button" onclick="window.location='{{ url("studies/study_archived") }}'" class="btn btn-danger">Delete</button>
            
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
    <!-- The Modal -->
  <div class="modal fade" id="myModal_4">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Study Details</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="upload_portion">
          <div class="modal-body">

          <div align="left" class="form-group">
          <label for="l_studyname">Study Name</label>
          <input type="text" class="form-control style_width" autocomplete="off" id="studyname" name="study_name" disabled placeholder="Enter Study Name" value="{{$study_content[0]['study_name']}}">
        </div>
        <div align="left"class="form-group">
          <label for="l_authorname">Study Description</label>
          
        </div>
   
        <div align="left" class="form-group">
          <textarea disabled class="form-control" onkeyup="countChar(this)" maxlength="502" rows = "5" name = "study_description" >{{$study_content[0]['study_description']}}</textarea>
          <div id="charNum"> </div>
       
        </div>
        <div align="left" class="form-group">
          <label for="l_studyname">Study Licence</label>
          <input disabled type="text" class="form-control style_width" autocomplete="off" id="studylicence" name="study_licence" value="{{$study_content[0]['study_licence']}}" placeholder="Enter Study Licence">
        </div>

         <div align="left" class="form-group">
          <label for="l_studyname">Author(s)</label>
       
        </div>
   

 

        <div align="left" class="form-group">

          <input disabled type="text" class="form-control style_width authors" autocomplete="off" id="authors" name="authors_input" value="{{$study_content[0]['authors']}}" data-role="tagsinput"  >
        </div>

        <div align="left" class="form-group">
          <label for="l_studyname">Access Type</label>
       
        </div>

        <div align="left" class="form-group">


          <div class="row">
            <div align="left" class="col-xs-3">

              
              <input type="checkbox" name="public_data" value="1" disabled checked> Public<br>
            </div>
            <div align="left" class="col-xs-9">
              
              <input type="checkbox" name="private_data" value="0" disabled> Private<br>
            </div>
          </div>
        

        </div>

        <div align="left" class="form-group">
          <label for="l_studyname">Publication Name</label>
          <input disabled type="text" class="form-control style_width" autocomplete="off" id="publication" name="publication_name" value="{{$study_content[0]['publication_name']}}" placeholder="Enter Publication Name">
        </div>

        <div align="left" class="form-group">
          
        <label for="l_studyname">Publication Time</label>
        </div>
         <div align="left" class="form-group">
         
          <input disabled id="datetimepicker" placeholder="Enter Publication Time" class="form-control style_width" type="text" autocomplete="off" value="{{$study_content[0]['publication_time']}}"  name="publication_time" />
        </div>

        <div align="left" class="form-group">
          <label for="l_studyname">Contact Info</label>
          <input disabled type="text" class="form-control style_width" autocomplete="off" id="contact_info" name="contact_info" value="{{$study_content[0]['contact_info']}}"  placeholder="Enter Contact Info">
        </div>


        <div align="left" class="form-group">
          <label for="l_studyname">Search Tag(s)</label>
       
        </div>



        <div align="left" class="form-group">

          <input disabled type="text" class="form-control style_width search_tags" autocomplete="off" id="search_tags" name="search_tags" value="{{$study_content[0]['search_tags']}}"  data-role="tagsinput"  >
        </div>


            
            
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection



@section('page-script')

<script type="text/javascript">


$( ".approve_study" ).click(function() {
  
  ajax_study_approve_reject("1");
});

$( ".reject_study" ).click(function() {
  
  ajax_study_approve_reject("0");
});

$("#go_home").click(function(){
  $('#myModal_1').modal('hide');
   window.location.href = "/";
});
$("#go_my_studies").click(function(){
  $('#myModal_1').modal('hide');
   window.location.href = "/studies/my_studies";
});


function ajax_study_approve_reject(status) {






  $.ajax({
    url: "/approval_rejection_study",
    data: {
      
      status: status,
      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);



      window.location.href = "studies/approval_requests";


    //
    //  $("#sub_category_admin").html(html);


    }
  })




}
function ajax_call_to_add_new_dataset(dataset_name,task_name) {






  $.ajax({
    url: "/create_dataset",
    data: {
      dataset_name: dataset_name,
      task_name: task_name,
      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);


      window.location.href = "/datesets";


    //
    //  $("#sub_category_admin").html(html);


    }
  })




}

$( "#submit_task" ).click(function() {
  var task_name = $( "#create_task" ).val();
  var dataset_name = $( "#create_dataset" ).val();
  ajax_call_to_add_new_dataset(dataset_name,task_name);
});



//////////////////////////


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
             // alert(msg);
             msg_tm = msg;

             if(msg == ''){

               var auth_checks = $( "#auth_check" ).val();
               if(auth_checks == "1"){

                 $('#myModal_1').modal('show');
               }
               else{
                  window.location.href = "/";
               }


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
  

  
}
</style>




@endsection
