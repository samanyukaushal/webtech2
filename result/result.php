<?php
include('../db/connection.php');

$studentData = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentID = $_POST['student_id'];

    $stmt = $conn->prepare("SELECT * FROM Results WHERE StudentID = ?");
    $stmt->bind_param("s", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $studentData = $result->fetch_assoc();
    } else {
        $error = "No result found for Student ID: $studentID";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f7fa;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .form-box {
            margin-bottom: 20px;
        }
        .form-box label {
            font-weight: bold;
            color: #333;
        }
        .form-box input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .form-box button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .form-box button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: left;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        table td {
            background-color: #f9f9f9;
        }
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        .download-btn {
            margin-top: 20px;
            text-align: center;
        }
        .download-btn button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .download-btn button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Your Result</h2>

        <div class="form-box">
            <form method="POST">
                <label>Enter Student ID:</label>
                <input type="text" name="student_id" required>
                <button type="submit">View Result</button>
            </form>
        </div>

        <?php if ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($studentData): ?>
            <h3>Result for <?= htmlspecialchars($studentData['Name']) ?> (<?= $studentData['StudentID'] ?>)</h3>
            <table>
                <tr><th>Semester</th><td><?= $studentData['Semester'] ?></td></tr>
                <tr><th>Subject 1</th><td><?= $studentData['WebTech'] ?></td></tr>
                <tr><th>Subject 2</th><td><?= $studentData['AdvJava'] ?></td></tr>
                <tr><th>Subject 3</th><td><?= $studentData['AI'] ?></td></tr>
                <tr><th>Subject 4</th><td><?= $studentData['Python'] ?></td></tr>
                <tr><th>Subject 5</th><td><?= $studentData['SSMDA'] ?></td></tr>
                <tr><th>Total Marks</th><td><?= $studentData['TotalMarks'] ?></td></tr>
                <tr><th>Percentage</th><td><?= $studentData['Percentage'] ?>%</td></tr>
                <tr><th>Class</th><td><?= $studentData['Class'] ?></td></tr>
            </table>
            <div class="download-btn">
                <form method="POST" action="download_result.php">
                    <input type="hidden" name="student_id" value="<?= $studentData['StudentID'] ?>">
                    <button type="submit">Download Result as PDF</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
