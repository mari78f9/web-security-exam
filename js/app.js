
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

//////////////////////////////////////////////////////////////////////////////////////////

// ##############################

// Function to check if a email is available, so more than one user can't have the same email (just like one id for each)
// Funtion *commented out* ... because the matching API doesn't exist


// async function is_email_available(){
//     const frm = event.target.form
//     const conn = await fetch("api/api-is-email-available.php", {
//       method: "POST",
//       body: new FormData(frm)
//     })
//     if( ! conn.ok ){ // everything that is not a 2xx
//       console.log("email not available")
//       document.querySelector("#msg_email_not_available").classList.remove("hidden")
//       return
//     }
//     console.log("email available")
//   }

  
// ##########################################################################################
  
// Toggle Blocked ////////////////////
// Switches between "Blocked" and "Unblocked" inside a user based on the user_id in the query-string

async function toggle_blocked(user_id, user_is_blocked){
  
    console.log("user_id", user_id)
    console.log("user_is_blocked", user_is_blocked)
  
    if(user_is_blocked == 0){
      event.target.innerHTML = "Blocked"
    }else
    {
      event.target.innerHTML = "Unblocked"
    }
  
    // Not using 'method' here, cause it's a GET-request (with a query-string)
    const conn = await fetch(`../api/api-toggle-user-blocked.php?user_id=${user_id}&user_is_blocked=${user_is_blocked}`)
    const data = await conn.text()
    console.log(data)
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

    // If the request isn't 'ok', show error-message with failed login
    if(!conn.ok ){
        throw new Error ("Login failed");
    }

    // Show the expected data from the form-submission in the console 
    // And sets the data into session_storage inside a key called 'user_info'
    const data = await conn.json();
    sessionStorage.setItem('user_info', JSON.stringify(data));

    // Depending on user_role, from the recieved data in the console, redirect the user to each of the pages (permission-access)
    switch (data.user_role) {
      case 'admin':
        location.href = "../views/admin.php";
        break;
      case 'partner':
        location.href = "../views/partner.php";
        break;
      case 'user':
        location.href = "../views/user.php";
        break;
    }

    // If error occurs during the login, send back error-message
  } catch (error) {
    alert('Invalid email or password');
    console.error("Login error:", error.message);
  }
}

// ##########################################################################################

// LOGOUT //////////////

// When logging out, clear the session-storage for data, and redirect to the logout-page (which is redirecting to the login page)
function logout() {
  sessionStorage.clear();
  
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

function deleteUser() {

  // Ask for confirmation (Double checking before confirming)
  var isConfirmed = confirm('Are you sure you want to delete your profile?');

  if (isConfirmed) {
    // Make an asynchronous request to the delete-user API
    fetch(`/api/api-delete-user.php`, {
      method: 'POST'  // Method is set as 'GET' in default (most commonly used HTTP-method) ... and we're using POST
    })
    .then(response => {

      if (response.ok) {

        // User deleted successfully
        alert('User deleted successfully');
        sessionStorage.clear();
        location.href="../views/logout.php" // Redirects to the home page

      } else {
        // Handle error
        alert('Failed to delete user');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  } else {
    // If not confirmed, do nothing or provide feedback to the user
    console.log('Delete canceled');
  }
}

// function confirmDelete(id) {
//   // Call the deleteUser function directly
//   deleteUser();
// }


// ##########################################################################################


// Unnesseary code – not linked to anything

// function show_page(page_id){
//     // Hide all the pages
//     __(".page").forEach( page => {
//       page.classList.add("hidden")
//     })
//     // Show the one with the id
//     _("#"+page_id).classList.remove("hidden")
//   }


// ##########################################################################################

