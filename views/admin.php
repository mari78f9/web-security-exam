<!-- This is the admin page -->
<?php 

require_once __DIR__.'/../_.php'; 
require_once __DIR__.'/_header.php';

// If there's no user in the session, return to the login-page
// if (! isset($_SESSION['user'])){
//     header("Location: /login");
// }

?>

<section class="admin-page">
    <h1 class="header-page"> Lieutanent </h1>

    <h1>File Upload</h1>
    <form id="file-upload" action="../api/api-upload-files.php" method="post" enctype="multipart/form-data">
        <label for="file_name">File Name:</label>
        <input type="text" id="file_name" name="file_name">
        <label for="case_id">Case ID:</label>
        <input type="text" id="case_id" name="case_id">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>

    <h1>Search Files by Case ID</h1>
    <form id="search-files">
        <label for="search_case_id">Case ID:</label>
        <input type="text" id="search_case_id" name="case_id">
        <input type="submit" value="Search">
    </form>

    <div id="files-display"></div>

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

    <h1>All Cases</h1>
    <div id="cases-display"></div>

</section>

<script>

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
    })
    .catch(error => {
        console.error('Error updating case solved status:', error);
    });
}
    // function toggleCaseSolved(caseId, currentStatus) {
    //     // Toggle the current status
    //     const newStatus = currentStatus === 1 ? 0 : 1;

    //     // Prepare the data to send in the POST request
    //     const formData = new FormData();
    //     formData.append('case_id', caseId);
    //     formData.append('case_solved', newStatus);

    //     // Send the POST request to the API endpoint
    //     fetch('../api/api-update-case.php', {
    //         method: 'POST',
    //         body: formData
    //     })
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error('Failed to update case solved status');
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         // Handle the response data if needed
    //         console.log(data);
    //     })
    //     .catch(error => {
    //         console.error('Error updating case solved status:', error);
    //     });
    // }

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
                        <p><strong>Solved:</strong> <span class="case-solved">${caseItem.case_solved ? 'Yes' : 'No'}</span> <button class="toggle-button" onclick="toggleCaseSolved('${caseItem.case_id}', ${caseItem.case_solved})">Toggle</button></p>
                        <p><strong>Created At:</strong> ${new Date(caseItem.case_created_at * 1000).toLocaleString()}</p>
                        <p><strong>Updated At:</strong> ${caseItem.case_updated_at !== 0 ? new Date(caseItem.case_updated_at * 1000).toLocaleString() : 'Never'}</p>
                        <p><strong>Public:</strong> ${caseItem.case_is_public ? 'Yes' : 'No'}</p>
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
