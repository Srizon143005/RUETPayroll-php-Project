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
        $id = $row['emp_no'];
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
    <style type="text/css">
        @media print{
            footer, a, img, .alert{
                display: none;
            }
            .breadcrumb-item{
                color: white;
            }
        }
    </style>
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
                        <a class="nav-link" href="login.php">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section style="margin-top: 20px;">

    </section>

    <div class="row" style="margin-left: 5px; margin-right: 5px;">
        <div class="col-md-12">
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
                    
                    <hr>
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
                </div>
                <div class="col-md-7">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="index.php" style="text-decoration: none;">Site </a></li>
                      <li class="breadcrumb-item active">Employee Details</li>
                    </ol>
                    <div class="alert alert-dismissible alert-primary">
                        <div class="row">
                            <div class="col-md-10" style="margin-top: 5px;">Print the pay details page.</div>
                            <div class="col-md-2"><form><button type="submit" class="btn btn-success" style="float: right;" name="send" onclick='window.print(); return false;'>Print</button></form></div>
                        </div>
                    </div>
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
                </div>
                
            </div>
            <hr>
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
