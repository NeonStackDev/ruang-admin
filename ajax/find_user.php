<?php
session_start();

$email = $_POST['email'];


include("../auth.php");
if(isset($_SESSION['admin']) =="") {
        
echo"<script>  setTimeout(function(){
            window.location.href = 'index.php';
         }, 100);
</script>"; 
}else{
if($email !=""){
$sql=mysqli_query($conn,"SELECT * FROM user_data WHERE email='$email'");
if(mysqli_num_rows($sql) !=0){
$datas=mysqli_fetch_assoc($sql);
$id=$datas['id'];
echo'<script>
    $(document).ready(function() {
     Swal.fire({
    title: "Success",
    text: "User Found",
    icon: "success",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    confirmButtonText: "View Details"
}).then((result) => {
    if (result.isConfirmed) {
        // Redirect to the dashboard or the desired URL
        window.location.href = "edit_user.php?user_id='.$id.'"; // Replace with your URL
    }
});

    });
</script>';  
}else{
echo'<script>
    $(document).ready(function() {
        Swal.fire({
            title: "Error!",
            text: "User Not Found",
            icon: "error",
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
            text: "Please fill all the fields first",
            icon: "warning",
            button: "Ok",
            
        });
    });
</script>';   
}
}
?>