<header class="header-area bg-white mb-24">
    <div class="row align-items-center">
        <div class="col-lg-6 col-sm-6">
            <div class="header-left-content">
                <ul class="list-unstyled ps-0 mb-0 d-flex justify-content-center justify-content-lg-start justify-content-md-start align-items-center">
                    <li>
                        <div class="burger-menu d-none d-lg-block">
                            <span class="top-bar"></span>
                            <span class="middle-bar"></span>
                            <span class="bottom-bar"></span>
                        </div>
                        <div class="responsive-burger-menu d-block d-lg-none">
                            <span class="top-bar"></span>
                            <span class="middle-bar"></span>
                            <span class="bottom-bar"></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="header-right-content float-lg-end float-md-end">
                <ul class="list-unstyled ps-0 mb-0 d-flex justify-content-center justify-content-lg-end justify-content-md-end align-items-center">

                    <li class="ms-lg-4 ms-md-4 ms-2">
                        <div class="dropdown user-profile">
                            <div class="btn border-0 p-0 d-flex align-items-center text-start" data-bs-toggle="dropdown">
                                <div class="flex-shrink-0">
                                    <img class="rounded-circle user" src="{{ asset('assets/images/user/user.png') }}" alt="user">
                                </div>
                                <div class="flex-grow-1 ms-2 d-none d-xxl-block">
                                    <h3 class="fs-14 mb-0">{{ Auth::user()->name }}</h3>
                                    <span class="fs-13 text-body">{{ Auth::user()->privilege }}</span>
                                </div>
                            </div>
                            <ul class="dropdown-menu border-0 rounded box-shadow">
                                
                                <li>
                                    <a class="dropdown-item d-flex align-items-center text-body editprofile" href="javascipt:void();" data-bs-toggle="modal" data-bs-target="#editprofile" id="edit_profile">
                                        <i data-feather="user"></i>
                                        <span class="ms-2 fs-14">Edit Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center text-body" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <i data-feather="log-out"></i>
                                        <span class="ms-2 fs-14">Logout</span>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

        <!-- Modal -->
        <div class="modal fade" id="editprofile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-body">					
                        <form action="{{ route('store_profile') }}" method="post" id="editProfileForm">
                            @csrf
                          <div class="form-group mb-4">
                            <label class="fw-semibold fs-14 mb-2 text-dark">Name<span class="text-danger">*</span></label>
                            <div class="form-floating">
                              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                              <label class="text-body fs-12" for="floatingInput">Enter Name</label>
                              @if ($errors->has('name'))
                                  <span class="text-danger">{{ $errors->first('name') }}</span>
                              @endif
                            </div>
                          </div>
                          <div class="form-group mb-4">
                            <label class="fw-semibold fs-14 mb-2 text-dark">Email Address<span class="text-danger">*</span></label>
                            <div class="form-floating">
                              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                              <label class="text-body fs-12" for="floatingInput3">Enter Email</label>
                              @if ($errors->has('email'))
                                  <span class="text-danger">{{ $errors->first('email') }}</span>
                              @endif
                            </div>
                          </div>
                          <div class="form-group mb-4">
                            <label class="fw-semibold fs-14 mb-2 text-dark">New Password <span class="text-danger">*</span></label>
                            <div class="form-floating position-relative">
                              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                              <label class="text-body fs-12" for="password-field1">Enter Password</label>
                              <span toggle="#password-field1" class="text-body ri-eye-line field-icon toggle-password position-absolute top-50 end-0 fs-20 translate-middle-y" style="right: 10px !important; cursor: pointer;"></span>
                              @if ($errors->has('password'))
                                  <span class="text-danger">{{ $errors->first('password') }}</span>
                              @endif
                            </div>
                          </div>
                          <div class="form-group mb-4">
                            <label class="fw-semibold fs-14 mb-2 text-dark">Confirm Password <span class="text-danger">*</span></label>
                            <div class="form-floating position-relative">
                              <input  type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                              <label class="text-body fs-12" for="password-field2">Enter Confirm Password</label>
                              <span toggle="#password-field2" class="text-body ri-eye-line field-icon toggle-password position-absolute top-50 end-0 fs-20 translate-middle-y" style="right: 10px !important; cursor: pointer;"></span>
                            </div>
                          </div>
                          <div class="form-group mb-4">
                            <button type="submit" id="updateProfileBtn" class="btn btn-primary ounded-1 w-100 py-3">Update Profile</button>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>

            $(document).ready(function() {
              // edit employee ajax request
              $(document).on('click', '.editprofile', function(e) {
                    e.preventDefault();
                    let id ={{ Auth::user()->id }};
                    $.ajax({
                      url: '{{ route('get_profile') }}',
                      method: 'get',
                      data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                      },
                      success: function(response) {
                        $("#name").val(response.name);
                        $("#email").val(response.email);
                      }
                    });
                  });

                  const form = document.getElementById('editProfileForm');
const updateBtn = document.getElementById('updateProfileBtn');

form.addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Serialize the form data
    const formData = new FormData(form);

    // Send an AJAX request to the server
    fetch('{{ route("store_profile") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        }
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response data
        console.log(data); // For testing, you can log the response data
        if (data.status === 200) {
            // Show success message using SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 3000, // Auto close after 3 seconds
                showConfirmButton: false
            }).then(() => {
                // Optional: Perform any other actions after the alert is closed
                // For example, redirect to another page
                window.location.href = '{{ route("dashboard") }}';
            });
        } else {
            // Show error message using SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show error message using SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred. Please try again later.',
        });
    });
});

                    
            
                });

            
                    </script>
            