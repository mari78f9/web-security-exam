<?php

require_once __DIR__ . '/_header.php';  
require_once __DIR__ . '/../_.php';

$user = $_SESSION['user'];
$user_id = $_SESSION['user']['user_id'];

if (!isset($_SESSION['user'])){
    header("Location: login");
}
?>

<main class="dashboard">

    <!-- Left side -->
    <section class="dashboard-menu">

        <!-- Top-Left -->
        <div class="dashboard-menu-top">
            
            <!-- Make sure to sanitize output with htmlspecialchars to prevent XSS attacks -->
            <img src="/images/profile-dark.png" alt="user_profile"> <br>
            <span id="user_name"> <?= htmlspecialchars($user['user_name']) ?> </span> <span id="user_last_name"> <?= htmlspecialchars($user['user_last_name']) ?> </span> </span>
            <p id="user_role"> <?= htmlspecialchars($user['role_name']) ?> </p>

        </div>
       
        <!-- Bottom-Left -->
        <div class="dashboard-menu-bottom">

        <?php require_once __DIR__ . '/../api/api-navigation.php'  ?>

            <div class="logout">
                <button onclick="logout()"> Log out </button>
            </div>

        </div>

    </section>

    <!-- Right side -->
    <section class="dashboard-content">

        <h2>View Users</h2>
        <div id="users-display" class="view-users">
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    fetch('../api/api-get-users.php')
                        .then(response => response.json())
                        .then(data => {
                            let usersDisplay = document.getElementById('users-display');
                            if (data.error) {
                                usersDisplay.innerHTML = `<p>Error fetching users: ${data.error}</p>`;
                                return;
                            }
                        
                            data.forEach(userItem => {
                                let userElement = document.createElement('div');
                                userElement.id = `user-${userItem.user_id}`;
                                userElement.innerHTML = `
                                    <div class="view-user">
                                        <div class="user-user-id"> 
                                            <p><strong>ID</strong> ${userItem.user_id}</p>
                                        </div>
                                        <img src="/images/profile-dark.png" alt="user_profile"> <br>
                                        <div class="user-user-name"> <span>${userItem.user_name}</span> <span>${userItem.user_last_name}</span> </div>
                                        <div class="user-user-role"> <p><strong>Role ID:</strong> ${userItem.role_id_fk}</p> </div>
                                        <p><strong>Email:</strong> ${userItem.user_email}</p>
                                        <p><strong>User created at:</strong> ${new Date(userItem.user_created_at * 1000).toLocaleString()}</p>
                                        <p><strong>User updated at:</strong> ${userItem.user_updated_at == 0 ? 'Never' : new Date(userItem.case_updated_at * 1000).toLocaleString()}</p>
                                        <p><strong>User deleted at:</strong> ${userItem.user_deleted_at == 0 ? 'Never' : new Date(userItem.user_deleted_at * 1000).toLocaleString()}</p>
                                        <p><strong>User is blocked:</strong> <span class="user-blocked">${userItem.user_is_blocked ? 'Yes' : 'No'}</span> <button class="toggle-blocked" onclick="toggleUserBlocked('${userItem.user_id}', ${userItem.user_is_blocked})">Toggle</button></p>
                                        <button onclick="deleteUser('${userItem.user_id}')">Delete user</button>
                                    </div>
                                `;
                                usersDisplay.appendChild(userElement);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching users:', error);
                            document.getElementById('users-display').innerHTML = 'Error fetching users.';
                        });
                });
            </script>
        </div>

        
    </section>

    
    
</main>

<?php require_once __DIR__ . '/_footer.php'  ?>