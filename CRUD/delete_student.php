<?php


include('../connect.php');

if (isset($_POST['delete_Student'])) {
    // echo 'yessss';
    if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query="DELETE FROM students WHERE id=$id ";
    $result = mysqli_query($conn,$query);

    if(!$result){
        die("you can't delete the student".mysqli_error($conn));
    }else{
        header('location:../index.php?delete_msg=The student has been deleted successfullly');
    }
}
}