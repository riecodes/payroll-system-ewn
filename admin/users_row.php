<?php 
include 'includes/session.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = "SELECT * FROM staff
    WHERE id = $id";
    $query = $conn->query($sql);
    if($query){
       $result = "success!";
    }
    $row = $query->fetch_assoc();
    echo json_encode($row);
}
?>
