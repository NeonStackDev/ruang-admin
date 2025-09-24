<?php
session_start();
$service_id = $_POST['service_id'];
$service_code = $_POST['service_code'];
$name = $_POST['name'];
$price = $_POST['price'];

include("../auth.php");
if(isset($_SESSION['admin']) =="") {
        
echo"<script>  setTimeout(function(){
            window.location.href = 'index.php';
         }, 100;
</script>"; 
}else{
if($service_id !="" && $service_code !="" && $name !="" && $price !=""){
if(is_numeric($price)){
$sql=mysqli_query($conn,"SELECT * FROM service WHERE id='$service_id'");
if(mysqli_num_rows($sql) !=0){
  $sql3 = mysqli_query($conn,"UPDATE service SET service_id='$service_code' , service_name='$name' , service_price='$price' WHERE id='$service_id'");
 
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
            text: "Invalid Service Id",
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