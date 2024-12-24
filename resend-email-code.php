<?php
session_start();
include('./dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Symfony\Component\Dotenv\Dotenv;

// Load composer autoloader 
require './vendor/autoload.php';


function resend_verify_email($name, $email, $verify_token)
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

            $mail->setFrom('akhilrana7874@gmail.com', $name);           
            $mail->addAddress($email);

            $mail->isHTML(true);
            // $mail->addAddress('$email', 'Name');
            $mail->Subject = "Resend - Verification email from webspace";
            
            $email_template = "
            <h2>You have registered with Webspace</h2>
            <p>Verify your email address to Login with the given below link:</p>
            <a href='$URI/verify-email.php?token=$verify_token'>Click here</a>";

            $mail->Body = $email_template;
            $mail->send();
            // echo "Mail has been sent successfully!";
    }

    if(isset($_POST['resend_email_btn']))
    {
        if(!empty(trim($_POST['email'])))
        {
            $email = mysqli_real_escape_string($con,$_POST['email']);

            $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
            $checkemail_query_run = mysqli_query($con, $checkemail_query);

            if(mysqli_num_rows($checkemail_query_run) > 0)
            {
                $row = mysqli_fetch_array($checkemail_query_run);

                if($row['verify_status'] == "0")
                {
                    $name = $row['name'];
                    $email = $row['email'];
                    $verify_token = $row['verify_token'];  

                    resend_verify_email($name,$email,$verify_token);

                    $_SESSION['status'] = "Verification link has been sent to your email address.";
                    header("Location: login.php");
                    exit(0);

                }
                else
                {
                    $_SESSION['status'] = "Email already verified. Please login.";
                    header("Location: resend-verification-email.php");
                    exit(0);
                }
            }
            else
            {
                $_SESSION['status'] = "Email Id is not registered. Please register now.";
                header("Location: register.php");
                exit(0);
            }


        }
        else 
        {
            $_SESSION['status'] = "Please enter the email address.";
            header("Location: resend-verification-email.php");
            exit(0);
        }        
    }


?>