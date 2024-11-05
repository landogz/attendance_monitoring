@extends('auth.layouts')

@section('content')

<style>
	@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
	*{
	  margin: 0;
	  padding: 0;
	  box-sizing: border-box;
	  font-family: 'Poppins', sans-serif;
	}
	html,body{
	  /* display: grid;
	  height: 100%;
	  width: 100%; */
	  /* place-items: center; */
	/*   background: -webkit-linear-gradient(left, #a445b2, #fa4299); */
	}
	::selection{
	  background: #fa4299;
	  color: #fff;
	}
	.wrapper{
	  overflow: hidden;
	  max-width: 512px;
	  background: #fff;
	  padding: 30px;
	  border-radius: 5px;
	  box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
	}
	.wrapper .title-text{
	  display: flex;
	  width: 200%;
	}
	.wrapper .title{
	  width: 50%;
	  font-size: 35px;
	  font-weight: 600;
	  text-align: center;
	  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
	}
	.wrapper .slide-controls{
	  position: relative;
	  display: flex;
	  height: 50px;
	  width: 100%;
	  overflow: hidden;
	  margin: 30px 0 10px 0;
	  justify-content: space-between;
	  border: 1px solid lightgrey;
	  border-radius: 5px;
	}
	.slide-controls .slide{
	  height: 100%;
	  width: 100%;
	  color: #fff;
	  font-size: 18px;
	  font-weight: 500;
	  text-align: center;
	  line-height: 48px;
	  cursor: pointer;
	  z-index: 1;
	  transition: all 0.6s ease;
	}
	.slide-controls label.signup{
	  color: #000;
	}
	.slide-controls .slider-tab{
	  position: absolute;
	  height: 100%;
	  width: 50%;
	  left: 0;
	  z-index: 0;
	  border-radius: 5px;
	  background: -webkit-linear-gradient(left, #0511B4, #3868D2);
	  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
	}
	input[type="radio"]{
	  display: none;
	}
	#signup:checked ~ .slider-tab{
	  left: 50%;
	}
	#signup:checked ~ label.signup{
	  color: #fff;
	  cursor: default;
	  user-select: none;
	}
	#signup:checked ~ label.login{
	  color: #000;
	}
	#login:checked ~ label.signup{
	  color: #000;
	}
	#login:checked ~ label.login{
	  cursor: default;
	  user-select: none;
	}
	.wrapper .form-container{
	  width: 100%;
	  overflow: hidden;
	}
	.form-container .form-inner{
	  display: flex;
	  width: 200%;
	}
	.form-container .form-inner form{
	  width: 50%;
	  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
	}
	.form-inner form .field{
	  height: 50px;
	  width: 100%;
	  margin-top: 20px;
	}
	.form-inner form .field input{
	  height: 100%;
	  width: 100%;
	  outline: none;
	  padding-left: 15px;
	  border-radius: 5px;
	  border: 1px solid lightgrey;
	  border-bottom-width: 2px;
	  font-size: 17px;
	  transition: all 0.3s ease;
	}
	.form-inner form .field input:focus{
	  border-color: #fc83bb;
	  /* box-shadow: inset 0 0 3px #fb6aae; */
	}
	.form-inner form .field input::placeholder{
	  color: #999;
	  transition: all 0.3s ease;
	}
	form .field input:focus::placeholder{
	  color: #b3b3b3;
	}
	.form-inner form .pass-link{
	  margin-top: 5px;
	}
	.form-inner form .signup-link{
	  text-align: center;
	  margin-top: 30px;
	}
	.form-inner form .pass-link a,
	.form-inner form .signup-link a{
	  color: #3868D2;
	  text-decoration: none;
	}
	.form-inner form .pass-link a:hover,
	.form-inner form .signup-link a:hover{
	  text-decoration: underline;
	}
	form .btn{
	  height: 50px;
	  width: 100%;
	  border-radius: 5px;
	  position: relative;
	  overflow: hidden;
	}
	form .btn .btn-layer{
	  height: 100%;
	  width: 300%;
	  position: absolute;
	  left: -100%;
	  background: -webkit-linear-gradient(right, #0511B4, #3868D2, #0511B4, #3868D2);
	  border-radius: 5px;
	  transition: all 0.4s ease;;
	}
	form .btn:hover .btn-layer{
	  left: 0;
	}
	form .btn input[type="submit"]{
	  height: 100%;
	  width: 100%;
	  z-index: 1;
	  position: relative;
	  background: none;
	  border: none;
	  color: #fff;
	  padding-left: 0;
	  border-radius: 5px;
	  font-size: 20px;
	  font-weight: 500;
	  cursor: pointer;
	}
	.auth-bg-cover {
    background: linear-gradient(-45deg, #0d6efd 50%, #198754);
    background-image: url(../images/back.jpg);
    background-position: center;
    background-size: cover;
}
	</style>
	
    <script src="{{ asset('assets/login/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/login/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/login/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/login/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/login/css/custom.min.css')}}" rel="stylesheet" type="text/css" />


	 <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="#" class="d-block">
                                                    <img src="assets/images/logo.png" alt="" width="188">
                                                </a>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white-50 pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">"VISION<br>PRMSU shall be a premier learner-centered and proactive university in a digital and global society."</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">"MISSION<br>The PRMSU shall primarily provide advance and higher professional, technical, and special instructions in various disciplines; undertake research, extension and income generation programs for the sustainable development of Zambales, the region and the country."</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">"QUALITY POLICY<br>The President Ramon Magsaysay State University is committed to continually strive for excellence in instruction, research, extension and production to strengthen global competitiveness adhering to quality standards for the utmost satisfaction of its valued customers."</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p class="text-muted">Sign in to continue to QR code based attendance monitoring system for PRMSU Junior High School</p>
                                        </div>

                                        <div class="mt-4">
											<div class="ps-0">
												<div class="container">
											  
															  <!--=== Start Login Area ===-->
															  <div class="login-area">
																  <div class="wrapper">
																	  <div class="title-text">
																		<div class="title login">
																		  Login Form
																		</div>
																		<div class="title signup">
																		  Signup Form
																		</div>
																	  </div>
																	
																	  <div class="form-container">
																		<div class="slide-controls">
																		  <input type="radio" name="slide" id="login" checked>
																		  <input type="radio" name="slide" id="signup">
																		  <label for="login" class="slide login">Login</label>
																		  <label for="signup" class="slide signup">Signup</label>
																		  <div class="slider-tab"></div>
																		</div>
																	
																		<div class="form-inner">
																		  {{-- Login Form --}}
																		  <form action="{{ route('authenticate') }}" method="post" class="login">
																			@csrf
																			<div class="field">
																			  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
																			  @if ($errors->has('email'))
																				  <span class="text-danger">{{ $errors->first('email') }}</span>
																			  @endif
																			</div>
																			<div class="field">
																			  <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
																			  @if ($errors->has('password'))
																				  <span class="text-danger">{{ $errors->first('password') }}</span>
																			  @endif
																			</div>
																			<div class="pass-link">
																			  {{-- <a href="#">Forgot password?</a> --}}
																			</div>
																			<div class="field btn">
																			  <div class="btn-layer"></div>
																			  <input type="submit" value="Login">
																			</div>
																			<div class="signup-link">
																			  Don't have an account? <a href="#signup">Signup now</a>
																			</div>
																		  </form>
																	
																		  {{-- Signup Form --}}
																		  <form action="{{ route('store') }}" method="post" class="signup">
																			@csrf
																			<div class="field">
																			  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name *" value="{{ old('name') }}" required>
																			  @if ($errors->has('name'))
																				  <span class="text-danger">{{ $errors->first('name') }}</span>
																			  @endif
																			</div>
																			<div class="field">
																			  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address *" value="{{ old('email') }}" required>
																			  @if ($errors->has('email'))
																				  <span class="text-danger">{{ $errors->first('email') }}</span>
																			  @endif
																			</div>
																			<div class="field">
																			  <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password *" required>
																			  @if ($errors->has('password'))
																				  <span class="text-danger">{{ $errors->first('password') }}</span>
																			  @endif
																			</div>
																			<div class="field">
																			  <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password *" required>
																			  <input type="text" class="form-control" name="priv" placeholder="Email Address *" value="Administrator" style="display: none;">
																			</div>
																			<div class="field btn">
																			  <div class="btn-layer"></div>
																			  <input type="submit" value="Signup">
																			</div>
																		  </form>
																		</div>
																	  </div>
																	</div>
															  
															  </div>
															  <!--=== End Login Area ===-->
											  
											  
													</div>
												  </div>
											  
											  
                                        </div>

                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>document.write(new Date().getFullYear())</script> PRMSU.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>

    

<script>
	const loginText = document.querySelector(".title-text .login");
const loginForm = document.querySelector("form.login");
const loginBtn = document.querySelector("label.login");
const signupBtn = document.querySelector("label.signup");
const signupLink = document.querySelector("form .signup-link a");
signupBtn.onclick = (()=>{
  loginForm.style.marginLeft = "-50%";
  loginText.style.marginLeft = "-50%";
});
loginBtn.onclick = (()=>{
  loginForm.style.marginLeft = "0%";
  loginText.style.marginLeft = "0%";
});
signupLink.onclick = (()=>{
  signupBtn.click();
  return false;
});
</script>
@endsection
