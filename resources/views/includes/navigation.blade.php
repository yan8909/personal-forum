
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="/">Forum</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              Menu
          <i class="fa fa-bars"></i>
        </button>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Channels
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach ($channels as $channel)
                <a class="dropdown-item" href="{{ route('channelPosts', $channel->name) }}">{{ $channel->name }}</a>
              @endforeach
            </div>
          </li>
        </ul>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('index') }}">Home</a>
            </li>

            @if(Auth::check())
                <li class="nav-item">
                    @if(Auth::user()->admin == true)
                      <a class="nav-link" href="{{ route('adminDashboard') }}">Dashboard</a>
                     @elseif(Auth::user()->user == true)
                        <a class="nav-link" href="{{ route('userDashboard') }}">Dashboard</a>
                  @endif
                    
                </li>
                <li class="nav-item">
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">@csrf</form>
                    <a class="nav-link" href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                </li>
              @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @endif
          </ul>
        </div>
      </div>
    </nav>