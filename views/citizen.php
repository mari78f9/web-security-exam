<!-- This is the user page -->
<?php 

require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';

// // If there's no user in the session, return to the login-page
// if (! isset($_SESSION['user'])){
//   header("Location: /login");
// }

?>

<section class="user-page">
  
  <h1 class="header-page"> Citizen </h1>

  <h2>All Cases</h2>
  <div id="cases-display"></div>

</section>
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
<?php require_once __DIR__.'/_footer.php'  ?>