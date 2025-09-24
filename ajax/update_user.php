<?php
session_start();

$user_id = $_POST['user_id'];
$balance = $_POST['balance'];
$recharge = $_POST['recharge'];
$total_otp = $_POST['total_otp'];


include("../auth.php");
if(isset($_SESSION['admin']) =="") {
        
echo"<script>  setTimeout(function(){
            window.location.href = '../index';
         }, 100);
</script>"; 
}else{
if($user_id !="" && $balance !="" && $recharge !="" && $total_otp !=""){
if(is_numeric($balance) && is_numeric($recharge) && is_numeric($total_otp)){
$sql=mysqli_query($conn,"SELECT * FROM user_data WHERE id='$user_id'");
if(mysqli_num_rows($sql) !=0){
$data3=mysqli_fetch_assoc($sql);
$user_id=$data3['id'];
  $sql3 = mysqli_query($conn,"UPDATE user_wallet SET balance='$balance' , total_recharge='$recharge' , total_otp='$total_otp' WHERE user_id='$user_id'");
 
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
            text: "Invalid User Id",
            icon: "warning",
            button: "Ok",
            
        });
    });
</script>';   
}
}else {
echo'<script>
    $(document).ready(function() {
        Swal.fire({
            title: "Warning!",
            text: "Please Enter Numerical Values",
            icon: "warning",
            button: "Ok",
            
        });
    });
</script>';   
}
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