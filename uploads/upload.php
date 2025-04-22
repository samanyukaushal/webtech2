<?php
require '../db/connection.php';
require '../vendor/autoload.php'; // This will work after we install PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_FILES['excel']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    for ($i = 1; $i < count($rows); $i++) {
        $data = $rows[$i];
        $stmt = $conn->prepare("INSERT INTO Results (StudentID, Name, Semester, WebTech, AdvJava, Ai, Python, SSMDA, TotalMarks, Percentage, Class) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiiiiidis", $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10]);
        $stmt->execute();
    }

    echo "<div class='alert alert-success mt-3'>Excel uploaded successfully.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Result Excel</title>
    <!-- Bootstrap CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 500px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #ff7f50;
            text-transform: uppercase;
        }
        form {
            margin-top: 30px;
        }
        input[type="file"] {
            margin: 15px 0;
            padding: 12px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            background-color: #ff7f50;
            color: white;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        input[type="file"]:hover {
            transform: scale(1.05);
        }
        button {
            padding: 12px 20px;
            font-size: 1.1rem;
            background-color: #ff7f50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        button:hover {
            transform: scale(1.05);
        }
        .alert {
            font-size: 1.1rem;
            border-radius: 5px;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #fff;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Result Excel</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="excel" required>
            <button type="submit">Upload</button>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Result Management System. All rights reserved.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
