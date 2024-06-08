<!-- This is the admin page -->
<?php 

require_once __DIR__.'/../_.php'; 
require_once __DIR__.'/_header.php';

// Ensure the user is an admin
if ($_SESSION['user']['role_id_fk'] !== 4) {
    header("Location: /error"); // Redirect to an unauthorized access page if the user is not an admin
    exit();
}

?>

<section class="admin-page">
    <h1 class="header-page"> Lieutanent </h1>

    <h2>File Upload</h2>
    <form id="file-upload" action="../api/api-upload-files.php" method="post" enctype="multipart/form-data">
        <label for="file_name">File Name:</label>
        <input type="text" id="file_name" name="file_name">
        <label for="case_id">Case ID:</label>
        <input type="text" id="case_id" name="case_id">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>

    <h2>Search Files by Case ID</h2>
    <form id="search-files">
        <label for="search_case_id">Case ID:</label>
        <input type="text" id="search_case_id" name="case_id">
        <input type="submit" value="Search">
    </form>

    <div id="files-display"></div>

    <h2>Add tip by Case ID</h2>
    <form id="add-tip-form" onsubmit="addTip(); return false;">
        <label for="case_id_tip">Case ID:</label>
        <input type="text" id="case_id_tip" name="case_id" required>
        <label for="case_tip">Tip:</label>
        <textarea id="case_tip" name="case_tip" required></textarea>
        <button type="submit">Add Tip</button>
    </form>

    <form id="create-case-form" onsubmit="makeCase(); return false">
        <label for="case_description">Description:</label>
        <textarea id="case_description" name="case_description" required></textarea>

        <label for="case_suspect">Suspect:</label>
        <input type="text" id="case_suspect" name="case_suspect" required>

        <label for="case_type">Type:</label>
        <input type="text" id="case_type" name="case_type" required>

        <label for="case_location">Location:</label>
        <input type="text" id="case_location" name="case_location" required>

        <button type="submit">Create Case</button>
    </form>

    <h2>All Users</h2>
    <div id="users-display"></div>

    <h2>All Cases</h2>
    <div id="cases-display"></div>

</section>

<script>

    function deleteUser(userId) {
        const formData = new FormData();
        formData.append('user_id', userId);

        fetch('../api/api-delete-user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            document.getElementById(`user-${userId}`).remove(); // Remove user element from the page
        })
        .catch(error => {
            console.error('Error deleting user:', error);
        });
    }

    function toggleUserBlocked(userId, currentStatus) {
        const newStatus = currentStatus === 1 ? 0 : 1;

        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('user_is_blocked', newStatus);

        fetch('../api/api-toggle-user-blocked.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            location.reload(); // Reload the page after toggling
        })
        .catch(error => {
            console.error('Error updating user blocked status:', error);
        });
    }

    function toggleCaseVisibility(caseId, currentStatus) {
        const newStatus = currentStatus === 1 ? 0 : 1;

        const formData = new FormData();
        formData.append('case_id', caseId);
        formData.append('case_is_public', newStatus);

        fetch('../api/api-update-case.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            const caseElement = document.getElementById(`case-${caseId}`);
            if (caseElement) {
                const visibilityStatusElement = caseElement.querySelector('.case-visibility');
                visibilityStatusElement.textContent = newStatus ? 'Yes' : 'No';

                const toggleVisibilityButton = caseElement.querySelector('.toggle-visibility-button');
                toggleVisibilityButton.setAttribute('onclick', `toggleCaseVisibility('${caseId}', ${newStatus})`);
            } else {
                console.error('Case element not found:', caseId);
            }
            // Reload the page after toggling
            location.reload();
        })
        .catch(error => {
            console.error('Error updating case visibility status:', error);
        });
    }

    function addTip() {
        const caseId = document.getElementById('case_id_tip').value;
        const caseTip = document.getElementById('case_tip').value;

        const formData = new FormData();
        formData.append('case_id', caseId);
        formData.append('case_tip', caseTip);

        fetch('../api/api-update-case.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            location.reload(); // Reload the page after adding the tip
        })
        .catch(error => {
            console.error('Error adding tip:', error);
        });
    }

    function toggleCaseSolved(caseId, currentStatus) {
        const newStatus = currentStatus === 1 ? 0 : 1;

        const formData = new FormData();
        formData.append('case_id', caseId);
        formData.append('case_solved', newStatus);

        fetch('../api/api-update-case.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            const caseElement = document.getElementById(`case-${caseId}`);
            if (caseElement) {
                const solvedStatusElement = caseElement.querySelector('.case-solved');
                solvedStatusElement.textContent = newStatus ? 'Yes' : 'No';

                const toggleButton = caseElement.querySelector('.toggle-button');
                toggleButton.setAttribute('onclick', `toggleCaseSolved('${caseId}', ${newStatus})`);
            } else {
                console.error('Case element not found:', caseId);
            }

            // Reload the page after toggling
            location.reload();
        })
        .catch(error => {
            console.error('Error updating case solved status:', error);
        });
    }

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
                        <p><strong>User ID:</strong> ${userItem.user_id}</p>
                        <p><strong>First name:</strong> ${userItem.user_name}</p>
                        <p><strong>Last name:</strong> ${userItem.user_last_name}</p>
                        <p><strong>Email:</strong> ${userItem.user_email}</p>
                        <p><strong>Role ID:</strong> ${userItem.role_id_fk}</p>
                        <p><strong>User created at:</strong> ${new Date(userItem.user_created_at * 1000).toLocaleString()}</p>
                        <p><strong>User updated at:</strong> ${userItem.user_updated_at == 0 ? 'Never' : new Date(userItem.case_updated_at * 1000).toLocaleString()}</p>
                        <p><strong>User deleted at:</strong> ${userItem.user_deleted_at == 0 ? 'Never' : new Date(userItem.user_deleted_at * 1000).toLocaleString()}</p>
                        <p><strong>User is blocked:</strong> <span class="user-blocked">${userItem.user_is_blocked ? 'Yes' : 'No'}</span> <button class="toggle-blocked" onclick="toggleUserBlocked('${userItem.user_id}', ${userItem.user_is_blocked})">Toggle</button></p>
                        <button onclick="deleteUser('${userItem.user_id}')">Delete user</button>
                        <hr>
                    `;
                    usersDisplay.appendChild(userElement);
                });
            })
            .catch(error => {
                console.error('Error fetching users:', error);
                document.getElementById('users-display').innerHTML = 'Error fetching users.';
            });
    });

    document.addEventListener('DOMContentLoaded', function() {
        fetch('../api/api-get-cases.php')
            .then(response => response.json())
            .then(data => {
                let casesDisplay = document.getElementById('cases-display');
                if (data.error) {
                    casesDisplay.innerHTML = `<p>Error fetching cases: ${data.error}</p>`;
                    return;
                }
                data.forEach(caseItem => {
                    let caseElement = document.createElement('div');
                    caseElement.id = `case-${caseItem.case_id}`;
                    caseElement.innerHTML = `
                        <p><strong>Case ID:</strong> ${caseItem.case_id}</p>
                        <p><strong>Description:</strong> ${caseItem.case_description}</p>
                        <p><strong>Suspect:</strong> ${caseItem.case_suspect}</p>
                        <p><strong>Type:</strong> ${caseItem.case_type}</p>
                        <p><strong>Location:</strong> ${caseItem.case_location}</p>
                        <p><strong>Tip:</strong> ${caseItem.case_tip ? caseItem.case_tip : 'No tips yet'}</p>
                        <p><strong>Solved:</strong> <span class="case-solved">${caseItem.case_solved ? 'Yes' : 'No'}</span> <button class="toggle-button" onclick="toggleCaseSolved('${caseItem.case_id}', ${caseItem.case_solved})">Toggle</button></p>
                        <p><strong>Created At:</strong> ${new Date(caseItem.case_created_at * 1000).toLocaleString()}</p>
                        <p><strong>Updated At:</strong> ${caseItem.case_updated_at == 0 ? 'Never' : new Date(caseItem.case_updated_at * 1000).toLocaleString()}</p>
                        <p><strong>Public:</strong> <span class="case-visibility">${caseItem.case_is_public ? 'Yes' : 'No'}</span> <button class="toggle-visibility-button" onclick="toggleCaseVisibility('${caseItem.case_id}', ${caseItem.case_is_public})">Toggle</button></p>
                        <hr>
                    `;
                    casesDisplay.appendChild(caseElement);
                });
            })
            .catch(error => {
                console.error('Error fetching cases:', error);
                document.getElementById('cases-display').innerHTML = 'Error fetching cases.';
            });
    });

    // Prevent form submission and handle search
    document.getElementById('search-files').addEventListener('submit', function(event) {
        event.preventDefault();

        var caseId = document.getElementById('search_case_id').value;

        fetch('../api/api-display-files.php?case_id=' + caseId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('files-display').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching files:', error);
            document.getElementById('files-display').textContent = 'Error fetching files.';
        });
    });
</script>
<?php require_once __DIR__.'/_footer.php' ?>  
