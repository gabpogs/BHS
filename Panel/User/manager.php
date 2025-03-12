<?php 
    session_start();
    require_once '../../include/config.php';

    if (isset($_POST['save'])){
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        if (isset($_POST['role_select'])){
            $role = strtolower($_POST['role_select']);
        }else{
            $role = strtolower($_POST['role_backup']);
        }
  
        $status = strtolower($_POST['status_select']);
        $achievement = $_POST['achievement'];

        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $check_email = $stmt->get_result();

        if ($check_email->num_rows > 0){
            $_SESSION['status-user'] = 'Email already exists';
            header("Location: ./Panel.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $username, $id);
        $stmt->execute();
        $check_username = $stmt->get_result();
        if ($check_username->num_rows > 0){
            $_SESSION['status-user'] = 'Username already exists';
            header("Location: ./Panel.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0){
            $user_data = $result->fetch_assoc();
            if(!empty($user_data)){
                $conn->query("UPDATE users SET username = '$username', email = '$email', role = '$role', status = '$status', achievement = '$achievement' WHERE id = '".$user_data['id']."'");
            }
        }
        header("Location: ./Panel.php");
        exit();
    }

    if (isset($_POST['eradicate'])){
        $id = $_POST['id'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            $conn->query("DELETE FROM `users` WHERE id = '$id'");    
        }
        header("Location: ./Panel.php");
        exit();
    }
?>