<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/db.php';

// Enhanced admin check
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    $_SESSION['redirect_message'] = "Admin access required";
    header("Location: login.php");
    exit();
}

// Rest of your admin.php code...

// Handle deletion of lost items
if (isset($_GET['delete_lost'])) {
    $id = $_GET['delete_lost'];
    $stmt = $conn->prepare("DELETE FROM lost_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php");
    exit();
}

// Handle deletion of found items
if (isset($_GET['delete_found'])) {
    $id = $_GET['delete_found'];
    $stmt = $conn->prepare("DELETE FROM found_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php");
    exit();
}

// Ban user
if (isset($_GET['ban_user'])) {
    $id = $_GET['ban_user'];
    $stmt = $conn->prepare("UPDATE users SET banned = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php");
    exit();
}

// Unban user
if (isset($_GET['unban_user'])) {
    $id = $_GET['unban_user'];
    $stmt = $conn->prepare("UPDATE users SET banned = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php");
    exit();
}

// Fetch data
$lost_items = $conn->query("SELECT * FROM lost_items");
$found_items = $conn->query("SELECT * FROM found_items");
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Lost & Found</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Dashboard</h2>

        <!-- Lost Items Section -->
        <div class="mb-5">
            <h3>Lost Items</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Date Lost</th>
                            <th>Location</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $lost_items->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['item_name']); ?></td>
                                <td><?= htmlspecialchars($row['description']); ?></td>
                                <td><?= htmlspecialchars($row['category']); ?></td>
                                <td><?= $row['date_lost']; ?></td>
                                <td><?= htmlspecialchars($row['location']); ?></td>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="<?= $row['image']; ?>" alt="Image" width="60">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td><a href="?delete_lost=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Found Items Section -->
        <div class="mb-5">
            <h3>Found Items</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Date Found</th>
                            <th>Location</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $found_items->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['item_name']); ?></td>
                                <td><?= htmlspecialchars($row['description']); ?></td>
                                <td><?= htmlspecialchars($row['category']); ?></td>
                                <td><?= $row['date_found']; ?></td>
                                <td><?= htmlspecialchars($row['location']); ?></td>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="<?= $row['image']; ?>" alt="Image" width="60">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td><a href="?delete_found=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Users Section -->
        <div class="mb-5">
            <h3>Users</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Banned</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $users->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= $row['banned'] ? 'Yes' : 'No'; ?></td>
                                <td>
                                    <?php if ($row['banned']): ?>
                                        <a href="?unban_user=<?= $row['id']; ?>" class="btn btn-success btn-sm">Unban</a>
                                    <?php else: ?>
                                        <a href="?ban_user=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Ban</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>