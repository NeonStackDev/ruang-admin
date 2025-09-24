<?php
session_start();
if(!isset($_SESSION['admin'])){
	header('location: ../index');
	return;
}
include("auth.php");
$today = date('Y-m-d'); // Today's date in "Y-m-d" format

$sql=mysqli_query($conn,"SELECT * FROM active_number WHERE status='1' and DATE(buy_time) = '$today' ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Today Number History- @radiumsahil</title>
<?php include("include/head.php"); ?>  
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  
</head>
<script>
        $(document).ready(function() {
            // Remove "active" class from all <a> elements
            $('#dashboard').removeClass("active");
            
            // Add "active" class to the specific element with ID "faq"
            $("#today_otp").addClass("active");
        });
    </script>
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
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Today Number History</li>
            </ol>
          </div>

        <!---Container Fluid-->
                  <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Today Number History</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light">
                      <tr>
                          <th>Email</th>
                                                <th>Number</th>
                                                <th>Buy Time</th>
                                                <th>Service name</th>
                                                <th>Server id</th>
                                                <th>Sms</th>
                       </tr>
                    </thead>
                     <tbody>
                                                                   <?php
        $i=1;
        while($data=mysqli_fetch_array($sql)){
        $user_id=$data['user_id'];
        $sql2=mysqli_query($conn,"SELECT * FROM user_data WHERE id='".$user_id."'");
        $sql3=mysqli_fetch_assoc($sql2);
         if($data['status'] =="1"){
        $status = "badge badge-success";
        $status1 = "Active";
        }else{
          $status = "badge badge-danger";  
           $status1 = "Blocked";   
        }    
        ?>
          <tr>
           <td><?php echo $sql3['email'];?></td>
           <td><?php echo $data['number'];?></td>
           <td><?php echo $data['buy_time'];?></td>
          <td><?php echo $data['service_name'];?></td>
          <td><?php echo $data['server_id'];?></td>
          <td><?php echo $data['sms_text'];?></td>          
           </tr>                                       
         <?php
          $i++;
          }
          ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
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
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>  
</body>

</html>