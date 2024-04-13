@extends('auth.layouts')

@section('content')
<div class="main-content-area ps-0">
  <div class="container">

				<!--=== Start Login Area ===-->
				<div class="login-area">
					<div class="text-center mb-4">
						<a href="index-2.html">
							<img src="assets/images/logo.svg" alt="logo">
						</a>
					</div> 
					<div class="card rounded-3 border-0 mb-24 mw-560 m-auto">
						<div class="card-body p-30">
							<div class="card-title mb-20 pb-20 border-bottom border-color text-center">
								<h4 class="mb-0 mb-2 fs-20">Login</h4>
								<p class="text-body fs-14">Welcome back Jacob Smith!</p>
							</div>

							<form  action="{{ route('authenticate') }}" method="post">
                @csrf
								<div class="form-group mb-4">
									<label class="fw-semibold fs-14 mb-2 text-dark">Email<span class="text-danger">*</span></label>
									<div class="form-floating">
										<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
										<label class="text-body fs-12" for="floatingInput">Enter Email</label>
                    @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
									</div>
								</div>
								<div class="form-group mb-4">
									<label class="fw-semibold fs-14 mb-2 text-dark">Password <span class="text-danger">*</span></label>
									<div class="form-floating position-relative">
										<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
										<label class="text-body fs-12" for="password-field1">Enter Password</label>
										<span toggle="#password-field1" class="text-body ri-eye-line field-icon toggle-password position-absolute top-50 end-0 fs-20 translate-middle-y" style="right: 10px !important; cursor: pointer;"></span>
                    @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
									</div>
								</div>
								<div class="form-group d-sm-flex justify-content-between">
									<div class="form-check mb-4">
										<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" style="position: relative; top: -2px;">
										<label class="form-check-label fs-14 text-body ms-2" for="flexCheckDefault">
											Remember password ? 
										</label>
									</div>
									<div class="mb-4">
										<a href="forgot-password.html" class="fs-14 text-primary text-decoration-none">Forgot your password?</a>
									</div>
								</div>
								<div class="form-group mb-4">
									<button type="submit" name="submit" class="btn btn-primary rounded-1 w-100 py-3">Login</button>
								</div>
								<div class="form-group mb-4 text-center">
									<p class="text-body mb-4 fs-14">Don't have an account? <a href="{{ route('register')}}" class="text-primary text-decoration-none">Register</a></p>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--=== End Login Area ===-->


      </div>
    </div>


    
@endsection
