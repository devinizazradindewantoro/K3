<nav class="main-header navbar navbar-expand" 
     style="background-color:#b00000; color:white !important;">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color:white !important;">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="../../index3.html" class="nav-link" style="color:white !important;">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link" style="color:white !important;">Contact</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto align-items-center">
    <!-- Real-time Date & Time -->
    <li class="nav-item d-none d-sm-inline-block mr-3">
      <span id="realTimeClock" class="font-weight-bold" style="color:white !important;"></span>
    </li>

    <!-- Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button" style="color:white !important;">
        <i class="fas fa-search"></i>
      </a>
    </li>

    <!-- Notification icon -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" style="color:white !important;">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
    </li>

    <!-- Fullscreen -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button" style="color:white !important;">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!-- Control sidebar -->
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" style="color:white !important;">
        <i class="fas fa-th-large"></i>
      </a>
    </li>
  </ul>
</nav>

<!-- ======= Script Real-Time Clock ======= -->
<script>
  function updateClock() {
    const now = new Date();
    const optionsDate = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    const formattedDate = now.toLocaleDateString('id-ID', optionsDate);

    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const formattedTime = `${hours}:${minutes}:${seconds}`;

    document.getElementById('realTimeClock').textContent = `${formattedDate} | ${formattedTime}`;
  }

  setInterval(updateClock, 1000);
  updateClock();
</script>
