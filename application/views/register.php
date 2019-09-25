<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/styles.css" type="text/css" />
    <!--<link
      href="https://fonts.googleapis.com/css?family=Roboto&display=swap"
      rel="stylesheet"
    />-->
    <!--<link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"
    />-->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <title>Hygieia || Sign Up</title>
  </head>
  <body>
    <section class="jumbotron hero">
      <div class="container">
        <div class="row">
          <!-- Sign Up -->
          <div
            class="col-sm-7 d-flex flex-column align-items-center justify-content-center"
          >
            <div class="d-flex flex-column w-50 justify-content-center">
              <h4 class="text-left mt-5">Sign Up</h4>
              <div class="alert-box">
					
				</div>
              <div class="spinner-border text-primary" role="status">
					<span class="sr-only">Signing you up...</span>
				  </div>
              <form class="pt-4" method="POST">
                <div class="form-group">
                  <input
                    type="email"
                    class="form-control"
                    placeholder="Enter email"
                    name="email"
                  />
                </div>

                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Enter your Name"
                    name="name"
                  />
                </div>
                <div class="form-group">
                  <input
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    name="password"
                    id="pass1"
                  />
                </div>
                
                <div class="text-right">
                  <button type="submit" class="btn btn-info">
                    Sign Up
                  </button>
                </div>
              </form>
            </div>
            <p class="text-right align-self-center pb-5 mb-5">
              Already have an account? <a href="<?php echo base_url()?>">Sign In</a>
            </p>
          </div>

          <!-- Linear Background -->
          <div
            class="col-sm-5 d-flex align-items-center justify-content-center linear"
          >
            <div
              class="d-flex flex-column justify-content-center align-self-center"
            >
              <h3 class="text-center">Hygieia <br />Net Worth Calculator</h3>
              <div class="text-center pt-4">
                <p>Calculate Net Worth</p>
                <p>Get your assets in one place</p>
                <p>Summary of liabilities</p>
              </div>
            </div>
          </div>
          <!-- End -->
        </div>
      </div>
    </section>
  </body>
</html>




<script>
	$(document).ready(()=>{
		$('.spinner-border').hide();
	})
	$('form').on('submit',(e)=>{
		e.preventDefault();
        console.log($('#pass1').val());
        console.log($('#pass2').val());
        if($('#pass1').val()===$('#pass1').val()){
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>auth/register',
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
    }else{

        $('form').show();
        $('.alert-box').html('<div class="alert alert-danger" role="alert">Passwords do not match</div>');

    }
	})
</script>



