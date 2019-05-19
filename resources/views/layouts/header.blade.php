<div class="header">
  <input type="image" src="/img/logo_transparent.png" class="go_home_btn" alt="Submit" width="70" height="70"  onclick="window.location='{{ url("/") }}'">
  <div class="header-right">
    @if (Auth::check())

      <div class="style_header_contents">
          <a href="{{ url('studies/create_study') }}">Create Study</a>
          <a href="{{ url('studies/my_studies') }}">My Studies</a>
          @if(Auth::user()->admin_status =='1') 
            <a href="{{ url('studies/approval_requests') }}">Approval Requests</a>
          @endif
          <a href="{{ route('logout') }}"
              onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
              Logout

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                           {{ csrf_field() }}
                                       </form>
          </a>
        </div>

    @else
        <div class="style_header_contents">
          <a href="{{ url('/login') }}">Login</a>
          <a href="{{ url('/register') }}">Register</a>
        </div>
    @endif
  </div>

</div>
  <hr  style="height:1px;border:none;color:#333;background-color:#333;">
  <style>



  .header {
    overflow: hidden;

    padding-top: 20px;
   padding-right: 10px;
   padding-bottom: 0px;
   padding-left: 10px;
  }

  .header a {
    float: left;
    color: black;
    text-align: center;
    padding: 12px;
    text-decoration: none;
    font-size: 18px;
    line-height: 25px;
    border-radius: 4px;
  }

  .header a.logo {
    font-size: 25px;
    font-weight: bold;
  }

  .header a:hover {
    background-color: #00adb5;
    color: black;
  }

  .header a.active {
    background-color: dodgerblue;
    color: white;
  }

  .header-right {
    float: right;
  }

  @media screen and (max-width: 500px) {
    .header a {
      float: none;
      display: block;
      text-align: left;
    }

    .header-right {
      float: none;
    }
  }

  .style_header_contents {

    margin-top: 10px;
  }


  </style>


  <script>

$( ".go_home_btn" ).click(function() {

   window.location.href = "/";
});
  </script>
