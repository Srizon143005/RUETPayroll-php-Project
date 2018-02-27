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
                            <a class="nav-link active" href="statistics.php">Statistics</a>
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
                    <a href="admin.php" class="list-group-item  list-group-item-action">Dashboard</a>
                    <a href="categories.php" class="list-group-item list-group-item-action">Categories</a>
                    <a href="additions.php" class="list-group-item list-group-item-action">Additions</a>
                    <a href="deductions.php" class="list-group-item list-group-item-action">Deductions</a>
                    <a href="employees.php" class="list-group-item list-group-item-action">Employees</a>
                    <a href="statistics.php" class="list-group-item list-group-item-action active">Statistics</a>
                </div>
            </div>
            <div class="col-md-9">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin.php" style="text-decoration: none;">Admin</a></li>
                    <li class="breadcrumb-item active">Statistics</li>
                </ol>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" data-background-color="" style="background-color: darkblue;">
                                <h4 class="title">At A Glance</h4>
                                <p class="category">Watch Out the website at a glance</p>
                            </div>
                            <div class="card-content table-responsive table-full-width table-striped">
                                <table class="table">
                                    <?php
                                    $q = "SELECT COUNT(category.cat_no) AS no FROM category";
                                    $run = mysqli_query($con, $q);
                                    $row = mysqli_fetch_array($run);
                                    $categories = $row['no'];
                                    
                                    $q = "SELECT COUNT(addition.add_no) AS no FROM addition";
                                    $run = mysqli_query($con, $q);
                                    $row = mysqli_fetch_array($run);
                                    $additions = $row['no'];
                                    
                                    $q = "SELECT COUNT(deduction.ded_no) AS no FROM deduction";
                                    $run = mysqli_query($con, $q);
                                    $row = mysqli_fetch_array($run);
                                    $deductions = $row['no'];
                                    
                                    $q = "SELECT COUNT(employee.emp_no) AS no FROM employee";
                                    $run = mysqli_query($con, $q);
                                    $row = mysqli_fetch_array($run);
                                    $employees = $row['no'];
                                ?>
                                        <thead class="text-danger">
                                            <th>Serial</th>
                                            <th>Name of Measurement</th>
                                            <th class="text-center">Measures</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    1.
                                                </td>
                                                <td>
                                                    Number of Categories
                                                </td>
                                                <td class="text-primary text-center">
                                                    <?php echo $categories; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    2.
                                                </td>
                                                <td>
                                                    Number of Additions
                                                </td>
                                                <td class="text-primary text-center">
                                                    <?php echo $additions; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    3.
                                                </td>
                                                <td>
                                                    Number of Deductions
                                                </td>
                                                <td class="text-primary text-center">
                                                    <?php echo $deductions; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    4.
                                                </td>
                                                <td>
                                                    Number of Employees
                                                </td>
                                                <td class="text-primary text-center">
                                                    <?php echo $employees; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    5.
                                                </td>
                                                <td>
                                                    Number of Functions
                                                </td>
                                                <td class="text-primary text-center">
                                                    15+
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" data-background-color="" style="background-color: darkgreen;">
                                <h4 class="title">Top Paid Jobs</h4>
                                <p class="category">List of all jobs that are paid for highest</p>
                            </div>
                            <div class="card-content table-responsive table-full-width table-striped">
                                <table class="table">
                                    <?php
                                    $q = "SELECT * FROM category ORDER BY cat_basic DESC LIMIT 5";
                                    $run = mysqli_query($con, $q);
                                    $count = 0;
                                    if(mysqli_num_rows($run)>0){
                                ?>
                                        <thead class="text-danger">
                                            <th>Serial</th>
                                            <th>Name</th>
                                            <th class="text-center">Basic Salary</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                        while($row = mysqli_fetch_array($run)){
                                            $count = $count + 1;
                                    ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $count; ?>.
                                                    </td>
                                                    <td>
                                                        <?php echo $row['cat_name']; ?>
                                                    </td>
                                                    <td class="text-primary text-center">
                                                        <?php echo $row['cat_basic']; ?>&#2547;
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else{
                                            echo "No categories yet.";
                                        }
                                    ?>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Top Paid Employees</h4>
                        <p class="category">List of all employees who are paid most</p>
                    </div>
                    <div class="card-content table-responsive table-full-width table-striped">
                        <table class="table">
                            <?php
                                    $q = "SELECT employee.emp_name, category.cat_name, employee.emp_join_day, employee.emp_join_month, employee.emp_join_year, emp_salary.emp_salary, employee.emp_email FROM employee, category, emp_salary WHERE employee.emp_no = emp_salary.emp_no AND employee.emp_desig = category.cat_no ORDER BY emp_salary.emp_salary DESC LIMIT 5";
                                    $run = mysqli_query($con, $q);
                                    $count = 0;
                                    if(mysqli_num_rows($run)>0){
                                ?>
                                <thead class="text-danger">
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Joining Day</th>
                                    <th class="text-center">Salary</th>
                                    <th>Email</th>
                                </thead>
                                <tbody>
                                    <?php
                                        while($row = mysqli_fetch_array($run)){
                                            $count = $count + 1;
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>.</td>
                                            <td>
                                                <?php echo $row['emp_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['cat_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['emp_join_day']." ".$row['emp_join_month']." ".$row['emp_join_year']; ?>
                                            </td>
                                            <td class="text-primary text-center">
                                                <?php echo $row['emp_salary']; ?>&#2547;
                                            </td>
                                            <td>
                                                <?php echo $row['emp_email']; ?>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        else{
                                            echo "No employees yet.";
                                        }
                                    ?>
                                </tbody>
                        </table>
                    </div>
                </div>
                <hr>

                <div class="card">
                    <div class="card-header" data-background-color="" style="background-color: darkred;">
                        <h4 class="title">Life Time Payment</h4>
                        <p class="category">List of life time payment of all employees</p>
                    </div>
                    <div class="card-content table-responsive table-full-width table-striped">
                        <table class="table">
                            <?php
                                    $q = "SELECT employee.emp_name, SUM(transactions.salary_paid) AS 'emp_salary', category.cat_name, employee.emp_join_day, employee.emp_join_month, employee.emp_join_year FROM employee, category, emp_salary, transactions WHERE employee.emp_no=emp_salary.emp_no AND employee.emp_desig=category.cat_no AND transactions.emp_no = employee.emp_no GROUP BY employee.emp_no";
                                    $run = mysqli_query($con, $q);
                                    $count = 0;
                                    if(mysqli_num_rows($run)>0){
                                ?>
                                <thead class="text-danger">
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Joining Day</th>
                                    <th class="text-center">Total Paid Salary Till Now</th>
                                </thead>
                                <tbody>
                                    <?php
                                        while($row = mysqli_fetch_array($run)){
                                            $count = $count + 1;
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>.</td>
                                            <td>
                                                <?php echo $row['emp_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['cat_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['emp_join_day']." ".$row['emp_join_month']." ".$row['emp_join_year']; ?>
                                            </td>
                                            <td class="text-primary text-center">
                                                <?php echo $row['emp_salary']; ?>&#2547;
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        else{
                                            echo "No transactions yet.";
                                        }
                                    ?>
                                </tbody>
                        </table>
                    </div>
                </div>
                <hr>

                <div class="card">
                    <div class="card-header" data-background-color="" style="background-color: darkgoldenrod;">
                        <h4 class="title">Employee Salary Details</h4>
                        <p class="category">List of details of salary for emlpoyees</p>
                    </div>
                    <div class="card-content table-responsive table-full-width table-striped">
                        <table class="table">
                            <?php
                                    $q = "SELECT employee.emp_name, category.cat_name, employee.emp_join_day, employee.emp_join_month, employee.emp_join_year, category.cat_basic, emp_salary.emp_salary FROM employee, category, emp_salary WHERE employee.emp_no = emp_salary.emp_no AND employee.emp_desig = category.cat_no";
                                    $run = mysqli_query($con, $q);
                                    $count = 0;
                                    if(mysqli_num_rows($run)>0){
                                ?>
                                <thead class="text-danger">
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Joining Day</th>
                                    <th class="text-center">Basic Salary</th>
                                    <th class="text-center">Salary</th>
                                </thead>
                                <tbody>
                                    <?php
                                        while($row = mysqli_fetch_array($run)){
                                            $count = $count + 1;
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $count; ?>.</td>
                                            <td>
                                                <?php echo $row['emp_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['cat_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['emp_join_day']." ".$row['emp_join_month']." ".$row['emp_join_year']; ?>
                                            </td>
                                            <td class="text-primary text-center">
                                                <?php echo $row['cat_basic']; ?>&#2547;
                                            </td>
                                            <td class="text-primary text-center">
                                                <?php echo $row['emp_salary']; ?>&#2547;
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        else{
                                            echo "No transactions yet.";
                                        }
                                    ?>
                                </tbody>
                        </table>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <section style="margin-top: 65px;"></section>

        <footer style="background: #2C3E50; height: 50px; color: white; padding: 12px;" class="fixed-bottom">
            <center>Copyright @RUET Payroll 2017-2020</center>
        </footer>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-1.12.4.min.js"></script>
        <script src="js/jquery-3.2.1.min.js"></script>
    </body>

    </html>
