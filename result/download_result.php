<?php
require '../vendor/autoload.php';
include('../db/connection.php');

use Mpdf\Mpdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentID = $_POST['student_id'];

    $stmt = $conn->prepare("SELECT * FROM Results WHERE StudentID = ?");
    $stmt->bind_param("s", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Result not found.");
    }

    $data = $result->fetch_assoc();

    $mpdf = new Mpdf();
    $html = "
        <h2>Result Sheet</h2>
        <strong>Name:</strong> {$data['Name']}<br>
        <strong>Student ID:</strong> {$data['StudentID']}<br>
        <strong>Semester:</strong> {$data['Semester']}<br><br>
        <table border='1' cellspacing='0' cellpadding='6'>
            <tr><th>Subject 1</th><td>{$data['WebTech']}</td></tr>
            <tr><th>Subject 2</th><td>{$data['AdvJava']}</td></tr>
            <tr><th>Subject 3</th><td>{$data['Ai']}</td></tr>
            <tr><th>Subject 4</th><td>{$data['Python']}</td></tr>
            <tr><th>Subject 5</th><td>{$data['SSMDA']}</td></tr>
            <tr><th>Total</th><td>{$data['TotalMarks']}</td></tr>
            <tr><th>Percentage</th><td>{$data['Percentage']}%</td></tr>
            <tr><th>Class</th><td>{$data['Class']}</td></tr>
        </table>
    ";
    $mpdf->WriteHTML($html);
    $mpdf->Output("Result_{$studentID}.pdf", "D"); // D = Download
}
?>
