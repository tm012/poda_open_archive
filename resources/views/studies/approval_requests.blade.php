@extends('default_contents_footer_trouble')
@section('content')
  <br> <br><br> <br>
      <br> <br><br> <br> 
<div class="container">

@if((Auth::user()->admin_status == "1"))

        
        <a href="/users_waiting"><button type="button" class="btn  btn-outline-primary ">Users (Waiting List)</button></a>
      @endif
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

     window.location.href = "/datasets";


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
