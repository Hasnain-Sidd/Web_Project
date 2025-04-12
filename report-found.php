<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date_found = $_POST['date_found'];
    $location = $_POST['location'];

    // File Upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){

    }
    else{
          $error='Failed to Upload!';
    }
    
    $stmt = $conn->prepare("INSERT INTO found_items (user_id, item_name, description, category, date_found, location, image) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $user_id, $item_name, $description, $category, $date_found, $location, $target_file);

    if ($stmt->execute()) {
        $success = "Found item reported successfully!";
    } else {
        $error = "Error reporting the found item.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Found Item</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Report a Found Item</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-success text-center"><?php echo $success; ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="report-found.php" method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
        <div class="mb-3">
            <label>Item Name:</label>
            <input type="text" name="item_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Category:</label>
            <select name="category" class="form-control">
                <option value="Electronics">Electronics</option>
                <option value="Documents">Documents</option>
                <option value="Accessories">Accessories</option>
                <option value="Clothing">Clothing</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Date Found:</label>
            <input type="date" name="date_found" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Location:</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Upload Image:</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Report Found Item</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
