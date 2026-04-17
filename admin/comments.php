<?php
require 'auth.php';
require '../dbconnect.php';
require 'partials/header.php';

$success = '';
$error = '';

/* DELETE COMMENT */
if (isset($_POST['delete_comment'])) {
    $id = (int) $_POST['id'];

    if (mysqli_query($con, "DELETE FROM comments WHERE comment_id = $id")) {
        $success = "Comment deleted successfully!";
    } else {
        $error = "Failed to delete comment.";
    }
}

/* EDIT COMMENT */
if (isset($_POST['edit_comment'])) {
    $id = (int) $_POST['id'];
    $comment = mysqli_real_escape_string($con, $_POST['comment']);

    if (mysqli_query($con, "UPDATE comments SET comment_content='$comment' WHERE comment_id=$id")) {
        $success = "Comment updated successfully!";
    } else {
        $error = "Failed to update comment.";
    }
}
?>

<h3 class="page-title">Manage Comments</h3>

<!-- ALERTS -->
<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?= $success ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <?= $error ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card admin-card p-4">
<table class="table table-hover admin-table table-hover">
<thead>
<tr>
    <th>#</th>
    <th>Comment</th>
    <th>User</th>
    <th>Thread</th>
    <th width="120">Action</th>
</tr>
</thead>

<tbody>
<?php
$res = mysqli_query($con, "
    SELECT comments.*, users.username, thread.thread_title
    FROM comments
    JOIN users ON comments.comment_by = users.sno
    JOIN thread ON comments.thread_id = thread.thread_id
");

$i = 1;
while ($row = mysqli_fetch_assoc($res)) {
    echo "
    <tr>
        <td>$i</td>
        <td>{$row['comment_content']}</td>
        <td>{$row['username']}</td>
        <td>{$row['thread_title']}</td>
        <td>
    <button 
        class='btn btn-primary btn-sm'
        data-bs-toggle='modal'
        data-bs-target='#editModal'
        data-id='{$row['comment_id']}'
        data-comment=\"".htmlspecialchars($row['comment_content'])."\">
        Edit
    </button>

    <button 
        class='btn btn-danger btn-sm'
        data-bs-toggle='modal'
        data-bs-target='#deleteModal'
        data-id='{$row['comment_id']}'>
        Delete
    </button>
</td>
    </tr>";
    $i++;
}
?>
</tbody>
</table>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" class="modal-content text-center">
      <div class="modal-body">
        <input type="hidden" name="id" id="delete_id">
        <p class="mb-3">Delete this comment permanently?</p>
        <button name="delete_comment" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" class="modal-content">
      <div class="modal-body">
        <input type="hidden" name="id" id="edit_id">

        <div class="mb-3">
          <label>Edit Comment</label>
          <textarea name="comment" id="edit_comment" class="form-control" required></textarea>
        </div>

        <button name="edit_comment" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    document.getElementById('delete_id').value = button.getAttribute('data-id');
});
</script>

<script>
document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    document.getElementById('edit_id').value = button.getAttribute('data-id');
    document.getElementById('edit_comment').value = button.getAttribute('data-comment');
});
</script>

<?php require 'partials/footer.php'; ?>
