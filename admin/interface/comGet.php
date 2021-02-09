<?php //定义接口
  include_once ('../../sql/fn.php');
  $page = $_GET['page'];
  $pageSize = $_GET['pageSize'];
  $start = $page * $pageSize;
  // SELECT * from comments LIMIT 10,10;
  $sql = "SELECT comments.*,posts.title from comments JOIN posts on comments.post_id = posts.id LIMIT $start,$pageSize";
  $data = my_exec_query($sql);
  echo json_encode($data);
