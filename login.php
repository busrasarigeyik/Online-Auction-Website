<?php
session_start();

if (isset($_POST['login'])) {
    $userEmail = $_POST["email"];
    $userPassword = $_POST["password"];
    $encryptedPass = md5($userPassword);
    
    include 'Consumer/config.php';

    // Veritabanı bağlantısı oluşturma
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol etme
    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM user_table WHERE email = '$userEmail' AND password = '$encryptedPass'";
    $result = $conn->query($sql);

    // Sonuçları kontrol etme
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row["role"];        
        // Kullanıcının rolüne göre yönlendirme yapma
        if ($role == "consumer") {
            $_SESSION['email'] = $userEmail; // Kullanıcının email değerini session'a kaydetme
            header("location: index.php");/*****************************************Şimdilik */
        } else {
            echo "Undefined user role";
        }
    } else {
        // Kullanıcı bulunamadı veya hatalı giriş
        echo "Invalid email or password";
    }

    // Veritabanı bağlantısını kapatma
    $conn->close();
}
?>