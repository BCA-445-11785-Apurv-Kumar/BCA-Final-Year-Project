<?php
require 'auth.php';
require '../dbconnect.php';
require 'partials/header.php';

$success = '';
$error = '';

/* DELETE MESSAGE */
if (isset($_POST['delete_message'])) {
    $id = (int) $_POST['id'];

    if (mysqli_query($con, "DELETE FROM contact_messages WHERE id = $id")) {
        $success = "Message deleted successfully!";
    } else {
        $error = "Failed to delete message.";
    }
}
?>

<div class="content">

<h3 class="mb-4">📩 Contact Messages</h3>

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

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>Username</th>
    <th>Email</th>
    <th>Subject</th>
    <th>Message</th>
    <th>Date</th>
    <th>Status</th>
    <th width="80">Actions</th>
</tr>
</thead>

<tbody>

<?php
$sql = "SELECT * FROM contact_messages ORDER BY id DESC";
$result = mysqli_query($con, $sql);
$i = 1;

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['subject']) ?></td>
    <td><?= htmlspecialchars($row['message']) ?></td>
    <td><?= $row['created_at'] ?></td>

    <!-- STATUS -->
    <td>
        <span class="badge bg-<?= ($row['status']=='Pending' ? 'warning' : 'success') ?>">
            <?= $row['status'] ?>
        </span>
    </td>

    <!-- ACTIONS -->
    <td>
        

        <button 
            class="btn btn-danger btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#deleteModal"
            data-id="<?= $row['id'] ?>">
            Delete
        </button>
    </td>
</tr>
<?php } ?>

</tbody>
</table>

</div>
</div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" class="modal-content text-center">
      <div class="modal-body">
        <input type="hidden" name="id" id="delete_id">
        <p class="mb-3">Delete this message permanently?</p>
        <button name="delete_message" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>

<!-- SCRIPT FOR MODAL -->
<script>
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    document.getElementById('delete_id').value = button.getAttribute('data-id');
});
</script>

<?php require 'partials/footer.php'; ?>