@extends('default_contents')
@section('content')

 <div id = "sub_category_admin">





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
        <label for="l_data_set_name">Select Column Names for SmartSearch</label>
        <br>
        	@foreach($col_names as $col_name=>$value)
		       
        		<label for="l_data_set_name">{{$value->col_name}}</label>
		        <input name="selector[]" type="checkbox" id="c_box" class="checkbox"  value="{{$value->col_name}}"> <br>
  			@endforeach
        
        </div>

        </div>
        <div class="modal-footer">
        <input type="button" class="btn btn-outline-success" id="save_value" name="save_value" value="GoSearch!" />
        
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>

        </div>
      </div>

    </div>
  </div>
@endsection



@section('page-script')

<script type="text/javascript">

	//https://stackoverflow.com/questions/11945802/how-to-get-multiple-checkbox-value-using-jquery
 	$('#save_value').click(function(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });

        
        
        $('#myModal').modal('hide');
        setTimeout(
		  function() 
		  {
		    //do something special
		   ajax_send_cols(val);
		  }, 1000);

        // ajax_send_cols(val);
      });



 	function ajax_send_cols(status) {


 		$status = status;

 		$status = $status.join(", ")
 		console.log($status);

	  $.ajax({
	    url: "/partial_view_smart_search_drops",
	    data: {
	      
	      status: $status,
	      submit_check_1: "submit_check_1"


	    },
	    type: 'GET',
	    async: false,
	    success: function (data) {
	      console.log("Success");
	      console.log(data);



	      var html = data;
      	  console.log(html);

      	  $("#sub_category_admin").html(html);


	    //
	    //  $("#sub_category_admin").html(html);


	    }
	  })




	}
	
	$(function() {



		$('#myModal').modal('toggle');

		
		
	});
</script>
@endsection