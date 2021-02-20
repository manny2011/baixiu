<?php
include_once('../../sql/fn.php');

echo '<pre>';
print_r($_POST);
echo '</pre>';

echo '<pre>';
print_r($_FILES);
echo '</pre>';

$title = $_POST['title'];
$content = $_POST['content'];
$slug = $_POST['slug'];
// $feature = $_POST[''];
$category = $_POST['category'];
$created = $_POST['created'];
$status = $_POST['status'];
session_start();
$user_id = $_SESSION['id'];
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

$sql = "insert into posts (title,slug,feature,created,content,status,'user_id','category_id') 
                    values ('$title','$slug','$feature','$created','$content','$status',$user_id,'$category')";

$data = my_exec($sql);
echo $data;
header('location:../posts.php');
