<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
global $config;

include __DIR__ . '/../boot/app.php';
$config['title'] = lang("部门");
include __DIR__ . '/header.php';
check_admin_login();
misc('jquery,vue,node,element,css');
$auth  = new \AuthClass;
$lists = $auth->load();
?>

<div id="app" v-cloak>
	<div class="main_body">

		<?php if (if_access('group.add')) { ?>
			<div class="flex">
				<el-button @click="is_show_add = true"><?=lang('添加部门')?></el-button> 
			</div>
		<?php } ?>
		<el-table v-loading="loading" border class="mt10" :data="lists" :default-expand-all="true" row-key="id" :tree-props="{children: 'children', hasChildren: 'hasChildren'}" style="width: 100%">
			<el-table-column type="index" label="<?=lang('序号')?>" :index="indexMethod" width="60">
        	</el-table-column>
			<el-table-column prop="name" label="<?=lang('部门名')?>" width="">
			</el-table-column>
			<?php if (if_access_or('system.group.auth,system.group.update')) { ?>
				<el-table-column label="<?=lang('操作')?>" width="120" fixed="right">
					<template slot-scope="scope">
						<el-dropdown @command="command($event,scope.row)">
							<span class="el-dropdown-link">
								<?=lang('选择操作')?><i class="el-icon-arrow-down el-icon--right"></i>
							</span>
							<el-dropdown-menu slot="dropdown">
								<?php if (if_access('system.group.update')) { ?>
									<el-dropdown-item :command="update"><?=lang('修改')?></el-dropdown-item>
								<?php } ?>
								<?php if (if_access('system.group.auth')) { ?>
									<el-dropdown-item :command="update_auth"><?=lang('分配权限')?></el-dropdown-item>
								<?php } ?>
								<?php
								//admin/group.php中table中的action
								do_action("admin.group.table.action", $action);
								echo $action;
								?>
							</el-dropdown-menu>
						</el-dropdown>

					</template>
				</el-table-column>


			<?php } ?>

		</el-table>


	</div>

	<el-dialog top="20px" title="<?=lang('添加')?>" :visible.sync="is_show_add" width="350px" @open="open">
		<el-form label-position="top" label-width="80px">
			<el-form-item label="<?=lang('部门名')?>">
				<el-input v-model="form.name"></el-input>
			</el-form-item>

			<el-form-item label="" class="mt10">
				<el-button type="primary" @click="save"><?=lang('添加')?></el-button>
			</el-form-item>
		</el-form>
	</el-dialog>

	<el-dialog top="20px" title="<?=lang('更新')?>" :visible.sync="is_show_update" width="350px">
		<el-form label-position="top" label-width="80px">
			<el-form-item label="<?=lang('部门名')?>">
				<el-input v-model="form.name"></el-input>
			</el-form-item>

			<el-form-item label="<?=lang('绑定上级')?>">
				<el-select v-model="form._pid_name" ref="pid">
					<el-option style="height: auto;width:100%;" :value="node">
						<el-tree class="filter-tree" @node-click="select_click" :data="options" default-expand-all ref="tree">
						</el-tree>
					</el-option>
				</el-select>
			</el-form-item>

			<el-form-item label="" class="mt10">
				<el-button type="primary" @click="save"><?=lang('更新')?></el-button>
			</el-form-item>
		</el-form>
	</el-dialog>

	<el-dialog top="20px"  :visible.sync="is_show_auth" width="800px">
		<div slot="title">
			[<span style='color:blue;font-weight: bold;font-size: 20px;'>{{row.name}}</span>]
		</div>
		<iframe :src="iframe_url" id="iframe" :style="'border: 0;width: 100%;height:'+(h-300)+'px;'"></iframe>
	</el-dialog>


	<?php
	do_action("admin.group.html", $dialog);
	echo $dialog;
	?>

</div>

<script type="text/javascript">
	var _this;
	var app = new Vue({
		el: "#app",
		data: {
			h: "",
			options: [],
			lists: [],
			page: 1,
			total: 0,
			where: {
				per_page: 20,
			},
			form: {},
			is_show_update: false,
			is_show_add: false,
			is_show_auth: false,
			iframe_url: "",
			node: {},
			row: {},
			loading:true,
			<?php
			do_action("admin.group.vue.data", $vue_data);
			echo $vue_data;
			?>
		},
		created() {
			_this = this;
			this.load();
			this.load_type();
			this.h = window.innerHeight - 100;
		},
		methods: {
			<?php
			do_action("admin.group.vue.method", $vue_method);
			echo $vue_method;
			?>
			command(e, row) {
				this.row = row;
				console.log(e)
				e();
			},
			handleCommand(e) {
				this[e.button](e.row);
			},
			composeValue(item, row) {
				return {
					'button': item,
					'row': row
				}
			},
			load_type() {
				ajax("/api/admin/group_select.php", {}, function(res) {
					_this.options = res.data;
				});
			},
			select_click(data) {
				this.node = data;
				this.form.pid = data.id;
				this.form._pid_name = data.label;
				this.$refs['pid'].$el.click();
			},
			page_size_change(val) {
				this.where.page = 1;
				this.where.per_page = val;
				this.load();
			},
			page_change(val) {
				this.where.page = val;
				this.load();
			},
			load() {
				let that = this;
				this.loading = true;
				ajax("/api/admin/group.php", this.where, function(res) {
					that.page = res.current_page;
					that.total = res.total;
					that.lists = res.data;
					that.loading = false;
				});
			},
			open() {
				this.form = {};
			},
			update_auth() {
				this.iframe_url = '/<?= ADMIN_DIR_NAME ?>/auth.php?id=' + this.row.id;
				this.is_show_auth = true;
			},
			update() {
				let row = this.row;
				this.is_show_update = true;
				this.form = {
					id: row.id,
					name: row.name,
				};
			},
			save() {
				let url = "/api/admin/group_add.php";
				if (this.form.id) {
					url = "/api/admin/group_update.php";
				}
				ajax(url, this.form, function(res) {
					_this.$message({
						message: res.msg,
						type: res.type
					});
					if (res.code == 0) {
						_this.form = {};
						_this.is_show_add = false;
						_this.is_show_update = false;
						_this.load();
					}
				});
			}

		}
	});
</script>
<?php include __DIR__ . '/footer.php'; ?>