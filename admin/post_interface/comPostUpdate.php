<?php
include_once('../../sql/fn.php');
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$slug = $_POST['slug'];
// $feature = $_POST[''];
$category = $_POST['category'];
$created = $_POST['created'];
$status = $_POST['status'];
$file = $_FILES['feature'];
$feature = '';
if ($file['error'] == 0) {
  // 随机生成文件名，但是后缀名不变
  $ext = explode('.', $file['name'])[1];
  // 新文件名
  $newName = time() .  rand(999, 999999) . '.' . $ext;
  // 转移
  move_uploaded_file($file['tmp_name'], '../../uploads/' . $newName);
  // 保存图片地址
  // 由于不同点文件夹相对于uploads的路径不一样，我们能确定图片一定放在uploads里面；
  $feature = 'uploads/' . $newName;
}
$sql = '';
if(empty($feature)){
    $sql = "UPDATE posts set content = '$content',slug = '$slug',title = '$title',created = '$created',status = '$status',category_id = '$category' where id = $id";
}else{
    $sql = "UPDATE posts set content = '$content',slug = '$slug',title = '$title',created = '$created',status = '$status',category_id = '$category',feature = '$feature' where id = $id";
}

$data = my_exec($sql);
echo json_encode($data);