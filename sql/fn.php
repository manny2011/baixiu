<?php
define('HOST', '127.0.0.1');
define('USR', 'root');
define('PWD', 'root');
define('DB', 'zbaixiu');

// $sql = "delete from users where id = 63";
// $data = my_exec($sql);
// var_dump($data);

//1.增删改语句
function my_exec($sql)
{
  $link = mysqli_connect(HOST, USR, PWD, DB);
  $r = mysqli_query($link, $sql);
  mysqli_close($link);
  return $r;
}

//2.查询语句
function my_exec_query($sql)
{
  $link = mysqli_connect(HOST, USR, PWD, DB);
  $r = mysqli_query($link, $sql);
  $num = mysqli_num_rows($r);
  if (!$r || $num == 0) {
    mysqli_close($link);
    return false;
  } else {
    $data = [];
    for ($i = 0; $i < $num; $i++) {
      $data[] = mysqli_fetch_assoc($r);
    }
    mysqli_close($link);
    return $data;
  }
}
