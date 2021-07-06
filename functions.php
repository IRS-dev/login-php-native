<?php
// connection to database
// koneksi ke database
$conn = new mysqli("localhost", "root", "", "login-native");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {

        $rows[] = $row;
    }
    return $rows;
}
function registrasi($data)
{

    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = ($data["email"]);
    $password = mysqli_real_escape_string($conn, $data["pass"]);
    $password2 = mysqli_real_escape_string($conn, $data["pass2"]);
    $namescheck = "SELECT username FROM users WHERE username='$username'";
    // check username already exists or not
    //cek username sudah ada atau belum
    $result = mysqli_query($conn, $namescheck);

    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
        alert('username is already exsist!')
        
        </script>
        
        ";

        return false;
    }
    // email
    $emailcheck = "SELECT email FROM users WHERE email='$email'";
    // check email already exists or not
    //cek email sudah ada atau belum
    $result = mysqli_query($conn, $emailcheck);
    if (mysqli_fetch_assoc($result)) {
        echo "
    <script>
    alert('email is already exsist!')  
    </script>
    ";
        return false;
    }
    // check password confirmation
    //cek konfirmasi password
    if ($password !== $password2) {

        echo "
        <script>
        alert('somethings wrong with your password');

        </script>";
        return false;
    }
    // password encryption
    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // add new user to database
    //tambahkan user baru ke databases
    mysqli_query($conn, "INSERT INTO users VALUE(NULL,'$username','$email','$password')");
    return mysqli_affected_rows($conn);
}
