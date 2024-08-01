<?php
require 'config/function.php';
session_start();

if(isset($_POST['loginBtn'])){
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    // if no 1 check if email or password is empty
    if($email!= "" && $password!=""){
            $query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
            $result = mysqli_query($conn, $query);

            //if no 2 for checking if result has a value
            if($result){
                //if no 3 checks if result returned a value
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['email'] = $row['email'];
                    $hashedPassword = $row['password'];
                    //if no 4 checks if password is valid
                    if(!password_verify($password, $hashedPassword)){
                        redirect('login.php','Invalid email or password');
                    }
                    //if no 5 checks if account is deactivated
                    $_SESSION['loggedInside'] = true;
                    $_SESSION['loggedInsideUser'] = [
                        'user_id'=> $row['user_id'],
                        'name'=> $row['name'],
                        'email'=> $row['email'],
                        'phone'=> $row['phone'],
                    ];
                    redirect('index.php','');

                }else{//else of if no 3
                    redirect("login.php","Invalid email or password");
                }

            }else{//else of if no 2
                redirect("login.php","Something went wrong");
            }

    }else{// else of first if statement no 1
        redirect("login.php","All fields are required");
    }
}

//this block contains code for registering users
if(isset($_POST["register"])){ //if the 'Save' button in user-create.php is clicked
    $name = validate($_POST["name"]);
    $email = validate($_POST["email"]);
    $password = validate($_POST["password"]);
    $phone = validate($_POST["phone"]);

    if($name != "" && $email != "" && $password!=""){
        $emailCheck = mysqli_query($conn,"SELECT * FROM user WHERE email='$email'" );
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect("register.php", "Email is taken by another user");//redirect is a function found in config/function.php
        }
    }
    $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

    $data = [
        'name' => $name,
        'email'=> $email,
        'password' => $bcrypt_password,
        'phone' => $phone,
        ];
        $result = insert('user', $data);//inserts data using the insert function defined in config/function.php
        if($result){
            redirect("login.php", "Account created successfully");
        }else{
            redirect("register.php", "Oops Something went wrong.");
        }

    }else{
        redirect("register.php", "Please fill all the required fields");
    }
}