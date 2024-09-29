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
					<h4 class="text-dark mb-0">Subject Logs</h4>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
							<li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item fs-14 text-primary" aria-current="page">Subject Logs</li>
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
											<h4 class="mb-0 ms-2 fs-16">List of Subject Logs</h4>
										</div>
									</div>  
                                    <div class="form-group mb-25">
                                        <label for="subjectDropdown" class="form-label mb-10 fs-14 text-dark fw-semibold">Select Subject *</label>
                                        <div class="d-flex align-items-end">
                                            <select name="subject_id" id="subjectDropdown" class="form-control me-3" required style="width: auto;">
                                                <option value="">Select Subject</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->Subject_Name }}</option>
                                                @endforeach
                                            </select>
                                    
                                            <div class="me-3">
                                                <label for="startDate" class="form-label mb-0">Start Date *</label>
                                                <input type="date" id="startDate" class="form-control" required>
                                            </div>
                                    
                                            <div>
                                                <label for="endDate" class="form-label mb-0">End Date *</label>
                                                <input type="date" id="endDate" class="form-control" required>
                                            </div>

                                            <button type="button" id="clearAll" class="btn btn-secondary">Clear All</button>
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
    $(document).ready(function() {
        
 // Set the initial title
 document.title = 'Subject Logs';

      // fetch all employees ajax request
      fetchAllData();
 
      function fetchAllData() {
        $.ajax({
            url: '{{ route('subjects_logs_data') }}',
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
        // Clear the subject dropdown
        document.getElementById('subjectDropdown').selectedIndex = 0;

        // Clear the date inputs
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        fetchAllData();
    });

 // Function to fetch logs based on selected subject and date range
 function fetchSubjectLogs() {
        var selectedSubjectId = $('#subjectDropdown').val(); // Get the selected subject ID
        var startDate = $('#startDate').val(); // Get the selected start date
        var endDate = $('#endDate').val(); // Get the selected end date

        $.ajax({
            url: '{{ route('subjects_logs_data') }}',
            method: 'get',
            data: {
                subject_id: selectedSubjectId, // Send the selected subject ID to the server
                start_date: startDate, // Send the start date
                end_date: endDate // Send the end date
            },
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
                            customize: function(win) {},
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
    $('#subjectDropdown, #startDate, #endDate').change(function() {
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