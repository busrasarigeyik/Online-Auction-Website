<?php
session_start();

include 'config.php';

// Veritabanı bağlantısı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}


$sql_about = "SELECT about_us FROM company_info WHERE id = 1"; // id = 1 olan satırı seç
$result_about = $conn->query($sql_about);


if ($result_about->num_rows > 0) {
    $row_about = $result_about->fetch_assoc();
    $aboutUsText = $row_about["about_us"];
} else {
    echo "Hata: ABOUT US kayıt bulunamadı";
}

$sql_contact = "SELECT address, phone, fax, email, facebook, instagram, linkedin, email_icon FROM company_info WHERE id = 1"; // id = 1 olan satırı seç
$result_contact = $conn->query($sql_contact);

if ($result_contact->num_rows > 0) {
    $row_contact = $result_contact->fetch_assoc();
    $address = $row_contact["address"];
    $phone = $row_contact["phone"];
    $fax = $row_contact["fax"];
    $email = $row_contact["email"];
    $facebook = $row_contact["facebook"];
    $instagram = $row_contact["instagram"];
    $linkedin = $row_contact["linkedin"];
    $email_icon = $row_contact["email_icon"];
} else {
    echo "Hata: ADRES, TELEFON, FAX, EMAIL veya ICON bağlantıları kayıt bulunamadı";
}

// Veritabanı bağlantısını kapatma
$conn->close();

if (isset($_POST['login'])) {
    $userEmail = $_POST["email"];
    $userPassword = $_POST["password"];
    $encryptedPass = md5($userPassword);

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
            $firstName = $row["name"];
            $lastName = $row["surname"];
            // Kullanıcının adı ve soyadını session'a kaydetme
            $_SESSION['first_name'] = $firstName;
            $_SESSION['last_name'] = $lastName;
            header("location: Consumer/homepage.php");
            exit; 
        } else {
            echo "Undefined user role";
        }
    } else {
        
        echo "Invalid email or password";
    }

    $conn->close();
}
?>


<head>
  <meta charset="UTF-8">  
  <link
    href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,600,700"
    rel="stylesheet"
  />
  <script
    src="https://kit.fontawesome.com/37b0ae8922.js"
    crossorigin="anonymous"
  ></script>

</head>
<link rel="stylesheet" href="homepage.css">
<div class="wrapper">
  <div class="Container">
        <div class="nav">
            <div class="logo">
                ONLINE AUCTION
            </div>
            <div class="menu">
                <ul class="navMenu">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Locations</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="../index.php"><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></a></li>
                </ul>
            </div>
        </div>
        <div class="header">
            <h1>Welcome to Online Auction</h1>
            <button type="button" onclick="window.location.href='products.php'">All Products</button>
        </div>
    </div>
</div>

<div class="wrapper2">
  <div class="Container">
        <div class="header">
          <h2>ABOUT US<br><br></h2>
          <h2><?php echo $aboutUsText; ?></h2>
        </div>
   
        </div>
</div>

<div class="container">
  <div id="one" class="section">
  </div>
  <div id="two" class="section">
  </div>
  <div id="three" class="section">
    <div class="header">
<div class="row">
  <div class="col-sm-4"> <span> <div class="rhombus"></div></span>
    </div>
  </div>
</div>
</div>
</div>

<div class="wrappercontact">
  <div class="Container">
    <div class="header">
        <h2> Address <br><br><br>
        <?php echo $address; ?><br><br>
        Phone: <?php echo $phone; ?>&nbsp - &nbsp Fax: <?php echo $fax; ?> &nbsp - &nbsp
        Email: <?php echo $email; ?>
    </h2>

        <div class="icon">
       
          <ul id="contact">
            <li ><a href="<?php echo $facebook; ?>" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
            <li><a href="<?php echo $instagram; ?>" target="_blank"><i class="fab fa-instagram-square"></i></a></li>
            <li><a href="<?php echo $linkedin; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
            <li><a href="https://mail.google.com/mail/u/0/?view=cm&source=mailto&to=<?php echo $email_icon; ?>&fs=1&tf=1" target="_blank"><i class="fas fa-envelope"></i></a></li>
          </ul>
        </div>

    </div>
   
  </div>
</div>

