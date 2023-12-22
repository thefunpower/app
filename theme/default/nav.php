<?php
include __DIR__ . '/menu.php';
?>
<el-aside width="200px" style="background-color: rgb(238, 241, 246)">
    <el-menu :default-active="nav_active" class="el-menu-vertical-demo">
        <?php
         $i = 1;
        foreach($menu as $v) {?>
        <el-submenu index="<?=$i?>">
            <template slot="title">
                <i class="<?=$v['icon']?>"></i>
                <span slot="title"><?=$v['title']?></span>
            </template>
            <?php
            $j = 0;
            if($v['menu']) {
                foreach($v['menu'] as $kk => $vv) {
                    $j++;
                    ?>
            <el-menu-item index="<?=$i . "_" . $j?>" @click="nav_left_click('<?=$vv?>','<?=$i . "_" . $j?>')"><?=$kk?>
            </el-menu-item>
            <?php }
           }?>
        </el-submenu>
        <?php $i++;
        }?>
    </el-menu>
</el-aside>

<?php
$vue->created(['load_iframe_url()']);
$vue->data("nav_active", "1_1");

$vue->method("load_iframe_url()", "
  let url = $.cookie('iframe_url');
  let nav_active = $.cookie('nav_active');
  if(url){
    $('#main_iframe').attr('src',url);
  }
  if(nav_active){
    this.nav_active = nav_active;
  }
");

$vue->method("nav_left_click(url,nav_active)", "
  $('#main_iframe').attr('src',url);
  this.nav_active = nav_active;
  $.cookie('iframe_url', url, { expires: 365, path: '/' });
  $.cookie('nav_active', nav_active, { expires: 365, path: '/' });

  nav_active
");
