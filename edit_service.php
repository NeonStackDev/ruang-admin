<?php
session_start();
if(!isset($_SESSION['admin'])){
	header('location: ../index');
	return;
}
include("auth.php");
if($_GET['id']==""){
echo"invalid id";
return;
}else{
$id = $_GET['id'];
}
$sql=mysqli_query($conn,"SELECT * FROM service WHERE id='".$id."'");
if(mysqli_num_rows($sql)==0){
echo"invalid id";
return;
}
$service_data = mysqli_fetch_assoc($sql);
$sql2=mysqli_query($conn,"SELECT * FROM otp_server WHERE id='".$service_data['server_id']."'");
$server_data = mysqli_fetch_assoc($sql2);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Service - @radiumsahil</title>
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
              <li class="breadcrumb-item active" aria-current="page">Edit Service </li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <!-- Form Basic -->
              <div class="card mb-4" id="loading">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Service Details </h6>
                </div>
                <div class="card-body">
                     <div class="form-group">
                      <label for="exampleInputEmail1">Server Name</label>
                      <input type="text" class="form-control" id="server_name" value="<?php echo $server_data['server_name'];?>" placeholder="Enter Server Name"readonly>
                    <input type="hidden" id="id" value="<?php echo $id;?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Price</label>
                      <input type="number" class="form-control" id="price" value="<?php echo $service_data['service_price'];?>" placeholder="Enter Service Price">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Service Name</label>
                      <input type="text" class="form-control" id="service_name" value="<?php echo $service_data['service_name'];?>" placeholder="Enter Service Name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Service Id</label>
                      <input type="text" class="form-control" id="service_id" value="<?php echo $service_data['service_id'];?>" placeholder="Enter Service Id">
                    </div>
                   <button type="submit" id="update" class="btn btn-primary w-100 mb-2">Submit</button><br>
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
    var price = $("#price").val();
    var name = $("#service_name").val();
    var service_code = $("#service_id").val();
    var service_id = $("#id").val();
        var params = {
        price: price,
        name: name,
        service_code: service_code,
        service_id: service_id,
        };

        $.ajax({
            type: "POST",
            url: "ajax/update_service.php",
            data: params,
            error: function (e) {
                console.log(e);
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