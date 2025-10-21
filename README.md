## QuickMark – Student Attendance System

## Description

QuickMark is a hybrid attendance system designed for educational institutions. It allows students, lecturers, and administrators to manage attendance efficiently. Students can clock in via a mobile app, lecturers can prompt attendance through a web dashboard, and admins oversee the entire system. The system uses geolocation (Haversine formula) to verify student presence during class sessions.

## Features

User Registration: Students, Lecturers, and Admins can register with role-specific details.

Role-based Access:

Students: Log in on mobile app, clock in for attendance.

Lecturers: Log in on web dashboard, prompt attendance, manage classes.

Admins: Log in on admin panel, manage users and system.

Attendance Verification: Students clock in via mobile app when prompted by the lecturer.

Dashboard & Analytics: Track attendance, student participation, and class activity.

## Installation

1. Clone the Repository

git clone https://github.com/Saar-engflow/quickmark-attendance-system.git

2. Import Database

Import quickmark_db.sql into MySQL.

3. Configure PHP

Update includes/db_connect.php with your database credentials.

4. Run Web App

Place files in your web server root (htdocs for XAMPP).

Open in browser: http://localhost/quickmark.

5. Run Android App

Update API URLs in the app to point to your local server or live host.

Open in emulator or connect a device on the same network.

## Usage

## Student Flow

1. Register on the website with:

Full Name, Institute, Student ID, Email, Password.

2. Log in and open the mobile app.

3. When prompted by the lecturer, clock in with a single button.

4. Access the student dashboard to view attendance history.

## Lecturer Flow

1. Register on the website with:

Full Name, Institute, Lecturer ID, Email, Password.

2. Log in on the web dashboard.

3. Prompt students for attendance during class.

4. View attendance reports and analytics.

## Admin Flow

1. Log in with admin credentials.

2. Access the admin panel to manage users, classes, and system settings.

Example

# Student clocks in via mobile app:

Press "Clock In" button → System verifies location → Attendance marked

// Haversine Distance Logic (simplified)
function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // km
    $phi1 = deg2rad($lat1);
$phi2 = deg2rad($lat2);
$deltaPhi = deg2rad($lat2 - $lat1);
    $deltaLambda = deg2rad($lon2 - $lon1);

    $a = sin($deltaPhi/2)*2 + cos($phi1) * cos($phi2) * sin($deltaLambda/2)*2;
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $R * $c;

}

# Contributing

Submit bug reports or feature requests via GitHub Issues.

Submit pull requests for new features or improvements.

# Acknowledgments

Special thanks to contributors, online resources, and PHP & Android development communities.
