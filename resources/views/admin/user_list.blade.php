@extends('default_contents_footer_trouble')
@section('content')
  <br> <br><br> <br>
      <br> <br><br> <br> 
<div class="container">
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
        <th>Name</th>

        <th>Institution Name</th>
        <th>Designation</th>
        <th>Phone Number</th>
        <th>Created At</th>

        

      </tr>
    </thead>
    <tbody id="myTable">
	@foreach($users as $user=>$value)
      <tr id="ClickableRow{{$value->id}}">
        <td><i class="fa fa-user-circle" aria-hidden="true"></i><td/>
        <td style="display:none;">{{$value->id}}</td>
        <td>{{$value->name}}</td>
        <td>{{$value->institution_name}}</td>
        <td>{{$value->designation}}</td>
        <td>{{$value->phone_number}}</td>




      


        <td>{{$value->created_at}}</td>

       <td> <a href="{!! route('user_studies_user_id', ['c_user_id'=>$value->id]) !!}">Studies</a></td>

       <!--  <td><button type="button" value='{{$value->id}}' class="btn btn-outline-success btn_approve">Approve</button></td> -->
        <td><button type="button" value='{{$value->id}}' class="btn btn-outline-danger btn_reject">Ban</button></td>
      </tr>
	@endforeach
    </tbody>
  </table>


</div>

<div align="center" class="container">
  {{ $users->links('vendor.pagination.bootstrap-4') }}
</div>

@endsection



@section('page-script')




<script>

$(document).ready( function () {
    $('#table_id').DataTable();
} );


$('#table_id').DataTable( {
    
} );


$( ".btn_approve" ).click(function() {
   var fired_button = $(this).val();
    ajax_update_user_status(fired_button,'1');
    
});


$( ".btn_reject" ).click(function() {
  var fired_button = $(this).val();
  ajax_update_user_status(fired_button,'0');
});

function ajax_update_user_status(user_id,status) {
  var user_id = user_id;
  console.log(user_id);



// alert(status);

  $.ajax({
    url: "/user_approval_rejection",
    data: {
      user_id: user_id,
      status: status,
      situation: 'Removed',
      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);
      if(data =="waiting"){
         window.location.href = "/users_waiting";
      }
      else{

         window.location.href = "user_list";
      }


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
       // ajax_call_go_to_dataset(study_id);
      }



});


</script>

@endsection
