<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{asset('assets/images/faces/face1.jpg')}}" alt="profile">
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{ucwords(Auth::user()->fullname)}}</span>
            <span class="text-secondary text-small">
              @foreach (Auth::user()->getRoleNames() as $name )
                  {{$name}}
              @endforeach
            </span>
          </div>
          <i class="mdi mdi-bookmark-check color-red nav-profile-badge"></i>
        </a>
      </li>

      <li class="nav-item {{ Request::route()->getPrefix() === 'home' ? 'active' : '' }}">
        <a href="{{route('home')}}" class="nav-link">
          <span class="menu-title">Beranda</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>

      <li class="nav-item {{ Request::route()->getPrefix() === 'admin/user' ? 'active' : '' }}">
        <a href="{{ route('pejabat_lelang.index') }}" class="nav-link">
          <span class="menu-title">Pejabat Lelang</span>
          <i class="mdi mdi-account-plus menu-icon"></i>
        </a>
      </li>

      <li class="nav-item {{ Request::route()->getPrefix() === 'admin/user' ? 'active' : '' }}">
        <a href="#" class="nav-link">
          <span class="menu-title">Kategori Pemohon</span>
          <i class="mdi mdi-account-plus menu-icon"></i>
        </a>
      </li>

      <li class="nav-item {{ Request::route()->getPrefix() === 'admin/user' ? 'active' : '' }}">
        <a href="#" class="nav-link">
          <span class="menu-title">Jenis Lelang</span>
          <i class="mdi mdi-account-plus menu-icon"></i>
        </a>
      </li>

      <li class="nav-item {{ Request::route()->getPrefix() === 'admin/user' ? 'active' : '' }}">
        <a href="#" class="nav-link">
          <span class="menu-title">Risalah Lelang</span>
          <i class="mdi mdi-account-plus menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a href="#laporan" data-bs-toggle="collapse" aria-expanded="true" aria-controls="forms" class="nav-link">
            <span class="menu-title">Laporan</span>
            <i class="menu-arrow"></i>
            <i class="bi bi-collection-play-fill menu-icon"></i>
        </a>
        <div class="collapse" id="laporan" style="">
            <ul class="nav flex-column sub-menu">
                <li><a class="nav-link" href="#">Laporan Lelang</li>
                <li><a class="nav-link" href="#">Laporan Risalah Lelang</li>
            </ul>
        </div>
      </li>

      {{-- @can('user') --}}
      <li class="nav-item {{ Request::route()->getPrefix() === 'admin/user' ? 'active' : '' }}">
        <a href="#" class="nav-link">
          <span class="menu-title">User</span>
          <i class="mdi mdi-account-plus menu-icon"></i>
        </a>
      </li>
      {{-- @endcan --}}
    </ul>
</nav>
