@extends('default_contents')
@section('content')



  <br> <br><br> <br>
      <br> <br><br> <br> 
 <div class="container">
  <h2>Create News</h2>
   <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ action('AdminController@post_news') }}">
    
     <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    <div class="form-group">
      <label for="l_studyname">News Title *</label>
      <input type="text" class="form-control style_width" autocomplete="off" id="studyname" name="study_name" required="true" placeholder="Enter News Title">
    </div>
  <div class="form-group">
      <label for="l_authorname">News Description *</label>
      
    </div>
   
    <div class="form-group">
      <textarea class="form-control" onkeyup="countChar(this)" maxlength="5000" rows = "5" name = "study_description" required="true"></textarea>
      <div id="charNum"> </div>
   
    </div>


     <div class="form-group">
      <label for="l_studyname">Author(s) * - Press ENTER key after typing each author name</label>
   
    </div>

 
    <div class="form-group">

      <input type="text" class="form-control style_width authors" autocomplete="off" id="authors" name="authors_input" data-role="tagsinput" required="true" >
    </div>

     <div class="form-group">
      <label for="l_studyname">News Image</label>
   
    </div>


  <div class="form-group">

 <input type="file"   class="form-control" name="pic" accept="image/*">
    </div>



    
    

    <div align="center" >

      <button type="submit"  class="btn btn-outline-success">Submit</button>
    </div>
  </form>
</div>
@endsection



@section('page-script')


          


 <script>

       $(document).on("keypress", 'form', function (e) {
          var code = e.keyCode || e.which;
          console.log(code);
          if (code == 13) {
              console.log('Inside');
              e.preventDefault();
              return false;
          }
      });
          
      function countChar(val) {
        var len = val.value.length;
        if (len >= 5000) {
          val.value = val.value.substring(0, 5000);
        } else {
          $('#charNum').text((5000 - len)+' remaining number of letters' );

        }
      };


  $(document).ready(function () {


     $.datetimepicker.setLocale('en');
      $('#datetimepicker').datetimepicker();


       //$("#authors").val();
       // $('.authors').tagsinput('add', 'some tag');
      // $('.authors').tagsinput('add', "this.value");


       // alert("sd");

      
        
    });
    </script>

<style>
.style_width {
  width: 100%;
}

textarea {
     width: 100%;
     -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
     -moz-box-sizing: border-box;    /* Firefox, other Gecko */
     box-sizing: border-box;         /* Opera/IE 8+ */
}

</style>

<script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
@endsection