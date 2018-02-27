<?php
    ob_start();
    require_once('db.php');
    $msg = null;
    $error = null;
    
    session_start();
    if(!isset($_SESSION['emp_email'])){
        header('Location: login.php');
    }
    else{
        $email = $_SESSION['emp_email'];
        $q = "SELECT * FROM employee WHERE emp_email='$email'";
        $run = mysqli_query($con, $q);
        $row = mysqli_fetch_array($run);
        $role = $row['emp_role'];
        if($role != "Admin"){
            header('Location: login.php');
        }
    }

    if(isset($_POST['submit'])){
        $q = "SELECT * FROM employee ORDER BY emp_no";
        $run = mysqli_query($con, $q);
        if(mysqli_num_rows($run)>0){
            $row = mysqli_fetch_array($run);
            $emp_no = $row['emp_no']+1;
        }
        else{
            $emp_no = 1;
        }
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $designation = $_POST['designation'];
        $role = $_POST['role'];
        $road = mysqli_real_escape_string($con, $_POST['road']);
        $thana = mysqli_real_escape_string($con, $_POST['thana']);
        $city = mysqli_real_escape_string($con, $_POST['city']);
        $district = mysqli_real_escape_string($con, $_POST['district']);
        $division = mysqli_real_escape_string($con, $_POST['division']);
        $zip = mysqli_real_escape_string($con, $_POST['zip']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        
        $q = "SELECT * FROM employee WHERE emp_email='$email'";
        $run = mysqli_query($con, $q);
        if(mysqli_num_rows($run)>0){
            $error = "Email already exists. Please use another email.";
        }
        else if(empty($name) || empty($designation) || empty($role) || empty($road) || empty($thana) || empty($city) || empty($district) || empty($division) || empty($zip) || empty($phone) || empty($email) || empty($day) || empty($month) || empty($year) || empty($password)){
            $error = "Please fill up all the required (*) fields";
        }
        else{
            $q = "INSERT INTO `employee` (`emp_no`,`emp_name`,`emp_desig`,`emp_role`,`emp_road`,`emp_thana`,`emp_city`,`emp_district`,`emp_division`,`emp_zip`,`emp_phone`,`emp_email`,`emp_join_day`,`emp_join_month`,`emp_join_year`,`emp_password`,`emp_image`) VALUES ('$emp_no','$name','$designation','$role','$road','$thana','$city','$district','$division','$zip','$phone','$email','$day','$month','$year','$password','$image')";
            
            if(mysqli_query($con,$q)){
                $q = "SELECT * FROM category WHERE cat_no='$designation'";
                $run = mysqli_query($con, $q);
                $row = mysqli_fetch_array($run);
                $salary = $row['cat_basic'];
                $q = "INSERT INTO `emp_salary` (`emp_no`, `emp_salary`) VALUES ('$emp_no', '$salary')";
                $run = mysqli_query($con, $q);
                move_uploaded_file($image_tmp, "img/$image");
                $msg = "Employee has been added successfully. Check the list of employees.";
            }
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
                        <a class="nav-link" href="admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Add Category</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="add-employee.php">Add Employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="statistics.php">Statistics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section style="margin-top: 20px;">

    </section>

    <div class="row" style="margin-left: 5px; margin-right: 5px;">
        <div class="col-md-3">
            <div class="list-group">
                <a href="admin.php" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="categories.php" class="list-group-item list-group-item-action">Categories</a>
                <a href="additions.php" class="list-group-item list-group-item-action">Additions</a>
                <a href="deductions.php" class="list-group-item list-group-item-action">Deductions</a>
                <a href="employees.php" class="list-group-item list-group-item-action active">Employees</a>
                <a href="statistics.php" class="list-group-item list-group-item-action">Statistics</a>
            </div>
        </div>
        <div class="col-md-9">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin.php" style="text-decoration: none;">Admin</a></li>
              <li class="breadcrumb-item"><a href="employees.php" style="text-decoration: none;">Employees</a></li>
              <li class="breadcrumb-item active">Add Employee</li>
            </ol>
            <?php if($msg != null){ ?>
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <?php if($error != null){ ?>
            <div class="alert alert-dismissible alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $error; ?>
            </div>
            <?php } ?>
            <form action="add-employee.php" method="post" enctype="multipart/form-data">
                <legend>Add an employee</legend>
                <fieldset>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Employee Name: *</label>
                        <input value="<?php if($error!=null){echo $name;} ?>" type="text" class="form-control" name="name" placeholder="Enter employee name">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Designation: *</label>
                                <select class="form-control" id="exampleSelect0" name="designation">
                                    <?php
                                        if($error!=null){
                                            $q = "SELECT * FROM category WHERE cat_no='$designation'";
                                            $run = mysqli_query($con, $q);
                                            $row = mysqli_fetch_array($run);
                                            $name = $row['cat_name'];
                                            echo "<option value=$designation>$name</option>";
                                        }
                                        $q = "SELECT * FROM category ORDER BY cat_no ASC";
                                        $run = mysqli_query($con, $q);
                                        while($row = mysqli_fetch_array($run)){
                                            if($row['cat_name']!=$name){
                                    ?>
                                    <option value="<?php echo $row['cat_no']; ?>"><?php echo $row['cat_name']; ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Role: *</label>
                                <select class="form-control" id="exampleSelect00" name="role">
                                    <?php
                                        if($error!=null){
                                            if($role == "Admin"){
                                                echo "<option value='Admin'>Admin</option>";
                                                echo "<option value='Visitor'>Visitor</option>";
                                            }
                                            else{
                                                echo "<option value='Visitor'>Visitor</option>";
                                                echo "<option value='Admin'>Admin</option>";
                                            }
                                        }
                                        else{
                                            echo "<option value='Visitor'>Visitor</option>";
                                            echo "<option value='Admin'>Admin</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Road/House: *</label>
                        <input value="<?php if($error!=null){echo $road;} ?>" type="text" class="form-control" name="road" placeholder="Enter road/house">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Thana: *</label>
                        <input value="<?php if($error!=null){echo $thana;} ?>" type="text" class="form-control" name="thana" placeholder="Enter thana">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">City: *</label>
                        <input value="<?php if($error!=null){echo $city;} ?>" type="text" class="form-control" name="city" placeholder="Enter city">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">District: *</label>
                        <input value="<?php if($error!=null){echo $district;} ?>" type="text" class="form-control" name="district" placeholder="Enter district">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Division: *</label>
                        <input value="<?php if($error!=null){echo $division;} ?>" type="text" class="form-control" name="division" placeholder="Enter division">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Zip Code: *</label>
                        <input value="<?php if($error!=null){echo $zip;} ?>" type="text" class="form-control" name="zip" placeholder="Enter zip code">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone: *</label>
                        <input value="<?php if($error!=null){echo $phone;} ?>" type="text" class="form-control" name="phone" placeholder="Enter phone">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email: *</label>
                        <input value="<?php if($error!=null){echo $email;} ?>" type="email" class="form-control" name="email" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleInputEmail1">Joining Day: *</label>
                                <select class="form-control" id="exampleSelect1" name="day">
                                    <?php
                                        if($error!=null){
                                            echo "<option value=$day>$day</option>";
                                        }
                                        for($i=1; $i<=31; $i++){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="exampleInputEmail1">Joining Month: *</label>
                                <select class="form-control" id="exampleSelect2" name="month">
                                    <?php
                                        if($error!=null){
                                            echo "<option value=$month>$month</option>";
                                        }
                                    ?>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="exampleInputEmail1">Joining Year: *</label>
                                <select class="form-control" id="exampleSelect3" name="year">
                                    <?php
                                        if($error!=null){
                                            echo "<option value=$year>$year</option>";
                                        }
                                        for($i=2000; $i<=2020; $i++){
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password: *</label>
                                <input value="<?php if($error!=null){echo $password;} ?>" type="text" class="form-control" name="password" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Profile Image: *</label>
                                <input type="file" class="form-control-file" id="image" aria-describedby="fileHelp" name="image">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="float: right;" name="submit">Submit</button>
                </fieldset>
            </form>
        </div>
    </div>

    <section style="margin-top: 10px;"></section>

    <footer style="background: #2C3E50; height: 50px; color: white; padding: 12px;">
        <center>Copyright @RUET Payroll 2017-2020</center>
    </footer>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.12.4.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
</body>

</html>
