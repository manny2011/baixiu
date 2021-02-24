define([
  'b',
  'a'
], function (mb, ma) {//高层模块使用依赖模块的展出项
  'use strict';
  console.log('这是c.js');
  console.log(mb, ma);
  console.log('这是c.js');
});