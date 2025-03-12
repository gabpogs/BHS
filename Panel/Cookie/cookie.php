<?php 
    session_start();
    require_once '../../include/config.php';

    if (isset($_POST['generate'])){
        $cookie = $_POST['cookie'];
        $role_select = strtolower($_POST['role_select']);

        $stmt = $conn->prepare("SELECT * FROM cookies WHERE cookie = ?");
        $stmt->bind_param("s", $cookie);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows <= 0){
            if(!empty($cookie)){
                $conn->query("INSERT INTO cookies(cookie, role) VALUES ('$cookie', '$role_select')");
                $_SESSION['status-cookie'] = 'Cookie made : '.$cookie;
                header("Location: ./Panel.php");
                exit();
            }else{
                $_SESSION['status-cookie'] = 'Cookie not found';
                header("Location: ./Panel.php");
                exit();
            }
        }else{
            $_SESSION['status-cookie'] = 'Cookie already exists';
            header("Location: ./Panel.php");
            exit();
        }


        $_SESSION['status-cookie'] = 'Email or Password is not correct!';
        header("Location: ./Panel.php");
        exit();
    }
?>