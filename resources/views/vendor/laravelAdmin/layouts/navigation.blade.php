<nav class="navbar navbar-expand-lg bg-body-tertiar bg-white">
  <div class="container-fluid">
    <a class="navbar-brand link-secondary" href="#">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @foreach (config('laravel-admin.navs', []) as $nav)
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs($nav['route_name']) ? 'active' : '' }}" aria-current="page"
              href="{{ route($nav['route_name']) }}">
              {{ $nav['display_name'] }}
            </a>
          </li>
        @endforeach
      </ul>
      <div class="dropdown">
        <a class="dropdown-toggle btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-lg-end">
          <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
              {{ __('Home') }}
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button type="submit" class="btn">
                {{ __('Log Out') }}
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
