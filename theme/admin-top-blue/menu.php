<?php if(!g('iframe_no_menu')){?>
<?php 
foreach ($menu as $k=>$v) {
  if(!$v['children']){
    unset($menu[$k]);
  }
}
$i=0;foreach ($menu as $v) { $i++;?> 
<div class="mdc-list-item mdc-drawer-item  ">
  <?php if(!$v['children']){?>
    <a href="<?= create_url($v['url'])?>" class="mdc-expansion-panel-link ">
      <?= lang($v['label']) ?> 
    </a>
  <?php }else{?>
    <a class="mdc-expansion-panel-link " href="javascript:void(0);" data-toggle="expansionPanel" data-target="ui-sub-menu<?=$i?>">
     
      <?= lang($v['label']) ?><?php if(g('debug')){?> (<?=$v['level']?>)<?php }?>
      <i class="mdc-drawer-arrow material-icons"></i>
    </a> 
  <?php }?>
  <?php 
    if($v['children']){
    ?>
  <div class="mdc-expansion-panel" id="ui-sub-menu<?=$i?>">
    <nav class="mdc-list mdc-drawer-submenu">
      <?php  
        foreach ($v['children'] as $v1) {
        $url = $v1["url"];
        if ($url) {
            $url = host() . $url;
        }
      ?>
      <div class="mdc-list-item mdc-drawer-item">
        <a class="mdc-drawer-link" href="<?= $url ?>">
          <?= lang($v1['label']) ?>
        </a>
      </div>
      <?php } ?>
    </nav>
  </div>
  <?php } ?>
</div> 
<?php } ?>
<?php } ?>