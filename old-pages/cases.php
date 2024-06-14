<?php

require_once __DIR__ . '/../_.php';
require_once __DIR__ . '/_header.php';  

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

        <h2>All Cases</h2>
        <div id="cases-display">
            <!-- Admin -->
            <?php if ($user['role_id_fk'] === 4): ?>
            <script>
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
                                    <p><strong>Created at:</strong> ${new Date(caseItem.case_created_at * 1000).toLocaleString()}</p>
                                    <p><strong>Updated at:</strong> ${caseItem.case_updated_at == 0 ? 'Never' : new Date(caseItem.case_updated_at * 1000).toLocaleString()}</p>
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
            </script>

            <!-- Detective -->
            <?php elseif ($user['role_id_fk'] === 1): ?>
            <script>
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
                                    <p><strong>Updated at:</strong> ${caseItem.case_updated_at == 0 ? 'Never' : new Date(caseItem.case_updated_at * 1000).toLocaleString()}</p>
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
            </script>

            <!-- Lawyer -->
            <?php elseif ($user['role_id_fk'] === 2): ?>
            <script>
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
                                    <p><strong>Created At:</strong> ${new Date(caseItem.case_created_at * 1000).toLocaleString()}</p>
                                    <p><strong>Updated at:</strong> ${caseItem.case_updated_at == 0 ? 'Never' : new Date(caseItem.case_updated_at * 1000).toLocaleString()}</p>
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
            </script>

            <!-- Citizen -->
            <?php elseif ($user['role_id_fk'] === 3): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    fetch('../api/api-get-cases.php?public_only=true')
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
                                    <p><strong>Type:</strong> ${caseItem.case_type}</p>
                                    <p><strong>Location:</strong> ${caseItem.case_location}</p>
                                    <p><strong>Created At:</strong> ${new Date(caseItem.case_created_at * 1000).toLocaleString()}</p>
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
            </script>
            <?php endif; ?>
        </div>
        
    </section>

    
    
</main>

<?php require_once __DIR__ . '/_footer.php'  ?>