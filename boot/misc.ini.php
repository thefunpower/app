<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md . $ID20221128 
*/

global $misc_config;

/**
 * misc('jquery,vue,element');  
 */ 

/**
 * https://purecss.io/layouts/side-menu/#company
 */
$misc_config['pure'] = [
	'misc/css/pure.css', 
];



$misc_config['node'] = [
	'misc/js/common.js',
];

$misc_config['css'] = [
	'misc/css/admin.css',
];

/**
* stackedit.js 
*/
 
$misc_config['stackedit'] = [
	'misc/js/stackedit.js', 
];
/**
 *https://purecss.io/start/
 */
$misc_config['pure'] = [
	'misc/css/pure.css',
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



/**
* https://animate.style/
*/
$misc_config['animate'] = [
	'node_modules/animate.css/animate.min.css', 
];


$misc_config['fontawesome'] = [
	'node_modules/font-awesome/css/font-awesome.min.css',
];
  
 
/**
* https://fomantic-ui.com/introduction/getting-started.html
*/
$misc_config['fui'] = [
	'node_modules/fomantic-ui/dist/semantic.min.css', 
	'node_modules/fomantic-ui/dist/semantic.min.js', 
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
	'node_modules/jquery.json-viewer/json-viewer/jquery.json-viewer.js',
	'node_modules/jquery.json-viewer/json-viewer/jquery.json-viewer.css',
];



/**
 * https://pandao.github.io/editor.md/
 */
$misc_config['md'] = [
	'node_modules/editor.md/editormd.amd.min.js',
];



// https://treejs.cn/v3/faq.php#_206
$misc_config['ztree'] = [
	'node_modules/@ztree/ztree_v3/css/zTreeStyle/zTreeStyle.css',
	'node_modules/@ztree/ztree_v3/js/jquery.ztree.core.min.js',
];

//////////////////////////////////////////////

$misc_config['element'] = [
	'node_modules/element-ui/lib/theme-chalk/index.css',
	'node_modules/element-ui/lib/index.js',
];
/**
* https://layui.github.io/
* 2.7.6
*/
$misc_config['layui'] = [
	'node_modules/layui/dist/layui.js',
	'node_modules/layui/dist/css/layui.css',
];

$misc_config['jquery'] = [
	'node_modules/jquery/dist/jquery.min.js',
	'node_modules/jquery-migrate/dist/jquery-migrate.min.js',
	'node_modules/jquery.cookie/jquery.cookie.js',
	'node_modules/jquery-form/dist/jquery.form.min.js',
	'node_modules/mathjs/lib/browser/math.js', 
	'misc/js/md5.js', 
];
  

$misc_config['vue'] = [
	'node_modules/vue/dist/vue.min.js',
];


$misc_config['wangEditor'] = [ 
	'node_modules/@wangeditor/editor/dist/css/style.css',
	'node_modules/@wangeditor/editor/dist/index.js', 
];
/**
 * https://sortablejs.github.io/Sortable/
 * https://github.com/SortableJS/Vue.Draggable
 */
$misc_config['sortable'] = [
	'node_modules/sortablejs/Sortable.min.js',  
	'node_modules/vuedraggable/dist/vuedraggable.umd.min.js'
];


$misc_config['echarts'] = [
	'node_modules/echarts/dist/echarts.min.js',
];


$misc_config['bs5'] = [
	'node_modules/bootstrap/dist/css/bootstrap.min.css',
	'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 
];

$misc_config['jui'] = [
	'node_modules/jquery-ui/dist/themes/base/jquery-ui.min.css',
	'node_modules/jquery-ui/dist/jquery-ui.min.js',
];
