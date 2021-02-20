<?php
include_once('../../sql/fn.php');
$sql = "select * from categories";
$data = my_exec_query($sql);
$json = json_encode($data);
echo $json;