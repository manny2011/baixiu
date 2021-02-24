define([], function (require, factory) {
  'use strict';
  console.log('这是b.js');
  var obj = {
    name: 'xxx',
    sex: 'male'
  }
  return obj//设置模块导出项供外界使用
});