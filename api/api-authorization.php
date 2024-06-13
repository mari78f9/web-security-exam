<a href="/views/view_profile.php">
  <button class="dashboard-button" id="dashboard-profile">
    <img src="/images/profile-light.png" alt="Profile"> <br>
    <h2> View Profile </h2>
  </button>
</a>

<!-- Admin -->
<?php if ($user['role_id_fk'] === 4): ?>

<a href="/views/users.php">
  <button class="dashboard-button" id="dashboard-users">
    <img src="/images/users-light.png" alt="Users"> <br>
    <h2> View Users </h2>
  </button>
</a>

<a href="/views/search-users.php">
  <button class="dashboard-button" id="dashboard-new-case">
    <img src="/images/users-light.png" alt="Case"> <br>
    <h2 href=""> Search Users </h2>
  </button>
</a>

<a href="/views/cases.php">
  <button class="dashboard-button" id="dashboard-cases">
    <img src="/images/cases-light.png" alt="Cases"> <br>
    <h2> View Cases </h2>
  </button>
</a>

<a href="/views/search-cases.php">
  <button class="dashboard-button" id="dashboard-new-case">
    <img src="/images/cases-light.png" alt="Case"> <br>
    <h2 href=""> Search Cases </h2>
  </button>
</a>

<a href="/views/create-case.php">
  <button class="dashboard-button" id="dashboard-new-case">
    <img src="/images/case-light.png" alt="Case"> <br>
    <h2 href=""> Create Case </h2>
  </button>
</a>

<a href="/views/tip.php">
  <button class="dashboard-button" id="dashboard-users">
    <img src="/images/add-light.png" alt="Tip"> <br>
    <h2> Add Tip </h2>
  </button>
</a>

<a href="/views/file-upload.php">
  <button class="dashboard-button" id="dashboard-users">
    <img src="/images/upload-file-light.png" alt="Tip"> <br>
    <h2> File Upload </h2>
  </button>
</a>

<a href="/views/files.php">
  <button class="dashboard-button" id="dashboard-file">
    <img src="/images/file-light.png" alt="File"> <br>
    <h2> File Registry </h2>
  </button>
</a>

<!-- Detective -->
<?php elseif ($user['role_id_fk'] === 1): ?>

<a href="/views/cases.php">
  <button class="dashboard-button" id="dashboard-cases">
    <img src="/images/cases-light.png" alt="Cases"> <br>
    <h2> View Cases </h2>
  </button>
</a>

<a href="/views/tip.php">
  <button class="dashboard-button" id="dashboard-users">
    <img src="/images/add-light.png" alt="Tip"> <br>
    <h2> Add Tip </h2>
  </button>
</a>

<a href="/views/file-upload.php">
  <button class="dashboard-button" id="dashboard-users">
    <img src="/images/upload-file-light.png" alt="Tip"> <br>
    <h2> File Upload </h2>
  </button>
</a>

<a href="/views/files.php">
  <button class="dashboard-button" id="dashboard-file">
    <img src="/images/file-light.png" alt="File"> <br>
    <h2> File Registry </h2>
  </button>
</a>

<!-- Lawyer -->
<?php elseif ($user['role_id_fk'] === 2): ?>

<a href="/views/cases.php">
  <button class="dashboard-button" id="dashboard-cases">
    <img src="/images/cases-light.png" alt="Cases"> <br>
    <h2> View Cases </h2>
  </button>
</a>

<a href="/views/files.php">
  <button class="dashboard-button" id="dashboard-file">
    <img src="/images/file-light.png" alt="File"> <br>
    <h2> File Registry </h2>
  </button>
</a>

<!-- Citizen -->
<?php elseif ($user['role_id_fk'] === 3): ?>

<a href="/views/cases.php">
  <button class="dashboard-button" id="dashboard-cases">
    <img src="/images/cases-light.png" alt="Cases"> <br>
    <h2> View Cases </h2>
  </button>
</a>

<?php endif; ?>