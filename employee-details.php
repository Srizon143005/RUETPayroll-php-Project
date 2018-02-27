<?php
    ob_start();
    require_once('db.php');
    $error = null;
    $msg = null;
    $check = null;
    
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

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    if(isset($_POST['add'])){
        $add_no = $_POST['addition'];
        $add_or_delete = $_POST['add_or_delete'];
        
        if($add_or_delete == "add"){
            $q = "SELECT * FROM emp_salary_add WHERE emp_no='$id' AND add_no='$add_no'";
            $run = mysqli_query($con, $q);
            if(mysqli_num_rows($run)>0){
                $error = "Addition already exists. Check the list.";
            }
            else{
                $q = "INSERT INTO emp_salary_add (`emp_no`,`add_no`) VALUES ('$id','$add_no')";
                $run = mysqli_query($con, $q);
                $msg = "Addition has been added successfully";
                
                $q = "SELECT * FROM addition WHERE add_no = '$add_no'";
                $run = mysqli_query($con, $q);
                $row = mysqli_fetch_array($run);
                $add_basic = $row['add_amount'];
                $add_type = $row['add_type'];
                if($add_type == "Fixed"){
                    $initial = $add_basic;
                }
                else{
                    $initial = $add_basic/100;
                }
                $q = "SELECT category.cat_basic FROM employee, category WHERE employee.emp_desig=category.cat_no AND employee.emp_no = '$id'";
                $run = mysqli_query($con, $q);
                $row = mysqli_fetch_array($run);
                $salary2 = $row['cat_basic'];
                $q = "SELECT * FROM emp_salary WHERE emp_no='$id'";
                $run = mysqli_query($con, $q);
                $row = mysqli_fetch_array($run);
                $salary = $row['emp_salary'];
                if($add_type == "Fixed"){
                    $salary = $salary + $initial;
                }
                else{
                    $salary = $salary + $salary2*$initial;
                }
                $q = "DELETE FROM emp_salary WHERE emp_no='$id'";
                $run = mysqli_query($con, $q);
                $q = "INSERT INTO emp_salary (`emp_no`,`emp_salary`) VALUES ('$id','$salary')";
                $run = mysqli_query($con, $q);
            }
        }
        else{
            $q = "DELETE FROM emp_salary_add WHERE emp_no='$id' AND add_no='$add_no'";
            $run = mysqli_query($con, $q);
            $msg = "Addition has been deleted successfully.";
            
            $q = "SELECT * FROM addition WHERE add_no = '$add_no'";
            $run = mysqli_query($con, $q);
            $row = mysqli_fetch_array($run);
            $add_basic = $row['add_amount'];
            $add_type = $row['add_type'];
            if($add_type == "Fixed"){
                $initial = $add_basic;
            }
            else{
                $initial = $add_basic/100;
            }
            $q = "SELECT category.cat_basic FROM employee, category WHERE employee.emp_desig=category.cat_no AND employee.emp_no = '$id'";
            $run = mysqli_query($con, $q);
            $row = mysqli_fetch_array($run);
            $salary2 = $row['cat_basic'];
            $q = "SELECT * FROM emp_salary WHERE emp_no='$id'";
            $run = mysqli_query($con, $q);
            $row = mysqli_fetch_array($run);
            $salary = $row['emp_salary'];
            if($add_type == "Fixed"){
                $salary = $salary - $initial;
            }
            else{
                $salary = $salary - $salary2*$initial;
            }
            $q = "DELETE FROM emp_salary WHERE emp_no='$id'";
            $run = mysqli_query($con, $q);
            $q = "INSERT INTO emp_salary (`emp_no`,`emp_salary`) VALUES ('$id','$salary')";
            $run = mysqli_query($con, $q);
        }
    }

    if(isset($_POST['deduc'])){
        $ded_no = $_POST['deduction'];
        $add_or_delete = $_POST['add_or_delete'];
        
        if($add_or_delete == "add"){
            $q = "SELECT * FROM emp_salary_ded WHERE emp_no='$id' AND ded_no='$ded_no'";
            $run = mysqli_query($con, $q);
            if(mysqli_num_rows($run)>0){
                $error = "Deduction already exists. Check the list.";
            }
            else{
                $q = "INSERT INTO emp_salary_ded (`emp_no`,`ded_no`) VALUES ('$id','$ded_no')";
                $run = mysqli_query($con, $q);
                $msg = "Deduction has been added successfully";
                
                $q = "SELECT * FROM deduction WHERE ded_no = '$ded_no'";
                $run = mysqli_query($con, $q);
                $row = mysqli_fetch_array($run);
                $ded_basic = $row['ded_amount'];
                $ded_type = $row['ded_type'];
                if($ded_type == "Fixed"){
                    $initial = $ded_basic;
                }
                else{
                    $initial = $ded_basic/100;
                }
                $q = "SELECT category.cat_basic FROM employee, category WHERE employee.emp_desig=category.cat_no AND employee.emp_no = '$id'";
                $run = mysqli_query($con, $q);
                $row = mysqli_fetch_array($run);
                $salary2 = $row['cat_basic'];
                $q = "SELECT * FROM emp_salary WHERE emp_no='$id'";
                $run = mysqli_query($con, $q);
                $row = mysqli_fetch_array($run);
                $salary = $row['emp_salary'];
                if($ded_type == "Fixed"){
                    $salary = $salary - $initial;
                }
                else{
                    $salary = $salary - $salary2*$initial;
                }
                $q = "DELETE FROM emp_salary WHERE emp_no='$id'";
                $run = mysqli_query($con, $q);
                $q = "INSERT INTO emp_salary (`emp_no`,`emp_salary`) VALUES ('$id','$salary')";
                $run = mysqli_query($con, $q);
            }
        }
        else{
            $q = "DELETE FROM emp_salary_ded WHERE emp_no='$id' AND ded_no='$ded_no'";
            $run = mysqli_query($con, $q);
            $msg = "Deduction has been deleted successfully.";
            
            $q = "SELECT * FROM deduction WHERE ded_no = '$ded_no'";
            $run = mysqli_query($con, $q);
            $row = mysqli_fetch_array($run);
            $ded_basic = $row['ded_amount'];
            $ded_type = $row['ded_type'];
            if($ded_type == "Fixed"){
                $initial = $ded_basic;
            }
            else{
                $initial = $ded_basic/100;
            }
            $q = "SELECT category.cat_basic FROM employee, category WHERE employee.emp_desig=category.cat_no AND employee.emp_no = '$id'";
            $run = mysqli_query($con, $q);
            $row = mysqli_fetch_array($run);
            $salary2 = $row['cat_basic'];
            $q = "SELECT * FROM emp_salary WHERE emp_no='$id'";
            $run = mysqli_query($con, $q);
            $row = mysqli_fetch_array($run);
            $salary = $row['emp_salary'];
            if($ded_type == "Fixed"){
                $salary = $salary + $initial;
            }
            else{
                $salary = $salary + $salary2*$initial;
            }
            $q = "DELETE FROM emp_salary WHERE emp_no='$id'";
            $run = mysqli_query($con, $q);
            $q = "INSERT INTO emp_salary (`emp_no`,`emp_salary`) VALUES ('$id','$salary')";
            $run = mysqli_query($con, $q);
        }
    }

    if(isset($_POST['loan'])){
        $q = "SELECT * FROM loan ORDER BY loan_no DESC";
        $run = mysqli_query($con, $q);
        if(mysqli_num_rows($run)>0){
            $row = mysqli_fetch_array($run);
            $loan_no = $row['loan_no']+1;
        }
        else{
            $loan_no = 1;
        }
        $loan_name = mysqli_real_escape_string($con, $_POST['loan_name']);
        $loan_amount = mysqli_real_escape_string($con, $_POST['loan_amount']);
        $loan_time = mysqli_real_escape_string($con, $_POST['loan_time']);
        if(empty($loan_amount) || empty($loan_time)){
            $per_month=0;
        }
        else{
            $per_month = $loan_amount/$loan_time;
        }
        
        $q = "SELECT * FROM emp_salary WHERE emp_no='$id'";
        $run = mysqli_query($con, $q);
        $row = mysqli_fetch_array($run);
        $salary = $row['emp_salary'];
        $percentage = ($salary*10)/100;
        $q = "SELECT * FROM loan WHERE emp_no='$id'";
        $run = mysqli_query($con, $q);
        if(mysqli_num_rows($run)>1){
            $error = "Maximum number of loans taken! Employee can take at most 2 loans.";
            $check = "1";
        }
        else if($percentage < $per_month){
            $error = "Loan return policy is to return at most 20% of salary every month. Yours is greater than 20%.";
            $check = "1";
        }
        else if($loan_time > 18){
            $error = "Least time to return loan is 18 months.";
            $check = "1";
        }
        else if(empty($loan_name) || empty($loan_amount) || empty($loan_time)){
            $error = "Please fill up all the required (*) fields.";
            $check = "1";
        }
        else{
            $q = "INSERT INTO loan(`emp_no`,`loan_no`,`loan_name`,`loan_amount`,`loan_time`,`loan_due`) VALUES ('$id','$loan_no','$loan_name','$loan_amount','$loan_time','$loan_amount')";
            $run = mysqli_query($con, $q);
            $msg = "Loan added successfully.";
        }
    }

    if(isset($_GET['delloan'])){
        $loan_no = $_GET['delloan'];
        $q = "DELETE FROM loan WHERE loan_no='$loan_no'";
        $run = mysqli_query($con, $q);
        $msg = "Loan successfully Deleted.";
    }

    if(isset($_GET['del'])){
        $emp_id = $_GET['del'];
        $month = $_GET['month'];
        $year = $_GET['year'];
        $q = "DELETE FROM transactions WHERE emp_no='$emp_id' AND for_month='$month' AND for_year='$year'";
        $run = mysqli_query($con, $q);
        $msg = "Transaction is deleted successfully";
    }

    if(isset($_GET['paid'])){
        $emp_id = $_GET['paid'];
        $month = $_GET['month'];
        $year = $_GET['year'];
        $q = "SELECT * FROM transactions WHERE emp_no='$emp_id' AND for_month='$month' AND for_year='$year'";
        $run = mysqli_query($con, $q);
        $row = mysqli_fetch_array($run);
        $paid_or_not = $row['paid_or_not'];
        if($paid_or_not=="Paid"){
            $paid_or_not = "Not Paid";
        }
        else{
            $paid_or_not = "Paid";
        }
        $q = "UPDATE transactions SET `paid_or_not`='$paid_or_not' WHERE emp_no='$emp_id' AND for_month='$month' AND for_year='$year'";
        $run = mysqli_query($con, $q);
        $msg = "Payment condition updated.";
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
                    <li class="nav-item">
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
              <li class="breadcrumb-item active">Employee Details</li>
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
            <div class="row">
                <div class="col-md-5">
                    <form action="">
                        <?php
                            $q = "SELECT * FROM employee WHERE emp_no='$id'";
                            $run = mysqli_query($con, $q);
                            $row = mysqli_fetch_array($run);
                        ?>
                        <legend>Employee Details</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <img src="img/<?php echo $row['emp_image']; ?>" alt="" style="width: 100%; border-top-right-radius: 5px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                            </div>
                            <div class="col-md-6" style="margin-left: -25px;">
                                <center>
                                    <h5 style="margin-top: 55px; color: darkmagenta; margin-bottom: -5px;"><strong>Current Salary</strong></h5>
                                    <?php
                                        $q1 = "SELECT * FROM emp_salary WHERE emp_no='$id'";
                                        $run1 = mysqli_query($con, $q1);
                                        $row1 = mysqli_fetch_array($run1);
                                        $salary = $row1['emp_salary'];
                                    ?>
                                    <h2 style="color: darkgreen;"><strong><?php echo ceil($salary); ?>&#2547;</strong></h2>
                                </center>
                            </div>
                        </div>
                        
                        <fieldset>
                            <div style="margin-bottom: 10px;"></div>
                            <label for="">Employee Name: <?php echo $row['emp_name']; ?></label><br>
                            <?php
                                $designation_id = $row['emp_desig'];
                                $q1 = "SELECT * FROM category WHERE cat_no='$designation_id'";
                                $run1 = mysqli_query($con, $q1);
                                $row1 = mysqli_fetch_array($run1);
                                $cat_name = $row1['cat_name'];
                            ?>
                            <label for="">Designation: <?php echo $cat_name; ?></label><br>
                            <label for="">Role: <?php echo $row['emp_role']; ?></label><br>
                            <label for="">Road/House: <?php echo $row['emp_road']; ?></label><br>
                            <label for="">Thana: <?php echo $row['emp_thana']; ?></label><br>
                            <label for="">City: <?php echo $row['emp_city']; ?></label><br>
                            <label for="">District: <?php echo $row['emp_district']; ?></label><br>
                            <label for="">Division: <?php echo $row['emp_division']; ?></label><br>
                            <label for="">Zip Code: <?php echo $row['emp_zip']; ?></label><br>
                            <label for="">Phone: <?php echo $row['emp_phone']; ?></label><br>
                            <label for="">Email: <?php echo $row['emp_email']; ?></label><br>
                            <label for="">Joining Date: <?php echo $row['emp_join_day']." ".$row['emp_join_month']." ".$row['emp_join_year']; ?></label><br>
                            <label for="">Password: <?php echo $row['emp_password']; ?></label><br>
                        </fieldset>
                    </form>
                </div>
                <div class="col-md-7">
                    <form action="">
                        <legend>All Additions &amp; Deductions</legend>
                        <fieldset>
                            <label for="">Additions: </label><br>
                            <?php
                                $q = "SELECT addition.add_name FROM addition, emp_salary_add WHERE emp_salary_add.add_no=addition.add_no AND emp_salary_add.emp_no='$id'";
                                $run = mysqli_query($con, $q);
                                if(mysqli_num_rows($run)){
                                    while($row = mysqli_fetch_array($run)){
                            ?>
                            <label for=""><span class="badge badge-success"><?php echo $row['add_name']; ?></span></label>
                            <?php }}
                                else{
                                    echo "<label for=''><span class='badge badge-success'>No Addition Available</span></label>";
                                }
                            ?>
                            <br>
                            <label for="">Deductions: </label><br>
                            <?php
                                $q = "SELECT deduction.ded_name FROM deduction, emp_salary_ded WHERE emp_salary_ded.ded_no=deduction.ded_no AND emp_salary_ded.emp_no='$id'";
                                $run = mysqli_query($con, $q);
                                if(mysqli_num_rows($run)){
                                    while($row = mysqli_fetch_array($run)){
                            ?>
                            <label for=""><span class="badge badge-warning"><?php echo $row['ded_name']; ?></span></label>
                            <?php }}
                                else{
                                    echo "<label for=''><span class='badge badge-warning'>No Deduction Available</span></label>";
                                }
                            ?>
                        </fieldset>
                    </form>
                    <hr>

                    <form action="employee-details.php?id=<?php echo $id; ?>" method="post">
                        <legend>Add or Delete Additions</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control" id="exampleSelect0" name="addition">
                                    <?php
                                        $q = "SELECT * FROM addition ORDER BY add_no ASC";
                                        $run = mysqli_query($con, $q);
                                        while($row = mysqli_fetch_array($run)){
                                    ?>
                                    <option value="<?php echo $row['add_no']; ?>"><?php echo $row['add_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="exampleSelect1" name="add_or_delete">
                                    <option value="add">Add</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary" style="float: right; width: 100%;" name="add">Apply</button>
                            </div>
                        </div>
                    </form>
                    <hr>

                    <form action="employee-details.php?id=<?php echo $id; ?>" method="post">
                        <legend>Add or Delete Deductions</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control" id="exampleSelect2" name="deduction">
                                    <?php
                                        $q = "SELECT * FROM deduction ORDER BY ded_no ASC";
                                        $run = mysqli_query($con, $q);
                                        while($row = mysqli_fetch_array($run)){
                                    ?>
                                    <option value="<?php echo $row['ded_no']; ?>"><?php echo $row['ded_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="exampleSelect3" name="add_or_delete">
                                    <option value="add">Add</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary" style="float: right; width: 100%;" name="deduc">Apply</button>
                            </div>
                        </div>
                    </form>
                    <hr>

                    <form action="employee-details.php?id=<?php echo $id; ?>" method="post">
                        <legend>Add Loan</legend>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Loan Name: *</label>
                            <input value="<?php if($check=="1"){echo $loan_name;} ?>" type="text" class="form-control" name="loan_name" placeholder="Enter loan name">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Loan Amount: *</label>
                            <input value="<?php if($check=="1"){echo $loan_amount;} ?>" type="text" class="form-control" name="loan_amount" placeholder="Enter loan amount">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Loan Return Time (Months): *</label>
                            <input value="<?php if($check=="1"){echo $loan_time;} ?>" type="text" class="form-control" name="loan_time" placeholder="Enter loan return time">
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="float: right;" name="loan">Submit</button>
                    </form>
                </div>
                <div class="col-md-12">
                    <hr>

                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">All Employees</h4>
                            <p class="category">List of all employees working in this company</p>
                        </div>
                        <div class="card-content table-responsive table-full-width table-striped">
                            <table class="table">
                                <?php
                                    $q = "SELECT * FROM transactions WHERE emp_no='$id'";
                                    $run = mysqli_query($con, $q);
                                    $count = 0;
                                    if(mysqli_num_rows($run)>0){
                                ?>
                                <thead class="text-danger">
                                    <th>Serial</th>
                                    <th>Payment For</th>
                                    <th class="text-center">Main Salary</th>
                                    <th class="text-center">Loan Paid</th>
                                    <th class="text-center">Salary Paid</th>
                                    <th class="text-center">Condition</th>
                                    <th class="text-center">Delete</th>
                                </thead>
                                <tbody>
                                    <?php
                                        while($row = mysqli_fetch_array($run)){
                                            $count = $count + 1;
                                            if($row['for_month']=="1"){
                                                $month = "January";
                                            }
                                            else if($row['for_month']=="2"){
                                                $month = "February";
                                            }
                                            else if($row['for_month']=="3"){
                                                $month = "March";
                                            }
                                            else if($row['for_month']=="4"){
                                                $month = "April";
                                            }
                                            else if($row['for_month']=="5"){
                                                $month = "May";
                                            }
                                            else if($row['for_month']=="6"){
                                                $month = "June";
                                            }
                                            else if($row['for_month']=="7"){
                                                $month = "July";
                                            }
                                            else if($row['for_month']=="8"){
                                                $month = "August";
                                            }
                                            else if($row['for_month']=="9"){
                                                $month = "Septermber";
                                            }
                                            else if($row['for_month']=="10"){
                                                $month = "October";
                                            }
                                            else if($row['for_month']=="11"){
                                                $month = "November";
                                            }
                                            else if($row['for_month']=="12"){
                                                $month = "December";
                                            }
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?>.</td>
                                        <td><?php echo $month." ".$row['for_year']; ?></td>
                                        <td class="text-primary text-center"><?php echo $row['loan_paid']+$row['salary_paid']; ?>&#2547;</td>
                                        <td class="text-primary text-center"><?php echo $row['loan_paid']; ?>&#2547;</td>
                                        <td class="text-primary text-center"><?php echo $row['salary_paid']; ?>&#2547;</td>
                                        <td class="text-center"><a href="employee-details.php?id=<?php echo $id; ?>&paid=<?php echo $row['emp_no']; ?>&month=<?php echo $row['for_month']; ?>&year=<?php echo $row['for_year']; ?>"><?php echo $row['paid_or_not']; ?></a></td>
                                        <td class="text-center"><a href="employee-details.php?id=<?php echo $id; ?>&del=<?php echo $row['emp_no']; ?>&month=<?php echo $row['for_month']; ?>&year=<?php echo $row['for_year']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                        else{
                                            echo "No transactions made yet.";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>

                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">All Loans</h4>
                            <p class="category">List of all loans taken by this employee</p>
                        </div>
                        <div class="card-content table-responsive table-full-width table-striped">
                            <table class="table">
                                <?php
                                    $q = "SELECT * FROM loan WHERE emp_no='$id'";
                                    $run = mysqli_query($con, $q);
                                    $count = 0;
                                    if(mysqli_num_rows($run)>0){
                                ?>
                                <thead class="text-danger">
                                    <th>Serial</th>
                                    <th>Loan For</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Time</th>
                                    <th class="text-center">Due</th>
                                    <th class="text-center">Delete</th>
                                </thead>
                                <tbody>
                                    <?php
                                        while($row = mysqli_fetch_array($run)){
                                            $count = $count + 1;
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?>.</td>
                                        <td><?php echo $row['loan_name']; ?></td>
                                        <td class="text-primary text-center"><?php echo $row['loan_amount']; ?>&#2547;</td>
                                        <td class="text-center"><?php echo $row['loan_time']; ?></td>
                                        <td class="text-primary text-center"><?php echo $row['loan_due']; ?>&#2547;</td>
                                        <td class="text-center"><a href="employee-details.php?id=<?php echo $id; ?>&delloan=<?php echo $row['loan_no']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                        else{
                                            echo "No loans has been taken by this employee.";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                </div>

            </div>
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
