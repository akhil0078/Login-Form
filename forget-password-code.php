<?php 
session_start();

include('./dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Symfony\Component\Dotenv\Dotenv;

// Load composer autoloader 
require './vendor/autoload.php';


function send_forget_password($get_name,$get_email,$token)
        {

            $dotenv = new Dotenv();
            $dotenv->loadenv(__DIR__.'/.env');
            
            // You can also load several files
            $dotenv->loadenv(__DIR__.'/.env', __DIR__.'/.env.dev');


            $URI = $_SERVER['URI'];

            $mail = new PHPMailer(true);

            // $mail->SMTPDebug = 2;                                       
            $mail->isSMTP(); 
                                                        
            $mail->SMTPAuth   = true;
                                        
            $mail->Host       = 'smtp.gmail.com;';                    
            $mail->Username   = 'akhilrana7874@gmail.com';                 
            $mail->Password   = 'zamtlacquuleinfc';                        
            $mail->SMTPSecure = 'tls';                              
            $mail->Port       = 587;  

            $mail->setFrom('akhilrana7874@gmail.com', $get_name);           
            $mail->addAddress($get_email);

            $mail->isHTML(true);
            // $mail->addAddress($get_email, $get_name);
            $mail->Subject = "Password reset email from webspace";
            
            $email_template = "
            <p>You are receiving this email beacause we received a password reset request form your account</p>
    
            <a href='$URI/change-password.php?token=$token&email=$get_email'>Click here</a>";

            $mail->Body = $email_template;
            $mail->send();
            // echo "Mail has been sent successfully!";
        }

// forget password 

    if(isset($_POST['forget_password_btn']))
    {
        $email = mysqli_real_escape_string($con,$_POST['email']);
        $token = md5(rand());

        $check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $check_email_run = mysqli_query($con, $check_email);

        if(mysqli_num_rows($check_email_run) > 0)
        {
            $row = mysqli_fetch_array($check_email_run);
            $get_name = $row['name'];
            $get_email = $row['email'];

            $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
            $update_token_run = mysqli_query($con, $update_token);

            if($update_token_run)
            {
                send_forget_password($get_name,$get_email,$token);
                $_SESSION['status'] = "Password reset link has been sent to your email.";
                header("Location: forget-password.php");
                exit(0);
            }
            else
            {
                $_SESSION['status'] = "Something went wrong.";
                header("Location: forget-password.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "No email found.";
            header("Location: forget-password.php");
            exit(0);
        }
    }

    // change password

    if(isset($_POST['change_password_btn']))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
        $salt = "codehunt";
        $new_password_encrypted = sha1($new_password.$salt);
        $confirm_password_encrypted = sha1($confirm_password.$salt);

        $token = mysqli_real_escape_string($con, $_POST['password_token']);

        if(!empty($token))
        {
            if(!empty($email) && !empty($new_password) && !empty($confirm_password))
            {
                // checking token is valid or not
                $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
                $check_token_run = mysqli_query($con, $check_token);

                if(mysqli_num_rows($check_token_run) > 0)
                {
                    if($new_password_encrypted == $confirm_password_encrypted)
                    {
                        $update_password = "UPDATE users SET password='$new_password_encrypted' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($con, $update_password);

                        if($update_password_run)
                        {
                            $new_token = md5(rand());
                            $update_to_new_token = "UPDATE users SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($con, $update_to_new_token);

                            $_SESSION['status'] = "New password successfully updated.";
                            header("Location: login.php");
                            exit(0);
                        }
                        else
                        {
                            $_SESSION['status'] = "Didn't update password. Something went wrong.";
                            header("Location: change-password.php?token=$token&email=$email");
                            exit(0);
                        }

                    }
                    else
                    {
                        $_SESSION['status'] = "Password and confirm password doesn't match.";
                        header("Location: change-password.php?token=$token&email=$email");
                        exit(0);
                    }
                }
                else
                {
                    $_SESSION['status'] = "Invalid token.";
                    header("Location: change-password.php?token=$token&email=$email");
                    exit(0);
                }
            }
            else
            {
                $_SESSION['status'] = "All fields are mandetory.";
                header("Location: change-password.php?token=$token&email=$email");
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "No token available.";
            header("Location: change-password.php");
            exit(0);
        }
    }
?>