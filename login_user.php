<?php
session_start();
if(!isset($_SESSION['admin'])){
	header('location: ../index');
	return;
}
include("auth.php");
function generateRandomString($length = 30) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';

    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $random_string;
}
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$deviceString = "";
$current_time_in_ist = date('Y-m-d H:i:s');
if (preg_match('/iPhone|iPad|iPod/i', $user_agent)) {
    $deviceString = "Device: Apple iOS";
} elseif (preg_match('/Android/i', $user_agent)) {
    $deviceString = "Device: Android";
} elseif (preg_match('/Windows Phone/i', $user_agent)) {
    $deviceString = "Device: Windows Phone";
} elseif (preg_match('/Macintosh|Mac OS X/i', $user_agent)) {
    $deviceString = "Device: Macintosh (Mac)";
} elseif (preg_match('/Windows/i', $user_agent)) {
    $deviceString = "Device: Windows";
} elseif (preg_match('/Linux/i', $user_agent)) {
    $deviceString = "Device: Linux";
} else {
    $deviceString = "Device: Unknown";
}

$user_agent = $_SERVER['HTTP_USER_AGENT'];
$browserData = "";

// Use a regular expression to extract browser and version
if (preg_match('/(MSIE|Edge|Firefox|Chrome|Safari|Opera)[\/\s](\d+\.\d+)/i', $user_agent, $matches)) {
    $browser = $matches[1]; // Browser name
    $version = $matches[2]; // Browser version
    $browserData = "Browser: " . $browser . " " . $version;
} else {
    $browserData = "Browser information not found.";
}
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
$sql2=mysqli_query($conn,"SELECT * FROM login_token WHERE user_id='".$user_id."'");
$user_token = mysqli_fetch_assoc($sql2);
$token = generateRandomString();
$user_ip = $_SERVER['REMOTE_ADDR'];

if(mysqli_num_rows($sql2) == 0){
$sql22 = $conn->query("INSERT INTO login_token(user_id, token, create_date, device, browser, ip, status) VALUES ('".$user_id."','".$token."','".$current_time_in_ist."','".$deviceString."','".$browserData."','".$user_ip."','1')");
$_SESSION['token'] = $token;
echo'<script>
  window.open("../dashboard");
</script>';
echo"Press Back To Go Dashboard";
}else{
$_SESSION['token'] = $user_token['token'];
echo'<script>
  window.open("../dashboard");
</script>';
echo"Press Back To Go Dashboard";


}
?>