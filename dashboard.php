<?php
session_start();
if(!isset($_SESSION['admin'])){
	header('location: ../index');
	return;
}
include("auth.php");
$sql=mysqli_query($conn,"SELECT * FROM user_data");
$total_user=mysqli_num_rows($sql);
$today = date('Y-m-d'); // Today's date in "Y-m-d" format

$query = "SELECT * FROM user_data WHERE DATE(register_date) = '$today'";
$result = mysqli_query($conn, $query);

if ($result) {
    $today_register = mysqli_num_rows($result);
} else {
    echo "Error: " . mysqli_error($conn);
}
$sql = "SELECT amount FROM user_transaction";
$result = $conn->query($sql);

// Initialize total amount
$totalAmount = 0;

// Loop through rows and calculate total
if ($result->num_rows > 0) {
  // Inside the loop
while ($row = $result->fetch_assoc()) {
    $total_recharge += (int)$row["amount"];
}
}
$sql2 = "SELECT amount FROM user_transaction WHERE DATE(date) = '$today'";
$result2 = $conn->query($sql2);

// Initialize total amount
$total_recharge_today = 0;

// Loop through rows and calculate total
if ($result2->num_rows > 0) {
  // Inside the loop
while ($row = $result2->fetch_assoc()) {
    $total_recharge_today += (int)$row["amount"];
}
}
$sql8=mysqli_query($conn,"SELECT * FROM active_number WHERE status='1'");
$total_otp_sell=mysqli_num_rows($sql8);
$query12 = "SELECT * FROM active_number WHERE DATE(buy_time) = '$today' and status='1'";
$result13 = mysqli_query($conn, $query12);
$total_otp_sell_today = 0;

if ($result13) {
    $total_otp_sell_today = mysqli_num_rows($result13);
} else {
//    echo "Error: " . mysqli_error($conn);
}
$sql81=mysqli_query($conn,"SELECT * FROM user_data WHERE status='2'");
$ban_user=mysqli_num_rows($sql81);
$sql113=mysqli_query($conn,"SELECT * FROM user_wallet ORDER BY total_otp DESC LIMIT 20");



$sql20 = "SELECT balance FROM user_wallet";
$result20 = $conn->query($sql20);

// Initialize total amount
$total_balances = 0;

// Loop through rows and calculate total
if ($result20->num_rows > 0) {
  // Inside the loop
while ($row11 = $result20->fetch_assoc()) {
    $total_balances += (int)$row11["balance"];
}
}
$sql201 = "SELECT * FROM active_number WHERE DATE(buy_time) = '$today' and status='1'";
$result201 = $conn->query($sql201);

$today_otp_balances = 0;

// Loop through rows and calculate total
if ($result201->num_rows > 0) {
  // Inside the loop
while ($row112 = $result201->fetch_assoc()) {
    $today_otp_balances += (int)$row112["service_price"];
}
}
$sql2012 = "SELECT * FROM active_number WHERE status='1'";
$result2012 = $conn->query($sql2012);

$total_otp_balances = 0;

// Loop through rows and calculate total
if ($result2012->num_rows > 0) {
  // Inside the loop
while ($row1122 = $result2012->fetch_assoc()) {
    $total_otp_balances += (int)$row1122["service_price"];
}
}
$sql20121 = "SELECT * FROM active_number WHERE status='2'";
$result20121 = $conn->query($sql20121);

$total_otp_active_balance = 0;
$total_otp_active_number = 0;

// Loop through rows and calculate total
if ($result20121->num_rows > 0) {
$total_otp_active_number = $result20121->num_rows;
  // Inside the loop
while ($row11221 = $result20121->fetch_assoc()) {
    $total_otp_active_balance += (int)$row11221["service_price"];
}
}
$sql292 = mysqli_query($conn,"SELECT DISTINCT user_id FROM active_number WHERE DATE(buy_time) = '$today' and status='1'");

$today_active_user = mysqli_num_rows($sql292);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard - @OTPWALL</title>
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
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total User</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_user;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fa fa-plus"></i> <?php echo $today_register;?></span>
                        <span>Register Today</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-circle fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Requested Recharge</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">PKR <?php echo $total_recharge;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-plus"></i> PKR <?php echo $total_recharge_today;?></span>
                        <span>Recharge Today</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Otp Sell</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_otp_sell;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-plus"></i> <?php echo $total_otp_sell_today;?></span>
                        <span>Today Otp Sell</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
               <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Otp Sell Amount</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">PKR <?php echo $total_otp_balances;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-plus"></i> PKR <?php echo $today_otp_balances;?></span>
                        <span>Today Otp Sell Amount</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <img src="/radium_sahil_op_786_12/img/pkr.png" alt="PKR Symbol" class="text-danger" style="width: 2em; height: 2em;">
                    </div>
                  </div>
                </div>
              </div>
            </div>
                <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Active Numbers (Otp Not Received)</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_otp_active_number;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-plus"></i> PKR <?php echo $total_otp_active_balance;?></span>
                        <span>Active Number Amount</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-phone-slash fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
                  <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Today Active User</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $today_active_user;?></div>
                       </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
               <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Deposited User Balance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">PKR <?php echo $total_balances;?></div>
                     
                    </div>
                    <div class="col-auto">
                      <img src="/radium_sahil_op_786_12/img/pkr.png" alt="PKR Symbol" class="text-danger" style="width: 2em; height: 2em;">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Banded User</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ban_user;?></div>
                     
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-alt-slash fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

     
  
            <!-- Invoice Example -->
            <div class="col-xl-8 col-lg-7 mb-4">
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Top 20 Otp Buyer</h6>
                  <a class="m-0 float-right btn btn-danger btn-sm" href="all_user">View More <i
                      class="fas fa-chevron-right"></i></a>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Total Otp</th>
                        <th>Total Recharge</th>
                        <th>Total Balance</th>
                        <th>Status</th>
                        <th>Detail</th>
                      </tr>
                    </thead>
                    <tbody>
                       <?php
        $i=1;
        while($data=mysqli_fetch_array($sql113)){
        $user_id=$data['user_id'];
        $sql2=mysqli_query($conn,"SELECT * FROM user_data WHERE id='".$user_id."'");
       $data2=mysqli_fetch_assoc($sql2);  
        if($data2['status'] =="1"){
        $status = "badge badge-success";
        $status1 = "Active";
        }else{
          $status = "badge badge-danger";  
           $status1 = "Blocked";   
        }    
        ?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $data2['email'];?></td>
                        <td><?php echo $data['total_otp'];?></td>
                        <td><?php echo $data['total_recharge'];?></td>
                         <td><?php echo $data['balance'];?></td> 
                        <td><span class="<?php echo $status;?>"><?php echo $status1;?></span></td>
                        <td><a href="edit_user?user_id=<?php echo $user_id; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                      </tr>
<?php
  $i++;     
}
?>                   
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
            <!--Row-->

         <centre><div class="row">
            <div class="col-lg-12 text-center">
              <p>Any Bug Found Please Contact Me <a href="https://telegram.dog/radiumsahil"
                  class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-telegram"></i>&nbsp; Telegram</a></p>
            </div>
          </div></centre>

 
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

</body>

</html>