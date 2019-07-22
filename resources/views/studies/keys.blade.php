@extends('default_contents_footer_trouble')
@section('content')
  <br> <br><br> <br>
      <br> <br><br> <br> 		

<div  class="container">

			  <table id="resultTable" class="table table-striped">
			    <thead>
			      <tr>
			          <th></th>
			              <th></th>
			        
			        <th>Key Name</th>

			        <th>Link</th>
			        <th>Created At</th>
<th></th>
			         

			      </tr>
			    </thead>
			    <tbody id="myTable">
				@foreach($keys as $key=>$value)
			      <tr id="ClickableRow{{$value->dateset_id}}">
			        <td><i class="fa fa-sticky-note" aria-hidden="true"></i><td/>
			        <td style="display:none;">{{$value->id}}</td>
			     

		

			        <td class="context-menu"> {{$value->filename}} </td>
			        <td class="context-menu"> <a href="{{$value->file_url}}">Link</a> </td>

			        


			        <td class="context-menu">{{$value->created_at}}</td>

			        <td class="context-menu"><button type="button" data-value="{{$value->dateset_id}}" class="delete_key btn btn-outline-danger">Delete</button></td>
			        <td class="context-menu">
			        	
			        	<input type="hidden" name="keys[]" value="{{$value->dateset_id}}">
			        </td>
			      </tr>
				@endforeach
			    </tbody>
			  </table>

			</div>

@endsection


@section('page-script')

<script type="text/javascript">
	
function ajax_call_to_delete_key(key_id) {
  var key_id = key_id;






  $.ajax({
    url: "/delete_key_file",
    data: {
      key_id: key_id,
  
      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);
     //window.location.href = "/datasets";


    //
    //  $("#sub_category_admin").html(html);


    }
  })




}
	$(".delete_key").click(function(){
	    i=$(this).data("value");
	    //alert(i);
	    //
	    $('#ClickableRow' + i).remove();
	    ajax_call_to_delete_key(i) ;
	   // ajax_call_go_to_files(i,'1');
	    
	});
</script>

@endsection