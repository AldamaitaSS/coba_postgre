{{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav ml-auto">
    <!-- Tombol Logout di pojok kanan -->
    <li class="nav-item">
      <form action="{{ url('/admin/logout') }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-link nav-link text-danger">
          <i class="fas fa-sign-out-alt"></i>
          <span class="d-none d-sm-inline-block ml-1"></span>
        </button>
      </form>        
    </li>
  </ul>
</nav> --}}

{{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav ml-auto align-items-center">

    <!-- Avatar dan Nama Admin -->
    @php $admin = auth('admin')->user(); @endphp
    @if ($admin)
      <li class="nav-item d-flex align-items-center mr-3">
        <a href="{{ route('admin.profile.index') }}" class="d-flex align-items-center text-decoration-none">
          <span style="
              background-color: #1B2C5A;
              color: white;
              padding: 6px 12px;
              border-radius: 20px;
              font-size: 14px;
              text-decoration: none;">
            {{ $admin->nama }}
          </span>
        </a>
      </li>
    @endif --}}

    <!-- Garis Pemisah -->
    <li class="nav-item mx-2" style="border-left: 1px solid rgba(0, 0, 0, 0.1); height: 25px;"></li>

    <!-- Tombol Logout -->
    <li class="nav-item">
      <form action="{{ url('/admin/logout') }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-link nav-link text-danger">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    </li>

  </ul>
</nav>


