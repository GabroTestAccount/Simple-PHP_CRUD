<?php

session_start();
$_SESSION['current_page'] = "Students";

include_once('connect.php');
include_once('layout/header.php');

if (!isset($_SESSION['username'])) {
    $_SESSION['failed_msg'] = "you don't have access please login or sign up to enter this site";
    header("location:login.php");
}
?>
<br>
<div class="container ">
    <div class="row text-light text-center bg-dark">
        <div class="col">
            <h1>students page</h1>
        </div>
    </div>
</div>
<br>
<!-- Failed Message -->
<?php
if (isset($_SESSION['failed_msg'])) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong> <?php echo $_SESSION["failed_msg"]; ?> </strong> .
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION["failed_msg"]);
} ?>
<!-- Success Message -->
<?php
if (isset($_SESSION['success_msg'])) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong> <?php echo $_SESSION["success_msg"]; ?> </strong> .
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION["success_msg"]);
} ?>
<!-- Delete Message -->
<?php
if (isset($_SESSION['delete_msg'])) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong> <?php echo $_SESSION["delete_msg"]; ?> </strong> .
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION["delete_msg"]);
} ?>
<table class="table">
    <thead class="table-dark">
        <row class="d-flex justify-content-between">
            <div class="col-1">
                <h3>Students</h3>
            </div>
            <div class="col-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudent">
                    Add Student
                </button>
            </div>
            </div>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Email</th>
                <th scope="col">Age</th>
                <th scope="col">Update</th>
                <th scope="col">Delete</th>
            </tr>
    </thead>
    <tbody>
        <?php
        $query = 'SELECT * FROM students';
        //return Mysql Result Object
        $result = mysqli_query($conn, $query);
        ?>
        <?php
        if (mysqli_num_rows($result) > 0) {
            //fetch data to use them
            /* 
                *if we have 2 or more results [mysqli_fetch_assoc] will
                get one row of data .so,here we put it in loop it will get 
                one row each time and we print it and the pointer will get 
                second row etc.. .
            */
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <th scope="col"><?php echo $row['id']; ?></th>
                    <th scope="col"><?php echo $row['first_name']; ?></th>
                    <th scope="col"><?php echo $row['last_name']; ?></th>
                    <th scope="col"><?php echo $row['email']; ?></th>
                    <th scope="col"><?php echo $row['age']; ?></th>
                    <!-- use POST to pass the ID -->
                    <th scope="col">
                        <form action="CRUD/update_student.php" method="POST">
                            <input type="submit" name="update_student" value="Update" class="btn btn-success">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
                        </form>
                    </th>
                    <!-- <th scope="col"><a href="CRUD/update_student.php?id=<?php //echo $row['id']; 
                                                                                ?>" name="update_student" class="btn btn-success">
                            Update</a></th> -->
                    <th scope="col">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_Student<?php echo $row['id']; ?>">
                            Delete
                        </button>
                    </th>

                </tr>
                <!-- modal Delete-Student -->
                <form action="CRUD/delete_student.php?id=<?php echo $row['id']; ?>" method="POST">
                    <div class="modal fade" id="delete_Student<?php echo $row['id']; ?>" role="dialog" tabstudents="-1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Do you want to delete the student<u>
                                            <?php echo $row['first_name'] . " " . $row['last_name']; ?></u>?</p>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" name="delete_Student" class="btn btn-danger" value="Delete">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        <?php
            }
        }
        ?>
    </tbody>
</table>

<!-- Modal Add-student -->
<form action="CRUD/add-students.php" method="POST">
    <div class="modal fade" id="addStudent" tabstudents="-1" role="dialog" aria-labelledby="exam" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exam">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body form-control">
                    <div class="row ">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" class="form-control" name="first_name" value="" placeholder="Write your first name" required>
                    </div>
                    <div class="row ">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name" value="" placeholder="Write your last name" required>
                    </div>
                    <div class="row ">
                        <label for="email" class="form-label">email</label>
                        <input type="email" id="email" class="form-control" name="email" value="" placeholder="Write your email" required>
                    </div>
                    <div class="row ">
                        <label for="age" class="form-label">Age</label>
                        <input type="text" id="age" class="form-control" name="age" value="" placeholder="Write your age" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="add-Student" class="btn btn-success" value="Save changes"></button>
                </div>
            </div>
        </div>
    </div>
</form>


<?php include_once('layout/footer.php'); ?>