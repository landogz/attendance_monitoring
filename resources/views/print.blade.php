<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print {{ $grade === 'all' ? 'All Students' : 'Grade' .  $grade }}</title>
    <style>
        /* Add your print styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
            .header {
                justify-content: center;
                margin-bottom: 40px;
            }
            body {
                margin: 0;
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

    <div class="grade-title">
        <h1>{{ $grade === 'all' ? 'All Students' : 'Grade ' . $grade . ' Students' }}</h1>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Student Number</th>
                <th>Full Name</th>
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
        };
    </script>
</body>
</html>
