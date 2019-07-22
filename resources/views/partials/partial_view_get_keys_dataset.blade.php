<!DOCTYPE html>
<html lang="en">
<head>
  <script src="{{ asset('/js/application_global.js') }}"></script>
</head>
<body>



	@php
	
	@endphp

	 <form id="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ action('StudyController@submit_post_key_dataset') }}">

    	

    	<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
			
<input type="hidden" id="dataset_name" name="dataset_name" value="{{$dataset_id}}">

			  <table id="resultTable" class="table table-striped">
			    <thead>
			      <tr>
			          <th></th>
			              <th></th>
			        <th>Connect/Disconnect</th>
			        <th>Key Name</th>

			        <th>Link</th>
			        <th>Created At</th>
<th></th>
			         

			      </tr>
			    </thead>
			    <tbody id="myTable">
				@foreach($keys as $key=>$value)
			      <tr id="ClickableRow{{$value->id}}">
			        <td><i class="fa fa-sticky-note" aria-hidden="true"></i><td/>
			        <td style="display:none;">{{$value->id}}</td>
			     

			        @if(in_array($value->dateset_id, $array_dataset_id))
					     <td class="context-menu">
			        	
			        		<input class="c{{$value->id}}" type="checkbox" value="{{$value->id}}" checked name="check_boxs[]" >
			        		<input type="hidden" class="t{{$value->id}}" type="text" value="1"  name="check_boxs1[]" >
			        		
			       		 </td>
					@else
					       <td class="context-menu">
			        	
			        			<input class="c{{$value->id}}" type="checkbox" value ="{{$value->id}}" name="check_boxs[]" >
			        			<input type="hidden" class="t{{$value->id}}" type="text"  name="check_boxs1[]" >
			        			
			        		</td>
					@endif

			        <td class="context-menu"> {{$value->filename}} </td>
			        <td class="context-menu"> <a href="{{$value->file_url}}">Link</a> </td>

			        


			        <td class="context-menu">{{$value->created_at}}</td>
			        <td class="context-menu">
			        	
			        	<input type="hidden" name="keys[]" value="{{$value->dateset_id}}">
			        </td>
			      </tr>
				@endforeach
			    </tbody>
			  </table>




				


		<div align="center" >

      		<button type="submit"  class="btn btn-outline-success">Submit</button>
    	</div>
	</form>

			<style type="text/css">
				
				
				.site-footer {
				  background-color:	#337ab7;
				  color: #000;
				}

				.site-footer a {
  color: #000;
}
			</style>
	
</body>

</html>
<script type="text/javascript">
    // when page is ready
 $('#form').on('change', 'input[type=checkbox]', function() {

 				id = $(this).val();
                if($(this).is(":checked")){
                	// alert($(this).val());

                	$('.t' + id).val("1");
                }
                else{
                	//alert("n");
                	$('.t' + id).val("0")
                }
               

            });
</script>

