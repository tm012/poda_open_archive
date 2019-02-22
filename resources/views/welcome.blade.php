
@extends('/default_contents')


@section('content')

<div align="center"  class="container">
  <div class="row">
    <div class="col-sm-6">

      <form action="/">
        Search By Study Name <input type="text" name="search" placeholder="Search By Task Name">
      </form>

    </div>


    <div class="col-sm-6">

      <form action="/">
        Search By Task Name <input type="text" name="search" placeholder="Search By Study Name">
      </form>
    </div>
  </div>

</div>
<br><br>

<div class="container">

  <table id="resultTable" class="table table-striped">
    <thead>
      <tr>
          <th></th>
              <th></th>
        <th>Study ID</th>
        <th>Study Name</th>
        <th>Author Name</th>
        <th>Access Status</th>
        <th>Created At</th>


      </tr>
    </thead>
    <tbody>

      <tr id="ClickableRow{{"1"}}">
        <td><i class="fa fa-folder" aria-hidden="true"></i><td/>
        <td>StudyID1</td>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
        <td>john@example.com</td>
      </tr>
      <tr id="ClickableRow{{"2"}}">
<td><i class="fa fa-folder" aria-hidden="true"></i><td/>
      <td>StudyID2</td>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
        <td>john@example.com</td>
      </tr>
      <tr id="ClickableRow{{"3"}}">
        <td><i class="fa fa-folder" aria-hidden="true"></i><td/>
        <td>StudyID3</td>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td>john@example.com</td>
      </tr>
    </tbody>
  </table>
</div>

@endsection
@section('page-script')

<script>
$('#resultTable tr').click(function (event) {
     // alert($(this).attr('id')); //trying to alert id of the clicked row
     var cls = "#" + $(this).attr('id') ;
     // alert($("#resultTable").find(cls).html());
     // $(cls).find("td:first").css('color', 'green');
     alert($(cls).find("td:nth-child(3)").text());
      var study_id = $(cls).find("td:nth-child(3)").text();


});


</script>



<style>
input[name=search] {
  width: 200px;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  background-color: white;
  background-image: url("/img/serchicon.png");
  background-position: 10px 10px;
  background-repeat: no-repeat;
  padding: 12px 20px 12px 40px;
  -webkit-transition: width 0.4s ease-in-out;
  transition: width 0.4s ease-in-out;
}

input[name=search]:focus {
  width: 100%;
}


</style>
@endsection
