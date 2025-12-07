<div class="sidebar">
  <div class="sidebar">
    @php
    $activeMenu = $activeMenu ?? '';
    @endphp
    <!-- SidebarSearch Form -->
    ...

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
          <a href="{{ url('/profil') }}" class="nav-link {{ ($activeMenu == 'profil')? 'active' : '' }}">
            <i class="nav-icon fas fa-building"></i>
            <p>Profil Perusahaan</p>
          </a>
        </li>

        <!-- Informasi Peraturan K3 -->
        <li class="nav-item">
          <a href="{{ url('/informasi') }}" class="nav-link {{ ($activeMenu == 'informasi')? 'active' : '' }}">
            <i class="nav-icon fas fa-gavel"></i>
            <p>Informasi Peraturan K3</p>
          </a>
        </li>

        <!-- Kebijakan K3 Perusahaan -->
        <li class="nav-item">
          <a href="{{ url('/kebijakan') }}" class="nav-link {{ ($activeMenu == 'kebijakan')? 'active' : '' }}">
            <i class="nav-icon fas fa-file-contract"></i>
            <p>Kebijakan K3 Perusahaan</p>
          </a>
        </li>

        <!-- Prosedur Darurat -->
        <li class="nav-item">
          <a href="{{ url('/prosedur') }}" class="nav-link {{ ($activeMenu == 'prosedur')? 'active' : '' }}">
            <i class="nav-icon fas fa-exclamation-triangle"></i>
            <p>Prosedur Darurat</p>
          </a>
        </li>

        <!-- Alat Pelindung Diri -->
        <li class="nav-item">
          <a href="{{ url('/pelindung') }}" class="nav-link {{ ($activeMenu == 'pelindung')? 'active' : '' }}">
            <i class="nav-icon fas fa-shield-alt"></i>

            <p>Alat Pelindung Diri</p>
          </a>
        </li>

        <!-- Materi K3 -->
        <li class="nav-item">
          <a href="{{ url('/p3k') }}" class="nav-link {{ ($activeMenu == 'p3k')? 'active' : '' }}">
            <i class="nav-icon fas fa-first-aid"></i>
            <p>P3K</p>
          </a>
        </li>
        <!-- Materi K3 -->
        <li class="nav-item">
          <a href="{{ url('/materi') }}" class="nav-link {{ ($activeMenu == 'materi')? 'active' : '' }}">
            <i class="nav-icon fas fa-book-open"></i>
            <p>Materi K3</p>
          </a>
        </li>

        <!-- SMK 3 -->
        <li class="nav-item">
          <a href="{{ url('/smk3') }}" class="nav-link {{ ($activeMenu == 'smk3')? 'active' : '' }}">
            <i class="nav-icon fas fa-book-open"></i>
            <p>SMK 3</p>
          </a>
        </li>

        <!-- AUDIT K3 -->
        <li class="nav-item">
          <a href="{{ url('/audit') }}" class="nav-link {{ ($activeMenu == 'audit')? 'active' : '' }}">
            <i class="nav-icon fas fa-book-open"></i>
            <p>AUDIT K3</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>