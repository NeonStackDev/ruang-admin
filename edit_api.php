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
$sql=mysqli_query($conn,"SELECT * FROM api_detail WHERE id='".$id."'");
if(mysqli_num_rows($sql)==0){
echo"invalid id";
return;
}
//$server_data = mysqli_fetch_assoc($sql);
$api_data = mysqli_fetch_assoc($sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Api - @radiumsahil</title>
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
              <li class="breadcrumb-item active" aria-current="page">Edit Api </li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <!-- Form Basic -->
              <div class="card mb-4" id="loading">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Api Details </h6>
                </div>
                <div class="card-body">
            
                     <div class="form-group">
                      <label for="exampleInputEmail1">Api Name</label>
                      <input type="text" class="form-control" id="api_name" value="<?php echo $api_data['api_name'];?>" placeholder="">
                    <input type="hidden" id="id" value="<?php echo $id;?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Api Url</label>
                      <input type="text" class="form-control" id="api_url" value="<?php echo $api_data['api_url'];?>" placeholder="Enter Api Url">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Api Key</label>
                      <input type="text" class="form-control" id="api_key" value="<?php echo $api_data['api_key'];?>" placeholder="Enter Api Key">
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
    var api_name = $("#api_name").val();
    var api_url = $("#api_url").val();
    var api_key = $("#api_key").val();
    var description = $("#description").val();
      var id = $("#id").val();
        var params = {
        api_name: api_name,
        api_url: api_url,
        api_key: api_key,
        id: id,
        };

        $.ajax({
            type: "POST",
            url: "ajax/edit_api.php",
            data: params,
            error: function (e) {
                console.log(e);
            },
            success: function (data) {
                   Notiflix.Block.Remove('#loading');
             $('#update').html(data);
                $('#update').html("Add Api");

            }
        });
    });
});
</script>

</body>

</html>