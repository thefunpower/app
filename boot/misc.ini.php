<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms . $ID20221128 
*/

global $misc_config;
/**
 * misc('jquery,vue,element');  
 */

 
/**
* https://fomantic-ui.com/introduction/getting-started.html
*/
$misc_config['fui'] = [
	'misc/Fomantic-UI-2.9.0/semantic.min.css', 
	'misc/Fomantic-UI-2.9.0/semantic.min.js', 
]; 

/**
 * https://purecss.io/layouts/side-menu/#company
 */
$misc_config['pure'] = [
	'misc/css/pure.css', 
];

/**
* https://animate.style/
*/
$misc_config['animate'] = [
	'misc/css/animate.min.css', 
];
 

/**
* stackedit.js 
*/
 
$misc_config['stackedit'] = [
	'misc/js/stackedit.js', 
];

/**
* https://github.com/abodelot/jquery.json-viewer
* misc('json-viewer');
<pre id="json-renderer"></pre> 
var data = {
  "foobar": "foobaz"
};
$('#json-renderer').jsonViewer(data); 
*/
$misc_config['json-viewer'] = [
	'misc/json-viewer/jquery.json-viewer.css',
	'misc/json-viewer/jquery.json-viewer.js',
];

/**
 *https://purecss.io/start/
 */
$misc_config['pure'] = [
	'misc/css/pure.css',
];

/**
 * https://pandao.github.io/editor.md/
 */
$misc_config['md'] = [
	'misc/md/editormd.amd.min.js',
];

/*
https://github.com/highlightjs/highlight.js
hljs.highlightAll();
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('pre code').forEach((el) => {
      hljs.highlightElement(el);
    });
  });
</script>
*/
$misc_config['hljs'] = [
	'misc/hljs/highlight.min.css',
	'misc/hljs/highlight.min.js',
];


// https://treejs.cn/v3/faq.php#_206
$misc_config['ztree'] = [
	'misc/zTree/css/zTreeStyle/zTreeStyle.css',
	'misc/zTree/js/jquery.ztree.core.min.js',
];

//////////////////////////////////////////////

$misc_config['element'] = [
	'misc/element-ui/theme-chalk/index.css',
	'misc/element-ui/index.js',
];
/**
* https://layui.github.io/
* 2.7.6
*/
$misc_config['layui'] = [
	'misc/layui/layui.js',
	'misc/layui/css/layui.css',
];

$misc_config['jquery'] = [
	'misc/js/jquery.js',
	'misc/js/jquery-migrate-3.0.0.js',
	'misc/js/jquery.cookie.js',
	'misc/js/jquery.form.js',
	'misc/js/math.js', 
	'misc/js/md5.js', 
];

$misc_config['jquery3'] = [
	'misc/js/jquery.js', 
];


$misc_config['vue'] = [
	'misc/js/vue.js',
];


$misc_config['node'] = [
	'misc/js/common.js',
];

$misc_config['css'] = [
	'misc/css/admin.css',
];

$misc_config['tailwind'] = [
	'misc/css/tailwind.css',
];


$misc_config['wangEditor'] = [
	//'misc/js/wangEditor.js',
	'https://unpkg.com/@wangeditor/editor@latest/dist/css/style.css',
	'https://unpkg.com/@wangeditor/editor@latest/dist/index.js'
];
/**
 * https://sortablejs.github.io/Sortable/
 * https://github.com/SortableJS/Vue.Draggable
 */
$misc_config['sortable'] = [
	'misc/sortable/sortable.js',
	'misc/sortable/vuedraggable.umd.js',
];


$misc_config['echarts'] = [
	'misc/js/echarts.js',
];


$misc_config['fontawesome'] = [
	'misc/font-awesome/css/font-awesome.min.css',
];

$misc_config['bs3'] = [
	'misc/bs3/css/bootstrap.min.css',
	'misc/bs3/js/bootstrap.min.js', 
];

$misc_config['bs5'] = [
	'misc/bs5/css/bootstrap.min.css',
	'misc/bs5/js/bootstrap.min.js',
	'misc/bs5/js/bootstrap.bundle.min.js',
];

$misc_config['jui'] = [
	'misc/jquery-ui-1.13.1/jquery-ui.min.css',
	'misc/jquery-ui-1.13.1/jquery-ui.min.js',
];
