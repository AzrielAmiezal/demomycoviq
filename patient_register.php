<?php
require 'functions.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

if (isset($_POST['register']) && $_POST['g-recaptcha-response'] != "") {

    $secret = '6Ldl_HYeAAAAAEkq9rscLamRb9aAa-dkURgLnScO';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {
        $register = patientRegister($_POST);
        if ($register["error"] != true) {
            echo "<script>
                alert('Link verifikasi telah dihantar ke email anda. Sila semak email dan klik VERIFY NOW untuk meneruskan proses pendaftaran akaun MYCOVIQ. Terima Kasih');
                document.location.href = 'patient_login.php';
            </script>";
        }
    } else {
        echo "<script>
                alert('Something went wrong. Please try again later.');
                document.location.href = 'patient_register.php';
            </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/x-icon" href="logo.png">
    <title>MYCOVIQ | COVID-19 INDIVIDUAL QUARANTINE</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />

</head>

<body>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- <div class="col-lg-5 d-none d-lg-block"></div> -->
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><b>Daftar Akaun</b></h1>
                            </div>
                            <form class="user" action="" method="POST" id="captcha_form">
                                <?php if (isset($register['error'])) : ?>
                                    <p class="alert alert-danger" role="alert" style="text-align: center; font-size: small;"><?= $register['message']; ?></p>
                                <?php endif; ?>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="patientName" id="patientName" autocomplete="off" placeholder="Nama Penuh" value="<?php if (isset($_POST['register'])) {
                                                                                                                                                                                            echo htmlentities($_POST['patientName']);
                                                                                                                                                                                        } ?>" required style="text-transform:uppercase">

                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="patient_icNo" id="patient_icNo" autocomplete="off" placeholder="No K/P (tanpa '-' / space)" value="<?php if (isset($_POST['register'])) {
                                                                                                                                                                                                            echo htmlentities($_POST['patient_icNo']);
                                                                                                                                                                                                        } ?>" required style="text-transform:uppercase">

                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="patient_address" id="patient_address" autocomplete="off" placeholder="Alamat Tetap" value="<?php if (isset($_POST['register'])) {
                                                                                                                                                                                                    echo htmlentities($_POST['patient_address']);
                                                                                                                                                                                                } ?>" required style="text-transform:uppercase">

                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="patient_telNo" id="patient_telNo" autocomplete="off" placeholder="No Telefon" value="<?php if (isset($_POST['register'])) {
                                                                                                                                                                                                echo htmlentities($_POST['patient_telNo']);
                                                                                                                                                                                            } ?>" required style="text-transform:uppercase">

                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="patientEmail" id="patientEmail" autocomplete="off" placeholder="EMAIL" value="<?php if (isset($_POST['register'])) {
                                                                                                                                                                                        echo htmlentities($_POST['patientEmail']);
                                                                                                                                                                                    } ?>" required>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name="patientPassword1" autocomplete="off" placeholder="KATA LALUAN" value="<?php if (isset($_POST['register'])) {
                                                                                                                                                                                        echo htmlentities($_POST['patientPassword1']);
                                                                                                                                                                                    } ?>" required>

                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="patientPassword2" autocomplete="off" placeholder="SAHKAN KATA LALUAN" value="<?php if (isset($_POST['register'])) {
                                                                                                                                                                                                echo htmlentities($_POST['patientPassword2']);
                                                                                                                                                                                            } ?>" required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6Ldl_HYeAAAAAEUuybZkVB5pWBO2NURKUJo6fqeN"></div>
                                    <span style="color: red;">Sila klik pada captcha.</span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block" name="register" onclick="return confirm('Adakah anda pasti tentang maklumat yang dimasukkan?')" id="register">Daftar akaun</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="patient_login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Google Captcha API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; MyCOVIQ <?= date('Y'); ?>. All right reserved.</span>
        </div>
    </div>
</footer>

</html>