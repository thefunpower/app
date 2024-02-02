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

Vue.prototype.$ELEMENT = { size: 'medium' };
Vue.mixin({
    methods: {

    }
});

$(document).ready(function () { }).keydown(
    function (e) {
        if (e.which === 27) {
            layer.closeAll();
        }

    });

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min)) + min; //不含最大值，含最小值
}
