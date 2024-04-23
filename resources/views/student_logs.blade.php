@extends('auth.layouts')

@section('content')
    
		<!--=== Title ===-->
		<title>Student Logs</title>
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
					<h4 class="text-dark mb-0">Students Logs</h4>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
							<li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item fs-14 text-primary" aria-current="page">Students Logs</li>
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
											<h4 class="mb-0 ms-2 fs-16">List of Students Logs</h4>
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
     // Define openImageViewer function outside of $(document).ready()
     function openImageViewer(imageUrl) {
        // Create a modal element
        var modal = document.createElement('div');
        modal.classList.add('modal');
        
        // Style the modal for fullscreen display
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
        modal.style.zIndex = '9999';
        modal.style.overflow = 'auto';

        // Create a container for the image and close button
        var modalContent = document.createElement('div');
        modalContent.style.position = 'relative';
        modalContent.style.margin = 'auto';
        modalContent.style.maxWidth = '800px';
        modalContent.style.padding = '20px';

        // Create the close button with Font Awesome icon
        var closeButton = document.createElement('span');
        closeButton.classList.add('close');
        closeButton.style.position = 'absolute';
        closeButton.style.top = '28px'; // Adjust top position to move the icon inside
        closeButton.style.right = '39px'; // Adjust right position to move the icon inside
        closeButton.style.fontSize = '30px';
        closeButton.style.color = '#fff';
        closeButton.style.cursor = 'pointer';
        closeButton.innerHTML = '<i class="fas fa-times"></i>'; // Font Awesome close icon
        closeButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Create the image element
        var image = document.createElement('img');
        image.src = imageUrl;
        image.style.maxWidth = '100%';
        image.style.padding = '10px'; // Add padding around the image

        // Append the elements to the modal
        modalContent.appendChild(closeButton);
        modalContent.appendChild(image);
        modal.appendChild(modalContent);

        // Append the modal to the document body
        document.body.appendChild(modal);

        // Display the modal
        modal.style.display = 'block';
    }
    $(document).ready(function() {
        
 // Set the initial title
 document.title = 'Student Logs';

      // fetch all employees ajax request
      fetchAllData();
 
      function fetchAllData() {
        $.ajax({
            url: '{{ route('fetchstudent_logs') }}',
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