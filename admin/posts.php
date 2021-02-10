<?php
include_once('./include/checkLoginStatus.php');
checkLoginStatus();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../lib/pagination.css">
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm pull-left btn-del-all" href="javascript:;" style="display: none">批量删除</a>
        <div class="pagination pagination-sm pull-right ">

        </div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" class='th-chk'></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
  <script type="text/template" id="tmp">
    {{each list v i}}
    <tr>
      <td class="text-center" data_id={{v.id}}><input type="checkbox" class='tr-chk'></td>
      <td>{{v.title}}</td>
      <td>{{v.nickname}}</td>
      <td>{{v.name}}</td>
      <td class="text-center">{{v.created}}</td>
      <td class="text-center">{{state[v.status]}}</td>
      <td class="text-center" data_id={{v.id}}>
        <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
    {{/each}}
  </script>

  <!-- include aside -->
  <?php
  $page = 'posts';
  include_once('./include/aside.php') ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../lib/jquery.pagination.js"></script>
  <script src="../lib/template-web.js"></script>
  <script>
    var currentPage = 0;
    var pageSize = 10;
    var state = {
      'drafted': '草稿',
      'trashed': '回收站',
      'published': "已发布",
    }
    $.ajax({
      url: './post_interface/comTotal.php',
      dataType: 'json',
      success: function(data) {
        renderPagination(data['total'])
      }
    })

    $('tbody').on('click', '.btn-del', function() {
      var id = $(this).parent().attr('data_id')
      console.log(id);
      $.ajax({
        url: './post_interface/comDel.php',
        dataType: 'json',
        data: {
          id: id,
        },
        success: function(data) {
          if (data) {
            var total = data['total']
            var maxPages = Math.ceil(total / pageSize)
            if (currentPage > maxPages - 1) {
              currentPage = maxPages - 1
            }
            renderPagination(total)
          } else {
            console.log('删除失败');
          }
        },
        error: function(err) {
          console.log(err);
        }
      })
    })

    function renderPagination(total) {
      $('.pagination').pagination(total, {
        prev_text: "« 上一页",
        next_text: "下一页 »",
        items_per_page: pageSize,
        num_edge_entries: 1, //两侧首尾分页条目数
        num_display_entries: 5,
        current_page: currentPage,
        callback: function(page) {
          currentPage = page
          getData()
        }
      });
    }

    function getData() {
      $.ajax({
        url: './post_interface/comGet.php',
        dataType: 'json',
        data: {
          page: currentPage,
          pageSize: pageSize,
        },
        success: function(data) {
          $('tbody').html(template('tmp', {
            list: data,
            state: state,
          }))
        }
      })
    }

    $('tbody').on('change', '.tr-chk', function() {
      var total = $('.tr-chk').length
      var checkedCount = $('.tr-chk:checked').length
      if (checkedCount >= 2) {
        $('.btn-del-all').show()
      } else {
        $('.btn-del-all').hide()
      }
      if (total == checkedCount) {
        $('.th-chk').prop('checked', true)
      } else {
        $('.th-chk').prop('checked', false)
      }
    })

    $('.th-chk').change(function() {
      var checked = $(this).prop('checked')
      $('.tr-chk').prop('checked', checked)
      if (checked) {
        $('.btn-del-all').show()
      } else {
        $('.btn-del-all').hide()
      }
    })
  </script>
  <script>
    NProgress.done()
  </script>
</body>

</html>