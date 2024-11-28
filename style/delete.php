<?php
session_start(); // -> Harus ditambahkan ketika menggunakan session

if(!isset($_SESSION['login'])) {
    header('location: ../auth/login.php');
    exit;
}

include('../database/connect.php');

if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Tangkap id lalu taruh di variable
    $id = $_GET['id'];

    // Hapus data berdasarkan 
    $result = mysqli_query($conn, "DELETE FROM pengaduan WHERE id = $id");

    if($result) {
        echo "<script>
            alert ('Data Berhasil Di Hapus');
            window.location.replace('index.php');
        </script>";
    } else {
        echo "<script>
            alert ('Data Gagal Di Hapus');
            window.location.replace('index.php');
        </script>";
    }
}
?>