<?php 
    session_start();
    require_once '../../include/config.php';

    if (isset($_POST['save'])){
        $id = $_POST['edit_id'];
        $cookie = $_POST['cookie'];
        $email = $_POST['user'];

        if (isset($_POST['role_select'])){
            $role = strtolower($_POST['role_select']);
        }else{
            $role = strtolower($_POST['role_backup']);
        }

        $stmt = $conn->prepare("SELECT cookie FROM cookies WHERE cookie = ? AND id != ?");
        $stmt->bind_param("si", $cookie, $id);
        $stmt->execute();
        $check_cookie = $stmt->get_result();

        if ($check_cookie->num_rows > 0){
            $_SESSION['status-cookie'] = 'Cookie already exists';
            header("Location: ./Panel.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM cookies WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            $cookie_data = $result->fetch_assoc();
            if(!empty($cookie_data)){
                $conn->query("UPDATE cookies SET cookie = '$cookie', user = '$email', role = '$role' WHERE id = '".$cookie_data['id']."'");
            }
        }
        header("Location: ./Panel.php");
        exit();
    }

    if (isset($_POST['eradicate'])){
        $cookie = $_POST['cookie'];

        $stmt = $conn->prepare("SELECT * FROM cookies WHERE cookie = ?");
        $stmt->bind_param("s", $cookie);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            $conn->query("DELETE FROM `cookies` WHERE cookie = '$cookie'");    
        }
        header("Location: ./Panel.php");
        exit();
    }
?>