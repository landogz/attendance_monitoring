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
					<h4 class="text-dark mb-0">Students</h4>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 mt-2 mt-sm-0 justify-content-center">
							<li class="breadcrumb-item fs-14"><a class="text-decoration-none" href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item fs-14 text-primary" aria-current="page">Students</li>
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
                      <h4 class="mb-0 ms-2 fs-16">List of Students</h4>
                    </div>
                    @if(Auth::user()->privilege != 'Principal')
                    <div class="d-flex justify-content-end">
                      <button class="btn btn-primary rounded-2 btn-primary px-3 me-2" type="button" data-bs-toggle="modal" data-bs-target="#addstudent" id="new_student">
                        <span class="d-none d-sm-block ms-0">New Student</span>
                      </button>
                      <button class="btn btn-primary rounded-2" type="button" data-bs-toggle="modal" data-bs-target="#importStudentsModal">
                        Import from Excel
                      </button>
                    </div>
                    @endif
                  </div>
                                               
                                        <div class="row justify-content-center">
                                              <div class="mb-3">
                                                @if(Auth::user()->privilege == 'Administrator' && Auth::user()->privilege != 'Principal')
                                                    <!-- Show buttons if the user is an admin -->
                                                    <button class="btn btn-primary" onclick="printGrade('all')">Print All Students</button>
                                                    <button class="btn btn-primary" onclick="printGrade(7)">Print Grade 7</button>
                                                    <button class="btn btn-primary" onclick="printGrade(8)">Print Grade 8</button>
                                                    <button class="btn btn-primary" onclick="printGrade(9)">Print Grade 9</button>
                                                    <button class="btn btn-primary" onclick="printGrade(10)">Print Grade 10</button>
                                                @else
                                                    <!-- Show buttons based on authenticated user's grade -->
                                                    @if(Auth::check())
                                                        @php
                                                            $userGrade = Auth::user()->Grade; // Assuming 'grade' is a field in your users table
                                                        @endphp
                                                         @if(Auth::user()->privilege != 'Principal')
                                                        <button class="btn btn-primary" onclick="printGrade('{{ $userGrade }}')">Print Grade {{ $userGrade }}</button>
                                                        @endif
                                                    @else
                                                        <!-- Optionally, you can handle cases where the user is not logged in -->
                                                        <p>Please log in to print grades.</p>
                                                    @endif
                                                @endif
                                            </div>
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


        <!-- Modal -->
	<div class="modal fade" id="addstudent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Student</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body text-body">					
                        <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4 bg-gray-200">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="form-group mb-25">
                                        <label for="exampleFormControlInput1" class="form-label mb-10 fs-14 text-dark fw-semibold">Student Number <span style="color: red">*</span> (Format : 00-0-0000)</label>
                                        <input type="text" name="student_number" id="student_number" class="form-control" placeholder="Student Number" required maxlength="9">
                                    </div>
                                    <div  class="form-group mb-25">
                                    <label for="name" class="form-label mb-10 fs-14 text-dark fw-semibold">Full Name <span style="color: red">*</span></label>
                                    <input type="text" name="fullname" id="fullname" class="form-control"  placeholder="Full Name" required>
                                    </div>
                                    <div  class="form-group mb-25">
                                    <label for="name" class="form-label mb-10 fs-14 text-dark fw-semibold">Email <span style="color: red">*</span></label>
                                    <input type="email" name="email_" id="email_" class="form-control"  placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="row  mb-25">
                                  <div class="col-lg-6">
                                    <label for="parent_name" class="form-label mb-10 fs-14 text-dark fw-semibold">Parent Name <span style="color: red">*</span></label>
                                    <input type="text" name="parent_name" id="parent_name" class="form-control"  placeholder="Parent Name" required>
                                  </div>
                                  <div class="col-lg-6">
                                    <label for="lname" class="form-label mb-10 fs-14 text-dark fw-semibold">Parent Number <span style="color: red">*</span></label>
                                    <input type="text" name="parent_number" id="parent_number" class="form-control"  placeholder="Parent Number" required>
                                  </div>
                                </div>
                                    <div class="form-group mb-25">
                                      <label for="grade" class="form-label mb-10 fs-14 text-dark fw-semibold">Grade <span style="color: red">*</span></label>
                                      <select name="grade" id="grade" class="form-control" required>
                                          <option value="">Select Grade</option>
                                      </select>
                                  </div>
                                    <div  class="form-group mb-25">
                                        <label for="lname" class="form-label mb-10 fs-14 text-dark fw-semibold">Address <span style="color: red">*</span></label>
                                        <input type="text" name="address" id="address" class="form-control"  placeholder="Address" required>
                                    </div>
                                <div class="form-group mb-25">
                                    <label for="avatar" class="form-label mb-10 fs-14 text-dark fw-semibold">Select Image <span style="color: red">*</span></label>
                                    <input type="file" name="avatar" id="avatar" class="form-control">
                                </div>
                                <div class="avatar-preview rounded-circle">
                                  <div id="avatars" class="rounded-circle"></div>
                                </div>
                                <div id="qrcode" style="display: none;" ></div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="student_id"  id="student_id" class="form-control"  placeholder="">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit"  id="add_employee_btn"  class="btn btn-primary">Save Student</button>
                            </div>
                        </form>
				</div>
			</div>
		</div>
	</div>



<!-- Import Students Modal -->
<div class="modal fade" id="importStudentsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="importStudentsLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="importStudentsLabel">Import Students from Excel</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="importForm" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group mb-3">
                      <label for="file" class="form-label">Upload Excel File</label>
                      <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .csv" required>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="importButton" class="btn btn-primary">Import Students</button>
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
        
          document.addEventListener('DOMContentLoaded', function() {
            // Fetch user privilege and grade
            const userPrivilege = '{{ Auth::user()->privilege }}'; // Get privilege
            const teacherGrade = '{{ Auth::user()->Grade }}'; // Get grade from authenticated user
        
            // Function to populate grades based on user privilege
            function populateGradeOptions() {
              const gradeSelect = document.getElementById('grade');
              gradeSelect.innerHTML = ''; // Clear existing options
              gradeSelect.append(new Option('Select Grade', '')); // Add default option
        
              if (userPrivilege === 'Administrator') {
                // Show all grades for Administrators
                const allGrades = ['7', '8', '9', '10'];
                allGrades.forEach(grade => {
                  gradeSelect.append(new Option(grade, grade));
                });
              } else if (userPrivilege === 'Teacher') {
                // Add the teacher's grade as an option
                if (teacherGrade) {
                  gradeSelect.append(new Option(teacherGrade, teacherGrade));
                } else {
                  console.warn('No grade found for the teacher:', teacherGrade);
                }
              }
            }
        
            populateGradeOptions();
          });
        </script>
        <script>
          function printGrade(grade) {
            window.open('/printGrade/' + grade, '_blank'); // Opens the URL in a new tab
          }
      </script>
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
            // Add click event listener to elements with class 'download-now'
    $(document).on('click', '.download-now', function(e) {
        e.preventDefault();

         // Get the student ID and name from data attributes
         var studentId = $(this).data('studentid');
        var name = $(this).data('name');

        
        generateQRCode(studentId,name,studentId);

    });

              // Open modal and reset form on button click
        $('#new_student').click(function() {
            $('#addstudentModal').modal('show');
            resetForm(); // Reset the form fields
        });

       // edit employee ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('edit_student') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#student_number").val(response.Student_Number);
            $("#fullname").val(response.Name);
            $("#email_").val(response.Email);
            $("#parent_name").val(response.Parent_Name);
            $("#parent_number").val(response.Parent_Number);
            $("#grade").val(response.Grade);
            $("#address").val(response.Address);
            $("#avatars").html(
              `<img src="storage/images/${response.Image}" width="100" class="img-fluid img-thumbnail">`);
            $("#student_id").val(response.id);
            $("#avatar").val(response.Image);
            $("#add_employee_btn").text('Update Student');
          }
        });
      });

  // Add new student AJAX request
$("#add_employee_form").submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $("#add_employee_btn").text('Adding...');
    $.ajax({
        url: '{{ route('store_student') }}',
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
                // Call the function to generate the QR code and open in a new tab
              var qrContent =  $("#student_number").val();
              generateQRCode($("#student_number").val(),$("#fullname").val(),qrContent);
              fetchAllData();
            } else {
                Swal.fire(
                    'Error!',
                    response.message,
                    'error'
                )
            }
            $("#add_employee_btn").text('Add Student');
            $("#add_employee_form")[0].reset();
            $("#addstudent").modal('hide');
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
                    'Failed to add student.',
                    'error'
                )
            }
            $("#add_employee_btn").text('Add Student');
        }
    });
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
              url: '{{ route('delete_student') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  'Student has been deleted.',
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
          url: '{{ route('fetchAccounts') }}',
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
    $("#student_id").val('');
    $("#student_number").val('');
    $("#fullname").val('');
    $("#email").val('');
    $("#parent_name").val('');
    $("#parent_number").val('');
    $("#address").val('');
    $("#avatar").val('');
    // Optionally, you can also reset any other form fields here
    $("#avatars").html('');
    
    // If you have custom input file styling, you may need to reset it separately
    $("#avatar").next('.custom-file-label').html('Choose file');
}
// Define a function to generate a QR code
function generateQRCode(studentId, name, content, elementId, width = 250, height = 250) {
    // Clear any previous QR code by removing the child nodes from the element
    var qrElement = document.getElementById('qrcode');
    qrElement.innerHTML = ''; // Clear the QR code container

    // Create a new QRCode instance
    var qr = new QRCode(qrElement, {
        text: content,
        width: width,
        height: height,
        colorDark: '#000000',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H // Error correction level
    });

    // Wait until the QR code is fully rendered and then proceed
    setTimeout(function() {
        // Get the data URL of the generated QR code
        var qrDataURL = qrElement.querySelector('canvas').toDataURL();

        // Create a new HTML canvas element for combining QR and text
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');

        // Set canvas dimensions
        canvas.width = width;
        canvas.height = height + 40; // Extra space for student details

        // Create a new image object for the QR code
        var qrImage = new Image();
        qrImage.onload = function() {
            // Draw the QR code onto the canvas
            ctx.drawImage(qrImage, 0, 0);

            // Set font and style for the student details
            ctx.font = 'bold 15px Arial';
            ctx.fillStyle = '#000000';
            ctx.textAlign = 'center';

            // Draw student ID and name below the QR code
            ctx.fillText(studentId, width / 2, height + 20);
            ctx.fillText(name, width / 2, height + 40);

            // Get the data URL of the combined image
            var compositeDataURL = canvas.toDataURL();

            // Open a new tab and display the generated image
            var newTab = window.open();
            var imageTag = '<img src="' + compositeDataURL + '" id="download-image">';
            var scriptTag = '<' + 'script' + '>document.getElementById("download-image").addEventListener("contextmenu", function(e) { e.preventDefault(); var a = document.createElement("a"); a.href = "' + compositeDataURL + '"; a.download = "' + studentId + '.jpg"; a.click(); }); window.onload = function() {window.print();};<' + '/script' + '>';
            newTab.document.write(imageTag + scriptTag);
            newTab.document.close();

            // Close the new tab
            newTab.document.close();
        };
        qrImage.src = qrDataURL;

    }, 500); // Add a short delay to ensure QR code generation is complete
}


    

             
    });
   
  </script>
<script>
  document.getElementById('student_number').addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
      let formattedValue = '';

      // Format as 21-1-2652
      if (value.length > 0) {
          formattedValue += value.substring(0, 2); // First two digits (21)
      }
      if (value.length > 2) {
          formattedValue += '-' + value.substring(2, 3); // Next digit (1)
      }
      if (value.length > 3) {
          formattedValue += '-' + value.substring(3, 7); // Last four digits (2652)
      }

      e.target.value = formattedValue; // Set the formatted value back to input
  });


  $('#importButton').on('click', function(event) {
        event.preventDefault();

        // Create a FormData object
        let formData = new FormData(document.getElementById('importForm'));

        // AJAX request
        $.ajax({
            url: "{{ route('students.import') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val() // Include CSRF token
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Importing...',
                    text: 'Please wait while the students are being imported.',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
              $('#importStudentsModal').modal('hide');
               // Notify user of success
               Swal.fire({
                    icon: 'success',
                    title: 'Import Successful',
                    text: response.message || 'Students imported successfully!',
                    showConfirmButton: true
                }).then(() => {
                  // Call the fetchAllData function after the alert is confirmed
                  $.ajax({
          url: '{{ route('fetchAccounts') }}',
          method: 'get',
          success: function(response) {
            $("#show_accounts").html(response);
            $("#basic_config").DataTable({
              order: [[0, 'asc']], // Order by the first column in descending order
            });
          }
        });
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Import Failed',
                    text: xhr.responseJSON?.message || 'An error occurred during import. Please try again.',
                    showConfirmButton: true
                });
            }
        });
    });
</script>

        	<!--=== Start CopyRight Area ===-->		
					@include('auth.sub-files.footer')
			<!--=== End CopyRight Area ===-->
@endsection