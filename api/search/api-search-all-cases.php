<?php

// Connects to the master-file, which contains the database connection and validation
require_once __DIR__.'/../../_.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: /../views/error.php");
    exit();
}
?>

<section class="admin-view-all-cases">

    <div class="section-header">

        <?php if ($user['role_id_fk'] === 4): ?>
            <button class="create-case" onclick="createCrime()">
                <img src="/images/add-light.png" alt="Users">
                <p> Create Case </p> 
            </button>
        <?php endif; ?>

        <?php if (in_array($user['role_id_fk'], [1, 4])): ?>
        <button class="add-tip" onclick="showAddTip()">
            <img src="/images/add-light.png" alt="Users">
            <p> Add tip </p> 
        </button>
        <?php endif; ?>

        <h2> View Cases </h2>

        <form class="search-data-function" id="searchForm">
            <input type="text" name="searchCase" id="searchInput" placeholder="🔍 Search by 'Case ID'" required>
            
            <button type="submit">Search</button>

            <!-- Reset button to clear search results -->
            <div class="reset-users">
                <button type="button" onclick="resetSearch()"> ⟳ </button>
            </div>

        </form>

    </div>

    <div id="cases-display"></div>

    <?php
    // PHP conditional blocks to fetch and display cases based on user role
    if ($user['role_id_fk'] === 4) {
        // Admin role
        ?>
        <script>
              document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(searchForm);
                const searchQuery = formData.get('searchCase');
                fetchCases(`../api/api-get-cases.php?searchCase=${encodeURIComponent(searchQuery)}`);
            });
            fetchCases('../api/api-get-cases.php');
        });

            function fetchCases(apiUrl) {
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        let casesDisplay = document.getElementById('cases-display');
                        casesDisplay.innerHTML = ''; // Clear previous content
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
                                <p><strong>Solved:</strong> <span class="case-solved">${caseItem.case_solved ? 'Yes' : 'No'}</span>
                                    <button class="toggle-button" onclick="toggleCaseSolved('${caseItem.case_id}', ${caseItem.case_solved})">Toggle</button>
                                </p>
                                <p><strong>Created At:</strong> ${new Date(caseItem.case_created_at * 1000).toLocaleString()}</p>
                                <p><strong>Updated at:</strong> ${caseItem.case_updated_at == 0 ? 'Never' : new Date(caseItem.case_updated_at * 1000).toLocaleString()}</p>
                                <p><strong>Public:</strong> <span class="case-visibility">${caseItem.case_is_public ? 'Yes' : 'No'}</span>
                                    <button class="toggle-visibility-button" onclick="toggleCaseVisibility('${caseItem.case_id}', ${caseItem.case_is_public})">Toggle</button>
                                </p>
                                <hr>
                            `;
                            casesDisplay.appendChild(caseElement);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching cases:', error);
                        document.getElementById('cases-display').innerHTML = 'Error fetching cases.';
                    });
            }
        </script>
    <?php
    } elseif ($user['role_id_fk'] === 1) {
        // Detective role
        ?>
        <script>
             document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(searchForm);
                const searchQuery = formData.get('searchCase');
                fetchCases(`../api/api-get-cases.php?searchCase=${encodeURIComponent(searchQuery)}`);
            });
            fetchCases('../api/api-get-cases.php');
        });

            function fetchCases(apiUrl) {
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        let casesDisplay = document.getElementById('cases-display');
                        casesDisplay.innerHTML = ''; // Clear previous content
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
                                <p><strong>Solved:</strong> <span class="case-solved">${caseItem.case_solved ? 'Yes' : 'No'}</span>
                                    <button class="toggle-button" onclick="toggleCaseSolved('${caseItem.case_id}', ${caseItem.case_solved})">Toggle</button>
                                </p>
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
            }
        </script>
    <?php
    } elseif ($user['role_id_fk'] === 2) {
        // Lawyer role
        ?>
        <script>
             document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(searchForm);
                const searchQuery = formData.get('searchCase');
                fetchCases(`../api/api-get-cases.php?searchCase=${encodeURIComponent(searchQuery)}`);
            });
            fetchCases('../api/api-get-cases.php');
        });

            function fetchCases(apiUrl) {
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        let casesDisplay = document.getElementById('cases-display');
                        casesDisplay.innerHTML = ''; // Clear previous content
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
            }
        </script>
    <?php
    } elseif ($user['role_id_fk'] === 3) {
        // Citizen role
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(searchForm);
                const searchQuery = formData.get('searchCase');
                fetchCases(`../api/api-get-cases.php?searchCase=${encodeURIComponent(searchQuery)}&public_only=true`);
            });
            fetchCases('../api/api-get-cases.php?public_only=true');
        });

            function fetchCases(apiUrl) {
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        let casesDisplay = document.getElementById('cases-display');
                        casesDisplay.innerHTML = ''; // Clear previous content
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
            }
        </script>
    <?php
    }
    ?>

    <script>
         // Function to reset search and display all cases
         function resetSearch() {
            document.getElementById('searchInput').value = '';
            <?php if ($user['role_id_fk'] === 3): ?>
                fetchCases('../api/api-get-cases.php?public_only=true');
            <?php else: ?>
                fetchCases('../api/api-get-cases.php');
            <?php endif; ?>
        }
    </script>
  
</section>

<?php require_once __DIR__ . '/../../views/_footer.php'  ?>