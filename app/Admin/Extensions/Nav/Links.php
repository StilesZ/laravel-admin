<?php

namespace App\Admin\Extensions\Nav;
class Links
{
    public function __toString()
    {
        return <<<HTML

<!--<audio style="display:none; height: 0" id="bg-music" preload="auto" src="http://fjdx.sc.chinaz.com/Files/DownLoad/sound1/201511/6571.mp3" loop="loop"></audio>-->

<li>
    <a href="">
      <i class="fa fa-bell-o"></i>
      <span class="label label-warning" id="inventory"></span>
    </a>
</li>

<script>

    var getting = {
        url:'/inventory',
        dataType:"json",
        success:function(res) {
          if(res.code == 200){
              toastr.options.timeOut=120000; // 保存2分钟
                toastr.warning(res.msg); // 提示文字
                toastr.options.onclick = function(){
                    location='order';  // 点击跳转页面
                };
               // var audio = document.getElementById('bg-music');  // 启用音频通知
               //  audio.play();
               //  setTimeout(function(){
               //      audio.load(); // 1.5秒后关闭音频通知
               //  },1500);
          }
          $('#inventory').html(res.re);
        },
        error: function (res) {
            console.log(res);
        }
    };
    window.setInterval(function() {
      $.ajax(getting)
    },5000);
</script>

HTML;
    }
}
