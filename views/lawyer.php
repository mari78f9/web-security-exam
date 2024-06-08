<!-- This is the partner page -->
<?php 

require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';

// Ensure the user is an admin
if ($_SESSION['user']['role_id_fk'] !== 2) {
    header("Location: /error"); // Redirect to an unauthorized access page if the user is not an admin
    exit();
}

?>

<section class="user-page">
  
  <h1 class="header-page"> Lawyer </h1>

  <h2>Search Files by Case ID</h2>
    <form id="search-files">
        <label for="search_case_id">Case ID:</label>
        <input type="text" id="search_case_id" name="case_id">
        <input type="submit" value="Search">
    </form>

  <div id="files-display"></div>

  <h2>All Cases</h2>
  <div id="cases-display"></div>

</section>

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

