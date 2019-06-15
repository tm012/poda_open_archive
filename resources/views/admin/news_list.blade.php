@extends('default_contents')
@section('content')



  <br> <br><br> <br>
      <br> <br><br> <br> 
 <div class="container">

<div class="row">

  @foreach($news as $service=>$value)

  <div class="col-md-6 col-lg-4">
    <div class="product is-gray">
      <div class="image d-flex align-items-center justify-content-center">
        <div class="ribbon ribbon-primary text-uppercase"></div><img src="" alt="product" class="img-fluid">
        <div class="hover-overlay d-flex align-items-center justify-content-center">
          <div class="CTA d-flex align-items-center justify-content-center"><a href="" class="visit-product active"><i class="fa fa-gavel"></i></a></div>

          <!--    <a href="#" data-toggle="modal" data-target="#exampleModal" class="quick-view"><i class="fa fa-arrows-alt"></i></a> -->
        </div>
      </div>
      <div class="title"><small class="text-muted">{{$value->news_title}}</small><a>
      </a></div>
    </div>
  </div>

  @endforeach
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