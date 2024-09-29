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
					<h4 class="text-dark mb-0">Subjects</h4>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
							<li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item fs-14 text-primary" aria-current="page">Subjects</li>
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
											<h4 class="mb-0 ms-2 fs-16">List of Subjects</h4>
										</div>
                      <button class="btn btn-primary rounded-2 btn-primary-transparent px-3" type="button" data-bs-toggle="modal" data-bs-target="#addstudent" id="new_subject">
											<span class="d-none d-sm-block ms-0">New Subject</span>
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
	<div class="modal fade" id="addsubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Subject</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body text-body">					
                        <form action="#" method="POST" id="add_subject_form" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4 bg-gray-200">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="form-group mb-25">
                                        <label for="exampleFormControlInput1" class="form-label mb-10 fs-14 text-dark fw-semibold">Subject Name *</label>
                                        <input type="text" name="subject_name" id="subject_name" class="form-control" placeholder="Subject Name" required>
                                    </div>
                        <div class="form-group mb-25">
                            <label for="schedule" class="form-label mb-10 fs-14 text-dark fw-semibold">Schedule *</label>
                            
                            <div class="input-group mb-3">
                                <input type="time" name="start_time" id="start_time" class="form-control" placeholder="Start Time" required>
                                <span class="input-group-text">to</span>
                                <input type="time" name="end_time" id="end_time" class="form-control" placeholder="End Time" required>
                            </div>
                        </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="subject_id"  id="subject_id" class="form-control"  placeholder="">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit"  id="add_subject_btn"  class="btn btn-primary">Save Subject</button>
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

<script>
  
    
$(document).ready(function() {

              // Open modal and reset form on button click
        $('#new_subject').click(function() {
            $('#addsubjectModal').modal('show');
            resetForm(); // Reset the form fields
        });

       // edit employee ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('edit_subject') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#subject_name").val(response.Subject_Name);
            $("#start_time").val(response.start_time);
            $("#end_time").val(response.end_time);
            $("#subject_id").val(response.id);
            $("#add_subject_btn").text('Update Subject');
          }
        });
      });

  // Add new student AJAX request
$("#add_subject_form").submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $("#add_subject_btn").text('Adding...');
    $.ajax({
        url: '{{ route('store_subject') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.status == 200) {
                Swal.fire(
                    'Added!',
                    response.message,
                    'success'
                )
                
              fetchAllData();
            } else {
                Swal.fire(
                    'Error!',
                    response.message,
                    'error'
                )
            }
            $("#add_subject_btn").text('Add Student');
            $("#add_subject_form")[0].reset();
            $("#addsubjectModal").modal('hide');
        },
        error: function(xhr, status, error) {
            if (xhr.status == 422) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '<br>';
                });
                Swal.fire(
                    'Error!',
                    errorMessage,
                    'error'
                )
            } else {
                Swal.fire(
                    'Error!',
                    'Failed to add subject.',
                    'error'
                )
            }
            $("#add_subject_btn").text('Add Subject');
        }
    });
});

$(document).on('click', '.openlink', function(e) {
                                e.preventDefault();
                                let id = $(this).attr('id');
                                window.location.href = '/scan-subject/' + id;
                            });

      // delete student ajax request
      $(document).on('click', '.deleteIcon', function(e) {
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
              url: '{{ route('delete_subject') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  'Subject Schedule has been deleted.',
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
          url: '{{ route('fetchsubjects') }}',
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
    $("#subject_id").val('');
    $("#subject_name").val('');
    $("#start_time").val('');
    $("#end_time").val('');
    
}
     
    });
   
  </script>
        	<!--=== Start CopyRight Area ===-->		
					@include('auth.sub-files.footer')
			<!--=== End CopyRight Area ===-->
@endsection