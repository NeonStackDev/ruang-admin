<?php
require_once '../include/config.php';
session_start();

// Admin check
if(!isset($_SESSION['admin'])){ // Change to match admin session
    die("Access Denied");
}

if(!isset($_GET['file'])) die("File not found");

$file = '/home/tqinvgbp/otpwall.online/Uploads/proofs/' . basename($_GET['file']);
if(file_exists($file)){
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if(in_array(strtolower($ext), ['jpg','jpeg','png','pdf'])){
        if($ext=='pdf') header('Content-Type: application/pdf');
        else header('Content-Type: image/'.$ext);
        readfile($file);
        exit;
    } else {
        die("Invalid file type");
    }
} else {
    die("File not found");
}
?>
