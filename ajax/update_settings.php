<?php
session_start();
$token = $_POST['token'];
$mechant_id = $_POST['mechant_id'];
$payment_qr = $_POST['payment_qr'];
$payment_upi = $_POST['payment_upi'];
$minimum_add = $_POST['minimum_add'];
include("../auth.php");
if(isset($_SESSION['admin']) =="") {
        
echo"<script>  setTimeout(function(){
            window.location.href = 'index.php';
         }, 100;
</script>"; 
}else{
if($mechant_id !="" && $token !="" && $payment_qr !="" && $payment_upi !="" && $minimum_add !=""){
  $sql3 = mysqli_query($conn,"UPDATE settings SET upi_merchant_token='$token' , upi_merchant_id='$mechant_id' , upi_qr='$payment_qr' ,  upi_id='$payment_upi' , upi_min_recharge='$minimum_add' WHERE id='1'");
 
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