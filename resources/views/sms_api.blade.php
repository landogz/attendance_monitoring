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
					<h4 class="text-dark mb-0">SEMAPHORE API Key</h4>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
							<li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item fs-14 text-primary" aria-current="page">API Key</li>
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
											<h4 class="mb-0 ms-2 fs-16">SMS Api Settings</h4>
										</div>
									</div>      
                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        You don't have API Key ? <a href="https://semaphore.co/" target="_blank">Click here</a> to register.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>                        
                                        <div class="row justify-content-center">
                                            
                                    <form action="#" method="POST" id="validate_api" enctype="multipart/form-data">
                                        @csrf  
                                            <div class="input-group mb-25">
                                                <input type="text" class="form-control" placeholder="Enter the API Key here" aria-label="API Key" aria-describedby="validate_btn"  name="api_value" id="api_value"  required>
                                                <button class="btn-primary btn-secondary rounded-end-3" type="submit" id="validate_btn">Validate API KEY</button>
                                            </div>                                            
                                        </form>
                                        <div class="global-table-area">
                                            <div class="table-responsive overflow-auto h-540" id="show_settings">
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

        <script src='https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js'></script>

        <script>
            $(function() {

      $("#validate_api").submit(function(e) {
    e.preventDefault();
    let csrf = '{{ csrf_token() }}';
    const fd = new FormData(this);
    $("#validate_btn").prop('disabled', true).text('Validating...');
    $.ajax({
        url: '{{ route('validateapi') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.status == 200) {
                if (response.data.hasOwnProperty('account_id')) {
                    Swal.fire({
                        title: 'Valid API Key',
                        text: 'Do you want to save this to the database?',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, save it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Get the value of the textbox
                            var apiValue = $("#api_value").val();

                            // Update the data object in your AJAX request
                            var data = {
                                api: apiValue,
                                account_id: JSON.stringify(response.data.account_id),
                                account_name: JSON.stringify(response.data.account_name),
                                status: JSON.stringify(response.data.status),
                                credit_balance: JSON.stringify(response.data.credit_balance),
                                _token: csrf // Assuming 'csrf' is defined and contains the CSRF token
                            };

                            $.ajax({
                                url: '{{ route('saveapi') }}',
                                method: 'post',
                                data: data,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire(
                                        'Success!',
                                        'The API data has been saved to the database.',
                                        'success'
                                    );
                                    fetchAllData();
                                    $("#api_value").val('');
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire(
                                        'Error!',
                                        response.message ? response.message : 'The API Key is already in the Database',
                                        'error'
                                    );
                                }
                            });

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Your data is not saved :)',
                                'error'
                            );
                        }
                    });
                } else {
                    Swal.fire(
                        'Not Found',
                        'The API Key is Invalid !',
                        'error'
                    );
                }
            } else {
                Swal.fire(
                    'Error!',
                    'Failed to validate API key.',
                    'error'
                );
            }
            $("#validate_btn").prop('disabled', false).text('Validate API KEY');
        },
        error: function(xhr, status, error) {
            Swal.fire(
                'Error!',
                'Failed to validate API key. <br> Please try again later.',
                'error'
            );
            $("#validate_btn").prop('disabled', false).text('Validate API KEY');
        }
    });
});

 
             
    });
   

    $(document).on('click', '.delete-item', function(e) {
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
              url: '{{ route('deleteapi') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  'Your API has been deleted.',
                  'success'
                )
                fetchAllData();
              }
            });
          }
        })
      });

      $(document).on('click', '.active-item', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let act = $(this).attr('data-active');
        let csrf = '{{ csrf_token() }}';
        let msg = '';
        if(act == 'Active'){
            msg = "This will be removed as the SMS provider.";
        }
        else{
            msg = "This will be designated as the SMS Provider";
        }
        Swal.fire({
          title: 'Are you sure?',
          text:  msg,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('updateapi') }}',
              method: 'post',
              data: {
                id: id,
                active: act,
                _token: csrf
              },
              success: function(response) {
                
            if (response.status == 200) {
                
                Swal.fire(
                  'Updated!',
                  'Your API has been set.',
                  'success'
                )
                fetchAllData();

            }
              }
            });
          }
        })
      });



                 // fetch all employees ajax request
                 fetchAllData();
 
      function fetchAllData() {
        $.ajax({
          url: '{{ route('fetchApis') }}',
          method: 'get',
          success: function(response) {
            $("#show_settings").html(response);
            $("#basic_config").DataTable({
              order: [[0, 'desc']], // Order by the first column in descending order
            });
          }
        });
      }

  </script>

        
        
		
        	<!--=== Start CopyRight Area ===-->		
					@include('auth.sub-files.footer')
			<!--=== End CopyRight Area ===-->
@endsection