@extends('default_contents')
@section('content')




 <div class="container">
  <h2>Study</h2>
   <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ action('StudyController@post_study') }}">
    <input name="study_id"  type="hidden" value="{{ $studyid }}"/>
     <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    <div class="form-group">
      <label for="l_studyname">Study Name</label>
      <input type="text" class="form-control style_width" autocomplete="off" id="studyname" name="study_name" placeholder="Enter Study Name">
    </div>
    <!-- <div class="form-group">
      <label for="l_authorname">Author:</label>
      <input type="text" class="form-control" id="author_name" name="authorname" placeholder="Enter Author Name">
    </div> -->
    <div align="center" >

      <button type="submit"  class="btn btn-outline-success">Submit</button>
    </div>
  </form>
</div>
@endsection



@section('page-script')

<style>
.style_width {
  width: 100%;
}
</style>
@endsection
