title Tech-Guardian
C:/xampp/xampp_start.exe
echo off
echo Tech-Guardian Server Started
cd C:/xampp/htdocs/students/receiver/
node receiver.js
echo off
echo SMS Server Started
pause
C:/xampp/xampp_stop.exe