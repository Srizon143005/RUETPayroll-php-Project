<?php
    ob_start();
    require_once('db.php');
    session_start();
    $msg = null;
    $error = null;

    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $sign_type = $_POST['sign_type'];
        
        $q = "SELECT * FROM employee WHERE emp_email='$email' AND emp_password='$password'";
        $run = mysqli_query($con, $q);
        if(empty($email) || empty($password)){
            $error = "Please fill up all the required (*) attributes.";
        }
        else if(mysqli_num_rows($run)>0){
            if($sign_type == "Admin")
                header('Location: admin.php');
            else
                header('Location: my-details.php');
            $_SESSION['emp_email'] = $email;
            $_SESSION['emp_password'] = $password;
            $_SESSIOM['emp_role'] = $type;
        }
        else{
            $error = "Wrong Email or Password. Check Again.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/agenda.png">
    <title>RUET Payroll Admin</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/demo-documentation.css">
    <link rel="stylesheet" href="css/material-dashboard.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">RUET Payroll Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">

            </ul>
            <div class="my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php">Sign In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section style="margin-top: 20px;"></section>
    
    <form action="login.php" method="post">
        <legend>
            <center>RUET Payroll Sign In</center>
        </legend>
        <fieldset>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <?php if($error != null){ ?>
                    <div class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $error; ?>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="">Email address: *</label>
                        <input value="<?php if($error != null){echo $email;} ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">Password: *</label>
                        <input value="<?php if($error != null){echo $password;} ?>" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="">Sign In As: *</label>
                        <select class="form-control" id="exampleSelect1" name="sign_type">
                            <?php
                                if($error != null){
                                    if($sign_type == "Admin"){
                            ?>
                            <option value="Admin">Adminstrator</option>
                            <option value="Guest">Guest</option>       
                            <?php
                                    }
                                    else{
                            ?>
                            <option value="Guest">Guest</option>
                            <option value="Admin">Adminstrator</option>
                            <?php       
                                    }
                                }
                                else{
                            ?>
                            <option value="Guest">Guest</option>
                            <option value="Admin">Adminstrator</option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="float: right;" name="submit">Sign In</button>
                </div>
                <div class="col-md-4"></div>
            </div>
        </fieldset>
    </form>

    <section style="margin-top: 65px;"></section>

    <footer style="background: #2C3E50; height: 50px; color: white; padding: 12px;" class="fixed-bottom">
        <center>Copyright @RUET Payroll 2017-2020</center>
    </footer>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.12.4.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
</body>

</html>
