@extends('default_contents')
@section('content')



  <br> <br><br> <br>
      <br> <br><br> <br> 
 <div class="container">
  <h2>Edit News</h2>
   <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ action('AdminController@post_edit_news') }}">
    <input name="id"  type="hidden" value="{{$news[0]->id}}"/>
     <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    <div class="form-group">
      <label for="l_studyname">News Title *</label>
      <input type="text" class="form-control style_width" autocomplete="off" id="studyname" name="study_name" required="true" placeholder="Enter News Title"  value="{{$news[0]->news_title}}" >
    </div>
  <div class="form-group">
      <label for="l_authorname">News Description *</label>
      
    </div>
   
    <div class="form-group">
      <textarea class="form-control" onkeyup="countChar(this)" maxlength="5000" rows = "5" name = "study_description" required="true">{{$news[0]->news_description}}</textarea>
      <div id="charNum"> </div>
   
    </div>


     <div class="form-group">
      <label for="l_studyname">Author(s) * - Press ENTER key after typing each author name</label>
   
    </div>

 
    <div class="form-group">

      <input type="text" class="form-control style_width authors" autocomplete="off" id="authors" name="authors_input" data-role="tagsinput"  value="{{$news[0]->news_author}}" required="true" >
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
</script>
@endsection