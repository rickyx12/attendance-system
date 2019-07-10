  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
      </ol>


    <div class="row">
      
      <?php foreach($data as $dashboard): ?>
        <div class="col-6">
          <div class="card mb-2">
            <div class="card-body">
              <h4>
                <?= $dashboard['gradeLevel'] ?>
              </h4>
        
                <div class="col-md-4" style="margin-bottom: -2%;">
                  <a href='<?= base_url('Dashboard/timelogDetails?gradeLevel='.$dashboard['id'].'&type=in') ?>' style="text-decoration: none; color:#000">
                    <label style="font-size:18px;">IN:</label>
                    <label style="font-size:17px; font-weight: bold;">
                      <?= $dashboard['timein'] ?>
                    </label>
                  </a>
                </div>

                <div class="col-md-4" style="margin-bottom: -2%;">
                  <a href='<?= base_url('Dashboard/timelogDetails?gradeLevel='.$dashboard['id'].'&type=out') ?>' style="text-decoration: none; color:#000">
                    <label style="font-size:18px;">OUT:</label>
                    <label style="font-size:17px; font-weight: bold;"><?= $dashboard['timeout'] ?></label>
                  </a>
                </div>

                <div class="col-md-4" style="margin-bottom: -2%;">
                  <a href='<?= base_url('Dashboard/lates?gradeLevel='.$dashboard['id']) ?>' style="text-decoration: none; color:#000">
                    <label style="font-size:18px;">LATE:</label>
                    <label style="font-size:17px; font-weight: bold;"><?= $dashboard['late'] ?></label>
                  </a>
                </div>
                            
            </div> 
          </div>
        </div>
      <?php endforeach; ?>

      <div class="col-6"></div>
    </div>

    </div>
  </div>