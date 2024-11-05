<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print {{ $grade === 'all' ? 'All Students' : 'Grade' .  $grade }}</title>
    <style>
        /* Add your print styles here */
        @page {
            size: 11in 8.5in; /* Letter size in landscape */
            margin: 0.5in; /* Adjust margin as necessary */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            padding-bottom: 60px; /* Ensure there's space for the footer */
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 100px; /* Adjust as necessary */
            margin-right: 20px; /* Space between logo and text */
        }
        .title {
            text-align: left; /* Align text to the left */
        }
        .title h1 {
            margin: 0;
            font-size: 24px;
        }
        .title p {
            margin: 5px 0;
        }
        .grade-title {
            text-align: center; /* Center the grade title */
            margin-top: 20px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Print styles */
        @media print {
            body {
                margin: 0;
            }
            footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                display: flex;
                justify-content: space-between; /* Space between left and right */
                font-size: 12px;
                padding: 10px;
                border-top: 1px solid #000;
            }
            .pageNumber {
                margin-left: 0; /* Ensure no margin on the left */
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('assets/images/user/user.png') }}" alt="School Logo" class="logo"> <!-- Updated logo path -->
        <div class="title">
            <h1>PRMSU Junior High School Department Iba Campus</h1> <!-- Replace with your school name -->
            <p>Palanginan, Iba, Zambales 2212</p> <!-- Replace with your school address -->
            <p>prmsujhsiba@gmail.com</p> <!-- Replace with your contact number -->
        </div>
    </div>

    <!-- Printed Information Section -->
    <div style="text-align: left; margin-bottom: 10px;">
        <span>Printed by:  {{ auth()->user()->name }}</span> <!-- User and timestamp on the right -->
    </div>

    <div class="grade-title">
        <h1>{{ $grade === 'all' ? 'All Students' : 'Grade ' . $grade . ' Students' }}</h1>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Student Number</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Parent Name</th>
                <th>Parent Number</th>
                <th>Address</th>
                @if ($grade === 'all')
                    <th>Grade</th> <!-- New Grade column -->
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->Student_Number }}</td>
                <td>{{ $student->Name }}</td>
                <td>{{ $student->Email }}</td>
                <td>{{ $student->Parent_Name }}</td>
                <td>{{ $student->Parent_Number }}</td>
                <td>{{ $student->Address }}</td>
                @if ($grade === 'all')
                    <td>{{ $student->Grade }}</td> <!-- Display the student's grade -->
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

 

    <script>
        window.onload = function() {
            window.print();
            // Close the tab after the print dialog has been executed
            window.onafterprint = function() {
                window.close();
            };

            // Set the page number (you may need to implement logic to get the actual page number)
            var pageNum = 1; // Placeholder for page number
            document.querySelector('.pageNumberText').textContent = pageNum;
        };
    </script>
</body>
</html>
