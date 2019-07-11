@extends('default_contents_footer_trouble')
@section('content')



  <br> <br><br> <br>
      <br> <br><br> <br> 
 <div class="container">

  <div class="row">
    <div align="right" class="col-sm-12">
		@if(Auth::check())
		 <a   href="{{ url('admin/add_news') }}">Add News</a>
		@endif
	</div>
		</div>
    <table id="resultTable" class="table table-striped">
      <thead>
        <tr>
		    <th>News Title</th>
		    <th>Edit</th>
		    <th>Delete</th>
	


        </tr>
      </thead>
      <tbody id="myTable">


		@php
			$index = 0;
		@endphp
	    @foreach($news as $task=>$value)


		    <tr id='{{$index }}' class='tr_clickable'>

		    	<input type='hidden' value='{{$index }}' id='item_index{{$index }}'></input>
		        <input type='hidden' value='{{$value->id}}' id='item_id{{$index }}'></input>
		        <td contenteditable='false' id='task_name{{$index }}'>{{$value->news_title}}</td>

		      


		        <td><a href="{!! route('switch_edit_news', ['news_id'=>$value->id]) !!}">Edit</a></td>
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
      {{ $news->links('vendor.pagination.bootstrap-4') }}
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