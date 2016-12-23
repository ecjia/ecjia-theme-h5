<?php
/*
Name: 用户中心模板
Description: 这是推广页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
<script type="text/javascript">
ecjia.touch.spread.init();

/***用户打开页面的时候就加载**/
$(document).ready(function(){
	initPage();
});
function initPage() {
	var url = "{$url}";
	var info = {
		'url' : window.location.href,
	};
		
	$.post(url, info, function(response, status){
		var data = response.data;
		wx.config({
			debug: true,
			appId: data.appId,
			timestamp: data.timestamp,
			nonceStr: data.nonceStr,
			signature: data.signature,
			jsApiList: [
				'checkJsApi',
				'onMenuShareTimeline',
				'onMenuShareAppMessage',
				'onMenuShareAppMessage',
				'hideOptionMenu',
			]
		});
		wx.ready(function () {
			//分享到朋友圈
			wx.onMenuShareTimeline({
		        title: "{$share_title}", // 分享标题【必填】
		        link: "{$invite_user.invite_url}", // 分享链接【必填】
		        imgUrl: data.image, // 分享图标【必填】
		        success: function () { 
		            // 用户确认分享后执行的回调函数
		        },
		        cancel: function () { 
		            // 用户取消分享后执行的回调函数
		        }
		    });

			//分享给朋友
		    wx.onMenuShareAppMessage({
		        title: "{$share_title}", // 分享标题【必填】
		        desc: "{$invite_user.invite_template}", // 分享描述【必填】
		        link: "{$invite_user.invite_url}", // 分享链接【必填】
		        imgUrl: data.image, // 分享图标【必填】
		        type: 'link', // 分享类型,music、video或link，不填默认为link【必填】
		        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		        success: function () { 
		            // 用户确认分享后执行的回调函数
// 					alert('已分享');
		        },
		        cancel: function () { 
		            // 用户取消分享后执行的回调函数
// 					alert('已取消');
		        }
		    });

		    //分享到QQ
		    wx.onMenuShareQQ({
		        title: "{$share_title}", // 分享标题
		        desc: "{$invite_user.invite_template}", // 分享描述
		        link: "{$invite_user.invite_url}", // 分享链接
		        imgUrl: data.image, // 分享图标
		        success: function () { 
		           // 用户确认分享后执行的回调函数
		        },
		        cancel: function () { 
		           // 用户取消分享后执行的回调函数
		        }
		    });
		});	
	});
};
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-spread">
	<div class="ecjia-bg-qr-code">
		<div class="bg-img"></div>
		<div class="qrcode_image">
			<img  src="{$invite_user.invite_qrcode_image}" />
		</div>
		<div class="my-invite-code">
			<p>我的邀请码</p>
			<div class="code-style">{$invite_user.invite_code}</div>
		</div>
	</div>
	<div class="invite-template">
		<textarea class="invite-template-style" name="invite_template">{$invite_user.invite_template}</textarea>
	</div>
	<div class="go-to-spread">
		<a class="show_spread_share"><div class="would-spread">我要推广</div></a>
	</div>
	
	<div class="ecjia-my-reward">
		<a href="{url path='user/user_bonus/my_reward'}"><div class="my_reward">查看我的奖励</div></a>
	</div>
	
	<div class="invite_explain"> 
		<p class="invite_explain-literal">邀请说明：</p>
		<div class="invite_explain-content">
			{if $invite_user.invite_explain_new}
				<!--{foreach from=$invite_user.invite_explain_new item=invite}-->
					{if $invite}
						<p>{$invite}；</p>
					{/if}
				<!--{/foreach}-->
			{else}
				{$invite_user.invite_explain}
			{/if}
		</div>
	</div>
	<div class="ecjia-spread-share hide"><img src="{$theme_url}images/spread.png"></div>
</div>
<!-- {/block} -->
