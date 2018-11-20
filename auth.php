<?php
$pwd = $_POST['password'];

if (password_verify($pwd, md5($pwd))) {
    changePassword($userId, $pwd);
}

function changePassword($userId, $pwd) {
    $pwd = password_hash($pwd, 0);
    //sql update user where UserId set pwd = $pwd
}