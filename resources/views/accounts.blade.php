@extends('auth.layouts')

@section('content')
    
		<!--=== Start Sidebar Menu Area ===-->		
		@include('auth.sub-files.sidebar_menu')
		<!--=== End Sidebar Menu Area ===-->

		<!--=== Start Main Content Area ===-->
		<div class="main-content-area">
			<div class="container-fluid">
				<!--=== Start Header Area ===-->				
					@include('auth.sub-files.header')
				<!--=== End Header Area ===-->

                <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
					<h4 class="text-dark mb-0">Admin Accounts</h4>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
							<li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item fs-14 text-primary" aria-current="page">Accounts</li>
						</ol>
					</nav>
				</div>

				<!--=== Start Website Overview Area ===-->
				<div class="input-groups-area">
					<div class="row justify-content-center">
						<div class="col-lg-12 mb-24">
							<div class="card rounded-3 border-0 h-100">
								<div class="card-body p-25">
									<div class="d-flex justify-content-between align-items-center border-bottom border-color pb-25 mb-25">
										<div class="d-flex align-items-center">
											<h4 class="mb-0 ms-2 fs-16">List of Accounts</h4>
										</div>
                      <button class="btn btn-primary rounded-2 btn-primary-transparent px-3" type="button" data-bs-toggle="modal" data-bs-target="#addprofile" id="new_account">
											<span class="d-none d-sm-block ms-0">New Account</span>
										</button>
									</div>                             
                                        <div class="row justify-content-center">
                                            <div class="global-table-area">
                                                <div class="table-responsive overflow-auto h-540" id="show_accounts">
                                                </div>
                                            </div>
                                        </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--=== End Website Overview Area ===-->
			</div>

			<div class="flex-grow-1"></div>

		
		</div>


    <!-- Modal -->
    <div class="modal fade" id="addprofile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Profile</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-body">					
                  <form action="{{ route('store_profile_edit') }}" method="post" id="editProfileForm_profile">
                      @csrf
                    <div class="form-group mb-4">
                      <label class="fw-semibold fs-14 mb-2 text-dark">Name<span class="text-danger">*</span></label>
                      <div class="form-floating">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name_profile" name="name_profile" value="{{ old('name') }}">
                        <label class="text-body fs-12" for="floatingInput">Enter Name</label>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <label class="fw-semibold fs-14 mb-2 text-dark">Email Address<span class="text-danger">*</span></label>
                      <div class="form-floating">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email_profile" name="email_profile" value="{{ old('email') }}">
                        <label class="text-body fs-12" for="floatingInput3">Enter Email</label>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <label class="fw-semibold fs-14 mb-2 text-dark">New Password <span class="text-danger">*</span></label>
                      <div class="form-floating position-relative">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_profile" name="password_profile">
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
                        <input  type="password" class="form-control" id="password_profile_confirmation" name="password_profile_confirmation">
                        <label class="text-body fs-12" for="password-field2">Enter Confirm Password</label>
                        <span toggle="#password-field2" class="text-body ri-eye-line field-icon toggle-password position-absolute top-50 end-0 fs-20 translate-middle-y" style="right: 10px !important; cursor: pointer;"></span>
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <input type="hidden" class="form-control " id="profile_id" name="profile_id">
                      <button type="submit" id="updateProfileBtn_profile" class="btn btn-primary ounded-1 w-100 py-3">Update Profile</button>
                    </div>
                  </form>
              </div>
          </div>
      </div>
  </div>



        {{-- new student modal --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
  </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
        

<script>
$(document).ready(function() {

                // Open modal and reset form on button click
        $('#new_student').click(function() {
            $('#addprofile').modal('show');
            resetForm(); // Reset the form fields
        });

      $(document).on('click', '.editprofile', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                      url: '{{ route('get_profile') }}',
                      method: 'get',
                      data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                      },
                      success: function(response) {
                        $("#name_profile").val(response.name);
                        $("#email_profile").val(response.email);
                        $("#profile_id").val(response.id);                        
                        $('#addprofile').modal('show');
                        $("#updateProfileBtn_profile").text('Update Account');
                      }
                    });
                  });
const form = document.getElementById('editProfileForm_profile');
const updateBtn = document.getElementById('updateProfileBtn_profile');

form.addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevent the default form submission

    try {
        // Serialize the form data
        const formData = new FormData(form);

        // Send an AJAX request to the server
        const response = await fetch('{{ route("store_profile_edit") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            }
        });

        // Parse the JSON response
        const data = await response.json();
console.log(data);
        // Handle the response data
        if (data.status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
            });
            
            // Fetch all employees AJAX request
            fetchAllData();
            
            $('#addprofile').modal('hide');
            resetForm(); // Reset the form fields
        } else {
            // Show error message using SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message,
            });
        }
    } catch (error) {
        console.error('Error:', error);
        // Show error message using SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred. Please try again later.',
        });
    }
});



      // delete student ajax request
      $(document).on('click', '.deleteprofile', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('delete_account') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  'Account has been deleted.',
                  'success'
                )
                fetchAllData();
              }
            });
          }
        })
      });

    


      // fetch all employees ajax request
      fetchAllData();
 
      function fetchAllData() {
        $.ajax({
          url: '{{ route('fetchAdminAccounts') }}',
          method: 'get',
          success: function(response) {
            $("#show_accounts").html(response);
            $("#basic_config").DataTable({
              order: [[0, 'asc']], // Order by the first column in descending order
            });
          }
        });
      }

      function resetForm() {
    // Reset form fields using jQuery
    $("#profile_id").val('');
    $("#name_profile").val('');
    $("#email_profile").val('');
    $("#password_profile").val('');
    $("#password_profile_confirmation").val('');
    $("#updateProfileBtn_profile").text('Save Account');
}



             
    });
   
  </script>
        	<!--=== Start CopyRight Area ===-->		
					@include('auth.sub-files.footer')
			<!--=== End CopyRight Area ===-->
@endsection