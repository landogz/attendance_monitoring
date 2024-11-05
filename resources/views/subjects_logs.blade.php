@extends('auth.layouts')

@section('content')
    
		<!--=== Title ===-->
		<title>Student Logs</title>
		<!--=== Start Sidebar Menu Area ===-->		
		@include('auth.sub-files.sidebar_menu')
        <!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

		<!--=== End Sidebar Menu Area ===-->
<style>
    .checkbox-large {
    transform: scale(1.5); /* Adjust the scale factor to your preference */
    margin-right: 10px; /* Optional: space between checkbox and label */
    cursor: pointer; /* Change cursor to pointer when hovering */
}

</style>
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
                                        <div id="logCount" class="mb-3"></div>
									</div>  
                                    <div class="form-group mb-25">
                                        <div class="d-flex align-items-end">                                            
                                            <div class="me-3">
                                                <label for="startDate" class="form-label mb-0">Select Subject *</label>
                                                <select name="subject_id" id="subjectDropdown" class="form-control me-3" required style="width: auto;">
                                                    <option value="">Select Subject</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}">{{ $subject->Subject_Name }}</option>
                                                    @endforeach
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
                                            <button type="button" id="clearAll" class="btn btn-secondary"><i class="fa-solid fa-arrows-rotate"></i> Clear All</button>&nbsp;

                                            @if(Auth::user()->privilege == 'Teacher')
                                                {{-- <button type="button" id="deleteAll" class="btn btn-danger deletelogs"><i data-feather="trash-2"></i> Delete All Logs</button>&nbsp;
                                                <button type="button" id="deleteSelectedLogs" class="btn btn-danger">
                                                    <i data-feather="trash"></i> Delete Selected
                                                </button> --}}
                                            @endif

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

        $('#deleteSelectedLogs').on('click', function() {
    const selectedIds = [];
    $('.select-row:checked').each(function() {
        selectedIds.push($(this).val());
    });

    if (selectedIds.length > 0) {
        // Show a confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send DELETE request to the backend using AJAX
                $.ajax({
                    url: '{{ route("delete_selected_logs") }}', // Use the defined route
                    type: 'DELETE',
                    contentType: 'application/json',
                    data: JSON.stringify({ ids: selectedIds }), // Pass the selected IDs
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            // Refresh the table or remove the deleted rows
                            Swal.fire('Deleted!', data.message, 'success');
                            fetchAllData();  
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        Swal.fire('Error!', 'An error occurred while deleting.', 'error');
                    }
                });
            }
        });
    } else {
        Swal.fire('Warning!', 'Please select at least one record to delete.', 'warning');
    }
});



        $(document).on('click', '.deletelogs', function(e) {
    e.preventDefault();
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
                url: '{{ route('delete_logs') }}',  // Call delete_logs route without an ID
                method: 'DELETE',
                data: {
                    _token: csrf  // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        )
                        fetchAllData();  // Refresh or reload the data
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the logs. Please try again later.',
                        'error'
                    );
                }
            });
        }
    });
});


 // Set the initial title
 document.title = 'Subject Logs';

      // fetch all employees ajax request
      fetchAllData();
 
      function fetchAllData() {
        $.ajax({
            url: '{{ route('subjects_logs_data') }}',
            method: 'get',
            success: function(response) {
                $("#show_accounts").html(response.html); // Set the HTML response
            $("#logCount").html(response.badge); // Set the badge HTML based on log count
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
                        '<h2 style="margin: 0; font-size: 14pt;">PRMSU Junior High School Department Iba Campus</h2>' + // Smaller school name
                        '<p style="margin: 0;">Palanginan, Iba, Zambales 2212</p>' + // Address line 1
                        '<p style="margin: 0;">prmsujhsiba@gmail.com</p>' + // Email
                    '</div>' +
                '</div><hr>' + // Horizontal line under the header
                '<h3 style="text-align: center; margin-top: 20px;">Subject Logs</h3>' + // Centered title for the logs
                // Add printed by information
                '<div style="text-align: left; margin-top: 10px;">' + // Align to the right
                    '<span>Printed by: ' + '{{ auth()->user()->name }} | No Time In Count : ' + response.na_count + '</span>' + // User and N/A count
                '</div>'
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
                $("#show_accounts").html(response.html); // Set the HTML response
            $("#logCount").html(response.badge); // Set the badge HTML based on log count


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
                        '<h2 style="margin: 0; font-size: 14pt;">PRMSU Junior High School Department Iba Campus</h2>' + // Smaller school name
                        '<p style="margin: 0;">Palanginan, Iba, Zambales 2212</p>' + // Address line 1
                        '<p style="margin: 0;">prmsujhsiba@gmail.com</p>' + // Email
                    '</div>' +
                '</div><hr>' + // Horizontal line under the header
                '<h3 style="text-align: center; margin-top: 20px;">Subject Logs</h3>' + // Centered title for the logs
                // Add printed by information
                '<div style="text-align: left; margin-top: 10px;">' + // Align to the right
                    '<span>Printed by: ' + '{{ auth()->user()->name }} | No Time In Count : ' + response.na_count + '</span>' + // User and N/A count
                '</div>'
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