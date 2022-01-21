<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">
    <link href="{{ asset('css/group.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer> </script>
    <script src="https://kit.fontawesome.com/6eab2549cc.js" crossorigin="anonymous"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

  </head>
  <body>
    <main>
      <header>
        <div id="grid-menu">
          <div id="logo-div">
            <a href="{{ url('/') }}"><img id='logo' src="{{ asset('images/PGLogo.png') }}" alt=""><div id="PG-name">Proteingram.</div></a>
          </div>

          <div class='grid-menu-item'> 
            <div id="search-wrapper">
              <form action="/search" method="POST" role="search" id="search-form">
                {{ csrf_field() }}
                <div class="seatch-bar">
                    <input type="text" class="search-bar-input" name="q" placeholder="Search users...">
                        <button type="submit" class="btn-default">search</button>
                </div>
              </form>
            </div>

          </div>
          @if (Auth::check())
          <div class="grid-menu-item">
            <div class="corner-grid"><div id="notification-tab">
              <i class="fas fa-bell"></i>
              <div class="notifications tab-closed">
                @include('partials.notifications', ['notifications'=> Auth::user()->notifications()->orderBy('id','desc')->limit(10)->get()])
                @if(Auth::user()->notifications()->count() == 0)
                <div class="no-notifications">
                NO NOTIFICATIONS
                </div>
                
                @endif
              </div>
            </div>
          </div>
          </div>
          @endif
          <div class='grid-menu-item'>
            @if (Auth::check())
            <div id="corner-grid">
            
            <div id="profile-icon-div">
              <a id="profile-icon-link" href="{{ url('/users/'.Auth::user()->id) }}">
                <img id='profile-icon' src={{Auth::user()->image}}>
              </a>

              @if (Auth::user()->is_admin)
              <div class="profile-menu admin-menu" id="profile-menu">
              <a id="logout-button" href="{{ url('/logout') }}"> LOGOUT </a>
                <a href="{{ url('/users/edit/'.Auth::user()->id)}}"> SETTINGS </a>
                <a id="admin-button" href="{{url('/administration')}}"> ADMINISTRATION </a>
              </div>
              @endif

              @if (!(Auth::user()->is_admin))
              <div class="profile-menu" id="profile-menu">
              <a id="logout-button" href="{{ url('/logout') }}"> LOGOUT </a>
                <a href="{{ url('/users/edit/'.Auth::user()->id)}}"> SETTINGS </a>
              </div>
              @endif

              
          </div>

            </div>
            
            @endif

            @if (!Auth::check())
            <div id='login-register-div'>
            <a class="button" href="{{ url('/login') }}"> Login </a>
            <a class="button" href="{{ url('/register') }}"> Register </a>
            </div>

            @endif
          </div>
         
        </div>
      </header>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>
