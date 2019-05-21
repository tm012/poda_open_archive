<!DOCTYPE html>
<html lang="en">
<head>
  <script src="{{ asset('/js/application_global.js') }}"></script>
</head>
<body>
	@php
	{{-- php code here --}}
		$tm = 0;
		$array_search_terms = explode( ',', $status );
		$array_search_terms_length = count($array_search_terms);

		$status1=$status;

		for($i = 0; $i <(int) $array_search_terms_length ; $i++){
			//echo $array_search_terms[$i];


		}

		$col_names = DB::table('col_names_key')->where('data_id', '1' )->distinct()->get();
	@endphp

	 <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ action('StudyController@submit_final_smart_search') }}">

    	<input type="hidden" id="dataid" name="dataid" value="{{$data_id }}">

    	<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
	    <div class="row">

		  	@for ($i = 0; $i <(int) $array_search_terms_length ; $i++)

			  <div class="col-md-6 col-lg-4">
			    <div class="product is-gray">
			      <div class="image d-flex align-items-center justify-content-center">
			        
			        <!-- <div class="hover-overlay d-flex align-items-center justify-content-center"> -->
					@php
						{{-- php code here --}}
					

						

					
						$white_spaced_removed_term =  trim(preg_replace('/\s+/', ' ', $array_search_terms[$i]));

						$col_no = DB::table('col_names_key')->where('data_id',  $data_id )->where('col_name', $white_spaced_removed_term)->value("col_no");

						$contains = DB::table('col_row_key')->where('data_id',  $data_id )->where('col_no', $col_no)->select("name")->distinct()->get();
						

					
						// echo $contains;

						

					@endphp

					<input type="hidden" id="col_names" name="col_names[]" value="{{$white_spaced_removed_term }}">
					<input type="hidden" id="col_nos" name="col_nos[]" value="{{$col_no}}">

			          
	           <div class="form-group">
	                <label for="country">Select Search Criteria:</label>
	                <select name="selections[]" class="form-control" style="width:250px">
	                    <option value="">--- Select  ---</option>
	                    @foreach ($contains as $key => $value)
	                    <option value="{{$value->name}}">{{$value->name}}</option>
	                    @endforeach
	                </select>
	            </div>
			      
			       <!--  </div> -->
			      </div>
			      <!-- <div class="title"><small class="text-muted">Tauseef</small><a>
			      </a></div> -->
			    </div>
			  </div>

			@endfor
		</div>

		<div align="center" >

      		<button type="submit"  class="btn btn-outline-success">Search</button>
    	</div>
	</form>
    

	
</body>

</html>
<script >

</script>