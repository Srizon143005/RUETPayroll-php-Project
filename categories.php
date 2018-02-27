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

    if(isset($_POST['add'])){
        $q = "SELECT * FROM category ORDER BY cat_no DESC";
        $run = mysqli_query($con, $q);
        if(mysqli_num_rows($run)>0){
            $row = mysqli_fetch_array($run);
            $cat_no = $row['cat_no'];
            $cat_no = $cat_no+1;
        }
        else{
            $cat_no = 1;
        }
        $cat_name = mysqli_real_escape_string($con, $_POST['category_add']);
        $basic = mysqli_real_escape_string($con, $_POST['basic_add']);
        $q = "SELECT * FROM category WHERE cat_name = '$cat_name'";
        $run = mysqli_query($con, $q);
        if(mysqli_num_rows($run)>0){
            $error = "Category already exists. Check the list first!";
        }
        else if(empty($cat_name) || empty($basic)){
            $error = "Fill up all the required (*) fields.";
        }
        else{
            $q = "INSERT INTO category (`cat_no`, `cat_name`, `cat_basic`) VALUES ('$cat_no', '$cat_name', '$basic')";
            $run = mysqli_query($con, $q);
            $msg = "Category inserted successfully. Check the list of categories.";
        }
    }

    if(isset($_POST['edit'])){
        $cat_no = $_GET['id'];
        $cat_name = mysqli_real_escape_string($con, $_POST['category_edit']);
        $basic = mysqli_real_escape_string($con, $_POST['basic_edit']);
        if(empty($cat_name) || empty($basic)){
            $error = "Fill up all the required (*) fields.";
        }
        else{
            $q = "update `category` set `cat_name`='$cat_name', `cat_basic`='$basic' where `cat_no`='$cat_no'";
            $run = mysqli_query($con, $q);
            $msg = "Category edited successfully. Check the list of categories.";
        }
    }

    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $q = "DELETE FROM category WHERE cat_no='$id'";
        $run = mysqli_query($con, $q);
        $msg = "Category Deleted. Check the list.";
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
                        <li class="nav-item active">
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
                    <a href="categories.php" class="list-group-item list-group-item-action active">Categories</a>
                    <a href="additions.php" class="list-group-item list-group-item-action">Additions</a>
                    <a href="deductions.php" class="list-group-item list-group-item-action">Deductions</a>
                    <a href="employees.php" class="list-group-item list-group-item-action">Employees</a>
                    <a href="statistics.php" class="list-group-item list-group-item-action">Statistics</a>
                </div>
            </div>
            <div class="col-md-9">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="admin.php" style="text-decoration: none;">Admin</a></li>
                  <li class="breadcrumb-item active">Categories</li>
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
                    <div class="col-md-4">
                        <form action="categories.php" method="post">
                            <legend>Add Category</legend>
                            <fieldset>
                                <div class="form-group">
                                    <label for="name">Category Name: *</label>
                                    <input type="text" value="<?php if($error!=null){echo $cat_name;} ?>" class="form-control" name="category_add" placeholder="Enter Category Name">
                                </div>

                                <div class="form-group">
                                    <label for="basic">Basic Salary: *</label>
                                    <input type="text" value="<?php if($error!=null){echo $basic;} ?>" class="form-control" name="basic_add" placeholder="Enter Basic Salary">
                                </div>

                                <button type="submit" class="btn btn-primary" style="float: right;" name="add">Submit</button>
                            </fieldset>
                        </form>

                        <?php 
                            if(isset($_GET['edit'])){
                                $id = $_GET['edit'];
                                $q = "SELECT * FROM category WHERE cat_no='$id'";
                                $run = mysqli_query($con, $q);
                                $row = mysqli_fetch_array($run);
                                $cat_name = $row['cat_name'];
                                $basic = $row['cat_basic'];
                        ?>
                        <form action="categories.php?id=<?php echo $row['cat_no']; ?>" method="post">
                            <legend>Edit a category</legend>
                            <fieldset>
                                <div class="form-group">
                                    <label for="name">Edit Category Name: *</label>
                                    <input type="text" value="<?php echo $cat_name; ?>" class="form-control" name="category_edit" placeholder="Enter Category Name">
                                </div>

                                <div class="form-group">
                                    <label for="basic">Edit Basic Salary: *</label>
                                    <input type="text" value="<?php echo $basic; ?>" class="form-control" name="basic_edit" placeholder="Enter Basic Salary">
                                </div>

                                <button type="submit" class="btn btn-primary" style="float: right;" name="edit">Submit</button>
                            </fieldset>
                        </form>
                        <?php } ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header" data-background-color="purple">
                                <h4 class="title">All Categories</h4>
                                <p class="category">List of all categories with basic salary</p>
                            </div>
                            <div class="card-content table-responsive table-full-width table-striped">
                                <table class="table">
                                    <?php
                                        $q = "SELECT * FROM category ORDER BY cat_no ASC";
                                        $run = mysqli_query($con, $q);
                                        $count = 0;
                                        if(mysqli_num_rows($run) > 0){
                                    ?>
                                    <thead class="text-danger">
                                        <th>Serial</th>
                                        <th>Category</th>
                                        <th class="text-center">Basic</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                                while($row = mysqli_fetch_array($run)){
                                                    $count = $count + 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $count; ?>.</td>
                                            <td><?php echo $row['cat_name']; ?></td>
                                            <td class="text-primary text-center"><?php echo $row['cat_basic']; ?>&#2547;</td>
                                            <td class="text-center"><a href="categories.php?edit=<?php echo $row['cat_no']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                            <td class="text-center"><a href="categories.php?del=<?php echo $row['cat_no']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                            else{
                                                echo "<h5>No categories available.</h5>";
                                            }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
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
