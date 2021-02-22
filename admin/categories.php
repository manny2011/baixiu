<?php
include_once('./include/checkLoginStatus.php');
checkLoginStatus();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>

<body>
  <script>
    NProgress.start()
  </script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger alert-error" style="display: none;">
        <strong>错误！</strong>发生XXX错误
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="form-add">
            <h2>添加新分类目录</h2>
            <!-- 非必填 隐藏域 -->
            <input class='category-id' name="id" style="display: none;">
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称" required>
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong id="strong-slug">slug</strong></p>
            </div>
            <div class="form-group">
              <input type="button" class="btn btn-primary btn-add" value="添加">
              <input type="button" class="btn btn-primary btn-update" value="修改" style="display: none;">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm btn-del-all" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox" class='th-chk'></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- include aside -->
  <?php
  $page = 'categories';
  include_once('./include/aside.php') ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../lib/template-web.js"></script>
  <script>
    NProgress.done()
  </script>
  <script type="text/template" id="temp-category">
    {{each $data}}
    <tr>
      <td class="text-center" data-id={{$value.id}}><input type="checkbox" class='tb-chk'></td>
      <td>{{$value.name}}</td>
      <td>{{$value.slug}}</td>
      <td class="text-center" data-id={{$value.id}}>
        <a href="javascript:;" class="btn btn-info btn-xs btn-modify">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
    {{/each}}
  </script>
  <script>
    getDataList()

    $('tbody').on('click', '.btn-modify', function() {
      var category_id = $(this).parent().attr('data-id')
      $.ajax({
        url: './category_interface/comGetById.php',
        type: 'get',
        data: {
          id: category_id,
        },
        dataType: 'json',
        success: function(data) {
          $('#name').val(data['name'])
          $('#slug').val(data['slug'])
          $('.category-id').val(data['id'])
          $('.btn-add').hide()
          $('.btn-update').show()
        }
      })
    })

    $('tbody').on('click', '.btn-del', function() {
      var category_id = $(this).parent().attr('data-id')
      $.ajax({
        url: './category_interface/comDel.php',
        type: 'get',
        data: {
          id: category_id,
        },
        dataType: 'json',
        success: function(data) {
          getDataList()
        }
      })
    })

    $('#slug').on('input', function() {
      var input = $(this).val()
      $('#strong-slug').text(input || 'slug')
    })

    $('.btn-add').click(function() {
      var data = $('#form-add').serialize()
      console.log(data);
      if ($('#name').val().trim().length == 0 || $('#slug').val().trim().length == 0) {
        $('.alert-error').show()
        return false
      }
      $.post('./category_interface/comAdd.php', data, function(data, status) {
        console.log(status, data);
        if (status && data) {
          getDataList()
          console.log('添加成功');
          $('#form-add')[0].reset() //jquery对象没有reset方法
          $('#strong-slug').text('slug')
        } else {
          console.log('添加失败');
        }
      })
    })

    $('.btn-update').click(function() {
      var str = $('#form-add').serialize()
      $.ajax({
        url: './category_interface/comUpdate.php',
        data: str,
        dataType:'json',
        success:function(data){
          console.log(data);
          $('#strong-slug').text('slug')
          $('#form-add')[0].reset()
          $('.btn-add').show(500)
          $('.btn-update').hide(500)
          getDataList()
        }
      })
    })

    $('.th-chk').click(function() {
      $('tbody .tb-chk').prop('checked', this.checked)
      if (this.checked) {
        $('.btn-del-all').show()
      } else {
        $('.btn-del-all').hide()
      }
    })

    $('tbody').on('click', ' .tb-chk', function() {
      var total = $('tbody .tb-chk').length
      var checkedNum = $('tbody .tb-chk:checked').length
      if (checkedNum >= 2) {
        $('.btn-del-all').show()
      } else {
        $('.btn-del-all').hide()
      }
      $('.btn-del-all').prop('checked', checkedNum == total)
      $('.th-chk').prop('checked', checkedNum == total)
    })

    function getDataList() {
      $.ajax({
        url: './category_interface/comGet.php',
        type: 'get',
        dataType: 'json',
        success: function(data) {
          console.log(data);
          $('tbody').html(template('temp-category', data))
        }
      })
    }
  </script>
</body>

</html>