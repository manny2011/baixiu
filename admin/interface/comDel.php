<?php
include_once('../../sql/fn.php');
$id = $_GET['id'];
$sql = "DELETE from comments where id = $id";
$data = my_exec($sql);

if ($data == 1) { //删除成功
  $sql_query_all = "select count(*) as 'total' from comments JOIN posts where comments.post_id = posts.id";
  $data = my_exec_query($sql_query_all);
  echo json_encode($data[0]);
} else {
  echo $data;
}
