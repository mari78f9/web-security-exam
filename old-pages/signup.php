<?php
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';
?>

<section class="form-switch">
    <a id="formSignupButton" class="form-switch-button-active" href="../views/signup.php"> Signup </a>
    <a id="formLoginButton" class="form-switch-button" href="../views/login.php"> Login </a>
</section>


<main class="form">

    <div id="signupForm" class="signup">
        <h4 class="header-form" id="signup-header">Signup with a citizen account</h4>
        <form class="signup-form" onsubmit="validate(signup); return false">

            <div id="name" class="form-signup-grid">
                <label class="form-label" for="user_name">
                    Name (<?= USER_NAME_MIN ?> to <?= USER_NAME_MAX ?> characters)
                </label>
                <input class="form-input" id="user_namex" name="user_name" placeholder="Name" type="text" data-validate="str" data-min="<?= USER_NAME_MIN ?>" data-max="<?= USER_NAME_MAX ?>" class="">
            </div>

            <div id="lastName" class="form-signup-grid">
                <label class="form-label" for="user_last_name">
                    Last name (<?= USER_LAST_NAME_MIN ?> to <?= USER_LAST_NAME_MAX ?> characters)
                </label>
                <input class="form-input" id="user_last_name" name="user_last_name" placeholder="Last name" type="text" data-validate="str" data-min="<?= USER_LAST_NAME_MIN ?>" data-max="<?= USER_LAST_NAME_MAX ?>" class="">
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

            <button class="submit-form" id="signup-btn">Signup</button>

        </form>
    </div>
</main>

<?php require_once __DIR__ . '/_footer.php'  ?>