<?php 
  session_start();

  if(!isset($_SESSION['log-email'])){
    header("Location: ../Login_Form/index.php");
    session_unset();
    exit();
  }

  if(!isset($_SESSION['log-role'])){
    header("Location: ../Login_Form/index.php");
    session_unset();
    exit();
  }

  function isAdminForm($role){
    if (!empty($role)){
      if ($role == 'admin' or $role == 'head admin'){
        return '<li class="nav-item">
            <a class="nav-link" href="../Panel/Cookie/Panel.php">PANEL</a>
          </li>';
      }
    }

    return '';
  }
?>
<!-- <source src="video.mov" type="video/quicktime"> -->
<!DOCTYPE html>
<html>

<head>
  <link href="home.css" rel="stylesheet" />

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../ImageSource/bhs_icon.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
    <div class="container-fluid">
      <a class="text-white active nav-link" aria-current="page" href="../Main/home.php"><?= strtoupper($_SESSION['log-email']) ?></a>

      <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?= isAdminForm($_SESSION['log-role']); ?>
          <li class="nav-item">
            <a class="nav-link text-danger" href="../include/logout.php">LOGOUT</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <main class="container pt-5 mt-3 accordion">
    <!--COURSES-->
    <div class="my-3 shadow-box p-3 bg-body rounded shadow-l card rounded-2">
      <button class="btn-primary border-bottom rounded-2 d-flex justify-content-between " id="courseOne"
        data-bs-toggle="collapse" data-bs-target="#collapseOne">
        <small class=" fw-bold">WHAT IS HYDROPONICS</small>
        <small class=" fw-light text-success">ONGOING</small>
      </button>

      <div id="collapseOne" class="collapse" aria-labelledby="courseOne" data-parent="#accordion">
      <div class="ratio ratio-16x9">
         <video controls>
         <source src="../videos/course1.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
      </div>
        
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
            xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
            preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#e83e8c" /><text x="50%" y="50%" fill="#e83e8c"
              dy=".3em">32x32</text>
          </svg>

          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@username</strong>
            Some more representative placeholder content, related to this other user. Another status update, perhaps.
          </p>
        </div>
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
            xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
            preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#6f42c1" /><text x="50%" y="50%" fill="#6f42c1"
              dy=".3em">32x32</text>
          </svg>

          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@username</strong>
            This user also gets some representative placeholder content. Maybe they did something interesting, and you
            really want to highlight this in the recent updates.
          </p>
        </div>

        <small class="d-block text-end mt-3">
          PROGRESS: 3/3
        </small>
      </div>
    </div>

    <div class="my-3 shadow-box p-3 bg-body rounded shadow-l card rounded-2">
      <button class="btn-primary border-bottom rounded-2 d-flex justify-content-between " id="courseOne"
        data-bs-toggle="collapse" data-bs-target="#collapseTwo">
        <small class=" fw-bold">COURSE 2</small>
        <small class=" fw-light text-danger">INCOMPLETE</small>
      </button>

      <div id="collapseTwo" class="collapse" aria-labelledby="courseTwo" data-parent="#accordion">
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
            xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
            preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff"
              dy=".3em">32x32</text>
          </svg>

          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@username</strong>
            Some representative placeholder content, with some information about this user. Imagine this being some sort
            of status update, perhaps?
          </p>
        </div>
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
            xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
            preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#e83e8c" /><text x="50%" y="50%" fill="#e83e8c"
              dy=".3em">32x32</text>
          </svg>

          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@username</strong>
            Some more representative placeholder content, related to this other user. Another status update, perhaps.
          </p>
        </div>
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
            xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
            preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#6f42c1" /><text x="50%" y="50%" fill="#6f42c1"
              dy=".3em">32x32</text>
          </svg>

          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@username</strong>
            This user also gets some representative placeholder content. Maybe they did something interesting, and you
            really want to highlight this in the recent updates.
          </p>
        </div>

        <small class="d-block text-end mt-3">
          PROGRESS: 0/3
        </small>
      </div>
    </div>
    
    <div class="my-3 shadow-box p-3 bg-body rounded shadow-l card rounded-2">
      <button class="btn-primary border-bottom rounded-2 d-flex justify-content-between " id="courseThree"
        data-bs-toggle="collapse" data-bs-target="#collapseThree">
        <small class=" fw-bold">WHAT IS HYDROPONICS</small>
        <small class=" fw-light text-success">ONGOING</small>
      </button>

      <div id="collapseThree" class="collapse" aria-labelledby="courseThree" data-parent="#accordion">
      <div class="ratio ratio-16x9">
         <video controls>
         <source src="../videos/course1.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
      </div>
        
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
            xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
            preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#e83e8c" /><text x="50%" y="50%" fill="#e83e8c"
              dy=".3em">32x32</text>
          </svg>

          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@username</strong>
            Some more representative placeholder content, related to this other user. Another status update, perhaps.
          </p>
        </div>
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
            xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
            preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#6f42c1" /><text x="50%" y="50%" fill="#6f42c1"
              dy=".3em">32x32</text>
          </svg>

          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@username</strong>
            This user also gets some representative placeholder content. Maybe they did something interesting, and you
            really want to highlight this in the recent updates.
          </p>
        </div>

        <small class="d-block text-end mt-3">
          PROGRESS: 3/3
        </small>
      </div>
    </div>
  </main>

  <script src="offcanvas.js"></script>
</body>

</html>