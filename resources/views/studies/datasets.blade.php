@extends('default_contents')
@section('content')

<div align="center" class="container">
  <div class="row">
    <div align="left" class="col-sm-10">
  <input type="image" src="/img/left_arrow.png" class="back_button" alt="Submit" width="30" height="30">
    </div>
    <div class="col-sm-2">


    	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Dataset</button>
    </div>
  </div>


  <div  class="container">

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
      <tbody>
  	@foreach($my_datasets as $my_study=>$value)
        <tr id="ClickableRow{{$value->id}}">
          <td><i class="fa fa-database" aria-hidden="true"></i><td/>
          <td>{{$value->dataset_name}}</td>
          <td>{{$value->task_related}}</td>




          <td>{{$value->created_date}}</td>
        </tr>
  	@endforeach
      </tbody>
    </table>
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
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id ="submit_task" class="btn btn-default" data-dismiss="modal">Create Dataset</button>
        </div>
      </div>

    </div>
  </div>

</div>
@endsection



@section('page-script')

<script type="text/javascript">
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

    ajax_call_go_to_files(dataset_name);


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
               window.location.href = "/studies/my_studies";
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
