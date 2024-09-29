Attendance Monitoring System
Overview
The Attendance Monitoring System is designed to help educational institutions track student attendance efficiently. This system provides a user-friendly interface for managing student records, logs, and subjects, ensuring easy access to attendance data for both teachers and administrators.

Features
1. Dashboard
A centralized view for quick insights into attendance statistics and student performance.
2. List of Students
View and manage the list of enrolled students, including personal details and attendance records.
3. Student Logs
Access detailed logs of student attendance, allowing for tracking of individual attendance patterns.
4. Subjects Logs
Review logs related to different subjects, ensuring accountability and monitoring of subject-specific attendance.
5. Subjects Management
Manage and organize subjects offered in the institution, enabling effective scheduling and tracking.
6. Login Logs
Monitor user login activity, enhancing security and accountability within the system.
7. Settings
Configure system settings, including SMS Gateway API integration and admin account management.
User Privileges
The system supports different user privileges:

Administrator: Full access to all features and settings.
Teacher: Limited access to student logs and relevant features.
Installation
Clone the repository:
bash
Copy code
git clone https://github.com/landogz/attendance_monitoring.git
Install dependencies:
bash
Copy code
composer install
Set up the environment:
bash
Copy code
cp .env.example .env
Run migrations:
bash
Copy code
php artisan migrate
Usage
Log in to the system with your credentials.
Navigate through the sidebar menu to access various sections.
Author
Rolan M. Benavidez Jr
Full Stack Web Developer
Landogz Web Solutions