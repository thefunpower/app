var load;
var map;
if(!host){
    var host = '';
} 
if(!signature_key){
    var signature_key = 'TheCoreFun2022';    
} 
/**
 * 签名 signature(d) 
 */
function signature(data) { 
    var n = null, d = {}, str = '', s = '';
    n = Object.keys(data).sort();
    for (var i in n) {  
        let dd =  data[n[i]];  
        if(typeof dd == 'object' ){
            if(dd){
                if(Object.keys(dd).length > 0){
                    dd = JSON.stringify (dd);  
                    d[n[i]] = dd;  
                }  
            } 
            
        }else{
            d[n[i]] = dd;  
        } 
    }  
    for (var k in d) {
        if (d[k] === '') continue;
        if (str != '') str += '';
        str += k + '=' + d[k];
    }
    str += '' + signature_key;   
    s = hex_md5(str).toUpperCase(); 
    return s;
}
 
function api_get(url,data,call){
    url = "/apireader/"+url;
    return ajax(url, data, call);
}

function ajax(url, data, call) {
    if(data._signature){
        data._signature = '';
    }
    data._timestamp = (Date.parse(new Date()))/1000;
    data._signature = signature(data);
    $.ajax({
        url: host+url, 
        type: "POST",
        dataType: "json",
        /**
        * application/x-www-form-urlencoded
        * application/json;charset=utf-8
        */
        contentType: "application/x-www-form-urlencoded",
        data: data,
        success: function (res) {
            if (load) {
                load.close();
            } 
            call(res);
        },
        error: function (xhr, textStatus, errorThrown) {
            if (load) {
                load.close();
            } 
        },
    });
} 

function select_jump(url,id,to_admin_home_page){
    let val = $('#'+id).val();
    let new_url = url+"?"+id+"="+val;
    if (self.frameElement && self.frameElement.tagName == "IFRAME") {
        window.parent.location.href = new_url;
    }else{
        window.location.href = new_url;
    }
    
}
// medium small mini
Vue.prototype.$ELEMENT = { size: 'medium' };
Vue.mixin({
    methods: {
        indexMethod(index) {
            let per_page = this.where.per_page||20;
            let cpage = this.where.page || 1;
            return (cpage - 1) * per_page + index + 1;
        },
        upload_success(f,res,files){
            console.log(f);
            let m = f.arr.request;
            let str = "";
            for(let i in m){
                if(i >=0){
                    str+=m[i];
                }
            }
            this.form[str] = f.data; 
            this.$forceUpdate();
        },
        initMap(id,lat,lng,content){
            if(map){
                map.destroy();
            }
            initMap(id,lat,lng,content);
        },
        show_loading(text) {
           load = this.$loading({
              lock: true,
              text: text,
              spinner: 'el-icon-loading',
              background: 'rgba(0, 0, 0, 0.7)'
           });
        }, 
        // 文件流转blob对象下载
        download_data(data, type, fileName) {
            let blob = new Blob([data], {type: `application/${type};charset=utf-8`});
            // 获取heads中的filename文件名
            let downloadElement = document.createElement('a');
            // 创建下载的链接
            let href = window.URL.createObjectURL(blob);
            downloadElement.href = href;
            // 下载后文件名
            downloadElement.download = fileName;
            document.body.appendChild(downloadElement);
            // 点击下载
            downloadElement.click();
            // 下载完成移除元素
            document.body.removeChild(downloadElement);
            // 释放掉blob对象
            window.URL.revokeObjectURL(href);
        },
        copy (data) {
          //创建input标签
          var input = document.createElement('input')
          //将input的值设置为需要复制的内容
          input.value = data;
          //添加input标签
          document.body.appendChild(input)
          //选中input标签
          input.select()
          //执行复制
          document.execCommand('copy')
          //成功提示信息
          this.$message.success('复制成功')
          //移除input标签
          document.body.removeChild(input)
        },
        json_viewer(data){
            layer.open({
                title:'',
                type:2,
                content:'/json_viewer.php?json='+encodeURI(data),
                area:['800px','800px']
            });
        }
    }
}); 
 


 $(document).ready(function () { }).keydown( 
　　　function (e) { 
　　　　if (e.which === 27) { 
　　　　　 layer.closeAll(); 
　　　　}

 });
 
/*
//设置infoWindow
<div id="map"></div>
initMap('map',39.984104,116.307503,"<div><img src='https://mapapi.qq.com/web/lbs/javascriptGL/demo/img/em.jpg'><p>Hello World!</p></div>");

*/
function initMap(id,lat,lng,content) { 
    let center = new TMap.LatLng(lat,lng); 
    map = new TMap.Map(id, {
        zoom: 16,
        center: center
    }); 
    new TMap.InfoWindow({
        map: map,
        position: center, 
        content: content
    });

} 
/**
 * 取文件后缀 pdf
 */
function get_ext(file_name){
    return file_name.substring(file_name.lastIndexOf('.') + 1);    
}
