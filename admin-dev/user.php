<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
global $config;

include __DIR__ . '/../boot/app.php';
$config['title'] = lang("员工");
include __DIR__ . '/header.php';
check_admin_login();
misc('jquery,vue,node,element,css');
?>
<div id="app" v-cloak>
	<div class="main_body">
		<div class="flex">
		<?php if (if_access('user.add')) { ?> 
			<el-button @click="is_show_add = true"><?=lang('添加员工')?></el-button>  
		<?php } ?>
		<el-select	v-model="where.status" @change="submit" style="width: 130px;" placeholder="<?=lang('状态')?>"> 
			<el-option label="<?=lang('在职')?>" value="1"></el-option>
			<el-option label="<?=lang('离职')?>" value="-1"></el-option>
		</el-select>
		 
		<el-input v-model="where.wq" @focus="blur" ref="wq" @keyup.enter.native="submit" placeholder="<?=lang('输入员工姓名并回车')?>"  style="width:300px"></el-input>
        <el-button  @click="submit" type="success" plain><?=lang('搜索')?></el-button>
        <el-button  @click="reset"  type="primary" plain><?=lang('重置')?></el-button>
        <?php do_action("html.group.button")?>
        </div>
		<el-table v-loading="loading" border class="mt10" :data="lists" style="width: 100%">
			<el-table-column type="index" label="<?=lang('序号')?>" :index="indexMethod" width="60">
        	</el-table-column>
			<el-table-column prop="user" label="<?=lang('员工姓名')?>" width="">
				<template slot-scope="scope">
					<span v-if="scope.row.nick_name">{{scope.row.nick_name}}</span>
					{{scope.row.user}}
				</template>

			</el-table-column>
			<el-table-column prop="phone" label="<?=lang('手机号')?>" width="180">
			</el-table-column>
			<el-table-column prop="email" label="<?=lang('电子邮件')?>" width="300">
			</el-table-column>
			<el-table-column prop="need_change" label="<?=lang('初始密码')?>" width="110">
	            <template slot-scope="scope">
	                <span v-if="scope.row.need_change">{{scope.row.need_change}}</span>
	                <span v-else ><?=lang('已修改')?></span>
	            </template>

	        </el-table-column>
	        
			<el-table-column prop="group_name" label="<?=lang('部门')?>" width="200">
			</el-table-column>
			<?php
			//admin/user.php中table中的column
			do_action("admin.user.table.column", $colum);
			echo $colum;
			?>
			<el-table-column label="<?=lang('操作')?>" width="120" fixed="right">
				<template slot-scope="scope">
					<el-dropdown @command="command($event,scope.row)">
						<span class="el-dropdown-link">
							<?=lang('选择操作')?><i class="el-icon-arrow-down el-icon--right"></i>
						</span>
						<el-dropdown-menu slot="dropdown">
							<?php if (if_access('system.user.update')) { ?>
								<el-dropdown-item :command="update"><?=lang('修改员工资料')?></el-dropdown-item>
							<?php } ?>

							<?php if (if_access('system.user.quit')) { ?>
								<el-dropdown-item :command="quit"><?=lang('离职')?></el-dropdown-item>
							<?php } ?>

							<?php if (if_access('system.user.reset_pwd')) { ?>
								<el-dropdown-item :command="reset_pwd"><?=lang('密码重置')?></el-dropdown-item>
							<?php } ?>

							<?php if (if_access('system.user.auth')) { ?>
								<el-dropdown-item v-if="scope.row.tag == 'admin'" :command="auth"><?=lang('设置操作权限')?></el-dropdown-item>
							<?php } ?>
							<?php
							//admin/user.php中table中的action
							do_action("admin.user.table.action", $action);
							echo $action;
							?>
						</el-dropdown-menu>
					</el-dropdown>

				</template>
			</el-table-column>

		</el-table>

		<p>
			<el-pagination background class="mt10" @size-change="page_size_change" @current-change="page_change" :current-page="page" :page-sizes="<?= el_page_sizes() ?>" :page_size="where.pre_page" layout="total, sizes, prev, pager, next, jumper" :total="total">
			</el-pagination>
		</p>
	</div>

	<el-dialog top="20px" title="<?=lang('添加')?>" @open="open" :visible.sync="is_show_add" width="500px">
		<el-form label-position="left" label-width="180px">
			<?php include __DIR__.'/_user_form.php';?>
			<?php
			//admin/user.php中表单
			do_action("admin.user.vue.form", $form);
			echo $form;
			?>
			<el-form-item label="" class="mt10">
				<el-button type="primary" @click="save"><?=lang('添加')?></el-button>
			</el-form-item>
		</el-form>
	</el-dialog>

	<el-dialog top="20px" title="<?=lang('修改')?>" :visible.sync="is_show_update" width="500px">
		<el-form label-position="left" label-width="180px">
			<?php include __DIR__.'/_user_form.php';?> 
			<?php
			//admin/user.php中表单
			do_action("admin.user.vue.form", $form);
			echo $form;
			?>
			<el-form-item label="" class="mt10">
				<el-button type="primary" @click="save"><?=lang('更新')?></el-button>
			</el-form-item>
		</el-form>
	</el-dialog>

	<el-dialog top="20px" title="<?=lang('绑定用户组')?>" :visible.sync="is_show_auth" width="350px">
		<el-form label-position="left" label-width="80px">
			<el-form-item label="<?=lang('用户名')?>">
				<el-input v-model="form.user" disabled></el-input>
			</el-form-item>
			<el-form-item label="<?=lang('选择用户组')?>">
				<el-select v-model="form.group_id" placeholder="<?=lang('请选择')?>">
					<el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
					</el-option>
				</el-select>
			</el-form-item>
			<el-form-item label="" class="mt10">
				<el-button type="primary" @click="save_auth"><?=lang('确认')?></el-button>
			</el-form-item>
		</el-form>
	</el-dialog>




	<?php
	//admin/user.php中HTML
	do_action("admin.user.vue.dialog", $dialog);
	echo $dialog;
	?>


</div>

<script type="text/javascript">
	var _this;
	var app = new Vue({
		el: "#app",
		data: {
			lists: [],
			page: 1,
			total: 0,
			where: {
				per_page: 20,
				status:"1",
			},
			form: {
				user: ""
			},
			is_show_update: false,
			is_show_add: false,
			is_show_auth: false,
			options: [],
			row: {},
			node: {},
			loading:true,
			<?php
			//admin/user.php中vue data
			do_action("admin.user.vue.data", $vue_data);
			echo $vue_data;
			?>
		},
		created() {
			_this = this;
			this.load();
			this.load_group();
		},
		methods: {
			<?php
			//admin/user.php中vue methods
			do_action("admin.user.vue.method", $vue_method);
			echo $vue_method;
			?>

			command(e, row) {
				this.row = row;
				console.log(e)
				e();
			},
			select_click(data) {
				this.node = data;
				this.form.group_id = data.id;
				this.form.group_name = data.label;
				this.$refs['group_id'].$el.click();
			},
			submit(){
				this.load();
			},
			reset(){
				this.where = {
					status:"1"
				};
				this.load();
			},
			reset_pwd(){
				layer.confirm("<?=lang('确认对员工')?> "+this.row.user+" <?=lang('重置密码')?>？", {
				  title:"<?=lang('操作提示')?>",
				  btn: ["<?=lang('确认')?>","<?=lang('取消')?>"] //按钮
				}, function(){
				   	ajax("/api/admin/user_reset_pwd.php", {id:_this.row.id}, function(res) {
						layer.closeAll();
						_this.load();
						_this.$message({type:res.type,message:res.msg});
					});
				}, function(){
				   
				});
			},
			quit(){
				layer.confirm("<?=lang('确认员工')?> "+this.row.user+" <?=lang('离职')?>？", {
				  title:"<?=lang('操作提示')?>",
				  btn: ["<?=lang('确认')?>","<?=lang('取消')?>"] //按钮
				}, function(){
				   	ajax("/api/admin/user_quit.php", {id:_this.row.id}, function(res) {
						layer.closeAll();
						_this.load();
						_this.$message({type:res.type,message:res.msg});
					});
				}, function(){
				   
				});
			},
			auth() {
				let h = window.innerHeight - 100;
				layer.open({
					type: 2,
					title: '[<span style="color:blue;font-weight: bold;font-size: 20px;">'+this.row.user+'</span>]',
					area: ['800px', h + 'px'],
					content: '/<?= ADMIN_DIR_NAME ?>/user_auth.php?id=' + this.row.id
				});
			},
			open() {
				this.form = {
					gender:'1',
					health_control:'-1'
				};
				<?php
				//admin/user.php中vue open方法
				do_action("admin.user.vue.add", $vue_add);
				echo $vue_add;
				?>
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
				ajax("/api/admin/user.php", this.where, function(res) {
					that.page = res.current_page;
					that.total = res.total;
					that.lists = res.data;
					that.loading = false;
				});
			},

			load_group() {
				let that = this;
				ajax("/api/admin/group_select.php", this.where, function(res) {
					that.options = res.data;
				});
			},

			update_auth() {
				row = this.row;
				this.is_show_auth = true;
				this.load_group();
				this.form = {
					id: row.id,
					user: row.user,
					group_id: row.group_id,

				};
			},

			save_auth() {
				let url = "/api/admin/user_bind_group.php";
				ajax(url, this.form, function(res) {
					_this.$message({
						message: res.msg,
						type: res.type
					});
					if (res.code == 0) {
						_this.is_show_auth = false;
						_this.load();
					}
				});
			},

			update() {
				this.is_show_update = true;
				let lists = JSON.parse(JSON.stringify(this.row));
				this.form = lists;
				<?php
				//admin/user.php中vue update方法
				do_action("admin.user.vue.edit", $vue_edit);
				echo $vue_update;
				?>
			},
			save() {
				let url = "/api/admin/user_add.php";
				if (this.form.id) {
					url = "/api/admin/user_update.php";
				}
				ajax(url, this.form, function(res) {
					_this.$message({
						message: res.msg,
						type: res.type
					});
					if (res.code == 0) {
						_this.is_show_add = false;
						_this.is_show_update = false;
						_this.load();
					}
				});
			}

		}
	});
</script>
<style type="text/css">
	.gender1 {
        color: blue;
    }

    .gender2,
    .active_color {
        color: red;
    }
</style>
<?php include __DIR__ . '/footer.php'; ?>