@extends('default_contents')
@section('content')



  <br> <br><br> <br>
      <br> <br><br> <br> 
 <div class="container">
  <h2>Create Study</h2>
   <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ action('StudyController@post_study') }}">
    <input name="study_id"  type="hidden" value="{{ $studyid }}"/>
     <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    <div class="form-group">
      <label for="l_studyname">Study Name *</label>
      <input type="text" class="form-control style_width" autocomplete="off" id="studyname" name="study_name" required="true" placeholder="Enter Study Name">
    </div>
  <div class="form-group">
      <label for="l_authorname">Study Description *</label>
      
    </div>
   
    <div class="form-group">
      <textarea class="form-control" onkeyup="countChar(this)" maxlength="500" rows = "5" name = "study_description" required="true"></textarea>
      <div id="charNum"> </div>
   
    </div>
    <div class="form-group">
      <label for="l_studyname">Study Licence</label>
      <input type="text" class="form-control style_width" autocomplete="off" id="studylicence" name="study_licence" placeholder="Enter Study Licence">
    </div>

     <div class="form-group">
      <label for="l_studyname">Author(s) - Press ENTER key after typing each author name</label>
   
    </div>

 
    <div class="form-group">

      <input type="text" class="form-control style_width authors" autocomplete="off" id="authors" name="authors_input" data-role="tagsinput"  >
    </div>

    <div class="form-group">
      <label for="l_studyname">Access Type</label>
   
    </div>

    <div class="form-group">


      <div class="row">
        <div align="left" class="col-xs-3">

          
          <input type="checkbox" name="public_data" value="1" disabled checked> Public<br>
        </div>
        <div align="left" class="col-xs-9">
          
          <input type="checkbox" name="private_data" value="0" disabled> Private<br>
        </div>
      </div>
    

    </div>

    <div class="form-group">
      <label for="l_studyname">Publication Name</label>
      <input type="text" class="form-control style_width" autocomplete="off" id="publication" name="publication_name" placeholder="Enter Publication Name">
    </div>

    <div class="form-group">
      
    <label for="l_studyname">Publication Time</label>
    </div>
     <div class="form-group">
     
      <input id="datetimepicker" placeholder="Enter Publication Time" class="form-control style_width" type="text" autocomplete="off" name="publication_time"/>
    </div>

    <div class="form-group">
      <label for="l_studyname">Contact Info</label>
      <input type="text" class="form-control style_width" autocomplete="off" id="contact_info" name="contact_info" placeholder="Enter Contact Info">
    </div>


    <div class="form-group">
      <label for="l_studyname">Keywords(s) - Press ENTER key after typing each Keyword </label>
   
    </div>

   

    <div class="form-group">

      <input type="text" class="form-control style_width search_tags" autocomplete="off" id="search_tags" name="search_tags"  data-role="tagsinput"  >
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
        if (len >= 500) {
          val.value = val.value.substring(0, 500);
        } else {
          $('#charNum').text((500 - len)+' remaining number of letters' );

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