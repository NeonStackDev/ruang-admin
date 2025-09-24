<?php
session_start();
$slug = $_POST['slug'];
$name = $_POST['name'];
$description = $_POST['description'];
$id = $_POST['id'];
include("../auth.php");
if(isset($_SESSION['admin']) =="") {
        
echo"<script>  setTimeout(function(){
            window.location.href = 'index.php';
         }, 100;
</script>"; 
}else{
if($slug !="" && $name !="" && $description !=""){
 
  $sql = "UPDATE otp_server SET server_name='$name', server_code='$slug', api_id='$description' WHERE id='$id'";
  $done=mysqli_query($conn,$sql);
echo'<script>
    $(document).ready(function() {
        Swal.fire({
            title: "Success",
            text: "Details Update Successful",
            icon: "success",
            button: "Ok",
            
        });
    });
</script>';  
}else{
echo'<script>
    $(document).ready(function() {
        Swal.fire({
            title: "Warning!",
            text: "Please fill all the fields first",
            icon: "warning",
            button: "Ok",
            
        });
    });
</script>';   
}
}
?>