<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Mailboard</title>
	<base href="<?php echo base_url(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

   
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style> 
	 
	<script src="js/jquery.js"></script> 
	<script src="js/bootstrap.min.js"></script>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
	 
 
  </head>

  <body> 

	<div class="container">
	<div id="email-container"></div>
	<script> 
		var _base_url = "http://"+window.location.host+"/";
		var _base_url_full = window.location.href;
		$(document).ready(function(){  
			var _email_script=document.createElement('script');
			_email_script.type='text/javascript';
			_email_script.src=_base_url+"mailboard/js/email.js";
			$("body").append(_email_script); 
		}); 
	</script>
	</div>
  </body>
</html>
