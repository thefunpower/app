$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function ajax(url, data, call) {
    $.ajax({
        url: url, 
        type: "POST",
        dataType: "json",
        /**
        * application/x-www-form-urlencoded
        * application/json;charset=utf-8
        */
        contentType: "application/x-www-form-urlencoded",
        data: data,
        success: function (res) { 
            call(res);
        },
        error: function (xhr, textStatus, errorThrown) {
             
        },
    });
} 

 
function open_confirm(ajax_url,call){
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {  
        "确认删除": function() {
          $( this ).dialog( "close" );
          $.post(ajax_url,{id:app.row.id},function(res){
              call();
          },'json');
          
        },
        '取消': function() {
          $( this ).dialog( "close" );
        }
      }
    });
} 

$(function(){
  $(".tab_click a").click(function(){
      let name = $(this).attr("name");  
      if(name){ 
        app[name]();  
      }      
  });
  if($( "#tabs" ).length > 0){
    $( "#tabs" ).tabs(); 
  } 
});

function sort_table(id,call) {
  $( id+" tbody" ).sortable({ 
          cursor: "move",
          helper: function(e, ui) {   
          ui.children().each(function() {  
              $(this).width($(this).width());   
          });  
          return ui;  
      },
      axis:"y",
      start:function(e, ui){
          ui.helper.css({"background":"#fff"})
          return ui;
      },
      stop:function( event, ui ){
          call();
      }
  });
}