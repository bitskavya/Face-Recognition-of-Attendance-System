<?php
$role=$_POST['role'];
$orgId=$_POST['orgId'];
$firstName=$_POST['firstName'];
$lastName=$_POST['lastName'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$department=$_POST['department'];
$batch=$_POST['batch'];
$password1=$_POST['password1'];
$confirm=$_POST['confirm'];
$tos=$_POST['tos'];
$servername = "sql306.infinityfree.com";
$username = "if0_40809241";
$password = "Sweety2005g";
$database = "if0_40809241_kavya";
$con=new mysqli($servername,$username,$password,$database);
$sql="insert into reg1(role ,orgid ,firstname,lastname ,email ,phone ,department ,batch ,password1 ,confirm ,tos )values('$role' ,'$orgId' ,'$firstName','$lastName' ,'$email' ,'$phone' ,'$department' ,'$batch' ,'$password1' ,'$confirm' ,'$tos')";
$res=$con->query($sql);
if($res)
header("location:index.html");
else
echo("not reg")
?>

















