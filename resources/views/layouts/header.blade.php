<header class="site-header collapsed-nav" data-bg-image="">
  <div class="container">
    <div class="header-bar">
      <a style="text-decoration:none" onclick="window.location='{{ url("/") }}'" class="branding">
        <img src="/img/logo_transparent.png" width="70" height="70" alt="" class="logo">
        <div class="logo-type">
          <h1 class="site-title">PODA</h1>
          <small class="site-description">Data Hive for PEBL</small>
        </div>
      </a>

      @php

          if(Auth::check()){
            $str = Auth::user()->name;
            $array_name = explode(" ",$str);
          }

      @endphp

      <nav class="main-navigation">
        <button class="menu-toggle"><i class="fa fa-bars"></i></button>
        <ul class="menu">
       
          <li class="home menu-item "><a href="/"><img style="position: static;" src="<?= asset('images/home_tm.png') ?>" alt="Home"></a></li>
         
<!--           <li class="menu-item dropdown "><a class="" style="text-decoration:none" href="">PEBL</a>
           <div class="dropdown-content">
              <a style="text-decoration:none" href="http://pebl.sourceforge.net/" target="_blank">PEBL Website</a>
              <a style="text-decoration:none" href="https://en.wikipedia.org/wiki/PEBL_(software)" target="_blank">PEBL Wikipedia</a>
              
            </div>
          </li>
 -->
<!--           <li class="menu-item dropdown "><a class="" style="text-decoration:none" href="">Guidelines</a>
           <div class="dropdown-content">
              <a style="text-decoration:none" href="">Help</a>
              <a style="text-decoration:none" href="">FAQ</a>
              <a style="text-decoration:none" href="">Quick-start Guide</a>
              <a style="text-decoration:none" href="">Licenses</a>
              <a style="text-decoration:none" href="">Contact</a>
              <a style="text-decoration:none" href="https://www.superiorideas.org/" target="_blank">Donate</a>
              
            </div>
          </li>  -->                    
          @if (Auth::check())

           
            <li class="menu-item dropdown "><a class="" style="text-decoration:none" href="">Study</a>
             <div class="dropdown-content">
                <a style="text-decoration:none" href="{{ url('/welcome') }}">Study List</a>
               
              

              


                
              </div>
            </li> 
            @if(Auth::user()->admin_status =='1') 
              <li class="menu-item dropdown "><a class="" style="text-decoration:none" href="">Admin</a>
               <div class="dropdown-content">
              
                  @if(Auth::user()->admin_status =='1') 
                    <a style="text-decoration:none" href="{{ url('studies/approval_requests') }}">Approval Requests</a>
                    <a style="text-decoration:none" href="{{ url('admin/news_list') }}">News</a>

                    <a style="text-decoration:none" href="{{ url('studies/tasks') }}">Tasks</a>
                    <a style="text-decoration:none" href="{{ url('admin/user_list') }}">User List</a>
                  @endif
           

                  
                </div>
              </li> 
         @endif
          @else
           <li class="menu-item "><a style="text-decoration:none" href="{{ url('/welcome') }}">Study List</a></li>  
             <li class="menu-item "><a style="text-decoration:none" href="{{ url('/login') }}">Login</a></li> 
                
               <li class="menu-item "><a style="text-decoration:none" href="{{ url('/register') }}">Register</a></li> 

          @endif

          <!--  <li class="menu-item "><a style="text-decoration:none" href="">Contact</a></li>  
 -->

          @if (Auth::check())
         <li class="menu-item dropdown "><a class="" style="text-decoration:none" href="">{{$array_name[0]}}</a>
               <div class="dropdown-content">
                 <a style="text-decoration:none" href="{{ url('studies/create_study') }}">Create Study</a>
            <a style="text-decoration:none" href="{{ url('/edit_account') }}">Edit Account</a>
            
             <a style="text-decoration:none" href="{{ url('studies/my_studies') }}">My Studies</a>
            <a style="text-decoration:none" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
              Logout

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                           {{ csrf_field() }}
                                       </form>
              </a>
            </li>

          @endif


       



   

      

              

        </ul>
      </nav>

      <div class="mobile-navigation"></div>
    </div>
  </div>
</header>


<script type="text/javascript">
  


</script>

<style>
.dropbtn {
  background-color: white;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>