<?php
session_start();
if(!isset($_SESSION['admin'])){
	header('location: ../index');
	return;
}
include("auth.php");
if($_GET['user_id']==""){
echo"invalid id";
return;
}else{
$user_id = $_GET['user_id'];
}
$sql=mysqli_query($conn,"SELECT * FROM user_data WHERE id='".$user_id."'");
if(mysqli_num_rows($sql)==0){
echo"invalid id";
return;
}
$user_data = mysqli_fetch_assoc($sql);

if(isset($_GET['update_status'])){
if($user_data['status'] ==1){
  $sql34 = mysqli_query($conn,"UPDATE user_data SET status='2' WHERE id='".$user_id."'");
  echo'<script>
  window.location("edit_user?user_id='.$user_id.'");
</script>';
}else{
  $sql34 = mysqli_query($conn,"UPDATE user_data SET status='1' WHERE id='".$user_id."'");
 echo'<script>
  window.location("edit_user?user_id='.$user_id.'");
</script>';
}
}
$sql2=mysqli_query($conn,"SELECT * FROM user_wallet WHERE user_id='".$user_id."'");
$user_wallet = mysqli_fetch_assoc($sql2);
if($user_data['status'] ==1){
$ban_status = "Block User";
$ban_class = "btn-success";

}else{
$ban_status = "Unblock User";
$ban_class = "btn-danger";

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit User - @radiumsahil</title>
<?php include("include/head.php"); ?>  
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
<?php include ("include/slidebar.php"); ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
<?php include ("include/topbar.php"); ?>              
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <!-- Form Basic -->
              <div class="card mb-4" id="loading">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                </div>
                <div class="card-body">
                     <div class="form-group">
                      <label for="exampleInputEmail1">User Email (Not Editable)</label>
                      <input type="email" class="form-control" id="email" value="<?php echo $user_data['email'];?>" placeholder="Enter User email"readonly>
                    <input type="hidden" id="user_id" value="<?php echo $user_id;?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Balance</label>
                      <input type="number" class="form-control" id="balance" value="<?php echo $user_wallet['balance'];?>" placeholder="User Balance">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Total Recharge</label>
                      <input type="number" class="form-control" id="recharge" value="<?php echo $user_wallet['total_recharge'];?>" placeholder="Recharge">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Total Otp Buy</label>
                      <input type="number" class="form-control" id="total_otp" value="<?php echo $user_wallet['total_otp'];?>" placeholder="Total Otp">
                    </div>
                   <button type="submit" id="update" class="btn btn-primary w-100 mb-2">Submit</button><br>
                   <a href="login_user?user_id=<?php echo $user_id;?>" target="_blank"><button type="submit" class="btn btn-success w-100 mb-2">Login As User</button></a><br> 
                   <form  method="get"><input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>"><button type="submit" name="update_status" value="update" class="btn <?php echo $ban_class; ?> w-100"><?php echo $ban_status;?></button></form>                                                              
               </div>
              
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
<?php include("include/copyright.php"); ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
<?php include("include/script.php"); ?>
<script>
$(document).ready(function() {
    // Attach a click event handler to the button

    $("#update").click(function() {
        Notiflix.Block.Dots('#loading', 'Please Wait');
    var user_id = $("#user_id").val();
    var balance = $("#balance").val();
    var recharge = $("#recharge").val();    
    var total_otp = $("#total_otp").val();

        var params = {
        user_id: user_id,
        balance: balance,
        recharge: recharge,
        total_otp: total_otp,
         };

        $.ajax({
            type: "POST",
            url: "ajax/update_user.php",
            data: params,
            error: function (e) {
                console.log(e);
               Notiflix.Block.Remove('#loading');
             $('#update').html(data);
                $('#update').html("Update");                
            },
            success: function (data) {
                   Notiflix.Block.Remove('#loading');
             $('#update').html(data);
                $('#update').html("Update");

            }
        });
    });
});
</script>

</body>

</html>