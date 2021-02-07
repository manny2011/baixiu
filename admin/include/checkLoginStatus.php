<?php
function checkLoginStatus()
{
  $sessionId = $_COOKIE['PHPSESSID']; //注意cookie传过来后的取值ID为 PHPSESSID
  if (empty($sessionId)) {
    header('location:./login.php');
    die(); //?停止当前脚本的执行 相当于exit().
  } else {
    session_start();
    $id = $_SESSION['id'];
    if (empty($id)) {
      header('location:./login.php');
      die(); //?
    }
  }
}
