// ##########################################################################################

// SOLVED/NOT SOLVED ////////////////////
// Handles a case to solved or not solved
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

// ##########################################################################################

// MAKE CASE ////////////////////
// Handles to make a case
async function makeCase(){
  const frm = event.target   // A form triggers the event (function is called upon a form-submission)
  console.log(frm)

  // Send a POST-request to the signup-api (sends the form-data as a FormData-object with key-value pairs)
  const conn = await fetch("/api/api-make-case.php", {
    method : "POST",
    body : new FormData(frm)
  })

  // Show the expected data from the form-submission in the console
  const data = await conn.text()
  console.log(data) 

  // Refresh the window
  location.reload();

}

// ##########################################################################################

// TIP ////////////////////
// Handles a case to make a tip

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

// ##########################################################################################

// PRIVATE/PUBLIC CASES ////////////////////
// Handles a case that is private or public

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

//////////////////////////////////////////////////////////////////////////////////////////

// Hide logout button on signup/login page

if (window.location.pathname === '../views/signup.php', '../views/login.php') {
  // Function to hide the section
  function hideSection() {
      var sectionToHide = document.getElementById('navigation');
      if (sectionToHide) {
          sectionToHide.style.display = 'none';
      }
  }
  // Call the function when the window has finished loading
  window.onload = hideSection;
}
  
// ##########################################################################################
  
// Toggle Blocked ////////////////////
// Switches between "Blocked" and "Unblocked" inside a user based on the user_id in the query-string

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
  
// ##########################################################################################

// SIGNUP ////////////////////
// Handles a user-signup, when submitting a form via POST-request

async function signup(){
  const frm = event.target   // A form triggers the event (function is called upon a form-submission)
  console.log(frm)

  // Send a POST-request to the signup-api (sends the form-data as a FormData-object with key-value pairs)
  const conn = await fetch("/api/api-signup.php", {
    method : "POST",
    body : new FormData(frm)
  })

  // Show the expected data from the form-submission in the console
  const data = await conn.text()
  console.log(data) 

  // Redirect to the login page (after submission)
  location.href="../views/login.php"

}

// ##########################################################################################

// LOGIN ////////////////////
// Handles a user-login, when submitting a form via POST-request

async function login(){
  
  const frm = event.target  // A form triggers the event (function is called upon a form-submission)
  console.log(frm)

  // Tries to send a POST-request to the login-api (sends the form-data as a FormData-object with key-value pairs)
  try {
    const conn = await fetch("/api/api-login.php", {
      method : "POST",
      body : new FormData(frm)
    });

    if (!conn.ok) {
      const errorData = await conn.json();

      // Check if the error message indicates the user is blocked
      if (conn.status === 403 && errorData.info === 'Your account is blocked. Please contact support.') {
        throw new Error('Your account is blocked. Please contact support.');
      }

      // Check if the error message indicates the user account is deleted
      if (conn.status === 403 && errorData.info === 'Your account has been deleted and you cannot log in.') {
        throw new Error('Your account has been deleted and you cannot log in.');
      }

      throw new Error("Login failed");
    }


    // Show the expected data from the form-submission in the console 
    // And sets the data into session_storage inside a key called 'user_info'
    const data = await conn.json();
    // sessionStorage.setItem('user_info', JSON.stringify(data));

    // Depending on user_role, from the recieved data in the console, redirect the user to each of the pages (permission-access)
    switch (data.role_id_fk) {
      case 1:
        location.href = "../views/detective.php";
        break;
      case 2:
        location.href = "../views/lawyer.php";
        break;
      case 3:
        location.href = "../views/citizen.php";
        break;
      case 4:
        location.href = "../views/admin.php";
        break;
      default:
      throw new Error("Unknown user role");
    }

    // If error occurs during the login, send back error-message
  } catch (error) {
    if (error.message === 'Your account is blocked. Please contact support.') {
      alert('Your account is blocked. Please contact support.');
    } else if (error.message === 'Your account has been deleted and you cannot log in.') {
      alert('Your account has been deleted and you cannot log in.');
    } else {
      alert('Invalid email or password');
    }
    console.error("Login error:", error.message);
  }
}

// ##########################################################################################

// LOGOUT //////////////

// When logging out, clear the session-storage for data, and redirect to the logout-page (which is redirecting to the login page)
function logout() {
  // sessionStorage.clear();
  
  location.href="../views/logout.php"
}

// ##########################################################################################

// UPDATE //////////////////
// Handles a user-update, when submitting a form via POST-request

async function updateUser() {
  const frm = event.target; // A form triggers the event (function is called upon a form-submission)
  console.log(frm);

  // Sends a POST-request to the update-api (sends the form-data as a FormData-object with key-value pairs)
  const conn = await fetch("/api/api-update-user.php", {
    method: 'POST',
    body: new FormData(frm)
  });
  
   // Show the expected data from the form-submission in the console 
  const data = await conn.text();
  console.log(data);

  // Showing an alert when the data is updated successfully
  alert('User updated successfully');
}

// ##########################################################################################

// DELETE //////////////////
// Handles a user-delete

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