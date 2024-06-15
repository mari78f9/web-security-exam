<a href="/views/view-profile.php">
  <button class="dashboard-button" id="dashboard-profile">
    <img src="/images/profile-light.png" alt="Profile"> <br>
    <p> View Profile </p>
  </button>
</a>

<!-- Admin -->
<?php if ($user['role_id_fk'] === 4): ?>

<a href="/views/users.php">
  <button class="dashboard-button" id="dashboard-users">
    <img src="/images/users-light.png" alt="Users"> <br>
    <p> View Users </p>
  </button>
</a>

<a href="/views/cases.php">
  <button class="dashboard-button" id="dashboard-cases">
    <img src="/images/cases-light.png" alt="Cases"> <br>
    <p> View Cases </p>
  </button>
</a>

<a href="/views/tip.php">
  <button class="dashboard-button" id="dashboard-users">
    <img src="/images/add-light.png" alt="Tip"> <br>
    <p> Add Tip </p>
  </button>
</a>

<a href="/views/files.php">
  <button class="dashboard-button" id="dashboard-file">
    <img src="/images/file-light.png" alt="File"> <br>
    <p> File Registry </p>
  </button>
</a>

<!-- Detective -->
<?php elseif ($user['role_id_fk'] === 1): ?>

<a href="/views/cases.php">
  <button class="dashboard-button" id="dashboard-cases">
    <img src="/images/cases-light.png" alt="Cases"> <br>
    <p> View Cases </p>
  </button>
</a>

<a href="/views/tip.php">
  <button class="dashboard-button" id="dashboard-users">
    <img src="/images/add-light.png" alt="Tip"> <br>
    <p> Add Tip </p>
  </button>
</a>

<a href="/views/files.php">
  <button class="dashboard-button" id="dashboard-file">
    <img src="/images/file-light.png" alt="File"> <br>
    <p> File Registry </p>
  </button>
</a>

<!-- Lawyer -->
<?php elseif ($user['role_id_fk'] === 2): ?>

<a href="/views/cases.php">
  <button class="dashboard-button" id="dashboard-cases">
    <img src="/images/cases-light.png" alt="Cases"> <br>
    <p> View Cases </p>
  </button>
</a>

<a href="/views/files.php">
  <button class="dashboard-button" id="dashboard-file">
    <img src="/images/file-light.png" alt="File"> <br>
    <p> File Registry </p>
  </button>
</a>

<!-- Citizen -->
<?php elseif ($user['role_id_fk'] === 3): ?>

<a href="/views/cases.php">
  <button class="dashboard-button" id="dashboard-cases">
    <img src="/images/cases-light.png" alt="Cases"> <br>
    <p> View Cases </p>
  </button>
</a>

<?php endif; ?>