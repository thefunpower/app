<p class="mt10" style="display: flex;justify-content: flex-end;align-items: center;">
    <el-button @click="is_show=false" type="info" class="mr10">关闭</el-button>  
    <el-button v-if="save_auto_loading" type="info" disabled   >操作中，请稍等……</el-button>  
    <span v-else>
        <el-button v-if="form.id>0" type="primary"   @click="save_auto">更新</el-button> 
        <el-button v-else type="primary"   @click="save_auto">添加</el-button> 
    </span>
</p> 