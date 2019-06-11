@extends('default_contents')
@section('content')

  <br> <br><br> <br>
      <br> <br><br> <br> 

	 <div  class="container">
	<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ action('StudyController@post_task') }}">
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

	    <div class="form-group">

	        <label class="col-sm-5 control-label">Add Task Names (Press ENTER key after typing each Task Name) :</label>

			<div class="form-group">

	      		<input type="text" class="form-control style_width search_tags" autocomplete="off" id="search_tags" name="search_tags"  data-role="tagsinput"  >
	    	</div>
	    </div>
	  	<div align="center" >

      		<button type="submit"  class="btn btn-outline-success">Submit</button>
    	</div>
	</form>

    <table id="resultTable" class="table table-striped">
      <thead>
        <tr>
		    <th>Task Name (Click & Type to Edit)</th>
		    <th>Edit</th>
		    <th>Delete</th>
	


        </tr>
      </thead>
      <tbody id="myTable">


		@php
			$index = 0;
		@endphp
	    @foreach($tasks as $task=>$value)


		    <tr id='{{$index }}' class='tr_clickable'>

		    	<input type='hidden' value='{{$index }}' id='item_index{{$index }}'></input>
		        <input type='hidden' value='{{$value->id}}' id='item_id{{$index }}'></input>
		        <td contenteditable='true' id='task_name{{$index }}'>{{$value->task_name}}</td>

		      


		        <td><a class='menu_edit'>Edit</a></td>
		        <td><a class='menu_delete'>Delete</a></td>

		      <!--   <td> <%= link_to "Delete", final_delete_kit_details_kits_path(kit_details_id: posts[:kit_details_id]) %></td> -->
		        @php
					$index = $index +1;
				@endphp

		    </tr>










      

    	@endforeach
      </tbody>
    </table>

    <div align="center" class="container">
      {{ $tasks->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection

@section('page-script')



<script type="text/javascript">
	
    $(document).on("keypress", 'form', function (e) {
          var code = e.keyCode || e.which;
          console.log(code);
          if (code == 13) {
              console.log('Inside');
              e.preventDefault();
              return false;
          }
      });

      $(function () {


      	    $(".menu_edit").click(function () {
		      var tr_id = $(this).closest('tr').attr('id');
		      console.log("tr id is " + tr_id);

		      var id = $('#item_id' + tr_id).val();
		      var task_name = $('#task_name' + tr_id).text();
		


		      $.ajax({
		        url: "/edit_task_name",
		        type: 'GET',
		        data: {
		          id: id,
		          edit: 'edit',
		          task_name: task_name,

		         


		        },
		        async: false,
		        success: function (data) {

		          alert("Data updated");
		        }
		      });


		    })
      	    $(".menu_delete").click(function () {
		      var tr_id = $(this).closest('tr').attr('id');
		      console.log("tr id is " + tr_id);

		      var id = $('#item_id' + tr_id).val();
		      var task_name = $('#task_name' + tr_id).text();
		      var index = $('#item_index' + tr_id).val();
		      var class_for_removal = '#'+index;
		      // alert(index);
		
		      

		      $.ajax({
		        url: "/delete_task_name",
		        type: 'GET',
		        data: {
		          id: id,
		          edit: 'delete',
		          task_name: task_name,

		         


		        },
		        async: false,
		        success: function (data) {

		          alert("Data Deleted");
		          $('#' + tr_id).remove();
		        }
		      });


		    })

      	})

</script>






@endsection