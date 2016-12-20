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

// wx.config({
//     debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//     appId: '', // 必填，公众号的唯一标识
//     timestamp: '', // 必填，生成签名的时间戳
//     nonceStr: '', // 必填，生成签名的随机串
//     signature: '',// 必填，签名，见附录1【必填：通过提供接口获取】
//     jsApiList: [
//         'checkJsApi',
//         'onMenuShareTimeline',
//         'onMenuShareAppMessage'
// 	]
//      // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
// });
// wx.ready(function () {
// 	var newHdUrl = ''+ '&fxOpenid=';
// 	    wx.onMenuShareTimeline({
//         title: '', // 分享标题【必填】
//         link: newHdUrl, // 分享链接【必填】
//         imgUrl: 'http://www.jeewx.com/P3-Web/content/bargain/images/top_01.png', // 分享图标【必填】
//         success: function () { 
//             // 用户确认分享后执行的回调函数
//         },
//         cancel: function () { 
//             // 用户取消分享后执行的回调函数
//         }
//     });
    
  
//     wx.onMenuShareAppMessage({
//         title: '', // 分享标题【必填】
//         desc: '东海音乐节起源于2011年，经过4年的持续举办，我们已经成为长三角地区最吸引人的户外音乐节之一。我们致力于将最好的音乐现场良性的融入城市生态，与观众共同创造一年一度的海洋音乐狂欢。', // 分享描述【必填】
//         link: newHdUrl, // 分享链接【必填】
//         imgUrl: 'http://www.jeewx.com/P3-Web/content/bargain/images/top_01.png', // 分享图标【必填】
//         type: 'link', // 分享类型,music、video或link，不填默认为link【必填】
//         dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
//         success: function () { 
//             // 用户确认分享后执行的回调函数
// 			alert('已分享');
//         },
//         cancel: function () { 
//             // 用户取消分享后执行的回调函数
// 			 alert('已取消');
//         }
//     });
// });

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
