<?php $pageTitle = 'Home' ?>
<?php require "inc/layout/header.inc.php" ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="ocean">
    <div class="wave"></div>
    <div class="wave"></div>
</div>
<div class="okwork"></div>
<div class="body container align-items-center">

    <div class="row align-items-center justify-content-center h-100">
        <?php require "process_forms.php" ?>
        <div class="col-auto ">
            <div class="app">

                <!-- <h1>Welcome!</h1> -->
                <button class="login">
                    <i class="fa fa-lock"></i>
                    Login
                </button>
                <button for="signup" class="signup">
                    <i class="fa fa-user-plus"></i>
                    Signup
                </button>

                <form action="<?= $_SERVER["PHP_SELF"] ?>" class="login-form hide" method="POST">

                    <h2>Login</h2>
                    <br>
                    <input type="text" placeholder="email address" id="in_email" name="in_email" required> <br>
                    <input type="password" placeholder="password" name="in_password" id="in_password" required>
                    <span id="showPassword" onclick="showPassword()">Show Password</span><br><br>
                    <input type="submit" class="button" name="sign_in" value="Login"></input>
                </form>

                <div>
                    <form action="<?= $_SERVER["PHP_SELF"] ?>" class="signup-form hide" method="POST">
                        <h2>Sign Up</h2>
                        <br><br>
                        <input type="text" placeholder="first name" class="half" id="first_name" name="first_name" required>
                        <input type="text" placeholder="last name" class="half" id="last_name" name="last_name" required>
                        <input type="text" placeholder="email address" id="up_email" name="up_email" required>
                        <input type="password" placeholder="password" id="up_password" name="up_password" required><br><br>
                        <input type="submit" class="button" name="sign_up" value="Create Account"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="js/form.js"></script>
<script src="js/script.js"></script>
</body>

</html>