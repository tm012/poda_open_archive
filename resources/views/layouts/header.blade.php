<div class="header">
  <a href="/" class="logo">PODA</a>
  <div class="header-right">
    @if (Auth::check())
        <a href="{{ url('studies/create_study') }}">Create Study</a>
        <a href="{{ url('studies/my_studies') }}">My Studies</a>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                         {{ csrf_field() }}
                                     </form>
        </a>

    @else
        <a href="{{ url('/login') }}">Login</a>
        <a href="{{ url('/register') }}">Register</a>
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
    background-color: #FFA07A;
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
  </style>
