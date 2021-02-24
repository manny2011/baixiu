<?php
include_once('../../sql/fn.php');
$sql = "select * from options where id = 10";
$data = my_exec_query($sql);
echo json_encode($data[0]);
// echo $data[0];