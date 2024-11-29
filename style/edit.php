<?php
session_start(); // Session untuk autentikasi pengguna
if (!isset($_SESSION['login'])) {
    header('location: auth/login.php');
    exit;
}

include('../database/connect.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>
        alert('Invalid ID');
        document.location.href = 'index.php';
    </script>";
    exit;
}

// Mengambil data pengaduan berdasarkan ID
$queryData = "SELECT * FROM pengaduan WHERE id = ?";
$stmt = mysqli_prepare($conn, $queryData);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>
        alert('Data not found');
        document.location.href = 'index.php';
    </script>";
    exit;
}

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    $updateQuery = "UPDATE pengaduan SET user_id = ?, judul = ?, isi = ? WHERE id = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, 'sssi', $user_id, $judul, $isi, $id);

    if (mysqli_stmt_execute($stmtUpdate)) {
        echo "<script>
            alert('Data successfully updated');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to update data');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .btn-light-blue {
            background-color: #00aaff;
            color: white;
            border: none;
        }
        .btn-light-blue:hover {
            background-color: #0099e6;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="text-center mb-4">Edit Report: <?= htmlspecialchars($data['judul']) ?></h2>
        <a href="index.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
        <form action="edit.php?id=<?= $id ?>" method="post">
            <div class="mb-3">
                <label for="user_id" class="form-label">Reporter's Name</label>
                <input type="text" value="<?= htmlspecialchars($data['user_id']) ?>" class="form-control" name="user_id" id="user_id" required>
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">Category</label>
                <select class="form-select" name="judul" id="judul" required>
                    <option selected value="<?= htmlspecialchars($data['judul']) ?>"><?= htmlspecialchars($data['judul']) ?></option>
                    <option value="Public Service">Public Service</option>
                    <option value="Infrastructure">Infrastructure</option>
                    <option value="Health">Health</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Description</label>
                <textarea class="form-control" name="isi" id="isi" rows="3" required><?= htmlspecialchars($data['isi']) ?></textarea>
            </div>
            <button name="submit" type="submit" class="btn btn-light-blue w-100">Update</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
