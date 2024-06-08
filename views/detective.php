<!-- This is the partner page -->
<?php 

require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';

// Ensure the user is an admin
if ($_SESSION['user']['role_id_fk'] !== 1) {
    header("Location: /error"); // Redirect to an unauthorized access page if the user is not an admin
    exit();
}

?>

<section class="user-page">
  
  <h1 class="header-page"> Detective </h1>

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

    <h2>All Cases</h2>
    <div id="cases-display"></div>

</section>

<script>

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
            alert('Tip added successfully!');
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
        })
        .catch(error => {
            console.error('Error updating case solved status:', error);
        });
    }

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
                        <p><strong>Updated At:</strong> ${caseItem.case_updated_at !== 0 ? new Date(caseItem.case_updated_at * 1000).toLocaleString() : 'Never'}</p>
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

<?php require_once __DIR__.'/_footer.php'  ?>

