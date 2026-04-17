<?php
require 'auth.php';
require '../dbconnect.php';
require 'partials/header.php';

$success = '';
$error   = '';

/* ADD CATEGORY */
if (isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);

    // SERVER SIDE VALIDATION
    if (!preg_match('/^[A-Za-z0-9 ]{3,50}$/', $name)) {
        $error = "Category name should contain only letters, numbers and spaces (3-50 chars).";
    } elseif (strlen($desc) < 10) {
        $error = "Description must be at least 10 characters.";
    } else {

        // IMAGE UPLOAD
        $imageName = 'default.jpg';

        if (!empty($_FILES['image']['name'])) {

            $allowed = ['jpg','jpeg','png','webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $error = "Only JPG, JPEG, PNG, WEBP images allowed.";
            } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                $error = "Image size must be less than 2MB.";
            } else {
                $imageName = time() . "_" . $_FILES['image']['name'];
                $target = "../images/" . $imageName;
                move_uploaded_file($_FILES['image']['tmp_name'], $target);
            }
        }

        if (empty($error)) {
            if (mysqli_query($con, "INSERT INTO categories (category_name, category_description, category_image)
                                    VALUES ('$name','$desc','$imageName')")) {
                $success = "Category added successfully!";
            } else {
                $error = "Failed to add category.";
            }
        }
    }
}

/* UPDATE CATEGORY */
if (isset($_POST['update_category'])) {
    $id   = $_POST['category_id'];
    $name = trim($_POST['edit_name']);
    $desc = trim($_POST['edit_description']);

    // VALIDATION
    if (!preg_match('/^[A-Za-z0-9 ]{3,50}$/', $name)) {
        $error = "Category name should contain only letters, numbers and spaces.";
    } elseif (strlen($desc) < 10) {
        $error = "Description must be at least 10 characters.";
    } else {

        // CHECK IMAGE UPDATE
        if (!empty($_FILES['edit_image']['name'])) {

            $allowed = ['jpg','jpeg','png','webp'];
            $ext = strtolower(pathinfo($_FILES['edit_image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $error = "Only JPG, JPEG, PNG, WEBP images allowed.";
            } elseif ($_FILES['edit_image']['size'] > 2 * 1024 * 1024) {
                $error = "Image size must be less than 2MB.";
            } else {
                $imageName = time() . "_" . $_FILES['edit_image']['name'];
                $target = "../images/" . $imageName;
                move_uploaded_file($_FILES['edit_image']['tmp_name'], $target);

                mysqli_query($con, "UPDATE categories 
                    SET category_name='$name', category_description='$desc', category_image='$imageName'
                    WHERE category_id=$id");

                $success = "Category updated successfully!";
            }

        } else {

            mysqli_query($con, "UPDATE categories 
                SET category_name='$name', category_description='$desc'
                WHERE category_id=$id");

            $success = "Category updated successfully!";
        }
    }
}

/* DELETE CATEGORY */
if (isset($_POST['delete_category'])) {
    $id = $_POST['delete_id'];

    if (mysqli_query($con, "DELETE FROM categories WHERE category_id = $id")) {
        $success = "Category deleted successfully!";
    } else {
        $error = "Failed to delete category.";
    }
}
?>

<h3 class="page-title">Manage Categories</h3>

<!-- ALERTS -->
<?php if($success): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?= $success ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if($error): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <?= $error ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- ADD CATEGORY -->
<div class="card admin-card p-4 mb-4">
    <h5>Add New Category</h5>

    <form method="POST" enctype="multipart/form-data" class="admin-form mt-3" id="addCategoryForm">

        <input type="text" 
               name="name" 
               class="form-control mb-3" 
               placeholder="Category Name" 
               required
               pattern="^[A-Za-z0-9 ]{3,50}$"
               title="Only letters, numbers and spaces (3-50 chars)">

        <textarea name="description" 
                  class="form-control mb-3" 
                  placeholder="Category Description" 
                  required
                  minlength="10"></textarea>

        <!-- IMAGE FIELD -->
        <input type="file" 
               name="image" 
               class="form-control mb-3" 
               accept=".jpg,.jpeg,.png,.webp,image/*">

        <button class="btn btn-success" name="add_category">Add Category</button>
    </form>
</div>

<!-- CATEGORY LIST -->
<div class="card admin-card p-4">
    <h5>All Categories</h5>

    <table class="table table-bordered table-hover mt-3 admin-table">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th width="160">Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $res = mysqli_query($con, "SELECT * FROM categories");
        $sno = 1;
        while ($row = mysqli_fetch_assoc($res)) {
        ?>
            <tr>
                <td><?= $sno++ ?></td>
                <td><?= htmlspecialchars($row['category_name']) ?></td>
                <td><?= htmlspecialchars($row['category_description']) ?></td>

                <td>
                    <img src="../images/<?= $row['category_image'] ?>" width="60" height="40">
                </td>

                <td>
                    <!-- EDIT BUTTON -->
                    <button 
                        class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editCategoryModal"
                        data-id="<?= $row['category_id'] ?>"
                        data-name="<?= htmlspecialchars($row['category_name']) ?>"
                        data-desc="<?= htmlspecialchars($row['category_description']) ?>">
                        Edit
                    </button>

                    <!-- DELETE -->
                    <button
                        class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteCategoryModal"
                        data-id="<?= $row['category_id'] ?>">
                        Delete
                    </button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" enctype="multipart/form-data" class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <input type="hidden" name="category_id" id="edit_id">

        <div class="mb-3">
          <label class="form-label">Category Name</label>
          <input type="text" 
                 name="edit_name" 
                 id="edit_name" 
                 class="form-control" 
                 required
                 pattern="^[A-Za-z0-9 ]{3,50}$">
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="edit_description" 
                    id="edit_description" 
                    class="form-control" 
                    rows="3" 
                    required
                    minlength="10"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Update Image</label>
          <input type="file" 
                 name="edit_image" 
                 class="form-control"
                 accept=".jpg,.jpeg,.png,.webp,image/*">
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-success" name="update_category">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>

    </form>
  </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p class="mb-0">Are you sure you want to delete this category?</p>
        <input type="hidden" name="delete_id" id="delete_id">
      </div>

      <div class="modal-footer justify-content-center">
        <button type="submit" name="delete_category" class="btn btn-danger">
          Yes, Delete
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Cancel
        </button>
      </div>

    </form>
  </div>
</div>

<script>
var editModal = document.getElementById('editCategoryModal');
if(editModal){
    editModal.addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget;
        document.getElementById('edit_id').value = btn.getAttribute('data-id');
        document.getElementById('edit_name').value = btn.getAttribute('data-name');
        document.getElementById('edit_description').value = btn.getAttribute('data-desc');
    });
}

var deleteModal = document.getElementById('deleteCategoryModal');
if(deleteModal){
    deleteModal.addEventListener('show.bs.modal', function (event) {
        document.getElementById('delete_id').value =
            event.relatedTarget.getAttribute('data-id');
    });
}

/* AUTO DISMISS ALERT */
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 500);
    });
}, 3500);
</script>

<?php require 'partials/footer.php'; ?>