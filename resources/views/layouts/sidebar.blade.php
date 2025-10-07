<div class="sidebar">
  <!-- SidebarSearch Form -->
  <div class="form-inline mt-">
    <div class="input-group" data-widget="sidebar-search">
      <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-sidebar">
          <i class="fas fa-search fa-fw"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      <!-- Dashboard -->
      <li class="nav-item">
        <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }}">
          <i class="nav-icon fas fa-home"></i>
          <p>Dashboard</p>
        </a>
      </li>

      <!-- Profil Perusahaan -->
      <li class="nav-item">
        <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }}">
          <i class="nav-icon fas fa-building"></i>
          <p>Profil Perusahaan</p>
        </a>
      </li>

      <!-- Informasi Peraturan K3 -->
      <li class="nav-item">
        <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user')? 'active' : '' }}">
          <i class="nav-icon fas fa-gavel"></i>
          <p>Informasi Peraturan K3</p>
        </a>
      </li>

      <!-- Kebijakan K3 Perusahaan -->
      <li class="nav-item">
        <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori')? 'active' : '' }}">
          <i class="nav-icon fas fa-file-contract"></i>
          <p>Kebijakan K3 Perusahaan</p>
        </a>
      </li>

      <!-- Prosedur Darurat -->
      <li class="nav-item">
        <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang')? 'active' : '' }}">
          <i class="nav-icon fas fa-exclamation-triangle"></i>
          <p>Prosedur Darurat</p>
        </a>
      </li>

      <!-- Materi K3 -->
      <li class="nav-item">
        <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok')? 'active' : '' }}">
          <i class="nav-icon fas fa-book-open"></i>
          <p>Materi K3</p>
        </a>
      </li>

      <!-- Logout -->
      <li class="nav-item">
        <a href="{{ url('/login') }}" class="nav-link text-danger {{ ($activeMenu == 'login') ? 'active' : '' }}">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>Logout</p>
        </a>
      </li>

    </ul>
  </nav>
</div>
