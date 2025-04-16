<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];

// Fetch lost items of the logged-in user
$query = "SELECT * FROM lost_items WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$lost_items = $stmt->get_result();

function findMatches($conn, $category, $location, $date_lost, $current_user_id) {
    $query = "SELECT fi.*, u.username 
              FROM found_items fi
              JOIN users u ON fi.user_id = u.id
              WHERE fi.category = ? 
              AND fi.location LIKE ?
              AND fi.date_found >= ?
              AND fi.user_id != ?";
    $stmt = $conn->prepare($query);

    // Use a temporary variable for location
    $like_location = "%$location%";

    $stmt->bind_param("sssi", $category, $like_location, $date_lost, $current_user_id);
    $stmt->execute();
    return $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Matching Found Items</h2>

    <?php while ($lost = $lost_items->fetch_assoc()): ?>
        <div class="card my-3">
            <div class="card-body">
                <h5 class="card-title">Lost Item: <?php echo htmlspecialchars($lost['item_name']); ?></h5>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($lost['category']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($lost['location']); ?></p>
                <p><strong>Lost Date:</strong> <?php echo htmlspecialchars($lost['date_lost']); ?></p>

                <h6>Possible Matches:</h6>
                <?php
                $matches = findMatches($conn, $lost['category'], $lost['location'], $lost['date_lost'], $current_user_id);
                if ($matches->num_rows > 0):
                    while ($match = $matches->fetch_assoc()):
                ?>
                    <div class="border p-2 mb-2">
                        <p><strong>Found Item:</strong> <?php echo htmlspecialchars($match['item_name']); ?></p>
                        <p><strong>Found By:</strong> <?php echo htmlspecialchars($match['username']); ?></p>
                        <img src="<?php echo htmlspecialchars($match['image']); ?>" width="100">
                    </div>
                <?php endwhile; else: ?>
                    <p class="text-danger">No matches found.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>