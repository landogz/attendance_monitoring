@extends('auth.layouts')

@section('content')
    
		<!--=== Title ===-->
		<title>Login Logs</title>
		<!--=== Start Sidebar Menu Area ===-->		
		@include('auth.sub-files.sidebar_menu')
        <!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

		<!--=== End Sidebar Menu Area ===-->

		<!--=== Start Main Content Area ===-->
		<div class="main-content-area">
			<div class="container-fluid">
				<!--=== Start Header Area ===-->				
					@include('auth.sub-files.header')
				<!--=== End Header Area ===-->

                <div class="section-title d-sm-flex justify-content-between align-items-center mb-24 text-center">
					<h4 class="text-dark mb-0">Login Logs</h4>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
							<li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item fs-14 text-primary" aria-current="page">Login Logs</li>
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
											<h4 class="mb-0 ms-2 fs-16">List of Login Logs</h4>
										</div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
        

<script>
    
    $(document).ready(function() {
     
      // fetch all employees ajax request
      fetchAllData();
 
      function fetchAllData() {
        $.ajax({
            url: '{{ route('fetchLoginLogs') }}',
            method: 'get',
            success: function(response) {
                $("#show_accounts").html(response);
                var table = $("#basic_config").DataTable({
                    order: [[0, 'asc']], // Order by the first column in ascending order
                    dom: 'Bfrtip', // Show buttons for export
                    buttons: [
                        {
                            extend: 'copy',
                            text: 'Copy',
                            action: function(e, dt, node, config) {
                                // Change title when Copy button is clicked
                                document.title = 'Copy Data';
                                dt.button(node).trigger();
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            action: function(e, dt, node, config) {
                                // Change title when CSV button is clicked
                                document.title = 'CSV Data';
                                dt.button(node).trigger();
                            }
                        },
                        // Add more button configurations as needed
                        {
                            extend: 'print',
                            text: 'Print',
                            customize: function(win) {
                            },
                            orientation: 'landscape' // Set print orientation to landscape
                        }
                    ]
                });

                // Event listener to reset title when DataTable is reloaded
                table.on('draw', function() {
                    document.title = ''; // Reset title
                });
            }
        });
    }
             
    });
   
  </script>
        	<!--=== Start CopyRight Area ===-->		
					@include('auth.sub-files.footer')
			<!--=== End CopyRight Area ===-->
@endsection