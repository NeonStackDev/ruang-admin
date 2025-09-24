<?php
session_start();
$server_code = $_POST['server_code'];
$server_name = $_POST['server_name'];
$api_id = $_POST['api_id'];
   
include("../auth.php");
if(isset($_SESSION['admin']) =="") {
        
echo"<script>  setTimeout(function(){
            window.location.href = 'index.php';
         }, 100;
</script>"; 
}else{
if($server_code !="" && $server_name !="" && $api_id !=""){
  $sql = "INSERT INTO otp_server (server_name, server_code, api_id, status) VALUES ('$server_name','$server_code','$api_id','1')";
  $done=mysqli_query($conn,$sql);
echo'<script>
    $(document).ready(function() {
        Swal.fire({
            title: "Success",
            text: "Details Added Successful",
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