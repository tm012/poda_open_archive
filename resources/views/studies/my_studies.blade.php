@extends('default_contents')
@section('content')

<div class="container">
<div class="row">
    <div class="col-sm-6"></div>
    <div align="right" class="col-sm-6">
      
 <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#myModal">
    See Instructions
  </button>
      <input id="myInput" type="text" placeholder="Search..">
    </div>
  </div>


  <table id="resultTable" class="table table-striped">
    <thead>
      <tr>
          <th></th>
              <th></th>
        <!-- <th>Study ID</th> -->
        <th>Study Name</th>

        <th>Access Status</th>
        <th>Created At</th>


      </tr>
    </thead>
    <tbody id="myTable">
	@foreach($my_studies as $my_study=>$value)
      <tr id="ClickableRow{{$value->id}}">
        <td><i class="fa fa-sticky-note" aria-hidden="true"></i><td/>
        <td style="display:none;">{{$value->study_id}}</td>
        <td>{{$value->study_name}}</td>

        @if($value->access_status == "1")
		      <td>public</td>
    		@else
    		    <td>private</td>
    		@endif


        <td>{{$value->created_at}}</td>
      </tr>
	@endforeach
    </tbody>
  </table>


</div>

<div align="center" class="container">
  {{ $my_studies->links('vendor.pagination.bootstrap-4') }}
</div>


 <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Instructions</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          1. Zip your data set and then upload it. Please make sure the name of the zip file is the name of your data set. <a href="https://drive.google.com/file/d/1NdD3oKg7kV0WW8d0ueYAzI-vru84KqAP/view?usp=sharing" target="_blank">Please See This Data Set For Example.</a>

          <br><br>
          2. Your upload files need to be approved by the admin.
          <br><br>
          3. While uploading key file, use the first column for indexing and second column for file names. Don't use this two columns for anyother use. Please make sure the name of the zip file is the name of your data set. <a href="https://drive.google.com/file/d/1LtyXkbjWJsx1-SJTuUzAFaZ03q3mehYa/view?usp=sharing" target="_blank">Please See This Key File For Example.</a>
          <br><br>
          
          4. Please refrain yourself from uploading unnecessary data or you will be banned.    
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
         <!--  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
        </div>
        
      </div>
    </div>
  </div>

@endsection



@section('page-script')




<script>

$(document).ready( function () {
    $('#table_id').DataTable();
} );


$('#table_id').DataTable( {
    
} );

function ajax_call_go_to_dataset(study_id) {
  var study_id = study_id;
  console.log(study_id);





  $.ajax({
    url: "/go_to_study_page",
    data: {
      study_id: study_id,
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
$('#resultTable tr').click(function (event) {
     // alert($(this).attr('id')); //trying to alert id of the clicked row
     var cls = "#" + $(this).attr('id') ;
     // alert($("#resultTable").find(cls).html());
     // $(cls).find("td:first").css('color', 'green');
     //alert($(cls).find("td:nth-child(3)").text());
     var study_id = $(cls).find("td:nth-child(3)").text();

     // ajax_call_go_to_dataset(study_id);
     if (study_id === "") {
          //...

      }
      else{
        ajax_call_go_to_dataset(study_id);
      }



});


</script>

@endsection
