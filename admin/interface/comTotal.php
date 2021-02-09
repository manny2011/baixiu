<?php
  include_once('../../sql/fn.php');
  // SELECT count(*) as 'total' from comments JOIN posts on comments.post_id = posts.id;
  $sql = "SELECT count(*) as 'total' from comments JOIN posts on comments.post_id = posts.id";
  $data = my_exec_query($sql);
  echo json_encode($data[0]);
