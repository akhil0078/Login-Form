<?php 
session_start();

include('./dbcon.php');

    if(isset($_POST['login_now_btn']))
    {
        // All fields are required 
        if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) 
        {
            $email = mysqli_real_escape_string($con,$_POST['email']);
            $password = mysqli_real_escape_string($con,$_POST['password']);
            $salt = "codehunt";
            $password_encrypted = sha1($password.$salt);

            // match username and password from database
            $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password_encrypted' LIMIT 1";
            $login_query_run = mysqli_query($con, $login_query);

                if(mysqli_num_rows($login_query_run) > 0)
                {
                    $row = mysqli_fetch_array($login_query_run);
                    echo $row['verify_status'];

                    if($row['verify_status'] == "1")
                    {
                            if($row['active_status'] == "1")
                            {
                                $_SESSION['authenticated'] = TRUE;
                                
                                if($row['user_type'] == "admin")
                                {
                                $_SESSION['status'] = "Admin logged in successfully.";
                                header('Location: dashboard.php');
                                exit(0);
                                }
                                elseif($row['user_type'] == "user")
                                {
                                    $_SESSION['status'] = "User logged in successfully.";
                                    header('Location: index.php');
                                    exit(0);
                                }
                                else
                                {
                                    $_SESSION['status'] = "Email / Password is Invalid";
                                    header('Location: login.php');
                                    exit(0);
                                }
                            }
                            else
                            {
                                $_SESSION['status'] = "Your account has been disabled.";
                                header('Location: login.php');
                                exit(0);
                            }
                    }
                    else
                    {
                        $_SESSION['status'] = "Please verify your email address to login.";
                        header("Location: login.php");
                        exit(0);
                    }
                }
                else
                {
                    $_SESSION['status'] = "Invalid Email or Password.";
                    header("Location: login.php");
                    exit(0);
                }
        }
        else
        {
            $_SESSION['status'] = "Please fill all the fields.";
            header("Location: login.php");
            exit(0);
        }
    }
?>




