

<div class="container">
  <div class="card card-register mx-auto mt-5">
    <div class="card-header">Change Password</div>
    <div class="card-body">
      <form>
        <div class="form-group">
            <input type="text" id="username" class="form-control" placeholder="Username" value="<?= $username ?>" readonly="readonly">
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <input type="password" id="currentPassword" class="form-control" placeholder="Current Password" required="required">
            </div>
          </div>         
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-12">
              <input type="password" id="newPassword" class="form-control" placeholder="New Password" required="required">
            </div>
          </div>           
        </div>

        <button id="changePasswordBtn" class="btn btn-danger btn-block">Change Password</button>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/settings/changePassword.js') ?>"></script>