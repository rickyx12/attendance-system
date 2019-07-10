  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a> 
        </li>
        <li class="breadcrumb-item active">
          <a href="#">Late</a> 
        </li>        
      </ol>

    <div class="row">
      <?php foreach($data as $d): ?>
        <div class="col-md-6 text-center">
           <h4><?= $d['section'] ?></h4>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($d['students'] as $student): ?>
                  <tr>
                    <td><?= $student->last_name ?>, <?= $student->first_name ?></td>
                    <td><?= $student->schedule_timein ?> | <?= $student->timeTap ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    </div>
  </div>