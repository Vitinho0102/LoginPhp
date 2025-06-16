<?php
include("connection.php");
session_start();
$msg='';
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $select1 = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
    $select_user = mysqli_query($conn,$select1);
    if(mysqli_num_rows($select_user)>0){
        $row1 = mysqli_fetch_assoc($select_user);
        if($row1['user_type'] == 'user'){
            $_SESSION['user']=$rowq['email'];
            $_SESSION['id']=$row1['id'];
            header('location:user.php');
        }
        elseif($row1['user_type'] == 'admin'){
            $_SESSION['admin']=$rowq['email'];
            $_SESSION['id']=$row1['id'];
            header('location:admin.php');
        }
        else{
            $msg= "incorrect email and password";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <button class="theme-toggle" aria-label="Toggle theme">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/>
        </svg>
    </button>
    <div class="form">
        <form action="" method="post">
            <h2>Registration</h2>
            <p class="msg"></p>
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter your password" class="form-control" required>
            </div>
            <button class="btn font-weight-bold" name="submit">Login Now</button>
            <p>Don't have an Account? <a href="register.php">register Now</a></p>
        </form>
    </div>
    <script src="js/theme.js"></script>
</body>
</html>
