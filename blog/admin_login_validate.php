<?php

session_start();
include 'koneksi.php';

function validateUsername($username) {
    // Format regex untuk validasi username
    $regex = '/^(?=.*[A-Z])(?=.*[0-9\W]).*$/';
    
    // Memeriksa apakah username sesuai dengan format regex
    if (preg_match($regex, $username)) {
        return true;
    } else {
        return false;
    }
}

function validatePassword($password) {
    if (strlen($password) >= 8) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!validateUsername($username)) {
        die("Username tidak valid! Username harus terdiri dari satu huruf besar dan angka atau karakter khusus.");
    }

    if (!validatePassword($password)) {
        die("Password tidak valid! Password minimal harus terdiri dari 8 karakter.");
    }

	
    // Menggunakan prepared statement dengan parameter
    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
	
	// fungsi mysqli_prepare() untuk membuat prepared statement, kemudian mysqli_stmt_bind_param() untuk mengikat nilai parameter yang diinputkan oleh pengguna ($username dan $password). Setelah itu, mengeksekusi prepared statement menggunakan mysqli_stmt_execute() dan menyimpan hasilnya dengan mysqli_stmt_store_result(). Kami kemudian menggunakan mysqli_stmt_num_rows() untuk memeriksa jumlah baris yang cocok dengan hasil query.

    if (mysqli_stmt_num_rows($stmt) == 0) {
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
    <!-- <form action="" method="post" > -->
        <p>Username:</p>
        <input type="text" name="username">

        <p>Password:</p>
        <input type="password" name="password">

        <br>
        <br>
        <input type="submit" name="submit" value="Login">
    </form>

    <script>
        function validateForm() {
            var username = document.forms[0].username.value;
            var password = document.forms[0].password.value;

            if (!isValidUsername(username)) {
                alert("Username tidak valid! Username harus terdiri dari satu huruf besar dan angka atau karakter khusus.");
                return false;
            }

            if (!isValidPassword(password)) {
                alert("Password tidak valid! Password minimal harus terdiri dari 8 karakter.");
                return false;
            }

            return true;
        }

        function isValidUsername(username) {
            var regex = /^(?=.*[A-Z])(?=.*[0-9\W]).*$/;
            return regex.test(username);
        }

        function isValidPassword(password) {
            return password.length >= 8;
        }
    </script>

</body>

</html>
