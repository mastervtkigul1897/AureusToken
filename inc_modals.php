<!-- Registration Modal -->
<div class="modal fade" id="Registration" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Registration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php include_once('data.php');?>
      <form method="POST" action="">
      <div class="modal-body">
        <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Wallet Address</small>
            <input type="text" class="form-control" name="wallet" placeholder="0x00" required>
        </div>
        <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Username</small>
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Password</small>
            <input type="password" class="form-control" name="password" placeholder="●●●●●●●●●●●" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="Registration" class="btn btn-primary">Register</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="Login" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="data.php">
      <div class="modal-body">
        <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Username</small>
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <small id="emailHelp" class="form-text text-muted">Password</small>
            <input type="password" class="form-control" name="password" placeholder="●●●●●●●●●●●" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="Login" class="btn btn-primary">Login</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="Activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="data.php">
      <div class="modal-body">
        <h4>Are you Sure?</h4>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="Activate" class="btn btn-primary">Activate</button>
      </div>
    </form>
    </div>
  </div>
</div>