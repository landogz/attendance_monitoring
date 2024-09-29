<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Monitoring System README</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            color: #4CAF50;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        h3 {
            color: #555;
        }
        ul {
            list-style-type: square;
            margin: 10px 0 20px 20px;
        }
        .author {
            margin-top: 40px;
            padding: 10px;
            background-color: #e7f3fe;
            border-left: 6px solid #2196F3;
        }
        pre {
            background-color: #f4f4f4;
            border-left: 4px solid #ccc;
            padding: 10px;
            overflow-x: auto;
        }
        code {
            background-color: #eaeaea;
            padding: 2px 4px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <h1>Attendance Monitoring System</h1>

    <h2>Overview</h2>
    <p>The Attendance Monitoring System is designed to help educational institutions track student attendance efficiently. This system provides a user-friendly interface for managing student records, logs, and subjects, ensuring easy access to attendance data for both teachers and administrators.</p>

    <h2>Features</h2>
    <ul>
        <li><strong>Dashboard:</strong> A centralized view for quick insights into attendance statistics and student performance.</li>
        <li><strong>List of Students:</strong> View and manage the list of enrolled students, including personal details and attendance records.</li>
        <li><strong>Student Logs:</strong> Access detailed logs of student attendance, allowing for tracking of individual attendance patterns.</li>
        <li><strong>Subjects Logs:</strong> Review logs related to different subjects, ensuring accountability and monitoring of subject-specific attendance.</li>
        <li><strong>Subjects Management:</strong> Manage and organize subjects offered in the institution, enabling effective scheduling and tracking.</li>
        <li><strong>Login Logs:</strong> Monitor user login activity, enhancing security and accountability within the system.</li>
        <li><strong>Settings:</strong> Configure system settings, including SMS Gateway API integration and admin account management.</li>
    </ul>

    <h2>User Privileges</h2>
    <p>The system supports different user privileges:</p>
    <ul>
        <li><strong>Administrator:</strong> Full access to all features and settings.</li>
        <li><strong>Teacher:</strong> Limited access to student logs and relevant features.</li>
    </ul>

    <h2>Installation</h2>
    <p>Follow these steps to install the system:</p>
    <pre>
1. Clone the repository:
   <code>git clone https://github.com/landogz/attendance_monitoring.git</code>
2. Install dependencies:
   <code>composer install</code>
3. Set up the environment:
   <code>cp .env.example .env</code>
4. Run migrations:
   <code>php artisan migrate</code>
    </pre>

    <h2>Usage</h2>
    <p>Log in to the system with your credentials. Navigate through the sidebar menu to access various sections.</p>

    <h2>Author</h2>
    <div class="author">
        <strong>Rolan M. Benavidez Jr</strong><br>
        Full Stack Web Developer<br>
        <strong>Landogz Web Solutions</strong>
    </div>

</body>
</html>
