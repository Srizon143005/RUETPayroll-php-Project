<?php
    ob_start();
    require_once('db.php');
    
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
    if(isset($_GET['del'])){
        $del = $_GET['del'];
        $q = "DELETE FROM employee WHERE emp_no='$del'";
        $run = mysqli_query($con, $q);
        $q = "DELETE FROM emp_salary WHERE emp_no='$del'";
        $run = mysqli_query($con, $q);
        $q = "DELETE FROM transactions WHERE emp_no='$del'";
        $run = mysqli_query($con, $q);
        $q = "DELETE FROM emp_salary_add WHERE emp_no='$del'";
        $run = mysqli_query($con, $q);
        $q = "DELETE FROM emp_salary_ded WHERE emp_no='$del'";
        $run = mysqli_query($con, $q);
        $msg = "Employee has been deleted from the database successfully.";
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
              <li class="breadcrumb-item active">Employees</li>
            </ol>
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">All Employees</h4>
                    <p class="category">List of all employees working in this company</p>
                </div>
                <div class="card-content table-responsive table-full-width table-striped">
                    <table class="table">
                        <?php
                            $q = "SELECT * FROM employee ORDER BY emp_no ASC";
                            $run = mysqli_query($con, $q);
                            if(mysqli_num_rows($run)){
                                $count=0;
                        ?>
                        <thead class="text-danger">
                            <th>Serial</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Joining Date</th>
                            <th class="text-center">Details</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </thead>
                        <?php
                            while($row = mysqli_fetch_array($run)){
                                $count=$count+1;
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['emp_name']; ?></td>
                                <?php
                                    $designation = $row['emp_desig'];
                                    $q1 = "SELECT * FROM category WHERE cat_no='$designation'";
                                    $run1 = mysqli_query($con, $q1);
                                    $row1 = mysqli_fetch_array($run1);
                                    $desig = $row1['cat_name'];
                                ?>
                                <td><?php echo $desig; ?></td>
                                <td><?php echo $row['emp_join_day']." ".$row['emp_join_month']." ".$row['emp_join_year']; ?></td>
                                <td class="text-center"><a href="employee-details.php?id=<?php echo $row['emp_no']; ?>"><i class="fa fa-address-card-o" aria-hidden="true"></i></a></td>
                                <td class="text-center"><a href="edit-employee.php?id=<?php echo $row['emp_no']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                <td class="text-center"><a href="employees.php?del=<?php echo $row['emp_no']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                            </tr>
                            <?php }}
                                else{
                                    echo "<h5>No employees available.</h5>";
                                }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
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
