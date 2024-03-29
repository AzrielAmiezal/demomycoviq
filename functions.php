<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//database connection
function connection()
{

  return mysqli_connect('localhost', 'root', '', 'mycoviq');
}


function query($query)
{
  $conn = connection();

  $result = mysqli_query($conn, $query);

  //if the result only have 1 data
  // if (mysqli_num_rows($result) == 1) {
  //   return mysqli_fetch_assoc($result);
  // }

  if (!$result) {
    echo "ERROR: " . mysqli_error($conn);
  }

  //if the results have many data
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}


function addHealthStatusReport($data)
{
  $conn = connection();

  $sakit_tekak = $data['sakit_tekak'];
  $selesema = $data['selesema'];
  $batuk = $data['batuk'];
  $demam = $data['demam'];
  $loya_muntah = $data['loya_muntah'];
  $kesukaran_bernafas = $data['kesukaran_bernafas'];
  $deria_rasa = $data['deria_rasa'];
  $deria_bau = $data['deria_bau'];
  $tarikh_kemaskini = $data['tarikh_kemaskini'];
  $hari_kemaskini = $data['hari_kemaskini'];
  $masa_kemaskini = $data['masa_kemaskini'];

  $result = mysqli_query($conn, "SELECT COUNT(spo2_id) AS ROWCOUNT FROM health_status");
  $row = mysqli_fetch_assoc($result);
  $rowcount = $row["ROWCOUNT"] + 1;
  //echo "ROW COUNT: " . $rowcount;

  // $result_day = mysqli_query($conn, "SELECT COUNT(day_id) AS DAYID FROM health_status WHERE patient_id = " . $_SESSION['patient_id']);
  // $row_day = mysqli_fetch_assoc($result_day);
  // $daycount = $row_day["DAYID"] + 1;

  $result_day = mysqli_query($conn, "SELECT COUNT(sesi_id) AS SESIID FROM health_status WHERE patient_id = " . $_SESSION['patient_id']);
  $row_sesi = mysqli_fetch_assoc($result_day);
  $sesi_count = $row_sesi["SESIID"] + 1;

  //$sesi_No = $_GET['sesi'];

  $query = "INSERT INTO health_status
              VALUES
              (null," . $_SESSION['patient_id'] . ", $rowcount, $rowcount, $sesi_count,'$sakit_tekak', '$selesema', '$batuk', '$demam', '$loya_muntah', '$kesukaran_bernafas', '$deria_rasa', '$deria_bau','$tarikh_kemaskini', '$hari_kemaskini','$masa_kemaskini',1) 
              ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  // $query = "INSERT INTO health_status
  //             VALUES
  //             (null," . $_SESSION['patient_id'] . ", $rowcount, $rowcount, '$sakit_tekak', '$selesema', '$batuk', '$demam', '$loya_muntah', '$kesukaran_bernafas', '$deria_rasa', '$deria_bau','$tarikh_kemaskini', '$hari_kemaskini','$masa_kemaskini', 2, 0) 
  //             ";

  // mysqli_query($conn, $query) or die(mysqli_error($conn));

  //$spo2_day = htmlspecialchars($data['spo2_day']);
  $spo2_level = htmlspecialchars($data['spo2_level']);

  $query = "INSERT INTO spo2
              VALUES
              ('$rowcount'," . $_SESSION['patient_id'] . ",'$spo2_level','$tarikh_kemaskini','$masa_kemaskini')
              ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  //$temperature_day = htmlspecialchars($data['temperature_day']);
  $temperature_level = htmlspecialchars($data['temperature_level']);
  $query = "INSERT INTO temperature
              VALUES
              ('$rowcount'," . $_SESSION['patient_id'] . " ,'$temperature_level','$tarikh_kemaskini','$masa_kemaskini')
              ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  $sesi = $_GET['sesi'];
  //$sesi_no2 = $data['sesi_kedua'];

  $query = "INSERT INTO sesi_kemaskini_kesihatan
            VALUES
            (null," . $_SESSION['patient_id'] . " ,$sesi)
            ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function patientLogin($data)
{

  $conn = connection();

  $patientEmail = htmlspecialchars($data['patientEmail']);
  $patientPassword = htmlspecialchars($data['patientPassword']);

  $query = sprintf("SELECT * FROM patient WHERE patientEmail = '%s' OR patient_IcNo = '%s'", mysqli_real_escape_string($conn, $patientEmail), mysqli_real_escape_string($conn, $patientEmail));
  $patient = mysqli_query($conn, $query);

  //if username or password is empty
  if (empty($patientEmail) || empty($patientPassword)) {

    echo "<script>
                alert('Sila isi untuk log masuk!');
                document.location.href = 'patient_login.php';
            </script>";

    return false;
  }
  //check email
  if (mysqli_num_rows($patient) == 1) {
    $row = mysqli_fetch_assoc($patient);
    //check password
    if (password_verify($patientPassword, $row['patientPassword'])) {

      if ($row['is_verified'] == 0) {
        // echo "<script>
        //         alert('Email belum disahkan. Sila semak link verifikasi akaun di email anda.');
        //         document.location.href = 'patient_login.php';
        //     </script>";
        return [
          'error' => true,
          'message' => 'Sila semak link verifikasi di akaun email anda dan klik Verify Now.'
        ];
      } else {
        //set session
        $_SESSION['login'] = true;
        $_SESSION['login_id'] = $row['patient_id']; //login id not defined
        $_SESSION['patient_id'] = $row['patient_id'];
        $_SESSION['patientName'] = $row['patientName'];
        $_SESSION['patient_icNo'] = $row['patient_icNo'];
        $_SESSION['patient_address'] = $row['patient_address'];
        $_SESSION['patient_telNo'] = $row['patient_telNo'];
        $_SESSION['patientEmail'] = $row['patientEmail'];
        header("Location: index.php");
      }
    }
  }
  return [
    'error' => true,
    'message' => 'Email / Kata laluan salah!'
  ];
}

//Email verification for new patient register
function sendMailRegister($patientEmail, $v_code)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'aazwary0@gmail.com';                   //SMTP username
    $mail->Password   = '991006amiezalazwary';                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('aazwary0@gmail.com', 'MyCOVIQ');
    $mail->addAddress($patientEmail);                           //Add a recipient

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'VERIFIKASI PENDAFTARAN AKAUN MYCOVIQ';
    // $mail->Body    = "Terima Kasih kerana mendaftar!
    // Sila klik link di bawah untuk mengesahkan email anda.
    // <a href='http://localhost/email_verify.php?email=$patientEmail&code=$v_code'>Verify Now</a>";

    $mail->Body    = "Terima Kasih kerana mendaftar!
    Sila klik link di bawah untuk mengesahkan email anda.
    <a href='http://demomycoviq.ddns.net/email_verify.php?email=$patientEmail&code=$v_code'>Verify Now</a>";


    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

//Email verification for notify admin that new user is sign up 
function sendMailNotifyAdmin($patientEmail, $patientName, $patientICNo, $patientTelNo)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'aazwary0@gmail.com';                   //SMTP username
    $mail->Password   = '991006amiezalazwary';                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('aazwary0@gmail.com', 'MyCOVIQ');
    $mail->addAddress('azrielamiezal10@outlook.com');          //Add admin email

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'MYCOVIQ: PENDAFTARAN PENGGUNA BARU';
    $mail->Body    = "Hi Admin! <br/><br/>
    Anda mempunyai pengguna baru MYCOVIQ. Maklumat pesakit adalah seperti berikut: <br/><br/>
    <b>
    Nama: $patientName <br/>
    NO K/P: $patientICNo <br/>
    Email: $patientEmail <br/>
    No Tel: $patientTelNo
    </b>
    <br/><br/>
    <b>SILA TETAPKAN TEMPOH KUARANTIN KEPADA PESAKIT YANG DINYATAKAN SUPAYA PESAKIT DAPAT MENGEMASKINI DEKLARASI HARIAN KENDIRI
    SEPANJANG TEMPOH KUARANTIN</b><br/><br/>

    Terima Kasih.
    ";

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

function patientRegister($data)
{
  $conn = connection();

  $patientName = htmlspecialchars(strtoupper($data['patientName']));
  $patientICNo = htmlspecialchars($data['patient_icNo']);
  $patientAddress = htmlspecialchars(($data['patient_address']));
  $patientTelNo = htmlspecialchars($data['patient_telNo']);
  $patientEmail = htmlspecialchars(strtolower($data['patientEmail']));
  $patientPassword1 = mysqli_real_escape_string($conn, $data['patientPassword1']);
  $patientPassword2 = mysqli_real_escape_string($conn, $data['patientPassword2']);

  $message = null;

  //if username or password is empty
  if (empty($patientName) || empty($patientICNo) || empty($patientAddress) || empty($patientTelNo) || empty($patientEmail) || empty($patientPassword1) || empty($patientPassword2)) {

    // echo "<script>
    //             alert('Sila isi semua maklumat yang diperlukan!');
    //             document.location.href = 'patient_register.php';
    //         </script>";

    // return [
    //   $message .= ,
    //   'error' => true,
    //   'message' => $message
    // ];
    return [
      'error' => true,
      'message' => 'Sila isi semua maklumat yang diperlukan!'
    ];
  }

  if (!filter_var($patientEmail, FILTER_VALIDATE_EMAIL)) {

    // echo "<script>
    //             alert('Sila masukkan email yang sah!');
    //             document.location.href = 'patient_register.php';
    //         </script>";
    return [
      'error' => true,
      'message' => 'Sila masukkan email yang sah!'
    ];
  }

  //if email is already registered
  if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM patient WHERE patientEmail = '$patientEmail'")) > 0) {

    // echo "<script>
    //             alert('Email sudah didaftarkan. Sila log masuk.');
    //             document.location.href = 'patient_register.php';
    //         </script>";

    return [
      'error' => true,
      'message' => 'Email sudah berdaftar. Sila log masuk!'
    ];
  }

  //if IC No is already registered
  if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM patient WHERE patient_icNo = '$patientICNo'")) > 0) {

    // echo "<script>
    //             alert('No IC / Passport sudah didaftarkan. Sila log masuk.');
    //             document.location.href = 'patient_register.php';
    //         </script>";
    return [
      'error' => true,
      'message' => 'No IC / Passport sudah didaftarkan. Sila log masuk!'
    ];
  }

  //if Tel No is already registered
  if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM patient WHERE patient_telNo = '$patientTelNo'")) > 0) {

    // echo "<script>
    //             alert('No telefon sudah didaftarkan! Sila log masuk.');
    //             document.location.href = 'patient_register.php';
    //         </script>";
    return [
      'error' => true,
      'message' => 'No telefon sudah didaftarkan! Sila log masuk!'
    ];
  }

  //check password confirmation
  if ($patientPassword1 !== $patientPassword2) {

    // echo "<script>
    //             alert('Kata laluan tidak sepadan. Sila masukkan kata laluan yang sah.');
    //             document.location.href = 'patient_register.php';
    //         </script>";

    return [
      'error' => true,
      'message' => 'Kata laluan tidak sepadan. Sila masukkan kata laluan yang sah!'
    ];

    // return [
    //   $message .= 'Kata laluan tidak sepadan. Sila masukkan kata laluan yang sah! <br />',
    //   'error' => true,
    //   'message' => $message
    // ];
  }

  //if password < 5 digit
  if (strlen($patientPassword1 < 5)) {

    // echo "<script>
    //             alert('Kata laluan terlalu pendek. Maksimum 8-10 perkataan / simbol');
    //             document.location.href = 'patient_register.php';
    //         </script>";

    return [
      'error' => true,
      'message' => 'Kata laluan terlalu pendek. Maksimum 8-10 perkataan / simbol'
    ];
  }

  //if username and password is suitable
  //encrypt password
  $patient_new_password = password_hash($patientPassword1, PASSWORD_DEFAULT);
  $v_code = bin2hex(random_bytes(16));
  //insert to table user
  $query = "INSERT INTO patient
                VALUES
                (null,0,'$patientName','$patientICNo','$patientAddress',$patientTelNo,'$patientEmail','$patient_new_password','$v_code',0,'default.jpg')";
  sendMailRegister($patientEmail, $v_code);
  sendMailNotifyAdmin($patientEmail, $patientName, $patientICNo, $patientTelNo);
  mysqli_query($conn, $query);
  if (mysqli_affected_rows($conn) > 0) return ['error' => false, 'affected_row' => mysqli_affected_rows($conn)];
}

function uploadPicture()
{
  $file_name = $_FILES['patient_profileImg']['name'];
  $file_type = $_FILES['patient_profileImg']['type'];
  $file_size = $_FILES['patient_profileImg']['size'];
  $file_error = $_FILES['patient_profileImg']['error'];
  $file_tmp = $_FILES['patient_profileImg']['tmp_name'];

  //when no picture is choose
  if ($file_error == 4) {
    // echo "<script>
    //     alert('Please upload student picture!');
    // </script>";

    return 'default.jpg';
  }

  //check file extension
  $file_register = ['jpg', 'jpeg', 'png'];
  $file_extension = explode('.', $file_name);
  $file_extension = strtolower(end($file_extension));

  //check valid file extension
  if (!in_array($file_extension, $file_register)) {
    echo "<script>
            alert('Sila muat naik format JPG, JPEG & PNG sahaja!');
        </script>";

    return false;
  }

  //check file type
  if ($file_type != 'image/jpeg' && $file_type != 'image/png') {

    echo "<script>
            alert('Sila muat naik format JPG, JPEG & PNG sahaja!');
        </script>";

    return false;
  }

  //check file size
  //maximum 5MB == 5000000
  if ($file_size > 5000000) {

    echo "<script>
            alert('Dokumen terlalu besar. Sila muat naik dokumen minimum saiz 5MB only! ');
        </script>";

    return false;
  }

  //pass file checking. ready to upload file
  //generate new file name
  $new_file_name = uniqid();
  $new_file_name .= '.';
  $new_file_name .= $file_extension;

  move_uploaded_file($file_tmp, 'img/' . $new_file_name);
  return $new_file_name;
}

function editProfile($data)
{
  $conn = connection();

  $id = $data['patient_id'];

  // $patientName = htmlspecialchars($data['patientName']);
  // $patientICNo = htmlspecialchars($data['patient_icNo']);
  $patientAddress = htmlspecialchars($data['patient_address']);
  //$patientTelNo = htmlspecialchars($data['patient_telNo']);
  $old_patientProfileImg = htmlspecialchars($data['old_profileImg']);

  //upload pictures
  $patientImage = uploadPicture();
  if (!$patientImage) {
    return false;
  }

  if ($patientImage == 'default.jpg') {
    $patientImage = $old_patientProfileImg;
  }

  $query = "UPDATE patient SET
              patient_address = '$patientAddress',
              patient_profileImg = '$patientImage'
            WHERE patient_id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function editDetails($data)
{

  $conn = connection();

  $id = $_GET['id'];

  $patientName = htmlspecialchars(strtoupper($data['patientName']));
  $patientICNo = htmlspecialchars($data['patient_icNo']);
  $patientAddress = htmlspecialchars(strtoupper($data['patient_address']));
  $patientTelNo = htmlspecialchars($data['patient_telNo']);
  $patientEmail = $data['patientEmail'];
  $patientProfileImg = htmlspecialchars($data['patient_profileImg']);

  //if IC No is already registered
  if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM patient WHERE patient_icNo = '$patientICNo'")) > 0) {

    return [
      'error' => true,
      'message' => 'No KP / Passport sudah didaftarkan!'
    ];
  }

  //if Tel No is already registered
  if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM patient WHERE patient_telNo = '$patientTelNo'")) > 0) {

    return [
      'error' => true,
      'message' => 'No telefon sudah didaftarkan!'
    ];
  }

  $query = "UPDATE patient SET
                patientName = '$patientName',    
                patient_icNo = '$patientICNo',
                patient_address = '$patientAddress',
                patient_telNo = '$patientTelNo',
                patient_profileImg = '$patientProfileImg'
            WHERE patient_id = $id";

  sendMailNotifyAdmin($patientEmail, $patientName, $patientICNo, $patientTelNo);
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  if (mysqli_affected_rows($conn) > 0) return ['error' => false, 'affected_row' => mysqli_affected_rows($conn)];
  // return mysqli_affected_rows($conn);
}

function adminRegister($data)
{
  $conn = connection();

  $adminName = htmlspecialchars($data['admin_name']);
  $adminUserName = htmlspecialchars($data['admin_username']);
  $adminTelno = htmlspecialchars($data['admin_telNo']);
  $adminEmail = htmlspecialchars($data['admin_email']);
  $adminPassword1 = mysqli_real_escape_string($conn, $data['admin_password1']);
  $adminPassword2 = mysqli_real_escape_string($conn, $data['admin_password2']);
  //$adminProfileImage = htmlspecialchars($data['admin_profileImg']);

  //if username or password is empty
  if (empty($adminName) || empty($adminUserName) || empty($adminTelno) || empty($adminEmail) || empty($adminPassword1) || empty($adminPassword2)) {

    echo "<script>
                alert('Sila isi semua maklumat yang diperlukan!');
                document.location.href = 'admin_register.php';
            </script>";

    return false;
  }

  //if email is already registered
  if (query("SELECT * FROM `admin` WHERE `admin_email` = '$adminEmail'")) {

    echo "<script>
                alert('Email sudah didaftarkan. Sila log masuk.');
                document.location.href = 'admin_register.php';
            </script>";

    return false;
  }

  //if IC No is already registered
  if (query("SELECT * FROM `admin` WHERE `admin_telNo` = '$adminTelno'")) {

    echo "<script>
                alert('No telefon sudah didaftarkan! Sila log masuk.');
                document.location.href = 'admin_register.php';
            </script>";

    return false;
  }

  //check password confirmation
  if ($adminPassword1 !== $adminPassword2) {

    echo "<script>
                alert('Kata laluan tidak sepadan. Sila masukkan kata laluan yang sah.');
                document.location.href = 'admin_register.php';
            </script>";

    return false;
  }

  //if password < 5 digit
  if (strlen($adminPassword1 < 5)) {

    echo "<script>
                alert('Kata laluan terlalu pendek. Maksimum 8-10 perkataan / simbol);
                document.location.href = 'admin_register.php';
            </script>";

    return false;
  }

  //if username and password is suitable
  //encrypt password
  $admin_new_password = password_hash($adminPassword1, PASSWORD_DEFAULT);
  //$v_code = bin2hex(random_bytes(16));
  //insert to table user
  $query = "INSERT INTO `admin`
                VALUES
                (null,'$adminName','$adminUserName','$adminTelno','$adminEmail','$admin_new_password','default.jpg')";
  //sendMail($patientEmail, $v_code);
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function adminLogin($data)
{

  $conn = connection();

  $adminUsername = htmlspecialchars($data['admin_username']);
  $adminPassword = htmlspecialchars($data['admin_password']);

  $query = sprintf("SELECT * FROM `admin` WHERE `admin_username` = '%s'", mysqli_real_escape_string($conn, $adminUsername));
  $patient = mysqli_query($conn, $query);
  //check email
  if (mysqli_num_rows($patient) == 1) {
    $row = mysqli_fetch_assoc($patient);

    //check password
    if (password_verify($adminPassword, $row['admin_password'])) {
      //set session
      $_SESSION['admin_login'] = true;
      $_SESSION['admin_id'] = $row['admin_id'];
      $_SESSION['admin_name'] = $row['admin_name'];
      header("Location: admin_index.php");
    }
  }
  return [
    'error' => true,
    'message' => 'Nama Pengguna atau Kata laluan salah!'
  ];
}

function uploadAdminPicture()
{
  $file_name = $_FILES['admin_profileImg']['name'];
  $file_type = $_FILES['admin_profileImg']['type'];
  $file_size = $_FILES['admin_profileImg']['size'];
  $file_error = $_FILES['admin_profileImg']['error'];
  $file_tmp = $_FILES['admin_profileImg']['tmp_name'];

  //when no picture is choose
  if ($file_error == 4) {
    // echo "<script>
    //     alert('Please upload student picture!');
    // </script>";

    return 'default.jpg';
  }

  //check file extension
  $file_register = ['jpg', 'jpeg', 'png'];
  $file_extension = explode('.', $file_name);
  $file_extension = strtolower(end($file_extension));

  //check valid file extension
  if (!in_array($file_extension, $file_register)) {
    echo "<script>
            alert('Sila muat naik format JPG, JPEG & PNG sahaja!');
        </script>";

    return false;
  }

  //check file type
  if ($file_type != 'image/jpeg' && $file_type != 'image/png') {

    echo "<script>
            alert('Sila muat naik format JPG, JPEG & PNG sahaja!');
        </script>";

    return false;
  }

  //check file size
  //maximum 5MB == 5000000
  if ($file_size > 5000000) {

    echo "<script>
            alert('Dokumen terlalu besar. Sila muat naik dokumen minimum saiz 5MB only! ');
        </script>";

    return false;
  }

  //pass file checking. ready to upload file
  //generate new file name
  $new_file_name = uniqid();
  $new_file_name .= '.';
  $new_file_name .= $file_extension;

  move_uploaded_file($file_tmp, '../admin/img/' . $new_file_name);
  return $new_file_name;
}

function editAdminProfile($data)
{
  $conn = connection();

  $id = $data['admin_id'];

  $adminName = htmlspecialchars($data['admin_name']);
  $adminUserName = htmlspecialchars($data['admin_username']);
  $adminEmail = htmlspecialchars($data['admin_email']);
  $adminTelNo = htmlspecialchars($data['admin_telNo']);
  $old_adminProfileImg = htmlspecialchars($data['old_adminprofileImg']);

  //upload pictures
  $adminImage = uploadAdminPicture();
  if (!$adminImage) {
    return false;
  }

  if ($adminImage == 'default.jpg') {
    $adminImage = $old_adminProfileImg;
  }

  $query = "UPDATE `admin` SET
              admin_name = '$adminName',
              admin_username = '$adminUserName',
              admin_email = '$adminEmail',
              admin_telNo = '$adminTelNo',
              admin_profileImg = '$adminImage'
            WHERE admin_id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}


function sendMailIsolation($patientEmail, $patientName, $patientICNo)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'aazwary0@gmail.com';                   //SMTP username
    $mail->Password   = '991006amiezalazwary';                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('aazwary0@gmail.com', 'MyCOVIQ');
    $mail->addAddress($patientEmail);                           //Add a recipient

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'MYCOVIQ: DEKLARASI HARIAN KENDIRI';
    $mail->Body    = 'Hi ' . $patientName . ',<br/><br/>
    Sila semak butiran deklarasi harian kendiri bagi <b>NO K/P ' . $patientICNo . '</b> di MYCOVIQ <br/><br/>
    <b>PASTIKAN ANDA KEMASKINI KESEMUA DEKLARASI HARIAN KENDIRI MENGIKUT HARI, TARIKH DAN SESI YANG DITETAPKAN SEHINGGA TAMAT TEMPOH KUARANTIN KENDIRI.</b><br/><br/>
    Terima Kasih.<br/><br/>';

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

function addIsolation($data)
{
  $conn = connection();

  //For email purpose
  $patientName = $data['patientName'];
  $patientICNo = $data['patient_icNo'];
  $patientEmail = $data['patientEmail'];

  $covidStage = htmlspecialchars($data['covidStage']);
  $tarikhMula = date('Y-m-d', strtotime($data['tarikh_mula']));
  $tarikhTamat = date('Y-m-d', strtotime($data['tarikh_tamat']));
  $status = htmlspecialchars($data['status_kuarantin']);


  $query = "INSERT INTO deklarasi_harian
              VALUES
              (null, " . $_GET['patient'] . ", '$covidStage','$tarikhMula','$tarikhTamat','$status') 
              ";
  sendMailIsolation($patientEmail, $patientName, $patientICNo);
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}


//Email notification for remind the patient end of quarantine
function sendMailTamatKuarantin($patientEmail, $patientName)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'aazwary0@gmail.com';                   //SMTP username
    $mail->Password   = '991006amiezalazwary';                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('aazwary0@gmail.com', 'MyCOVIQ');
    $mail->addAddress($patientEmail);          //Add admin email

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'MYCOVIQ: TAMAT ISOLASI / KUARANTIN KENDIRI';
    $mail->Body    = "Hi $patientName, <br/><br/>
    <b>Tahniah anda telah tamat isolasi / kuarantin kendiri. Sila semak status dan muat turun dokumen deklarasi kendiri anda di
    aplikasi MYCOVIQ.</b> <br/><br/>
    
    <b>PASTIKAN ANDA TERUS KEKAL PATUHI SOP, AMALKAN 3W DAN ELAKKAN 3C.</b><br/><br/>

    Terima Kasih.
    ";

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

function editIsolation($data)
{
  $conn = connection();

  $id = $data['patient_id'];
  $covidStage = htmlspecialchars($data['covidStage']);
  $tarikhMula = date('Y-m-d', strtotime($data['tarikh_mula']));
  $tarikhTamat = date('Y-m-d', strtotime($data['tarikh_tamat']));

  $query = "UPDATE deklarasi_harian SET
              covidStage= '$covidStage',
              tarikh_mula = '$tarikhMula',
              tarikh_tamat = '$tarikhTamat'
            WHERE patient_id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function editStatusKuarantin($data)
{
  $conn = connection();

  //For email purpose
  $patientName = $data['patientName'];
  $patientEmail = $data['patientEmail'];
  $patientICNo = $data['patient_icNo'];

  $id = $data['patient_id'];
  $status = htmlspecialchars($data['status_kuarantin']);

  if ($status == 'Sedang dalam pemantauan') {
    sendMailIsolation($patientEmail, $patientName, $patientICNo);
  } else if ($status == 'Tamat Kuarantin') {
    sendMailTamatKuarantin($patientEmail, $patientName);
  }

  $query = "UPDATE deklarasi_harian SET
              status_kuarantin = '$status'
            WHERE patient_id = $id";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function changePassword($data)
{
  $conn = connection();

  $id = $data['patient_id'];
  $patientPassword1 = mysqli_real_escape_string($conn, $data['patientPassword1']);
  $patientPassword2 = mysqli_real_escape_string($conn, $data['patientPassword2']);

  //if username or password is empty
  if (empty($patientPassword1) || empty($patientPassword2)) {

    echo "<script>
                alert('Sila isi maklumat yang diperlukan!');
                document.location.href = 'patient_change_password.php?id=$id';
            </script>";

    return false;
  }

  //check password confirmation
  if ($patientPassword1 !== $patientPassword2) {

    echo "<script>
                alert('Kata laluan tidak sepadan. Sila masukkan kata laluan yang sah.');
                document.location.href = 'patient_change_password.php?id=$id';
            </script>";

    return false;
  }

  //if password < 5 digit
  if (strlen($patientPassword1 < 5)) {

    echo "<script>
                alert('Kata laluan terlalu pendek. Maksimum 8-10 perkataan / simbol');
                document.location.href = 'patient_change_password.php?id=$id';
            </script>";

    return false;
  }

  //encrypt password
  $patient_new_password = password_hash($patientPassword1, PASSWORD_DEFAULT);
  $query = "UPDATE patient SET
              patientPassword = '$patient_new_password'
            WHERE patient_id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}


function adminchangePassword($data)
{
  $conn = connection();

  $id = $data['admin_id'];
  $adminPassword1 = mysqli_real_escape_string($conn, $data['admin_password1']);
  $adminPassword2 = mysqli_real_escape_string($conn, $data['admin_password2']);

  //if username or password is empty
  if (empty($adminPassword1) || empty($adminPassword2)) {

    echo "<script>
                alert('Sila isi maklumat yang diperlukan!');
                document.location.href = 'patient_change_password.php?id=$id';
            </script>";

    return false;
  }

  //check password confirmation
  if ($adminPassword1 !== $adminPassword2) {

    echo "<script>
                alert('Kata laluan tidak sepadan. Sila masukkan kata laluan yang sah.');
                document.location.href = 'patient_change_password.php?id=$id';
            </script>";

    return false;
  }

  //if password < 5 digit
  if (strlen($adminPassword1 < 5)) {

    echo "<script>
                alert('Kata laluan terlalu pendek. Maksimum 8-10 perkataan / simbol');
                document.location.href = 'patient_change_password.php?id=$id';
            </script>";

    return false;
  }

  //encrypt password
  $admin_new_password = password_hash($adminPassword1, PASSWORD_DEFAULT);
  $query = "UPDATE `admin` SET
              admin_password = '$admin_new_password'
            WHERE admin_id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function sendMailForgotPassword($patientEmail, $v_code)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'aazwary0@gmail.com';                   //SMTP username
    $mail->Password   = '991006amiezalazwary';                  //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('aazwary0@gmail.com', 'MyCOVIQ');
    $mail->addAddress($patientEmail);                           //Add a recipient

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'MYCOVIQ: RESET KATA LALUAN';
    // $mail->Body    = "Hi,<br/>
    // <b>Sila klik pada link di bawah untuk menukar kata laluan baharu.</b> <br/>
    // <a href='http://localhost/forgotPassword.php?email=$patientEmail&code=$v_code'>Tukar Kata Laluan</a>";

    $mail->Body    = "Hi,<br/>
    <b>Sila klik pada link di bawah untuk menukar kata laluan baharu.</b> <br/>
    <a href='http://demomycoviq.ddns.net/forgotPassword.php?email=$patientEmail&code=$v_code'>Tukar Kata Laluan</a>";

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

function forgotPassword($data)
{
  $patientEmail = htmlspecialchars(strtolower($data['patientEmail']));
  $v_code = bin2hex(random_bytes(16));
  return sendMailForgotPassword($patientEmail, $v_code);
}

function updateForgotPassword($data)
{
  $conn = connection();

  $email = $data['patientEmail'];
  $patientPassword1 = mysqli_real_escape_string($conn, $data['patientPassword1']);
  $patientPassword2 = mysqli_real_escape_string($conn, $data['patientPassword2']);

  //if username or password is empty
  if (empty($patientPassword1) || empty($patientPassword2)) {

    echo "<script>
                alert('Sila isi maklumat yang diperlukan!');
                document.location.href = 'forgotPassword.php?email=$email';
            </script>";

    return false;
  }

  //check password confirmation
  if ($patientPassword1 !== $patientPassword2) {

    echo "<script>
                alert('Kata laluan tidak sepadan. Sila masukkan kata laluan yang sah.');
                document.location.href = 'forgotPassword.php?email=$email';
            </script>";

    return false;
  }

  //if password < 5 digit
  if (strlen($patientPassword1 < 5)) {

    echo "<script>
                alert('Kata laluan terlalu pendek. Maksimum 8-10 perkataan / simbol');
                document.location.href = 'forgotPassword.php?email=$email';
            </script>";

    return false;
  }

  //encrypt password
  $patient_new_password = password_hash($patientPassword1, PASSWORD_DEFAULT);
  $query = "UPDATE patient SET
              patientPassword = '$patient_new_password'
            WHERE patientEmail = '$email'";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
