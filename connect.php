<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Renren Connect</title>
  <script type="text/javascript">
    addEventListener = function(element, type, handler) {
	  if (element.addEventListener) {
        element.addEventListener(type, handler, false);
      } else if (element.attachEvent){
        handler._ieEventHandler = function () {
          handler(window.event);
        };
        (element).attachEvent("on" + type, (handler._ieEventHandler));
      }
	}
  </script>
</head>
<body>
<script type="text/javascript">
  	function sendFeed(id){
	var schoolid = "<?php echo '11' ?>";
  		feedSettings = {
  			"template_bundle_id": 1,
			"template_data": {"images":[{"src":"http://www.duitasuo.com/images/tuitasuo_logo.jpg","href":"http://www.duitasuo.com/home.php?schoolid="+schoolid+""}], "site":"<a href=\"http://www.duitasuo.com\">对ta说</a>","feedtype":"对ta说","content":""+id+"","action":"click"},
  			"user_message_prompt": "邀请大家都来看看",
  			"user_message": "好精彩啊！快来看看！"
  		};
  		XN.Connect.showFeedDialog(feedSettings);
  	}
  </script>
  
  
  <a id="feed_link" href="javascript:void(0);" onclick='aa(1)'>告诉人人好友</a>
  
  
  <script type="text/javascript" src="http://static.connect.renren.com/js/v1.0/FeatureLoader.jsp"></script>
  <script type="text/javascript">
  function aa(id){
    XN_RequireFeatures(["EXNML"], function()
    {
      XN.Main.init("ca131a518fd642d0b20a72a897648aac", "/xd_receiver.html");
      XN.Connect.requireSession(sendFeed(id));   
    });
  }
  </script>
</body>
