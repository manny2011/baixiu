<?php
include_once('../../sql/fn.php');
$page = $_GET['page'];
$pageSize = $_GET['pageSize'];
$start = $page * $pageSize;
$sql = "SELECT posts.*,users.nickname,categories.name FROM posts 
JOIN users on posts.user_id = users.id
JOIN categories on posts.category_id = categories.id
ORDER BY posts.id ASC
LIMIT $start,$pageSize";
$data = my_exec_query($sql);
echo json_encode($data);
