
    @if($status == "Approved")
        <div>
            Hi, you have been {{$status}} in PODA. Please  <a href="https://poda.cls.mtu.edu/login">Sign In</a> here for using PODA.
        </div>
    @else
        <div>
            Hi, you have been {{$status}} in PODA. Please contact PODA maanger for more information.
        </div>
    @endif


