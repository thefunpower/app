<?php 
/*
  Copyright (c) 2021-2050 FatPlug, All rights reserved.
  This file is part of the FatPlug Framework (http://fatplug.cn).
  This is not free software.
  you can redistribute it and/or modify it under the
  terms of the License after purchased commercial license. 
  mail: sunkangchina@163.com
  web: http://fatplug.cn
*/
include __DIR__.'/../../../../boot/app.php'; 
 
$table = $input['table']; 
shop_admin_is_login(); 
table_builder_edit($input);