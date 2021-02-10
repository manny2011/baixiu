<?php
include_once('../../sql/fn.php');
$id = $_GET['id'];
$sql = "delete from posts where id in ($id)";
$data = my_exec($sql);
if ($data) {
  $sql_query_all = "select count(*) as 'total' from posts 
  join users on posts.user_id = users.id
  join categories on posts.category_id = categories.id";
  $data = my_exec_query($sql_query_all);
  echo json_encode($data[0]);
} else {
  echo json_encode($data);
}
