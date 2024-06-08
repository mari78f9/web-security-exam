<?php
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';
?>

<section class="project-header">
</section>


<section class="form-switch">
    <a id="formSignupButton" class="form-switch-button" href="../views/signup.php"> Signup </a>
    <a id="formLoginButton" class="form-switch-button-active" href="../views/login.php"> Login </a>
</section>


<main class="form">

    <div id="loginForm" class="login">

        <h4 class="header-form">Login</h4>

        <form class="login-form" method="post" onsubmit="validate(login); return false">

            <div class="form-login-grid" id="email">
                <label class="form-label" for="user_email">Email</label>
                <input class="form-input" name="user_email" type="email" placeholder="Email" data-validate="email" required>
            </div>
            
            <div class="form-login-grid" id="pwd">
                <label class="form-label" for="user_password">Password </label>
                <input class="form-input" name="user_password" placeholder="Password" type="password" required>
            </div>
            
            <input type="submit" class="submit-form" id="login-btn" placeholder="Login"></input>
        
        </form>
    </div>
</main>


<?php require_once __DIR__ . '/_footer.php'  ?>
