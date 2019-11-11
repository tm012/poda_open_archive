@extends('default_contents_footer_trouble')
@section('content')
  <br> <br><br> <br>
      <br> <br><br> <br> 

<div  class="container">
			
	           <div align="center" class="form-group">
	                <label for="country">Select Dataset:</label>
	                <select  id="mySelect" onchange="myFunction_dataset()" name="selected_dataset" class="form-control" style="width:250px">
	                    <option  value="" selected>--- Select  ---</option>
	                    
	                    @foreach ($datasets as $dataset => $value)
	                    	@if($value->dateset_id != "")
	                    		<option value="{{$value->dataset_name}}">{{$value->dateset_id}}</option>
	                    	@endif
	                    @endforeach
		                
	                </select>
	            </div>
	        

			<div id = "sub_category_admin">

			</div>

</div>
@endsection


@section('page-script')


<script>
function myFunction_dataset() {
  var x = document.getElementById("mySelect").value;

  if(x!=""){

  	 ajax_get_html(x)
  }
  else{
  	var html = "";
      	  console.log(html);

    $("#sub_category_admin").html(html);

  }


}



 	function ajax_get_html(status) {


 		$status = status;
  //alert($status);
 		
	  $.ajax({
	    url: "/partial_view_get_keys_dataset",
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
</script>

@endsection