@extends('default_contents')
@section('content')

<div align="center" class="container">
  <div class="row">
    <div align="left" class="col-sm-7">
  <input type="image" src="/img/left_arrow.png" class="back_button" alt="Submit" width="30" height="30">
    </div>
    <div align="right" class="col-sm-5">

      @if(Auth::check())
    	 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Dataset</button>

        <a href="{{ action('FileUploadController@zipcreate_test') }}"> <button    type="button" class="done_btn btn btn btn-link">Download as Zip</button></a>
        <button  class="btn btn-primary" data-toggle="modal" data-target="#myModal_2" type="button" >Upload Dataset as Zip</button>
      @endif
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
    <table id="resultTable" class="table table-striped">
      <thead>
        <tr>
            <th></th>
          <th></th>
          <th>Dataset Name</th>
          <th>Related Task</th>


          <th>Created At</th>


        </tr>
      </thead>
      <tbody id="myTable">
  	@foreach($my_datasets as $my_study=>$value)
        <tr id="ClickableRow{{$value->id}}">
          <td><i class="fa fa-database" aria-hidden="true"></i><td/>
          <td>{{$value->dataset_name}}</td>
          <td>{{$value->task_related}}</td>




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
			  <input type="text" id="create_task" class="form-control" name="new_task">
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
          <h4 class="modal-title">Upload file as zip</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form method="post" action="{{url('test_tm')}}" enctype="multipart/form-data"
                      >
             <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

             <input name="data_id" type="hidden" value="0"/>

              <input name="path" type="hidden" value="{{Session::get("current_path")}}"/>

              <!-- <div class="form-group">
                <label for="l_dataset_name_m">DataSet Name</label>
                <input type="text" class="form-control" name="dataset_name_m" id="dataset_name_m" required>
              </div> -->
              <div align="center" class="form-group">
                <label for="l_zip_file">Zip file</label>
                <input type="file" required  class="form-control" name="zipfile" id="zipfile">
              </div>

              <button type="submit" class="btn btn-default">Submit</button>

             </form>
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

$("#go_home").click(function(){
  $('#myModal_1').modal('hide');
   window.location.href = "/";
});
$("#go_my_studies").click(function(){
  $('#myModal_1').modal('hide');
   window.location.href = "/studies/my_studies";
});
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




@endsection
