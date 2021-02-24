require.config({
  // <script src="../assets/vendors/jquery/jquery.js"></script>
  // <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  // <script src="../lib/moment.min.js"></script>
  // <script src="../lib/wangEditor.min.js"></script>
  // <script src="../lib/template-web.js"></script>
  baseUrl:'/baixiu/assets/vendors/',//1。这个路径后面必须要加上 /
  paths:{//2。相对路径前面都不加 /
    jquery:'jquery/jquery',
    bootstrap:'bootstrap/js/bootstrap',
    moment:'moment/moment',
    wangEditor:'wangEditor/wangEditor',
    template:'template/template-web',
    postAdd:'post-add',//3。相对路径结尾统一不加扩展名 .js
  },
  shim:{//针对不支持模块化的插件，进行处理（依赖和导出项）
    bootstrap:{
      deps:['jquery'],//依赖项
      // exports:'',  //导出项
    }
  }
})