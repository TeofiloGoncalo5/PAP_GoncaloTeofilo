<?php
include '../../config.php';

if (isset($_GET['logout'])) {
    unset($_SESSION["username"]);
    unset($_SESSION["theId"]);
    unset($_SESSION["time"]);
    session_destroy();
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
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>

<body>
    <div class="login-wrapper">
        <form action="" class="form">
            <img src="../../assets/img/logo-sports.png" alt="">
            <h2>Register</h2>
            <div class="input-group">
                <input type="text" name="username-field" id="username-field" class="login-form-field" required>
                <label for="loginUser">Username</label>
            </div>
            <div class="input-group">
                <input type="text" name="email-field" id="email-field" class="login-form-field" required>
                <label for="loginEmail">E-mail</label>
            </div>
            <div class="input-group">
                <input type="password" name="password-field" id="password-field" class="login-form-field" required>
                <label for="loginPassword">Password</label>
                <i class="bi bi-eye-slash" id="togglePassword"></i>
            </div>
            <input type="submit" value="Save" class="submit-btn" id="register-form-submit">
            <a href="/minha_PAP/Views/login/index.php" class="forgot-pw">Already Registered?</a>
        </form>
    </div>
</body>

<link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
<!-- jQuery -->
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- cript() -->
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
        $("#register-form-submit").click(function() {
            var username = $("#username-field").val().trim();
            var email = $("#email-field").val().trim();
            var password = $("#password-field").val().trim();
            $.ajax({
                url: '/minha_PAP/api/verify_register.php',
                type: 'post',
                data: {
                    'username': username,
                    'email': email,
                    'password': password,
                }
            }).done(function(res) {
                console.log(res);
                if (res == "User registered successfully") {
                    toastr['success'](res);
                    window.location = '/minha_PAP/Views/login/index.php';
                } else {
                    toastr['error'](res);
                }
            })

        });
    });
</script>

<script src="../../assets/plugins/toastr/toastr.min.js"></script>

</html>