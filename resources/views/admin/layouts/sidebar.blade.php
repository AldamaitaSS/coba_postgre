<style>
.sidebar {
    background-color: #B22222 !important; /* Warna biru sesuai desain */
    color: white;
    min-height: 100vh !important; /* Mengubah dari 88vh menjadi 100vh untuk memenuhi seluruh tinggi layar */
        height: 100% !important; /* Menambahkan height 100% */
        position: fixed !important; /* Menambahkan position fixed */
        left: 0;
        top: 0;
        bottom: 0;
        width: 250px; /* Sesuaikan lebar sidebar sesuai kebutuhan */
}

.nav-link {
    color: #d1d5db; 
}

.nav-link.active, .nav-link:hover {
    background-color: #F1F1F1!important; 
    color: #B22222 !important;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
    border-radius: 8px; 
    background-color: #F1F1F1; 
}
</style>

<div class="sidebar">
    <div class="sidebar">
        <!-- Logo JTI Polinema -->
        <div class="logo-header">
            <div class="header-content">
                {{-- <img src="{{ asset('logo.png') }}" width="80" height="80" style="margin-left: -15px;"/> --}}
                <div class="header-text">
                    <h4>Yuk!</h4> <br> <h4>Buat Artikelmu.</h4>
                    {{-- <span>Buat Artikelmu.</span> --}}
                </div>
            </div>
        </div>
        <style>
            .logo-header {
              padding: 10px;
              background-color: #B22222;
              border-bottom: 1px solid rgba(255, 255, 255, 0.1);
          }

          .header-content {
              display: flex;
              align-items: center;
              gap: 5px;
          }

          .logo-icon {
              font-size: 30px;
              color: white;
          }

          .header-text {
              display: flex;
              flex-direction: column;
          }

          .header-text h4 {
              color: white;
              font-weight: 700;
              margin: 0;
              font-size: 19px;
              line-height: 1;
              margin-top: 4px; /* Memberikan jarak antara title dan subtitle */
          }

          .header-text span {
              color: #d1d5db;
              font-size: 15px;
              font-weight: normal;
              line-height: 1.2;
              margin-top: 4px; /* Memberikan jarak antara title dan subtitle */
          }

          .user-panel {
              display: flex;
              flex-direction: column; /* Atur vertikal */
              align-items: center; /* Pusatkan horizontal */
              justify-content: center; /* Pusatkan vertikal */
          }

          .user-panel .profile-img {
              width: 80px; /* Penuhi kontainer */
              height: 80px; /* Penuhi kontainer */
              object-fit: cover; /* Gambar menyesuaikan */
              border-radius: 80px; /* Membuat gambar berbentuk lingkaran */

              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Tambahkan bayangan */
          }

          /* Styling nama pengguna */
          .user-panel .info {
              margin-top: 10px; /* Jarak antara foto dan nama */
              font-size: 16px; /* Ukuran teks */
              font-weight: bold; /* Tebalkan teks */
              text-align: center; /* Teks rata tengah */
          }
          \.bg-orange {
                background-color:#F1F1F1 !important;
            }

        </style>

<div class="sidebar-profile">
    {{-- profile admin --}}
    {{-- <div class="user-panel mt-3 pb-3 d-flex flex-column align-item-center">
        <div class="image">
            <img src="{{ auth()->user()->avatar ? asset('storage/photos/' . auth()->user()->avatar) : asset('img/pp.jpg') }}"
                class="profile-img img-circle elevation-2"
                alt="Admin Image">
        </div>
        <div class="info mt-2">
            <a href="{{ url('/profile') }}" class="d-block text-white text-center"> {{ auth()->user()->username }}</a>
        </div>
    </div> --}}

    {{-- menu menu --}}
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Dashboard (Untuk semua user) -->
            <li class="nav-item">
                <a href="{{ url('admin/') }}"
                class="nav-link" 
                style="background-color: {{ $activeMenu == 'dashboard' ? '#F1F1F1' : '' }}; color: {{ $activeMenu == 'dashboard' ? '#B22222' : '#F1F1F1' }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <p>Home</p>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a href="{{ url('admin/data_editor') }}"
                class="nav-link" 
                style="background-color: {{ $activeMenu == 'editor' ? '#F1F1F1' : '' }}; color: {{ $activeMenu == 'editor' ? '#B22222' : '#F1F1F1' }}">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Data Editor</p>
                </a>
            </li> --}}

            <li class="nav-item">
                <a href="{{ url('admin/galeri') }}" 
                class="nav-link" 
                style="background-color: {{ $activeMenu == 'galeri' ? '#EE4123' : '' }}; color: {{ $activeMenu == 'galeri' ? 'white' : '#d1d5db' }}">
                    <i class="fas fa-images nav-icon"></i>
                    <p>Galeri</p>
                </a>
            </li>

            {{-- <!-- Profil Perusahaan -->
            <li class="nav-item">
                <a href="{{ url('/admin/profil_kantor') }}"
                class="nav-link"
                style="background-color: {{ $activeMenu == 'profil_kantor' ? '#EE4123' : '' }}; color: {{ $activeMenu == 'profil_kantor' ? 'white' : '#d1d5db' }}">
                    <i class="fas fa-building nav-icon"></i>
                    <p>Profil Perusahaan</p>
                </a>
            </li>

            <!-- Data Editor -->
            <li class="nav-item">
                <a href="{{ url('admin/data_editor'') }}" 
                class="nav-link" 
                style="background-color: {{ $activeMenu == 'data_pengguna' ? '#EE4123' : '' }}; color: {{ $activeMenu == 'data_pengguna' ? 'white' : '#d1d5db' }}">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Data Pengunjung</p>
                </a>
            </li>
            
            <!-- Galeri -->
            <li class="nav-item">
                <a href="{{ url('admin/galeri') }}" 
                class="nav-link" 
                style="background-color: {{ $activeMenu == 'galeri' ? '#EE4123' : '' }}; color: {{ $activeMenu == 'galeri' ? 'white' : '#d1d5db' }}">
                    <i class="fas fa-images nav-icon"></i>
                    <p>Galeri</p>
                </a>
            </li>
            
            <!-- Agenda -->
            <li class="nav-item">
                <a href="{{ url('admin/agenda') }}" 
                class="nav-link" 
                style="background-color: {{ $activeMenu == 'agenda' ? '#EE4123' : '' }}; color: {{ $activeMenu == 'agenda' ? 'white' : '#d1d5db' }}">
                    <i class="fas fa-tasks nav-icon"></i>
                    <p>Kegiatan</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/promosi') }}" 
                class="nav-link" 
                style="background-color: {{ $activeMenu == 'promosi' ? '#EE4123' : '' }}; color: {{ $activeMenu == 'promosi' ? 'white' : '#d1d5db' }}">
                    <i class="fas fa-bullhorn nav-icon"></i>  <!-- Ikon terompet promosi -->
                    <p>Promosi</p>
                </a>
            </li> --}}
        </ul>
    </nav>
</div>