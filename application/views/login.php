<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <base href="<?php echo base_url(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Carmelo Roda">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
	
		body {
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background-color: #eee;
		}

		.form-signin {
		  max-width: 330px;
		  padding: 15px;
		  margin: 0 auto;
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
		  margin-bottom: 10px;
		}
		.form-signin .checkbox {
		  font-weight: normal;
		}
		.form-signin .form-control {
		  position: relative;
		  font-size: 16px;
		  height: auto;
		  padding: 10px;
		  -webkit-box-sizing: border-box;
			 -moz-box-sizing: border-box;
				  box-sizing: border-box;
		}
		.form-signin .form-control:focus {
		  z-index: 2;
		}
		.form-signin input[type="text"] {
		  margin-bottom: -1px;
		  border-bottom-left-radius: 0;
		  border-bottom-right-radius: 0;
		}
		.form-signin input[type="password"] {
		  margin-bottom: 10px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}	
	
	</style>
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
	
	
  </head>

  <body>

    <div class="container">

      <form class="form-signin" onsubmit="return login.submit(this);">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" name="txtUsername" id="txtUsername" placeholder="Username" autofocus>
        <input type="password" class="form-control" name="txtpassword" id="txtPassword" placeholder="Password">         
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
 
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script> 
	<script>
		
		$(document).ready(function(){
			
			
			login = {
				
				submit: function(form){
					
					var u = jQuery.trim(form.txtUsername.value), 
						p = jQuery(form.txtpassword.value);
					
					if( u != '' && p != '' ){
						
						$.ajax({
							type:'post',
							url: 'login/check',
							data: $(form).serialize(),
							dataType: 'json',
							success: function(json){
								if(json.status){
									window.location = json.redirect
								}else{
									alert(json.msg);
								}
							}
						}); 
					} 
					return false; 
				} 
			
			}
			
		});
	
	</script>
  </body>
</html>
