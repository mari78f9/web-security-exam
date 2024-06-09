<button class="dashboard-button" id="dashboard-profile">
  <img src="/images/profile-light.png" alt="Profile"> <br>
  <h2> View Profile </h2>
</button>

<!-- Admin -->
<?php if ($user['role_id_fk'] === 4): ?>

<button class="dashboard-button" id="dashboard-users">
  <img src="/images/users-light.png" alt="Users"> <br>
  <h2> View Users </h2>
</button>

<button class="dashboard-button" id="dashboard-new-case">
  <img src="/images/case-light.png" alt="Case"> <br>
  <h2 href=""> Search Users </h2>
</button>

<button class="dashboard-button" id="dashboard-cases">
  <img src="/images/cases-light.png" alt="Cases"> <br>
  <h2> View Cases </h2>
</button>

<button class="dashboard-button" id="dashboard-new-case">
  <img src="/images/case-light.png" alt="Case"> <br>
  <h2 href=""> Search Cases </h2>
</button>

<button class="dashboard-button" id="dashboard-new-case">
  <img src="/images/case-light.png" alt="Case"> <br>
  <h2 href=""> Create Case </h2>
</button>

<button class="dashboard-button" id="dashboard-users">
  <img src="/images/users-light.png" alt="Tip"> <br>
  <h2> Add Tip </h2>
</button>

<button class="dashboard-button" id="dashboard-users">
  <img src="/images/users-light.png" alt="Tip"> <br>
  <h2> File Upload </h2>
</button>

<button class="dashboard-button" id="dashboard-file">
  <img src="/images/file-light.png" alt="File"> <br>
  <h2> File Registry </h2>
</button>

<!-- Detective -->
<?php elseif ($user['role_id_fk'] === 1): ?>

<button class="dashboard-button" id="dashboard-users">
  <img src="/images/users-light.png" alt="Tip"> <br>
  <h2> Add Tip </h2>
</button>

<button class="dashboard-button" id="dashboard-users">
  <img src="/images/users-light.png" alt="Tip"> <br>
  <h2> File Upload </h2>
</button>

<button class="dashboard-button" id="dashboard-file">
  <img src="/images/file-light.png" alt="File"> <br>
  <h2> File Registry </h2>
</button>

<button class="dashboard-button" id="dashboard-cases">
  <img src="/images/cases-light.png" alt="Cases"> <br>
  <h2> View Cases </h2>
</button>

<!-- Lawyer -->
<?php elseif ($user['role_id_fk'] === 2): ?>

<button class="dashboard-button" id="dashboard-file">
  <img src="/images/file-light.png" alt="File"> <br>
  <h2> File Registry </h2>
</button>

<button class="dashboard-button" id="dashboard-cases">
  <img src="/images/cases-light.png" alt="Cases"> <br>
  <h2> View Cases </h2>
</button>

<!-- Citizen -->
<?php elseif ($user['role_id_fk'] === 3): ?>

<button class="dashboard-button" id="dashboard-cases">
  <img src="/images/cases-light.png" alt="Cases"> <br>
  <h2> View Cases </h2>
</button>

<?php endif; ?>