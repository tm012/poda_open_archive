
@extends('/default_contents')


@section('content')

<!-- <button type="button" onclick="window.location='{{ url("test_tm") }}'">Button</button -->
<div class="site-content">
  <main class="main-content">
  <br> <br><br> <br>
      <br> <br><br> <br> 
    
    
    
        <div class="fullwidth-block" data-bg-color="#edf2f4">


          <div align="center" class="container">
            <div class="row">
              <div class="col-md-4 col-sm-4">
                
                  <form method="GET" action="{{ action('StudyController@search_home_with_param') }}">
                    <input autocomplete="off" data-id='study' onchange="this.form.submit()" type="text" name="search" id="search" placeholder="Search By Study Name" class="form-control search_by_study">
                  </form>
                
              </div>
              <div class="col-md-4 col-sm-4">
               
                  <form method="GET" action="{{ action('StudyController@search_home_with_param') }}">
                    <input autocomplete="off" data-id='dataset' onchange="this.form.submit()" type="text" name="search" id="search" placeholder="Search using Data Set Name" class="form-control search_by_dataset">
                  </form>
                
              </div>
              <div class="col-md-4 col-sm-4">
                
                  <form method="GET" action="{{ action('StudyController@search_home_with_param') }}">
                    <input autocomplete="off" data-id='task' onchange="this.form.submit()" type="text" name="search" id="search" placeholder="Search using Task Name" class="form-control search_by_task">
                  </form>
                
              </div>
            
            </div> <!-- .row -->
          </div> <!-- .container -->
        </div> <!-- .fullwidth-block -->
         <div class="fullwidth-block" data-bg-color="#edf2f4">


          <div align="center" class="container">
            <div class="row">
              <div align="right" class="col-sm-6">
                
                  <form method="GET" action="{{ action('StudyController@search_home_with_param') }}">
                    <input autocomplete="off" data-id='author_name' onchange="this.form.submit()" type="text" name="search" id="search" placeholder="Search by Author" class="form-control search_by_author_name">
                  </form>
              
              </div>
         
              <div align="left"  class="col-sm-6">


                <form method="GET" action="{{ action('StudyController@search_home_with_param') }}">
                  <input autocomplete="off" data-id='tag' onchange="this.form.submit()" type="text" name="search" id="search" placeholder="Search by Keyword" class="form-control search_by_tag">
                </form>


              </div>
            
            </div> <!-- .row -->
          </div> <!-- .container -->     
    <div class="fullwidth-block" data-bg-color="#edf2f4">    
      <div class="container">
        <div class="row">
            <div class="col-sm-6"></div>
            <div align="right" class="col-sm-6">


              <input id="myInput" type="text" placeholder="Search..">
            </div>
          </div>
          <table id="resultTable" class="table table-striped">
            <thead>
              <tr>
                  <th></th>
                      <th></th>
               <!--  <th>Study ID</th> -->
                <th>Study Name</th>

                <th>Access Status</th>
                <th>Created At</th>


              </tr>
            </thead>
            <tbody id="myTable">
          @foreach($my_studies as $my_study=>$value)


          @if(Auth::check())

            @if($value->access_status == "1")
              <tr id="ClickableRow{{$value->id}}">
                <td><i class="fa fa-sticky-note" aria-hidden="true"></i><td/>
                <td style="display:none;">{{$value->study_id}}</td>
                <td>{{$value->study_name}}</td>

                @if($value->access_status == "1")
                 <td>public</td>
               @else
                   <td>private</td>
               @endif


                <td>{{$value->created_at}}</td>
              </tr>
            @else

              @if($value->user_id == Auth::user()->id)
                <tr id="ClickableRow{{$value->id}}">
                  <td><i class="fa fa-sticky-note" aria-hidden="true"></i><td/>
                  <td style="display:none;">{{$value->study_id}}</td>
                  <td>{{$value->study_name}}</td>

                  @if($value->access_status == "1")
                   <td>public</td>
                 @else
                     <td>private</td>
                 @endif


                  <td>{{$value->created_at}}</td>
                </tr>

              @else
                <tr>
                  <td><i class="fa fa-sticky-note" aria-hidden="true"></i><td/>
                  <td style="display:none;">{{$value->study_id}}</td>
                  <td>{{$value->study_name}}</td>

                  @if($value->access_status == "1")
                   <td>public</td>
                 @else
                     <td>private</td>
                 @endif


                  <td>{{$value->created_at}}</td>
                </tr>

              @endif

            @endif

          @else
            @if($value->access_status == "1")
              <tr id="ClickableRow{{$value->id}}">
                <td><i class="fa fa-sticky-note" aria-hidden="true"></i><td/>
                <td style="display:none;">{{$value->study_id}}</td>
                <td>{{$value->study_name}}</td>

                @if($value->access_status == "1")
                 <td>public</td>
               @else
                   <td>private</td>
               @endif


                <td>{{$value->created_at}}</td>
              </tr>
            @else
                <tr >
                  <td><i class="fa fa-sticky-note" aria-hidden="true"></i><td/>
                  <td style="display:none;" >{{$value->study_id}}</td>
                  <td>{{$value->study_name}}</td>

                  @if($value->access_status == "1")
                   <td>public</td>
                 @else
                     <td>private</td>
                 @endif


                  <td>{{$value->created_at}}</td>
                </tr>
            @endif
          @endif

          @endforeach
            </tbody>
          </table>


      </div>

      <div align="center" class="container">
        {{ $my_studies->links('vendor.pagination.bootstrap-4') }}
      </div>
    </div>
  </main>
</div>
@endsection
@section('page-script')

<script>

function ajax_call_go_to_dataset(study_id) {
  var study_id = study_id;
  console.log(study_id);





  $.ajax({
    url: "/go_to_study_page",
    data: {
      study_id: study_id,
      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);
      window.location.href = "/datesets";


    //
    //  $("#sub_category_admin").html(html);


    }
  })




}
$('#resultTable tr').click(function (event) {
     // alert($(this).attr('id')); //trying to alert id of the clicked row
     var cls = "#" + $(this).attr('id') ;
     // alert($("#resultTable").find(cls).html());
     // $(cls).find("td:first").css('color', 'green');
     //alert($(cls).find("td:nth-child(3)").text());
     var study_id = $(cls).find("td:nth-child(3)").text();
     if (study_id === "") {
          //...

      }
      else{

        ajax_call_go_to_dataset(study_id);
      }




});

function getEmployeeName(search_type){

  result ="";
  $.ajax({


    url: "/search_home",
    data: {

      search_type: search_type,
      submit_check_1: "submit_check_1"


    },
    type: 'GET',
    async: false,
    success: function (data) {
      console.log("Success");
      console.log(data);
      result = data;

    }
  })


  var jsonData=  result;
  console.log("TM");
  console.log(jsonData);
  console.log(search_type);
  //ajaxToPass("/job_cards/get_problem_name.json", "" , "get");

  var productNames = new Array();
  if(search_type == "study"){

    $.each( jsonData, function ( index, product )
    {
      console.log("Name" + product.study_name);
      productNames.push( product.study_name );

    } );
  }


  if(search_type == "dataset"){

    $.each( jsonData, function ( index, product )
    {
      console.log("Name" + product.dataset_name);
      productNames.push( product.dataset_name );

    } );
  }

  if(search_type == "task"){

    $.each( jsonData, function ( index, product )
    {
      console.log("Name" + product.task_related);
      productNames.push( product.task_related );

    } );
  }
  if(search_type == "author_name"){

    $.each( jsonData, function ( index, product )
    {
      console.log("Name" + product.author_name);
      productNames.push( product.author_name );

    } );
  }
  if(search_type == "tag"){

    $.each( jsonData, function ( index, product )
    {
      console.log("Name" + product.search_tag);
      productNames.push( product.search_tag );

    } );
  }  


  return productNames;
}



$(function() {


  $('form').on('focus','.search_by_study',function(){



    // var user_id = $('.search_by_study').val();

    //console.log(user_id);




    var productNames = getEmployeeName("study");
      // var productNames = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
    // getproblemName();


    $(this).typeahead({


      source: productNames,
    });


  })



  $('form').on('focus','.search_by_dataset',function(){



    // var user_id = $('.search_by_study').val();

    //console.log(user_id);




    var productNames = getEmployeeName("dataset");
      // var productNames = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
    // getproblemName();


    $(this).typeahead({


      source: productNames,
    });


  })

  $('form').on('focus','.search_by_task',function(){



    //var user_id = $('.search_by_task').val();

    //console.log(user_id);




    var productNames = getEmployeeName("task");
      //var productNames = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
    // getproblemName();


    $(this).typeahead({


      source: productNames,
    });


  })
  $('form').on('focus','.search_by_author_name',function(){



    //var user_id = $('.search_by_task').val();

    //console.log(user_id);




    var productNames = getEmployeeName("author_name");
      //var productNames = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
    // getproblemName();


    $(this).typeahead({


      source: productNames,
    });


  })  
  $('form').on('focus','.search_by_tag',function(){



    //var user_id = $('.search_by_task').val();

    //console.log(user_id);




    var productNames = getEmployeeName("tag");
      //var productNames = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
    // getproblemName();


    $(this).typeahead({


      source: productNames,
    });


  }) 

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
  background-position: 10px 5px;
  background-repeat: no-repeat;
  /* padding: 1px 20px 12px 40px; */
  padding-left: 40px;

  -webkit-transition: width 0.4s ease-in-out;
  transition: width 0.4s ease-in-out;
}

input[name=search]:focus {
  width: 100%;
}


</style>
@endsection
