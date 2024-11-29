<?php
session_start(); // -> Harus ditambahkan ketika menggunakan session

if(!isset($_SESSION['login'])) {
    header('location: auth/login.php');
    exit;
}
    include('../database/connect.php');

    $id = $_GET['id'];

    $queryData = "SELECT * FROM pengaduan WHERE id = $id";

    $result = mysqli_query($conn, $queryData);

    $data = mysqli_fetch_assoc($result);

    if(isset($_POST['submit'])) {
        $user_id = $_POST['user_id'];
        $judul = $_POST['judul'];
        $isi = $_POST['isi'];

        $result = mysqli_query(
            $conn,
            "UPDATE pengaduan SET user_id='$user_id', judul='$judul', isi='$isi'
            WHERE id=$id"
        );

        if($result) {
            echo "<script>
                alert ('Data Berhasil Di Update')
                document.location.href='index.php'
            </script>";
        } else {
        echo "<script>
                alert('Data Gagal Di Update')
            </script>";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT</title>
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

    <h1>Edit Data <?= $data['judul'] ?></h1>

    <a href="index.php">CANCEL</a>

    </br>

    <section id="report">
            <div class="mb-4">
                <h3>Submit a New Report</h3>
                <form action="edit.php?id=<?= $id ?>" method="post">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Reporter's Name</label>
                        <input type="text" value="<?= $data['user_id']?>" class="form-control" name="user_id" id="user_id" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Category</label>
                        <select class="form-select" name="judul" id="judul" required>
                            <option selected value="<?= $data['judul']?>"><?= $data['judul'] ?></option>
                            <option value="Public Service">Public Service</option>
                            <option value="Infrastructure">Infrastructure</option>
                            <option value="Health">Health</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label">Description</label>
                        <textarea class="form-control" name="isi" id="isi" rows="3" placeholder="Write a report description" required><?= $data['isi'] ?></textarea>
                    </div>
                    <button name="submit" type="submit" class="btn btn-light-blue">Submit</button>
                </form>
            </div>
        </section>
</body>
</html>