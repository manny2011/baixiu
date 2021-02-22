<?php
include_once('../../sql/fn.php');
$name = $_POST['name'];
$slug = $_POST['slug'];
if(!empty($name) && !empty($slug)){
  $sql = "INSERT INTO categories (slug,name) VALUES ('$slug','$name')";
  echo json_encode(my_exec($sql));
}else{
  echo '入参不合法';
}
