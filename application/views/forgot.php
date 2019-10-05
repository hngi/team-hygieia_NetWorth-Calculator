<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Poppins|Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
</head>

<body>
   <div class="container-fluid">
       <div class="row">
            <div class="col-md-1"></div>
            
           <div class="col-md-6 form-container">
           <div class="alert-box">
					
          </div>
           <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Logging you in...</span>
            </div>
                <form action="" method="post">
                    <h3 class="text-center">Recover your password</h3>
                    <p>
                        Please enter the email address you used to sign up on this site to recover your password
                    </p>
                    <!-- error alert for wrong mail -->
                    
                    <div class="alert-danger">
                        
                    </div>

                    <div class="form-group form-input">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email-field" placeholder="Email*" name="email" required>
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control" id="email-field" placeholder="Name*" name="name" required>
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="email-field" placeholder="New Password*" name="password" required>
                        </div>

                    </div>
                    <div class="sign-in">
                        <button type="submit" name="forgot_password" class="btn btn-primary btn-block">Recover Password</button>
                    </div>
                </form>
           </div>
           <a href="<?php echo base_url();?>">Login?</a>
           <a href="<?php echo base_url();?>auth/register">Login?</a>
       </div>
   </div>
   <div class="loader-wrapper">
        <span class="loader"><span class="loader-inner"></span></span>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url();?>assets/js/script.js"></script> 
</body>
</html>



<script>
	$(document).ready(()=>{
		$('.spinner-border').hide();
	})
	$('form').on('submit',(e)=>{
		e.preventDefault();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>auth/forgot_password',
			dataType:'text',
			data:$('form').serialize(),
			beforeSend:()=>{
				$('.spinner-border').show();
				$('form').hide();
                $('.alert-box').html('');
			},
			
			success:(data)=>{
				//console.log(data);
				function succession(){
					let result=JSON.parse(data);
					$('.spinner-border').hide();
					
					
					if(result['success'] !== ''){
						$('.alert-box').html('<div class="alert alert-success" role="alert">'+result['success']+'</div>');
						
					}else{
						$('form').show();
						$('.alert-box').html('<div class="alert alert-danger" role="alert">'+result['error']+'</div>');
					}
				}
				setTimeout(succession,3000);
				
			},
			error:(err)=>{
				$('.spinner-border').hide();
				$('form').show();
				console.log(err);
			}
		})
	})
</script>

