<?php 
//memulai session atau melanjutkan session yang sudah ada
session_start(); 

//check jika belum ada user yang login arahkan ke halaman login
if (!isset($_SESSION['username'])) { 
	header("location:login.php"); 
}

echo "Selamat Datang ".$_SESSION['username'];
echo "<br><a href='logout.php'>Logout</a>";
?>