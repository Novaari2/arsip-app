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
      @can('pejabat_lelang')
        <li class="nav-item {{ Request::route()->getPrefix() === 'administrator/user' ? 'active' : '' }}">
            <a href="{{ route('pejabat_lelang.index') }}" class="nav-link">
            <span class="menu-title">Pejabat Lelang</span>
            <i class="mdi mdi-account-plus menu-icon"></i>
            </a>
        </li>
      @endcan

      @can('kategori_pemohon')
        <li class="nav-item {{ Request::route()->getPrefix() === 'administrator/user' ? 'active' : '' }}">
            <a href="{{ route('kategori_pemohon.index') }}" class="nav-link">
            <span class="menu-title">Kategori Pemohon</span>
            <i class="mdi  mdi-code-not-equal menu-icon"></i>
            </a>
        </li>
      @endcan

      @can('jenis_lelang')
        <li class="nav-item {{ Request::route()->getPrefix() === 'administrator/user' ? 'active' : '' }}">
            <a href="{{ route('jenis_lelang.index') }}" class="nav-link">
            <span class="menu-title">Jenis Lelang</span>
            <i class="mdi mdi-buffer menu-icon"></i>
            </a>
        </li>
      @endcan

      @can('risalah_lelang')
      <li class="nav-item {{ Request::route()->getPrefix() === 'admin/user' ? 'active' : '' }}">
        <a href="{{ route('risalah_lelang.index') }}" class="nav-link">
          <span class="menu-title">Risalah Lelang</span>
          <i class="mdi  mdi-book-multiple menu-icon"></i>
        </a>
      </li>
      @endcan

      @can('rak_gudang')
        <li class="nav-item {{ Request::route()->getPrefix() === 'administrator/user' ? 'active' : '' }}">
            <a href="{{ route('rak_gudang.index') }}" class="nav-link">
            <span class="menu-title">Rak Gudang</span>
            <i class="mdi mdi-bitbucket menu-icon"></i>
            </a>
        </li>
      @endcan

      @can('rak_detail')
        <li class="nav-item {{ Request::route()->getPrefix() === 'administrator/user' ? 'active' : '' }}">
            <a href="{{ route('rak_detail.index') }}" class="nav-link">
            <span class="menu-title">Nomor Rak</span>
            <i class="mdi mdi-border-all menu-icon"></i>
            </a>
        </li>
      @endcan

      {{-- <li class="nav-item">
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
      </li> --}}

      @can('user')
      <li class="nav-item {{ Request::route()->getPrefix() === 'admin/user' ? 'active' : '' }}">
        <a href="{{ route('user.index') }}" class="nav-link">
          <span class="menu-title">User</span>
          <i class="mdi mdi-account menu-icon"></i>
        </a>
      </li>
      @endcan

      @can('role')
        <li class="nav-item {{ Request::route()->getPrefix() === 'admin/user' ? 'active' : '' }}">
            <a href="{{ route('role.index') }}" class="nav-link">
            <span class="menu-title">Hak Akses</span>
            <i class="mdi mdi-arrow-right menu-icon"></i>
            </a>
        </li>
      @endcan
    </ul>
</nav>
