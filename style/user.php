<?php
require('../database/connect.php');
$query = mysqli_query($conn,"SELECT * FROM pengaduan");
$i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Reporting System - User List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 1.8rem;
            margin-bottom: 0;
        }

        header p {
            margin: 0;
            font-size: 1rem;
        }

        /* Sidebar */
        #sidebar {
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
            height: 100%;
            padding-top: 20px;
            min-width: 240px;
            position: fixed;
        }

        #sidebar a {
            color: #343a40;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 4px;
            margin: 5px 15px;
            font-size: 1rem;
            font-weight: bold;
        }

        #sidebar a:hover,
        #sidebar a.active {
            background-color: #007bff;
            color: white;
        }

        /* Main Content */
        main {
            margin-left: 260px;
            padding: 20px;
            flex-grow: 1;
        }

        @media (max-width: 768px) {
            #sidebar {
                display: none;
            }

            #toggleSidebar {
                display: inline-block;
            }

            main {
                margin-left: 0;
            }
        }

        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }

        footer p {
            margin: 0;
        }

        /* Custom Light Blue Button */
        .btn-light-blue {
            background-color: #00aaff;
            color: white;
            border: none;
        }

        .btn-light-blue:hover {
            background-color: #0099e6;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>User List</h1>
        <p>View and manage user reports</p>
        <button class="btn btn-light-blue d-md-none" id="toggleSidebar">☰ Menu</button>
    </header>

    <!-- Sidebar -->
    <div id="sidebar">
        <ul class="list-unstyled">
            <li><a href="index.php"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li><a href="report.php"><i class="bi bi-file-earmark-text"></i> Report</a></li>
            <li><a href="user.php" class="active"><i class="bi bi-people"></i> Users</a></li>
            <li><a href="../auth/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main>
        <section id="report">
            <!-- Report Table -->
            <h3>Report List</h3>
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Reporter's Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['user_id'] ?></td>
                        <td><?= $row['judul'] ?></td>
                        <td><?= $row['isi'] ?></td>
                        <td>
                            <a href="delete.php?id=<?= $row['id']?>" class="btn btn-light-blue btn-sm"><i class="bi bi-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- JavaScript -->
    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.style.display = sidebar.style.display === 'block' ? 'none' : 'block';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
