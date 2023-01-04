### 需要审核的表中需要以下字段

id  title  status  status_process 


status_process值为
wait   时可以进行审核
finish 完成

字段显示

~~~
//字段显示
'column'=>array_merge([
   ['field'=>'id','label'=>'ID','sortable'=>true,'width'=>'100'],
   ['field'=>'title','label'=>'店铺名称'], 
   ['field'=>'name','label'=>'联系人'], 
   ['field'=>'phone','label'=>'联系电话'],  
],status_process_table_column()), 
~~~


