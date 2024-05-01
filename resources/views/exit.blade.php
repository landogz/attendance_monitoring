@extends('auth.layouts')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card text-center border-color mb-24">
                <div class="card-header bg-secondary-transparent border-color p-3 fs-16">
                    EXIT - SCANNER HERE
                </div>
                <div class="card-body p-25">
                    <h5 class="card-title"  id="blink-heading" >Please Scan QR Code to Display ID or User Data</h5>
                    <div class="flex-shrink-0">
                        <img class="rounded-circle user wh-100" src="assets/images/user/user.png" alt="user" id="image_student">
                    </div>
                    <h3 class="card-text" id="student_number">-----</h3>
                    <h3 class="card-text" id="name">------</h3>
                    <h4 class="card-text" id="grade">------</h4>
                </div>
                <div class="card-footer bg-secondary-transparent border-color p-3 fs-16">
                    <form action="{{ route('scanner_morning') }}" method="post" id="scanner_form">
                        @csrf
                        <input type="text" id="scanid" name="scanid" autofocus>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes blink {
        0% { color: red; }
        50% { color: blue; }
        100% { color: green; }
    }
    
    .blink-animation {
        animation: blink 1s infinite;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // JavaScript to add and remove the 'blink-animation' class
    const heading = document.getElementById('blink-heading');
    setInterval(() => {
        heading.classList.toggle('blink-animation');
    }, 1000);

     // Function to loop focus on the scanid input field
     function loopFocus() {
        const scanid = document.getElementById('scanid');
        scanid.focus(); // Focus on the input field
        setTimeout(loopFocus, 1000); // Set timeout for 1 second to loop the focus
    }

    $(document).ready(function () {
        loopFocus();
        
    const form = $('#scanner_form');
    const scanid = $('#scanid');
        const studentNumber = $('#student_number');
        const studentName = $('#name');
        const studentGrade = $('#grade');
        const studentImage = $('#image_student');

    scanid.on('keypress', async function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent the default Enter key behavior

            $.ajax({
                url: '{{ route("scanner_afternoon") }}',
                method: 'POST',
                data: form.serialize(), // Serialize the form data
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data) {
                    if (data.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                        });

                        // Update student details on success
                        if (data.student) {
                                studentNumber.text(data.student.student_number || '-----');
                                studentName.text(data.student.name || '------');
                                studentGrade.text('Grade ' + data.student.grade || '------');
                                studentImage.attr('src', '{{ asset("storage/images/") }}' + '/'+data.student.image_url || '{{ asset("assets/images/user/user.png") }}');
                            }

                    } else {
                        // Show error message using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'An error occurred. Please try again later.', // Display server error message or generic message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    // Show error message using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred. Please try again later.',
                    });
                }
            });

            $('#scanid').val('');
        }
    });
});

</script>


<!-- container-fluid -->

<!--=== Start CopyRight Area ===-->      
{{-- @include('auth.sub-files.footer') --}}
<!--=== End CopyRight Area ===-->
@endsection
