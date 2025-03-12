<?php 
  session_start();

  if(!isset($_SESSION['log-email'])){
    session_unset();
    header("Location: ../../Login_Form/index.php");
    exit();
  }
  
  if(!isset($_SESSION['log-role'])){
    session_unset();
    header("Location: ../../Login_Form/index.php");
    exit();
  }

  if($_SESSION['log-role'] == 'client'){
    header("Location: ../../Main/home.php");
    exit();
  }

  function generateCode() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Uppercase letters & numbers
    $groups = [];

    for ($i = 0; $i < 4; $i++) { // Generate 4 groups
        $group = '';
        for ($j = 0; $j < 5; $j++) { // Each group has 5 characters
            $randomIndex = rand(0, strlen($characters) - 1);
            $group .= $characters[$randomIndex];
        }
        $groups[] = $group;
    }

    return implode('-', $groups); // Join groups with hyphens
  }

  function showEditForm($id){
    echo 'console.log("'.$id.'");';
  }
  
  function adminOption($role){
    if ($role == "head admin"){
      return '';
    }else{
      return 'disabled';
    }
  }

  function inputEditableOption($role){
    if ($role == "head admin"){
      return '';
    }else{
      return 'readonly';
    }
  }

  require_once '../../include/config.php';

  $result = $conn->query("SELECT * FROM users");

  $status_user = $_SESSION['status-user'] ?? '';

  function showStatus($status){
    if (!empty($status)){
      if($status == "Success!" or $status == "Cookie!"){
        return "<p class='success-box my-3'>$status</p>";
      }else{
        echo '<script>console.log("'.$status.'")</script>';
        return "<p class='error-box my-3'>$status</p>";
      }
    }

    return '';
  }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../../ImageSource/bhs_icon.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="panel.css"/>
</head>

<body class="">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
    <div class="container-fluid">
      <a class="nav-link text-white" aria-current="page" href="../../Main/home.php"><?= strtoupper($_SESSION['log-email']) ?></a>

      <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="">PANEL</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="../../include/logout.php">LOGOUT</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <main class="container mt-5 pt-5 accordion">
    <div class="form d-flex justify-content-between">
      <table>
        <td>
           <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='../Cookie/Panel.php'"><</button>
       </td>
       <td class="px-2 align-bottom">
        <a href="Panel.php"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="Grey" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
          <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.8 6.8 0 0 0 1.16 8z"/>
          <path d="M6.641 11.671V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352zm0-3.75V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324z"/>
        </svg>
        </a>
       </td>
       <td class="align-bottom px-2">
        <small class="fw-semibold lh-1 m-0 align-self-end">// USER LIST</small>
       </td>
      </table>
      <p class="d-inline fw-bold fs-6 p-0 m-0 lh-1 align-self-end" id="TimeDateLabel"></p>
    </div>

    <!-- EDIT -->
    <div class="modal fade" id="editCookie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="editModalLongTitle">EDIT COOKIE : 2</h5>
          </div>
          <form action="./manager.php" method="post">
            <small class="form m-0 mx-3 d-block text-danger fs-lighter" id="self-data-warn">*warning: this is your account data</small>
            <input name="id" id="edit_id" class="d-none">
            <input name="role_backup" id="role_backup" class="d-none">
            <div class="modal-body form">
              <p class='error-box mb-3 d-none' id="status-box" style="
                border: 1px solid rgba(0, 0, 0, 0.13);
                background-color: rgba(255, 0, 0, 0.1);
                border-radius: 10px;
                padding: 10px 15px;
              ">Please select a role</p>

              <div class="form-floating mb-3">
                <input name="username" type="text" class="form-control" id="edit_username" placeholder="INPUT USERNAME" value="">
                <label for="username">USERNAME</label>
              </div>

              <div class="form-floating mb-3">
                <input name="email" type="email" class="form-control" id="edit_email" placeholder="INPUT EMAIL" value="">
                <label for="email">EMAIL</label>
              </div>

              <div class="form-floating mb-3">
                <input name="password" type="text" class="form-control" id="edit_password" placeholder="INPUT PASSWORD" value="" readonly>
                <label for="password">PASSWORD</label>
              </div>
              
              <select name="role_select" <?= adminOption($_SESSION['log-role']); ?>  class="form-select p-2 mb-3" id="edit_role" aria-label="Default select example" require>
                <option value="1">CLIENT</option>
                <option value="2">ADMIN</option>
                <option value="3">HEAD ADMIN</option>
              </select>

              <select name="status_select" class="form-select p-2 mb-3" id="edit_status" aria-label="Default select example" require>
                <option selected disabled>-- ACCOUNT STATUS --</option>  
                <option value="1">ENABLED</option>
                <option value="2">DISABLED</option>
              </select>

              <div class="form-floating mb-3">
                <input name="achievement" type="text" class="form-control" id="edit_achievement" placeholder="ACHIEVEMENT" value="">
                <label for="achievement">ACHIEVEMENT LEVEL</label>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger" name="eradicate">Delete</button>
              <button type="submit" class="btn btn-primary" name="save">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <?= showStatus($status_user); ?>

    <table id="example" class="table table-responsive table-demir mt-3" id="shadow-box" style="">
        <thead>
            <tr>
              <th>ID</th>
              <th>USERNAME</th>
              <th>EMAIL</th>
              <th>PASSWORD</th>
              <th>ROLE</th>
              <th>STATUS</th>
              <th>LEVEL</th>
              <th>EDIT<th>
            </tr>
        </thead>
        <tbody>
            <?php 
              if ($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                  echo '
                    <tr class="">
                      <td class="align-middle" name="id_label">'.$row['id'].'</td>
                      <td class="align-middle">'.strtoupper($row['username']).'</td>
                      <td class="align-middle">'.strtoupper($row['email']).'</td>
                      <td class="align-middle">[-- PRIVACY --]</td>
                      <td class="align-middle">'.strtoupper($row['role']).'</td>
                      <td class="align-middle">'.strtoupper($row['status']).'</td>
                      <td class="align-middle">'.strtoupper($row['achievement']).'</td>
                      <td class="align-middle w-15 m-0 p-0"> 
                      <button class="btn btn-outline-warning btn-sm  w-75 p-0" style="display: block;" data-bs-toggle="modal" 
                      data-bs-target="#editCookie" 
                      data-id="'.$row['id'].'" 
                      data-username="'.$row['username'].'" 
                      data-email="'.$row['email'].'" 
                      data-password="*********" 
                      data-role="'.$row['role'].'" 
                      data-status="'.$row['status'].'" 
                      data-achievement="'.$row['achievement'].'">
                          CONFIG
                      </button>
                      </td>
                    </tr>
                  ';
                }
              }else{
                echo '
                <tr>
                  <td class="align-middle">NULL</td>
                  <td class="align-middle">NULL</td>
                  <td class="align-middle">NULL</td>
                  <td class="align-middle">NULL</td>
                  <td class="align-middle">NULL</td>
                  <td class="align-middle">NULL</td>
                  <td class="align-middle">NULL</td>
                  <td class="align-middle"><button>EDIT</button></td>
                </tr>
                ';
              }
            ?>
        </tbody>
        <tfoot>
            <tr>
              <th>ID</th>
              <th>USERNAME</th>
              <th>EMAIL</th>
              <th>PASSWORD</th>
              <th>ROLE</th>
              <th>STATUS</th>
              <th>LEVEL</th>
              <th>EDIT<th>
            </tr>
        </tfoot>
    </table>
    
  </main>
  
  <?php 
    unset($_SESSION['status-user']);
  ?>

  <script src="offcanvas.js"></script>
            
  <script>

  document.addEventListener("DOMContentLoaded", function () {
      var modalElement = document.getElementById('editCookie'); // Get the modal element
      var myModal = new bootstrap.Modal(modalElement); // Create Bootstrap modal instance

      modalElement.addEventListener('show.bs.modal', function (event) { // Attach event to modal element
          var button = event.relatedTarget; // Button that triggered the modal
          if (button) {
            var userId = button.getAttribute('data-id');              
            var userUsername = button.getAttribute('data-username');  
            var userEmail = button.getAttribute('data-email');
            var userPassword = button.getAttribute('data-password');
            var userRole = button.getAttribute('data-role');
            var userStatus = button.getAttribute('data-status');
            var userAchievement = button.getAttribute('data-achievement');
            
            if (userEmail == "<?= $_SESSION['log-email'] ?>"){
              document.getElementById('self-data-warn').classList.remove('d-none');
            }else{
              document.getElementById('self-data-warn').classList.add('d-none');
            }

            // Fill modal fields
            document.getElementById('editModalLongTitle').innerHTML = "EDIT USER - ID: "+userId;              document.getElementById('edit_id').value = userId;
            document.getElementById('edit_username').value = userUsername;
            document.getElementById('edit_email').value = userEmail;
            document.getElementById('edit_password').value = userPassword;
            //document.getElementById('edit_role').value = userRole == "admin" ? "2" : "1";
            if (userRole == "head admin"){
              document.getElementById('edit_role').value = "3";
              document.getElementById('role_backup').value = "head admin";
            }else if(userRole == "admin"){
              document.getElementById('edit_role').value = "2";
              document.getElementById('role_backup').value = "admin";
            }else{
              document.getElementById('edit_role').value = "1";
              document.getElementById('role_backup').value = "client";
            }
            document.getElementById('edit_status').value = userStatus == "enabled" ? "1" : "2";
            document.getElementById('edit_achievement').value = userAchievement;
          }
      });
  });

  function updateDateTime() {
  const now = new Date();

  // Get the date in the format: MM/DD/YYYY
  const date = now.toLocaleDateString('en-US');

  // Get the time in the format: hh:mm AM/PM
  const time = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

  // Set the formatted date and time to the TimeDateLabel
  document.getElementById('TimeDateLabel').textContent = `LAST UPDATE: ${date} - ${time}`;
  }

  function validateForm() {
    var roleSelect = document.querySelector('select[name="role_select"]');
    var selectedValue = roleSelect.value;
    var statusBox = document.getElementById('status-box');

    // Check if a valid role is selected
    if (selectedValue === "1" || selectedValue === "2" || selectedValue === "3") {
      return true; // Allow form submission
    } else {
      // Show the status-box error message
      statusBox.classList.remove('d-none');
      return false; // Prevent form submission
    }
  }

  updateDateTime();
  </script>
</body>

</html>