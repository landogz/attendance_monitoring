@extends('auth.layouts')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card text-center border-color mb-24">
                <div class="card-header bg-secondary-transparent border-color p-3 fs-16">
                    SCANNER HERE
                </div>
                <div class="card-body p-25">
                    <h5 class="card-title"  id="blink-heading" >Please Scan QR Code to Display ID or User Data</h5>
                    <div class="flex-shrink-0">
                        <img class="rounded-circle user wh-100" src="assets/images/user/user.png" alt="user">
                    </div>
                    <h3 class="card-text">-----</h3>
                    
                <h3 class="card-text">------</h3></div>
                <div class="card-footer bg-secondary-transparent border-color p-3 fs-16">
                    Morning In
                </div>
                <form action="{{ route('scanner_morning') }}" method="post" id="scanner_form">
                    @csrf
                    <input type="text" id="scanid" name="scanid" autofocus>
                </form>
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

    $(document).ready(function () {
    const form = $('#scanner_form');
    const scanid = $('#scanid');

    scanid.on('keypress', async function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent the default Enter key behavior

            $.ajax({
                url: '{{ route("scanner_morning") }}',
                method: 'POST',
                data: form.serialize(), // Serialize the form data
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log(data);
                    if (data.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                        });
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
        }
    });
});

</script>


<!-- container-fluid -->

<!--=== Start CopyRight Area ===-->      
{{-- @include('auth.sub-files.footer') --}}
<!--=== End CopyRight Area ===-->
@endsection
