<?php
include PATH . '/theme/default/header.php';
?>
<div id='main'>
    <div class="mb5">
    	<h3>员工管理</h3>
        <div class="flex">

            <el-button type="primary" size="small" @click="add()">添加</el-button>
            <el-input class="ml5 w300" v-model="where.wq" placeholder="请输入姓名、姓名拼音、手机号、邮件搜索" @input="search"></el-input>
            <el-button class="ml5 " type="" size="small" @click="search()">搜索</el-button>
            <el-button class="ml5 " type="" size="small" @click="reset()">重置</el-button>
        </div>
    </div>
    <el-table :data="list" :height="height" border style="width:100%;">
        <el-table-column prop="name" label="姓名" width="180">
        </el-table-column>
        <el-table-column prop="phone" label="手机号" width="180">
        </el-table-column>
        <el-table-column prop="email" label="邮件">
        </el-table-column>
        <el-table-column fixed="right" label="操作" width="100">
            <template slot-scope="scope">
                <el-button type="text" size="small" @click="edit(scope.row)">编辑</el-button>
            </template>
        </el-table-column>

    </el-table>

    <el-pagination  class="mb5" background layout="total, sizes,prev, pager, next" :page-size="per_page"
        :page-sizes="page_sizes" @size-change="size_change" @current-change="current_change" :total="total">
    </el-pagination>


    <el-dialog :close-on-click-modal="false" title="" :visible.sync="is_open" width="500px">
        <el-form ref="form" :model="form" label-width="80px" style="margin-right: 20px;">
            <el-form-item label="姓名" required>
                <el-input v-model="form.name" ref="name"></el-input>
            </el-form-item>
            <el-form-item label="手机号" required>
                <el-input v-model="form.phone" ref="phone"></el-input>
            </el-form-item>
            <el-form-item label="邮件" required>
                <el-input v-model="form.email" ref="email"></el-input>
            </el-form-item>

        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="is_open = false">取 消</el-button>
            <el-button type="primary" @click="save">确 定</el-button>
        </span>
    </el-dialog>


</div>

<?php
$vue->data("height", "");
$vue->data("list", "[]");
$vue->data("page", 1);
$vue->data("total", "");
$vue->data("per_page", 20);
$vue->data("page_sizes", json_encode([10, 20, 30, 40, 50, 100]));
$vue->data("total", "");
$vue->created(['load()','window_resize()']);
$vue->method("size_change(e)", "
	this.per_page = e;
	this.page = 1;
	this.load();
");
$vue->method("current_change(e)", " 
	this.page = e;
	this.load();
");

$vue->method("load()", " 
	let where = this.where;
	where.page = this.page;
	where.per_page = this.per_page;
	ajax('/sys/user/pager',where,function(res){
		app.list  = res.data;
		app.total = res.total;
	});
");
$vue->method("reset()", "
	this.where = {};
	this.page = 1;
	this.load();
");
$vue->method("search()", " 
	this.page = 1;
	this.load();
");
$vue->method("window_resize()", "
this.height = window.innerHeight - 160;
");


$vue->data('is_open', false);
$vue->method("edit(row)", " 
	this.row = row;
	this.is_open = true;
	this.form = {
		id:row.id,
		name:row.name,
		phone:row.phone,
		email:row.email,
	};
	this.\$nextTick(()=>{
		app.\$refs['name'].focus();
	});
");
$vue->method("add()", " 
	this.row = {};
	this.form = {};
	this.is_open = true;
	this.\$nextTick(()=>{
		app.\$refs['name'].focus();
	});
");

$vue->method("save()", "
	let url = '/sys/user/add';
	if(this.row.id){
		url = '/sys/user/edit';
	}
	ajax(url,{data:this.form},function(res){
	" . vue_message() . "	
	if(res.code == 0){
		app.load();
		app.is_open = false;
	}else{
		app.\$refs[res.key].focus();
	}
	});
");
?>
<script type="text/javascript">
window.onresize = function() {
    app.window_resize();
};
</script>


<?php   include PATH . '/theme/default/footer.php';?>