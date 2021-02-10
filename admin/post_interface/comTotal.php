<?php
include_once('../../sql/fn.php');
$sql = "select count(*) as 'total' from posts 
        join users on posts.user_id = users.id
        join categories on posts.category_id = categories.id";
$data = my_exec_query($sql);
echo json_encode($data[0]);
