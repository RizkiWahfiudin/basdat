<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        {{-- <img src="{{ url('storage/'.$logo) }}" style="max-width: 150px;"> --}}
        {{-- <h4>{{ $page_title }}</h4> --}}
        <h5>SISTEM EVENT</h5>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">

    @if (session()->has('roles_nama'))
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link">
            <i class="link-icon" data-feather="pie-chart"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>

        @if (hakAksesMenu('event','read'))
        <li class="nav-item">
            <a href="{{ url('/event') }}" class="nav-link">
              <i class="link-icon" data-feather="calendar"></i>
              <span class="link-title">Event</span>
            </a>
        </li>
        @endif

        @if (hakAksesMenu('region','read') || hakAksesMenu('kota','read') || hakAksesMenu('kategori','read'))
        <li class="nav-item nav-category">Master</li>
        @endif

        @if (hakAksesMenu('region','read'))
        <li class="nav-item">
            <a href="{{ url('/region') }}" class="nav-link">
              <i class="link-icon" data-feather="globe"></i>
              <span class="link-title">Region</span>
            </a>
        </li>
        @endif

        @if (hakAksesMenu('kota','read'))
        <li class="nav-item">
            <a href="{{ url('/kota') }}" class="nav-link">
              <i class="link-icon" data-feather="map-pin"></i>
              <span class="link-title">Kota</span>
            </a>
        </li>
        @endif

        @if (hakAksesMenu('kategori','read'))
        <li class="nav-item">
            <a href="{{ url('/kategori') }}" class="nav-link">
              <i class="link-icon" data-feather="list"></i>
              <span class="link-title">Kategori</span>
            </a>
        </li>
        @endif

      </ul>
    @endif

    </div>
</nav>
