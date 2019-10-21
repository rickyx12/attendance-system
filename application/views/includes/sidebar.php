    
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">

<!--       <?php if($page == 'dashboard-page'): ?>
        <li id="dashboard-nav" class="nav-item active">
      <?php else: ?>
        <li id="dashboard-nav" class="nav-item">
      <?php endif; ?>

        <a id="dashboard" class="nav-link" href="<?= base_url('Dashboard/index') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
 -->

      <?php if($page == 'students-page'): ?>
        <li id="students-nav" class="nav-item active">
      <?php else: ?>
        <li id="students-nav" class="nav-item">
      <?php endif; ?>

        <a id="students" class="nav-link" href="<?= base_url('Students/index') ?>">
          <i class="fas fa-fw fa-users"></i>
          <span>Students</span>
        </a>
      </li>
      

      <?php if($page == 'settings-page'): ?>
        <li id="settings-nav" class="nav-item active">
      <?php else: ?>
        <li id="settings-nav" class="nav-item">
      <?php endif; ?>

        <a id="settings" class="nav-link" href="<?= base_url('Settings/index') ?>">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Settings</span>
        </a>
      </li>


    </ul>
