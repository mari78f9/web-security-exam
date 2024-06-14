<section class="admin-view-all-users">

    <!-- Section header with a title and a search form -->
    <div class="section-header">

        <h2> View Users </h2>

        <!-- Form for searching users by User ID -->
        <form class="search-data-function" method="post" action="">
            
            <!-- Input field for entering the user ID to search -->
            <input type="text" name="searchUser" placeholder="🔍 Search by 'User ID'" required>

            <!-- Submit button for the search form -->
            <button type="submit">Search</button>

            <!-- Reset button to clear search results -->
            <button type="button" onclick="resetSearch()">Reset</button>

        </form>

    </div>

    <div id="users-display" class="view-users"></div>
        
    <script>
        // Function to fetch and display users
        function fetchUsers(query = '') {
            let url = '../api/api-get-users.php';
            if (query) {
                url += `?searchUser=${encodeURIComponent(query)}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    let usersDisplay = document.getElementById('users-display');
                    usersDisplay.innerHTML = ''; // Clear existing content

                    if (data.error) {
                        usersDisplay.innerHTML = `<p>Error fetching users: ${data.error}</p>`;
                        return;
                    }

                    if (data.length === 0) {
                        usersDisplay.innerHTML = `<p>No matching users found.</p>`;
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
                                <div class="user-user-role"> <p><strong>Role:</strong> ${userItem.role_name}</p> </div>
                                <p><strong>Email:</strong> ${userItem.user_email}</p>
                                <p><strong>User created at:</strong> ${new Date(userItem.user_created_at * 1000).toLocaleString()}</p>
                                <p><strong>User updated at:</strong> ${userItem.user_updated_at == 0 ? 'Never' : new Date(userItem.user_updated_at * 1000).toLocaleString()}</p>
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
        }

        // Function to reset search and display all users
        function resetSearch() {
            document.querySelector('input[name="searchUser"]').value = ''; // Clear search input
            fetchUsers(); // Fetch all users
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Fetch all users on page load
            fetchUsers();

            // Handle the search form submission
            document.querySelector('.search-data-function').addEventListener('submit', function(event) {
                event.preventDefault();
                let searchQuery = document.querySelector('input[name="searchUser"]').value;
                fetchUsers(searchQuery);
            });
        });
    </script>

</section>

<?php require_once __DIR__ . '/../../views/_footer.php'  ?>