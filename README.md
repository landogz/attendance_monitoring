# Attendance Monitoring System

## Overview
The Attendance Monitoring System is a comprehensive platform designed to streamline the management of student attendance and related records. This application provides a user-friendly interface for administrators and teachers to track attendance, manage student data, and generate reports.

---

## Features

- **Dashboard**: Overview of attendance statistics and quick access to important features.
  
- **List of Students**: View, add, edit, and delete student records.
  
- **Student Logs**: Detailed logs of student attendance and activities.
  
- **Subjects Logs**: Track attendance and performance across various subjects.
  
- **Subjects Management**: Manage and assign subjects to students.

- **Login Logs**: Monitor user login activities for security and auditing purposes.
  
- **Settings**: Configure SMS Gateway API and manage admin accounts (available for Administrators only).

---

## Menu Structure

```html
<div class="sidebar-menu-area" id="metismenu" data-simplebar>
    <ul class="sidebar-menu o-sortable">
        <li><span class="cat">HOME</span></li>
        <li><a href="{{ route('dashboard') }}" class="menu-title">Dashboard</a></li>
        <li><span class="cat">Menus</span></li>
        <li><a href="{{ route('students') }}" class="menu-title">List of Students</a></li>
        <li><a href="{{ route('students-logs') }}" class="menu-title">Student Logs</a></li>
        <li><a href="{{ route('subjects_logs') }}" class="menu-title">Subjects Logs</a></li>
        <li><a href="{{ route('subjects') }}" class="menu-title">Subjects</a></li>
        @if(Auth::user()->privilege !== 'Teacher')
            <li><a href="{{ route('loginlogs') }}" class="menu-title">Login Logs</a></li>
            <li><a href="#" class="has-arrow menu-title">Settings</a>
                <ul class="sidemenu-second-level">
                    <li><a href="{{ route('smsapi') }}">SMS Gateway API</a></li>
                    <li><a href="{{ route('accounts') }}">Admin Accounts</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>
