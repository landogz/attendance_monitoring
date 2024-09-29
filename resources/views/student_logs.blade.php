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
                                    
                                    <div class="form-group mb-25">
                                        <div class="d-flex align-items-end">
                                            <div class="me-3">
                                                <label for="startGrade" class="form-label mb-0">Start Grade *</label>
                                                <select name="start_grade" id="startGrade" class="form-control me-3" required style="width: auto;">
                                                    <option value="">Select Grade</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                            <div class="me-3">
                                                <label for="startDate" class="form-label mb-0">Start Date *</label>
                                                <input type="date" id="startDate" class="form-control" required>
                                            </div>
                                    
                                            <div>
                                                <label for="endDate" class="form-label mb-0">End Date *</label>
                                                <input type="date" id="endDate" class="form-control" required>
                                            </div>

                                            <button type="button" id="clearAll" class="btn btn-secondary">Clear All </button>
                                        </div>
                                    </div>                             
                                        <div class="row justify-content-center">
                                            <div class="global-table-area">
                                                <div class="table-responsive overflow-auto" id="show_accounts">
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



    
    document.getElementById('clearAll').addEventListener('click', function() {
        // Clear the date inputs
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        // Clear the subject dropdown
        document.getElementById('startGrade').selectedIndex = 0;
        fetchAllData();
    });

 // Function to fetch logs based on selected subject and date range
 function fetchSubjectLogs() {
        var startDate = $('#startDate').val(); // Get the selected start date
        var endDate = $('#endDate').val(); // Get the selected end date
        var startGrade = $('#startGrade').val(); // Get the selected start grade

        $.ajax({
            url: '{{ route('student_logs_data') }}',
            method: 'get',
            data: {
                start_date: startDate, // Send the start date
                end_date: endDate, // Send the end date
                start_grade: startGrade // Send the selected grade
            },
            success: function(response) {
                $("#show_accounts").html(response);
                var table = $("#basic_config").DataTable({
                    order: [[6, 'desc']], // Order by the first column in ascending order
                    dom: 'Bfrtip', // Show buttons for export
                    buttons: [
                        {
                            extend: 'copy',
                            text: 'Copy',
                            action: function(e, dt, node, config) {
                                document.title = 'Copy Data';
                                dt.button(node).trigger();
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            action: function(e, dt, node, config) {
                                document.title = 'CSV Data';
                                dt.button(node).trigger();
                            }
                        },
                        {
    extend: 'print',
    text: 'Print',
    customize: function(win) {
        // Remove the default title by setting it to an empty string
        $(win.document.body).find('title').text('');

        // Add custom styles for the print view
        $(win.document.body)
            .css('font-size', '12pt') // Change overall font size
            .prepend(
                '<div style="text-align: center; display: flex; align-items: center; justify-content: center;">' + // Center-align and flexbox for alignment
                    '<img src="{{ asset('assets/images/user/user.png') }}" alt="Logo" style="width: 100px; height: auto; margin-right: 10px;"/>' + // Logo
                    '<div>' + // Wrap school name and details in a div
                        '<h2 style="margin: 0;font-size: 16pt;">PRMSU Junior High School Department Iba Campus</h2>' + // School name
                        '<p style="margin: 0;">Palanginan, Iba, Zambales 2212</p>' + // Address line 1
                        '<p style="margin: 0;">prmsujhsiba@gmail.com</p>' + // Email
                    '</div>' +
                '</div><hr>' + // Horizontal line under the header
                '<h3 style="text-align: center; margin-top: 20px;">Student Logs</h3>' // Centered title for the logs
            );

        // Change the font size of the table to be smaller
        $(win.document.body).find('table')
            .css({
                'font-size': '9pt', // Set smaller font size for the table
                'width': '100%', // Make sure the table takes full width
                'border-collapse': 'collapse' // Optional: Collapses table borders for better presentation
            })
            .find('th, td') // Target both headers and data cells
            .css({
                'padding': '5px', // Adjust padding for a compact look
                'border': '1px solid #ddd' // Optional: Add borders to table cells
            });

        // Remove any default title content
        $(win.document.body).find('h1, h4, h5, h6').remove(); // Remove any default headers
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

    // Trigger fetchSubjectLogs function when the dropdown value or date range changes
    $('#startGrade,#startDate, #endDate').change(function() {
        fetchSubjectLogs(); // Fetch logs based on the selected subject and date range
    });

    // Initial fetch to load data when the page is first loaded
    fetchSubjectLogs();
             
    });
   
  </script>
        	<!--=== Start CopyRight Area ===-->		
					@include('auth.sub-files.footer')
			<!--=== End CopyRight Area ===-->
@endsection