<?php
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';
?>

<a class="return-btn" href="/views/index.php">
    <button> ↩ </button>
 </a>

<main class="form">


    <div id="signupForm" class="signup">
        <h4 class="header-form" id="signup-header">Signup</h4>
        <form class="signup-form" onsubmit="validate(signup); return false">

            <div class="name-input">
                
                <div id="name" >
                    <label class="form-label" for="user_name">
                        Name (<?= USER_NAME_MIN ?> to <?= USER_NAME_MAX ?> characters)
                    </label>
                    <input class="form-input" id="user_namex" name="user_name" placeholder="Name" type="text" data-validate="str" data-min="<?= USER_NAME_MIN ?>" data-max="<?= USER_NAME_MAX ?>" class="">
                </div>

                <div id="lastName">
                    <label class="form-label" for="user_last_name">
                        Last name (<?= USER_LAST_NAME_MIN ?> to <?= USER_LAST_NAME_MAX ?> characters)
                    </label>
                    <input class="form-input" id="user_last_name" name="user_last_name" placeholder="Last name" type="text" data-validate="str" data-min="<?= USER_LAST_NAME_MIN ?>" data-max="<?= USER_LAST_NAME_MAX ?>" class="">
                </div>

            </div>

            <div id="email" class="form-signup-grid">
                <label class="form-label" for="">Email</label>
                <input class="form-input" name="user_email" placeholder="Email" type="text" data-validate="email">
            </div>

            <div id="pwd" class="form-signup-grid">
                <label class="form-label" for="">
                    Password (<?= USER_PASSWORD_MIN ?> to <?= USER_PASSWORD_MAX ?> characters)
                </label>
                <input class="form-input" name="user_password" placeholder="Password" type="text" data-validate="str" data-min="<?= USER_PASSWORD_MIN ?>" data-max="<?= USER_PASSWORD_MAX ?>" class="">
            </div>

            <div id="cpwd" class="form-signup-grid">
                <label class="form-label" for="">Confirm password</label>
                <input class="form-input" name="user_confirm_password" placeholder="Confirm password" type="text" data-validate="match" data-match-name="user_password" class="">
            </div>

            <button class="signup-btn" id="signup-btn"> Signup </button>

        </form>
    </div>



    <div id="loginForm" class="login">

        <h4 class="header-form" id="login-header">Login</h4>

        <form class="login-form" method="post" onsubmit="validate(login); return false">

            <div class="form-login-grid" id="email">
                <label class="form-label" for="user_email">Email</label>
                <input class="form-input" name="user_email" type="email" placeholder="Email" data-validate="email" required>
            </div>
            
            <div class="form-login-grid" id="pwd">
                <label class="form-label" for="user_password">Password </label>
                <input class="form-input" name="user_password" placeholder="Password" type="password" required>
            </div>
            
            <input type="submit" class="login-btn" id="login-btn" placeholder="Login"></input>
        
        </form>
    </div>
    


</main>


<?php require_once __DIR__ . '/_footer.php'  ?>
