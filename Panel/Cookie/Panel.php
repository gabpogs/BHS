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
  
  function getinfo($user) {
    require_once '../../include/config.php';
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    return $user_data;

  }

  require_once '../../include/config.php';

  $result = $conn->query("SELECT * FROM cookies");
  $results = $conn->query("SELECT * FROM users");
  
  if(isset($_SESSION['edit-cookie'])){
    echo 'showEditForm()';
    session_unset($_SESSION['edit-cookie']);
  }

  $status_cookie = $_SESSION['status-cookie'] ?? '';

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
       <!-- Button trigger modal -->
    <div class="form d-flex justify-content-between">
      <table>
        <td>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
            NEW COOKIE
         </button>
       </td>
       <td class="px-2 align-bottom">
        <a href="Panel.php"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="Grey" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
          <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.8 6.8 0 0 0 1.16 8z"/>
          <path d="M6.641 11.671V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352zm0-3.75V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324z"/>
        </svg>
        </a>
       </td>
       <td class="px-0 align-bottom">
        <a href="../User/Panel.php"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="Grey" class="bi bi-person-gear" viewBox="0 0 16 16">
            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
            </svg>
        </a>
       </td>
       <td class="align-bottom px-2">
        <small class="fw-semibold lh-1 m-0 align-self-end">// COOKIE LIST</small>
       </td>
      </table>
      <p class="d-inline fw-bold fs-6 p-0 m-0 lh-1 align-self-end" id="TimeDateLabel"></script></p>
    </div>

    

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">NEW COOKIE</h5>
          </div>
          <form action="./cookie.php" method="post" onsubmit="return validateForm()">
            <div class="modal-body form">
              <p class='error-box mb-3 d-none' id="status-box" style="
                border: 1px solid rgba(0, 0, 0, 0.13);
                background-color: rgba(255, 0, 0, 0.1);
                border-radius: 10px;
                padding: 10px 15px;
              ">Please select a role</p>
              <div class="form-floating mb-3">
                <input name="cookie" type="text" class="form-control" id="floatingInput" placeholder="INPUT COOKIE" value="<?= generateCode() ?>" <?= inputEditableOption($_SESSION['log-role']); ?>>
                <label for="floatingInput">RANDOM COOKIE</label>
              </div>

              <select name="role_select" class="form-select p-2" aria-label="Default select example" require>
                <option selected>--SELECT ROLE--</option>
                <option value="1">CLIENT</option>
                <option value="2" <?= adminOption($_SESSION['log-role']); ?>>ADMIN</option>
                <option value="3" <?= adminOption($_SESSION['log-role']); ?>>HEAD ADMIN</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="generate">Generate</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- EDIT -->
    <div class="modal fade" id="editCookie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLongTitle">EDIT COOKIE : 2</h5>
          </div>
          <form action="./manager.php" method="post">
            <input name="edit_id" id="edit_id" class="d-none">
            <input name="role_backup" id="role_backup" class="d-none">
            <div class="modal-body form">
              <p class='error-box mb-3 d-none' id="status-box" style="
                border: 1px solid rgba(0, 0, 0, 0.13);
                background-color: rgba(255, 0, 0, 0.1);
                border-radius: 10px;
                padding: 10px 15px;
              ">Please select a role</p>
              <div class="form-floating mb-3">
                <input name="cookie" type="text" class="form-control" id="edit_cookie" placeholder="INPUT COOKIE" value="" <?= inputEditableOption($_SESSION['log-role']); ?>>
                <label for="cookie">COOKIE</label>
              </div>

              <div class="form-floating mb-3">
                <input name="user" type="email" class="form-control" id="edit_user" placeholder="INPUT USER" value="">
                <label for="user">USER</label>
              </div>

              <div class="form-floating mb-3">
                <input name="level" type="int" class="form-control" id="edit_level" placeholder="INPUT LEVEL" value="">
                <label for="level">LEVEL</label>
              </div>

              <select name="role_select" <?= adminOption($_SESSION['log-role']); ?> class="form-select p-2" id="edit_role" aria-label="Default select example" require>
                <option value="1">CLIENT</option>
                <option value="2" >ADMIN</option>
                <option value="3" >HEAD ADMIN</option>
              </select>
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
    
    <?= showStatus($status_cookie); ?>

    <table id="example" class="table table-responsive table-demir mt-3" id="shadow-box" style="">
        <thead>
            <tr>
                <th>ID</th>
                <th>COOKIE</th>
                <th>USER</th>
                <th>ROLE</th>
                <th>LEVEL</th>
                <th>EDIT<th>
            </tr>
        </thead>
        <tbody>
            <?php 
              if ($result->num_rows > 0){
                while ($row = $result->fetch_assoc() and $row2 = $results->fetch_assoc()){
                  echo '
                    <tr class="">
                      <td class="align-middle" name="id_label">'.$row['id'].'</td>
                      <td class="align-middle">'.$row['cookie'].'</td>
                      <td class="align-middle">'.strtoupper($row['user']).'</td>
                      <td class="align-middle">'.strtoupper($row['role']).'</td>
                      <td class="align-middle">'.strtoupper($row['level']).'</td>
                      <td class="align-middle w-15 m-0 p-0"> 
                      <button class="btn btn-outline-warning btn-sm  w-75 p-0" style="display: block;" data-bs-toggle="modal" 
                      data-bs-target="#editCookie" data-id="'.$row['id'].'" data-cookie="'.$row['cookie'].'" data-email="'.$row['user'].'" data-role="'.$row['role'].'" data-level="'.$row['level'].'">
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
                  <td class="align-middle"><button>EDIT</button></td>
                </tr>
                ';
              }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>COOKIE</th>
                <th>USER</th>
                <th>ROLE</th>
                <th>LEVEL</th>
                <th>EDIT<th>
            </tr>
        </tfoot>
    </table>
    
  </main>

  <?php 
    unset($_SESSION['status-cookie']);
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
              var userCookie = button.getAttribute('data-cookie');
              var userEmail = button.getAttribute('data-email');
              var userLevel = button.getAttribute('data-level')
              var userRole = button.getAttribute('data-role');

              // Fill modal fields
              document.getElementById('editModalLongTitle').innerHTML = "EDIT COOKIE - ID: "+userId;
              document.getElementById('edit_id').value = userId;
              document.getElementById('edit_cookie').value = userCookie;
              document.getElementById('edit_user').value = userEmail;
              document.getElementById('edit_level').value = userLevel;
              
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