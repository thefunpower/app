<!DOCTYPE html>
<html lang="en">
  <head>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <meta name="description" content="">
    <meta name="author" content=""> 
    <title></title> 
    <?php include __DIR__.'/js.php';?>
  </head>
  <body>
<?php 
global $vue; 
$vue = new Vue();
?>
<div id="app">
  <el-container style="height: 100vh; border: 1px solid #eee;">
  <?php include __DIR__.'/nav.php';?>   