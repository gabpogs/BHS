<?php 
    session_start();
    require_once 'config.php';

    if (isset($_POST['register'])){
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $cookie = $_POST['cookie'];
        $role = 'client';

        $_SESSION['email'] = $_POST['email'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['cpassword'] = $_POST['cpassword'];
        $_SESSION['cookie'] = $_POST['cookie'];

        $_SESSION['activeform'] = 'register';

        $check_email = $conn->query("SELECT email FROM users WHERE email = '$email'");
        if ($check_email->num_rows > 0){
            $_SESSION['status-register'] = 'Email already exists';
            header("Location: ../Login_Form/index.php");
            exit();
        }

        $check_username = $conn->query("SELECT username FROM users WHERE username = '$username'");
        if ($check_username->num_rows > 0){
            $_SESSION['status-register'] = 'Username already exists';
            header("Location: ../Login_Form/index.php");
            exit();
        }

        if ($password !== $cpassword){
            $_SESSION['status-register'] = 'Password and Confirm password does not match';
            header("Location: ../Login_Form/index.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM cookies WHERE cookie = ?");
        $stmt->bind_param("s", $cookie);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            $cookie = $result->fetch_assoc();

            if(empty($cookie['user'])){
                $role = $cookie['role'];
                $conn->query("UPDATE cookies SET user = '$email', level = 1 WHERE cookie = '".$cookie['cookie']."'");
                
            }elseif($cookie['user'] == '-'){
                $role = $cookie['role'];
                $_SESSION['status-register'] = 'Cookie!';
            }else{
                $_SESSION['status-register'] = 'Cookie already used';
                header("Location: ../Login_Form/index.php");
                exit();
            }
        }else{
            $_SESSION['status-register'] = 'Cookie does not exists';
            header("Location: ../Login_Form/index.php");
            exit();
        }

        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        $conn->query("INSERT INTO users(username, email, password, role, status, achievement) VALUES ('$username', '$email', '$hashedpassword', '$role', 'enabled', '1')");
        
        foreach($_SESSION as $key => $val)
        {

            if ($key !== 'status-register')
            {

            unset($_SESSION[$key]);

            }

        }

        if (!isset($_SESSION['status-register'])){
            $_SESSION['status-register'] = 'Success!';
        }
        $_SESSION['activeform'] = 'register';
        header("Location: ../Login_Form/index.php");
        exit();
    }

    if (isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $_SESSION['semail'] = $_POST['email'];
        $_SESSION['spassword'] = $_POST['password'];

        //$result = $conn->query("SELECT * FROM users WHERE email = '$email'");
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<script>console.log('".$result->num_rows."');</script>";

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                if ($user['status'] == 'enabled'){
                    $_SESSION['log-email'] = $user['email'];
                    $_SESSION['log-role'] = $user['role'];
                    header("Location: ../Main/home.php");
                    exit();
                }else{
                    $_SESSION['status-login'] = 'account disabled';
                    header("Location: ../Login_Form/index.php");
                    exit();  
                }
            }
        }


        $_SESSION['status-login'] = 'Email or Password is not correct!';
        header("Location: ../Login_Form/index.php");
        exit();        
    }
?>