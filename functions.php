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
  //check email
  if (mysqli_num_rows($patient) == 1) {
    $row = mysqli_fetch_assoc($patient);
    //check password
    if (password_verify($patientPassword, $row['patientPassword'])) {

      if ($row['is_verified'] == 0) {
        echo "<script>
                alert('Email belum disahkan. Sila semak link verifikasi akaun di email anda.');
                document.location.href = 'patient_login.php';
            </script>";
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
    'message' => 'Emel / Kata laluan salah!'
  ];
}

//Email verification
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
    // <a href='http://localhost/demomycoviq/email_verify.php?email=$patientEmail&code=$v_code'>Verify Now</a>";

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

function patientRegister($data)
{
  $conn = connection();

  $patientName = htmlspecialchars(($data['patientName']));
  $patientICNo = htmlspecialchars($data['patient_icNo']);
  $patientAddress = htmlspecialchars(($data['patient_address']));
  $patientTelNo = htmlspecialchars($data['patient_telNo']);
  $patientEmail = htmlspecialchars(strtolower($data['patientEmail']));
  $patientPassword1 = mysqli_real_escape_string($conn, $data['patientPassword1']);
  $patientPassword2 = mysqli_real_escape_string($conn, $data['patientPassword2']);

  //upload pictures
  // $patientImage = uploadPicture();
  // if (!$patientImage) {
  //   return false;
  // }

  //if username or password is empty
  if (empty($patientName) || empty($patientICNo) || empty($patientAddress) || empty($patientTelNo) || empty($patientEmail) || empty($patientPassword1) || empty($patientPassword2)) {

    echo "<script>
                alert('Sila isi semua maklumat yang diperlukan!');
                document.location.href = 'patient_register.php';
            </script>";

    return false;
  }

  if (!filter_var($patientEmail, FILTER_VALIDATE_EMAIL)) {

    echo "<script>
                alert('Sila masukkan email yang sah!');
                document.location.href = 'patient_register.php';
            </script>";

    return false;
  }

  //if email is already registered
  if (query("SELECT * FROM patient WHERE patientEmail = '$patientEmail'")) {

    echo "<script>
                alert('Email sudah didaftarkan. Sila log masuk.');
                document.location.href = 'patient_register.php';
            </script>";

    return false;
  }

  //if IC No is already registered
  if (query("SELECT * FROM patient WHERE patient_icNo = '$patientICNo'")) {

    echo "<script>
                alert('No IC / Passport sudah didaftarkan. Sila log masuk.');
                document.location.href = 'patient_register.php';
            </script>";

    return false;
  }

  //if Tel No is already registered
  if (query("SELECT * FROM patient WHERE patient_telNo = '$patientTelNo'")) {

    echo "<script>
                alert('No telefon sudah didaftarkan! Sila log masuk.');
                document.location.href = 'patient_register.php';
            </script>";

    return false;
  }

  //check password confirmation
  if ($patientPassword1 !== $patientPassword2) {

    echo "<script>
                alert('Kata laluan tidak sepadan. Sila masukkan kata laluan yang sah.');
                document.location.href = 'patient_register.php';
            </script>";

    return false;
  }

  //if password < 5 digit
  if (strlen($patientPassword1 < 5)) {

    echo "<script>
                alert('Kata laluan terlalu pendek. Maksimum 8-10 perkataan / simbol');
                document.location.href = 'patient_register.php';
            </script>";

    return false;
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
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
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
  $patientAddress = htmlspecialchars($data['patient_address']);
  $patientTelNo = htmlspecialchars($data['patient_telNo']);
  //$patientEmail = htmlspecialchars($data['patientEmail']);
  $patientProfileImg = htmlspecialchars($data['patient_profileImg']);

  $query = "UPDATE patient SET
                patientName = '$patientName',    
                patient_icNo = '$patientICNo',
                patient_address = '$patientAddress',
                patient_telNo = '$patientTelNo',
                patient_profileImg = '$patientProfileImg'
            WHERE patient_id = $id";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
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
  $adminProfileImage = htmlspecialchars($data['admin_profileImg']);

  //if username or password is empty
  if (empty($adminName) || empty($adminUserName) || empty($adminTelno) || empty($adminEmail) || empty($adminPassword1) || empty($adminPassword2) || empty($adminProfileImage)) {

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
                (null,'$adminName','$adminUserName','$adminTelno','$adminEmail','$admin_new_password','$adminProfileImage')";
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
      $_SESSION['admin_name'] = $row['admin_name'];
      header("Location: index.php");
    }
  }
  return [
    'error' => true,
    'message' => 'Nama Pengguna atau Kata laluan salah!'
  ];
}


function sendMailIsolation($patientEmail, $patientName, $patient_icNo)
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
    Sila semak butiran deklarasi harian kendiri bagi <b>NO K/P ' . $patient_icNo . '</b> di MYCOVIQ <br/><br/>
    <b>PASTIKAN ANDA KEMASKINI KESEMUA DEKLARASI HARIAN KENDIRI MENGIKUT HARI, TARIKH DAN SESI YANG DITETAPKAN SEHINGGA TAMAT TEMPOH KUARANTIN KENDIRI.</b><br/><br/>
    Terima Kasih.<br/><br/>
    <b>SALAM WASALAM.</b>';

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
