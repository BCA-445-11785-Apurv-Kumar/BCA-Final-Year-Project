<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalLabel">Login to iDiscuss</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/FORUM/partials/handlelogin.php" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="username" class="form-label lable">Username</label>
            <input type="text" class="form-control" maxlength="11" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="password" class="form-label lable">Password</label>
            <input type="password" class="form-control" maxlength="255" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary mt-2">Login</button>
        </div>
        <div class="modal-footer">
      </form>
    </div>
  </div>
</div>
</div>