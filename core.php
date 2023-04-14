<?php

include "connection.php";

if (isset($_POST['btn_register']))
    {
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password']))
        {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (full_name, username, password)VALUES (?,?,?)";

            // Create a prepared Statement
            $stmt=mysqli_stmt_init($con);

            if(!mysqli_stmt_prepare($stmt,$sql))
            {
                echo "SQL Statement Failed.";
                echo "Yes";
                return;
            }else
            {
                mysqli_stmt_bind_param($stmt, "sss", $fullname, $username, $password);

                mysqli_stmt_execute($stmt);
            }
            
        }
      else
         {
            echo "ERROR!";
         }

    }

    if(isset($_POST['btn_login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * from user where username = ? ";

        $stmt=mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            echo "SQL Statement Failed.";
            return;
        }else
        {
              mysqli_stmt_bind_param($stmt, "s",$username);
              mysqli_stmt_execute($stmt);

             $result = mysqli_stmt_get_result($stmt);
         if(mysqli_num_rows($result) != NULL)
             {
                $row = mysqli_fetch_assoc($result);
                var_dump($row);
                $dbpassword = $row['password'];

                if(password_verify($password , $dbpassword) == TRUE)
                {
                
                    $_SESSION['signin_success'] = "signin_success";
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['fullname'] = $row['full_name'];   
                    $_SESSION['password'] = $row['password'];   

                    header("Location: out.php");
                }else{
                    echo "sorry";
                    return;
                }
             }
        }

    //     if (mysqli_num_rows($result_login)> 0)
    //     {
    //         $row = mysqli_fetch_array($result_login, MYSQLI_ASSOC);
    //        if(password_verify($password, $row['password']))
    //        {
    //         // echo "SUCCESFULLY LOGIN..";
    //         Header("Location: dashboard.php");
    //        }
       
    //   else
    //         {
    //         echo "UNKNOWN ACCOUNT";
    //         }
    //     }

    }
?>
