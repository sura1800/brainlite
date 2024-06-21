
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="/">
        <img style="width:5%;" src="{{asset(asset_path('upload/front/logo/jb-logo.png'))}}" alt="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown" style="width: 50%;">
      <ul class="navbar-nav ml-auto">
        
        
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::guard('front')->user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="width:192px; padding-top:4px; padding-top:4px;">
            <a class="drpLink" href="route('profile.edit')">
                {{ __('Profile') }}
            </a>
            <div class="">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="drpLink"  href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>     
            </div>  
          </div>
        </li>
      </ul>
    </div>
  </nav>