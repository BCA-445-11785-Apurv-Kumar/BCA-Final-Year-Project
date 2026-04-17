<?php
require '../dbconnect.php';
require 'partials/header.php';

/* UPDATE THREAD */
if(isset($_POST['update'])){
    $id    = $_POST['id'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc  = mysqli_real_escape_string($con, $_POST['desc']);

    mysqli_query($con,"UPDATE thread SET
        thread_title='$title',
        thread_desc='$desc'
        WHERE thread_id=$id
    ");
}

/* DELETE THREAD */
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    mysqli_query($con,"DELETE FROM thread WHERE thread_id=$id");
}
?>

<h3 class="page-title">Manage Threads</h3>

<div class="card admin-card p-4">
<table class="table table-bordered table-hover admin-table">
<tr>
<th>#</th>
<th>Title</th>
<th>Description</th>
<th>User</th>
<th>Action</th>
</tr>

<?php
$res = mysqli_query($con,"
SELECT thread.*, users.username 
FROM thread 
JOIN users ON thread.thread_user_id = users.sno
");

$i = 1;
while($row = mysqli_fetch_assoc($res)){
    $safeTitle = htmlspecialchars($row['thread_title'], ENT_QUOTES);
    $safeDesc  = htmlspecialchars($row['thread_desc'], ENT_QUOTES);

    echo "
    <tr>
    <td>$i</td>
    <td>{$row['thread_title']}</td>
    <td>{$row['thread_desc']}</td>
    <td>{$row['username']}</td>
    <td>
        <button class='btn btn-primary btn-sm' data-bs-toggle='modal'
        data-bs-target='#editModal'
        data-id='{$row['thread_id']}'
        data-name=\"$safeTitle\"
        data-desc=\"$safeDesc\">Edit</button>

        <button class='btn btn-danger btn-sm' data-bs-toggle='modal'
        data-bs-target='#deleteModal'
        data-id='{$row['thread_id']}'>Delete</button>
    </td>
    </tr>";
    $i++;
}
?>
</table>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog">
<form method="POST" class="modal-content">
<input type="hidden" name="id" id="edit_id">

<div class="modal-body">
<input name="title" id="edit_name" class="form-control mb-2" required>
<textarea name="desc" id="edit_desc" class="form-control" required></textarea>
</div>

<div class="modal-footer">
<button name="update" class="btn btn-primary">Update</button>
</div>
</form>
</div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
<div class="modal-dialog">
<form method="POST" class="modal-content text-center">
<input type="hidden" name="id" id="delete_id">
<p class="p-3">Delete this thread?</p>
<button name="delete" class="btn btn-danger">Delete</button>
</form>
</div>
</div>

<script>
document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    document.getElementById('edit_id').value =
        button.getAttribute('data-id');

    document.getElementById('edit_name').value =
        button.getAttribute('data-name');

    document.getElementById('edit_desc').value =
        button.getAttribute('data-desc');
});

document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
    document.getElementById('delete_id').value =
        event.relatedTarget.getAttribute('data-id');
});
</script>

<?php require 'partials/footer.php'; ?>
