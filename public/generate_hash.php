<?php

$password_anda = 'staff123'; 
$hashed_password = password_hash($password_anda, PASSWORD_DEFAULT);

echo "Password Asli: " . $password_anda . "<br>";
echo "Password Hash (untuk di database): " . $hashed_password;
?>