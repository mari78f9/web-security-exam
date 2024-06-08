<?php

$user = $_SESSION['user'];
$user_id = $_SESSION['user']['user_id'];

if (!isset($_SESSION['user'])){
    header("Location: login");
}

?>

<section class="view-profile">
      <h2> View Profile </h2>

      <div class="view-profile-form">
            <form class="view-profile-form-input" onsubmit="validate(updateUser); return false">

                <label class="profile-form-label" for="user_id"> ID </label> 
                    <div class="profile-form-input"><p id="user_id"> <?= $user['user_id'] ?> </p></div>
                    
                <label class="profile-form-label" for="user_name">
                Name <br> Your name must be min <?= USER_NAME_MIN?> and max <?= USER_NAME_MAX?> </label> 
                    <input id="user_name" class="profile-form-input" type="text" name="user_name" data-validate="str" data-min="<?= USER_NAME_MIN?>" data-max="<?= USER_NAME_MAX?>" value="<?= $user['user_name'] ?>">

                <label class="profile-form-label" for="user_last_name"> Lastname <br> Your name must be min <?= USER_LAST_NAME_MIN?> and max <?= USER_LAST_NAME_MAX?> </label> 
                    <input id="user_last_name" class="profile-form-input" type="text" name="user_last_name" data-validate="str" data-min="<?= USER_LAST_NAME_MIN?>" data-max="<?= USER_LAST_NAME_MAX?>" value="<?= $user['user_last_name'] ?>">

                <label class="profile-form-label" for="user_email"> Email </label> 
                    <input id="user_email" class="profile-form-input" type="email" name="user_email" data-validate="email" value="<?= $user['user_email'] ?>">

                <button id="edit-profile" class="edit-profile"> Edit profile </button>
              
            </form>

        </div>
        
        <div>
            <button id="delete-profile" class="delete-profile" onclick="deleteUser()"> Delete profile </button>
        </div>
  </section>