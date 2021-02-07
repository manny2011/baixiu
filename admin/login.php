<?php
include_once('../sql/fn.php');

if (!empty($_POST)) {
  // echo ('<pre>');
  // var_dump($_POST);//shift+alt+->扩大选中区域
  $email = $_POST['email'];
  $pwd = $_POST['password'];
  $msg = "";
  if (empty($email) || empty($pwd)) {
    $msg = '用户名或密码不能为空';
  } else {
    $sql = "select * from users where email = '$email'";
    $data = my_exec_query($sql);
    // var_dump($data);
    $data = $data[0];
    if ($data['password'] === $pwd) {
      session_start();
      $_SESSION['id'] = $data['id'];
      header('location:./index1.php');
    } else {
      $msg = '密码不正确';
    }
  }
  // echo $msg;
  // echo ('</pre>');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
  <div class="login"> 
    <!-- action='',表示向当前页面提交？ -->
    <form class="login-wrap" action="" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if (!empty($msg)) { ?>
        <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $msg ?>
        </div>
      <?php } ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <!-- input表单元素必须有name属性才能正常提交 -->
        <input id="email" type="email" class="form-control" name='email' placeholder="邮箱" autofocus>
      </div>
      <div class="form-group"> 
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" name='password' placeholder="密码">
      </div>
      <input class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
</body>

</html>