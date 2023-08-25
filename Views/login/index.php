<?php
include '../../config.php';

if (isset($_GET['logout'])) {
    unset($_SESSION["email"]);
    print "<script>console.log('logged out')</script>";
}
?>
<!DOCTYPE html>
<html lang="pt">


<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>

<body>
    <div class="login-wrapper">
        <form action="" class="form">
            <img src="../../assets/img/logo-sports.png" alt="">
            <h2>Login</h2>
            <div class="input-group">
                <input type="text" name="loginUser" id="email-field" class="login-form-field" required>
                <label for="loginUser">E-mail</label>
            </div>
            <div class="input-group">
                <input type="password" name="loginPassword" id="password-field" class="login-form-field" required>
                <label for="loginPassword">Password</label>
                <i class="bi bi-eye-slash" id="togglePassword"></i>
            </div>
            <input type="submit" value="Login" class="submit-btn" id="login-form-submit">
            <a href="/minha_PAP/Views/registrar/registerpage.php" class="forgot-pw">Register Now!</a>
        </form>
    </div>
</body>
<link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
<!-- jQuery -->
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password-field");

    togglePassword.addEventListener("click", function() {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // toggle the icon
        this.classList.toggle("bi-eye");
    });

    // prevent form submit
    const form = document.querySelector("form");
    form.addEventListener('submit', function(e) {
        e.preventDefault();
    });

    $(document).ready(function() {
        $("#login-form-submit").click(function() {
            var email = $("#email-field").val().trim();
            var password = $("#password-field").val().trim();
            $.ajax({
                type: 'POST',
                url: '/minha_PAP/api/verify_login.php',
                data: {
                    'email': email,
                    'password': password
                }
            }).done(function(res) {
                res = JSON.parse(res);
                if (res.status == 'success') {
                    toastr[res.status](res.message);
                    if(res.admin == 1){
                        window.location = '<?= $global_configs['SERVER_URL'] ?>/Views/Homepage/HomeAdmin.php';
                    }else{
                    window.location = '<?= $global_configs['SERVER_URL'] ?>/Views/Homepage/Home.php';
                    }
                } else { 
                    toastr['error']('Password ou Username Errados');
                }
            }).fail(function(err) {
                toastr[res.status](res.message);
            });

        });
    });
</script>

<script src="../../assets/plugins/toastr/toastr.min.js"></script>

</html>