<?php
session_start();
$api_name = $_POST['api_name'];
$api_url = $_POST['api_url'];
$api_key = $_POST['api_key'];
$id = $_POST['id'];

include("../auth.php");
if(isset($_SESSION['admin']) =="") {
        
echo"<script>  setTimeout(function(){
            window.location.href = 'index.php';
         }, 100;
</script>"; 
}else{
if($api_name !="" && $api_url !="" && $api_key !=""  &&  $id !=""){
 
  $sql = "UPDATE api_detail SET api_name='$api_name', api_key='$api_key', api_url='$api_url' WHERE id='$id'";
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