<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('books.index') }}">Mazen's BookShop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('books.index') }}">
            @lang('site.books')
          </a>
        </li>
        {{-- new dorpdowon cats don't forget to include Popper and our JS separately in the layout file --}}
        <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              @lang('site.cats')
            </button>
            <ul class="dropdown-menu">
                @foreach ($cats as $cat)
                <a class="dropdown-item" href="#">{{$cat->name}}</a>
            @endforeach  
            </ul>
          </div>
        {{-- new dorpdowon cats end --}}

    
    </ul>

      
    </div>
    <ul class="navbar-nav ml-auto">
        @guest    
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.register') }}">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
            </li>
        @endguest

        @auth
            <li class="nav-item">
                <a class="nav-link disabled" href="#">{{ Auth::user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.logout') }}">
                  @lang('site.logout')
                </a>
            </li>

          {{-- new dorpdowon cats don't forget to include Popper and our JS separately in the layout file --}}
            <div class="dropdown">
              <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Change 
              </button>
              <ul class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('lang.ar') }}">AR</a>
                  <a class="dropdown-item" href="{{ route('lang.en') }}">EN</a>
              </ul>
            </div>
          {{-- new dorpdowon cats end --}} 

        @endauth

    </ul>
</nav>