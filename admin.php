<?php
    ob_start();
    require_once('db.php');
    require 'PHPMailerAutoload.php';
    
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

    if(isset($_POST['send'])){
        $q = "SELECT * FROM emp_salary ORDER BY emp_no ASC";
        $run = mysqli_query($con, $q);
        while($row = mysqli_fetch_array($run)){
            $salary = $row['emp_salary'];
            $emp_no = $row['emp_no'];
            $loan_paid = 0;
            
            $q1 = "SELECT * FROM loan WHERE emp_no='$emp_no'";
            $run1 = mysqli_query($con, $q1);
            while($row1 = mysqli_fetch_array($run1)){
                $loan_no = $row1['loan_no'];
                $amount = $row1['loan_amount'];
                $time = $row1['loan_time'];
                $due = $row1['loan_due'];
                if($due - ceil($amount/$time) > 0){
                    $salary = $salary - ceil($amount/$time);
                    $due = $due - ceil($amount/$time);
                    $loan_paid = ceil($amount/$time);
                }
                else{
                    $salary = $salary - $due;
                    $loan_paid = $due;
                }
                $q2 = "UPDATE `loan` SET `loan_due`='$due' WHERE `loan_no`='$loan_no'";
                $run2 = mysqli_query($con, $q2);
            }
            $month = date("m");
            $year = date("Y");
            $q2 = "SELECT category.cat_basic FROM category, employee WHERE category.cat_no=employee.emp_desig AND employee.emp_no='$emp_no'";
            $run2 = mysqli_query($con, $q2);
            $row2 = mysqli_fetch_array($run2);
            $basic = $row2['cat_basic'];
            
            $q2 = "SELECT * FROM employee WHERE emp_no='$emp_no'";
            $run2 = mysqli_query($con, $q2);
            $row2 = mysqli_fetch_array($run2);
            $emp_email = $row2['emp_email'];
            
            

            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'Smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'azmainsrizon@gmail.com';
            $mail->Password = 'srizon_143005';
            $mail->Port =25;
            $mail->setFrom('azmainsrizon@gmail.com', 'RUET Payroll');
            $mail->addAddress($emp_email, 'Pay Details'); 
            $mail->isHTML(true);

            $mail->Subject = "Pay Details For ".date("d")." ".date("M")." ".date("Y");
            $mail->Body    = "
            Hello, ".$row2['emp_name'].",<br>
            The payment for ".date("M")." ".date("Y")." is available now. For this month your salary is ".$salary." Taka. Loan Paid ".$loan_paid." Taka. For details, go to this link: <a href='localhost/my-details.php?id=".$emp_no."'>Pay Details for ".$row2['emp_name']."</a>
            ";
            $mail->AltBody = 'Your Payment is updated. Visit the site now.';
            if(!$mail->send()) {
                //echo 'Message could not be sent.';
                //echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                $q2 = "INSERT INTO transactions (`emp_no`,`for_month`,`for_year`,`basic`,`loan_paid`,`salary_paid`, `paid_or_not`) VALUES ('$emp_no', '$month', '$year', '$basic', '$loan_paid', '$salary', 'Not Paid')";
                $run2 = mysqli_query($con, $q2);
                $msg = "All works are done successfully";
                //echo 'Message has been sent';
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
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/fonts.css"> -->
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand  Aladin-Regular" href="#">RUET Payroll Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">

            </ul>
            <div class="my-2 my-lg-0">
                <ul class="navbar-nav mr-auto  Acme-Regular">
                    <li class="nav-item active">
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
            <div class="list-group Aladin-Regular">
                <a href="admin.php" class="list-group-item  list-group-item-action active">Dashboard</a>
                <a href="categories.php" class="list-group-item list-group-item-action">Categories</a>
                <a href="additions.php" class="list-group-item list-group-item-action">Additions</a>
                <a href="deductions.php" class="list-group-item list-group-item-action">Deductions</a>
                <a href="employees.php" class="list-group-item list-group-item-action">Employees</a>
                <a href="statistics.php" class="list-group-item list-group-item-action">Statistics</a>
            </div>
        </div>
        <div class="col-md-9">
            <ol class="breadcrumb Aladin-Regular">
              <li class="breadcrumb-item"><a href="admin.php" style="text-decoration: none;">Admin</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <?php if($msg != null){ ?>
            <div class="alert alert-dismissible alert-success Aladin-Regular">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $msg; ?>
            </div>
            <?php } ?>
            <?php if($error != null){ ?>
            <div class="alert alert-dismissible alert-warning Aladin-Regular">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $error; ?>
            </div>
            <?php } ?>
            
            <?php
                $month = date("m");
                $year = date("Y");
                $q = "SELECT * FROM transactions WHERE for_month='$month' AND for_year='$year'";
                $run = mysqli_query($con, $q);
                if(mysqli_num_rows($run)==0){
            ?>
            <div class="alert alert-dismissible alert-primary Aladin-Regular">
                <div class="row">
                    <div class="col-md-10" style="margin-top: 5px;">The payment of this month is ready. Hit the button to send mail.</div>
                    <div class="col-md-2"><form action="admin.php" method="post"><button type="submit" class="btn btn-success" style="float: right;" name="send">Send</button></form></div>
                </div>
            </div>
            <?php
                }
                
            ?>
            
            <div class="row" style="margin-top: -15px;">
                <div class="col-md-3">
                    <?php
                        $q = "SELECT * FROM category";
                        $run = mysqli_query($con, $q);
                        $num = mysqli_num_rows($run);
                    ?>
                    <div class="card text-white bg-info">
                      <div class="card-body">
                        <blockquote class="card-blockquote">
                          <div class="row">
                              <div class="col-md-5 text-left" style="font-size: 70px;; margin-top: -30px; margin-bottom: -20px;"><i class="fa fa-list" aria-hidden="true"></i></div>
                              <div class="col-md-7 text-right" style="margin-top: -10px;"><span style="font-size: 30px;"><?php echo $num; ?></span><br><span>Categories</span></div>
                          </div>
                        </blockquote>
                      </div>
                    </div>
                    <footer style="margin-top: -45px;" class="card text-white bg-primary decoration">
                        <div class="container">
                            <a href="categories.php" class="decoration">
                            <div class="row">
                                <div class="col-md-10 text-left Acme-Regular">View All Categories</div>
                                <div class="col-md-2 text-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
                            </div>
                            </a>
                        </div>
                    </footer>
                </div>
                
                <div class="col-md-3">
                    <?php
                        $q = "SELECT * FROM addition";
                        $run = mysqli_query($con, $q);
                        $num = mysqli_num_rows($run);
                    ?>
                    <div class="card text-white bg-warning">
                      <div class="card-body">
                        <blockquote class="card-blockquote">
                          <div class="row">
                              <div class="col-md-5 text-left" style="font-size: 70px;; margin-top: -30px; margin-bottom: -20px;"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
                              <div class="col-md-7 text-right" style="margin-top: -10px;"><span style="font-size: 30px;"><?php echo $num; ?></span><br><span>Additions</span></div>
                          </div>
                        </blockquote>
                      </div>
                    </div>
                    <footer style="margin-top: -45px;" class="card text-white bg-primary decoration">
                        <div class="container">
                            <a href="additions.php" class="decoration">
                            <div class="row">
                                <div class="col-md-10 text-left Acme-Regular">View All Additions</div>
                                <div class="col-md-2 text-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
                            </div>
                            </a>
                        </div>
                    </footer>
                </div>
                
                <div class="col-md-3">
                    <?php
                        $q = "SELECT * FROM deduction";
                        $run = mysqli_query($con, $q);
                        $num = mysqli_num_rows($run);
                    ?>
                    <div class="card text-white bg-dark">
                      <div class="card-body">
                        <blockquote class="card-blockquote">
                          <div class="row">
                              <div class="col-md-5 text-left" style="font-size: 70px;; margin-top: -30px; margin-bottom: -20px;"><i class="fa fa-minus-square-o" aria-hidden="true"></i></div>
                              <div class="col-md-7 text-right" style="margin-top: -10px;"><span style="font-size: 30px;"><?php echo $num; ?></span><br><span>Deductions</span></div>
                          </div>
                        </blockquote>
                      </div>
                    </div>
                    <footer style="margin-top: -45px;" class="card text-white bg-primary decoration">
                        <div class="container">
                            <a href="deductions.php" class="decoration">
                            <div class="row">
                                <div class="col-md-10 text-left Acme-Regular">View All Deductions</div>
                                <div class="col-md-2 text-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
                            </div>
                            </a>
                        </div>
                    </footer>
                </div>
                
                <div class="col-md-3">
                    <?php
                        $q = "SELECT * FROM employee";
                        $run = mysqli_query($con, $q);
                        $num = mysqli_num_rows($run);
                    ?>
                    <div class="card text-white bg-danger">
                      <div class="card-body">
                        <blockquote class="card-blockquote">
                          <div class="row">
                              <div class="col-md-5 text-left" style="font-size: 70px;; margin-top: -30px; margin-bottom: -20px;"><i class="fa fa-address-book-o" aria-hidden="true"></i></div>
                              <div class="col-md-7 text-right" style="margin-top: -10px;"><span style="font-size: 30px;"><?php echo $num; ?></span><br><span>Employees</span></div>
                          </div>
                        </blockquote>
                      </div>
                    </div>
                    <footer style="margin-top: -45px;" class="card text-white bg-primary decoration">
                        <div class="container">
                            <a href="employees.php" class="decoration">
                            <div class="row">
                                <div class="col-md-10 text-left Acme-Regular">View All Employees</div>
                                <div class="col-md-2 text-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
                            </div>
                            </a>
                        </div>
                    </footer>
                </div>
                
                <div class="col-md-3" style="margin-top: -20px;">
                    <div class="card text-white bg-dark">
                      <div class="card-body">
                        <blockquote class="card-blockquote">
                          <div class="row">
                              <div class="col-md-5 text-left" style="font-size: 70px;; margin-top: -30px; margin-bottom: -20px;"><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
                              <div class="col-md-7 text-right" style="margin-top: -10px;"><span style="font-size: 30px;">5</span><br><span>Statistics</span></div>
                          </div>
                        </blockquote>
                      </div>
                    </div>
                    <footer style="margin-top: -45px;" class="card text-white bg-primary decoration">
                        <div class="container">
                            <a href="statistics.php" class="decoration">
                            <div class="row">
                                <div class="col-md-10 text-left Acme-Regular">View All Statistics</div>
                                <div class="col-md-2 text-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></div>
                            </div>
                            </a>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <section style="margin-top: 65px;"></section>

    <footer style="background: #2C3E50; height: 50px; color: white; padding: 12px;" class="fixed-bottom Acme-Regular">
        <center>Copyright @RUET Payroll 2017-2020</center>
    </footer>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.12.4.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
</body>

</html>
