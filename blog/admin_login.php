<?php

session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	// SELECT * FROM user WHERE username = 'Admin1'--<spasi> (-- artinya komentar, jadi query selanjutnya tidak akan dijalankan)  AND password = '{$password}' 

	// SELECT * FROM user WHERE username = 'yyy' OR 1=1 -- '  AND password = '{$password}' (artinya false or true = true)
	
	
	$login = mysqli_query($conn, "SELECT * FROM user WHERE username = '{$username}' AND password = '{$password}'");

	if (mysqli_num_rows($login) == 0) {
		die("Username atau password salah!");
	} else {
		$_SESSION['admin'] = 1;
		header("Location: admin.php");
	}
	
}

?><!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Login</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body>
	
	<h1 style="text-align: center">My Blog Login</h1>
	<hr>
	
	<form action="" method="post" onsubmit="return validateForm()">
    <p>Username:</p>
    <input type="text" name="username">
    
    <p>Password:</p>
    <input type="password" name="password">
    
    <br>
    <br>
    <input type="submit" name="submit" value="Login">
</form>
	
</body>

</html>

