<?php
// Replace these variables with your PostgreSQL database credentials
$host = 'localhost';
$dbname = 'your_database_name';
$user = 'your_username';
$password = 'your_password';

// Function to connect to the PostgreSQL database
function connectDB() {
    global $host, $dbname, $user, $password;
    $dsn = "pgsql:host=$host;dbname=$dbname";
    return new PDO($dsn, $user, $password);
}

if (isset($_POST["submit"])) {
    if ($_FILES["csv_file"]["error"] == 0) {
        $file = $_FILES["csv_file"]["tmp_name"];

        // Read the CSV file into an array
        $data = array_map('str_getcsv', file($file));

        // Remove header row if present (assuming the first row is the header)
        $header = array_shift($data);

        // Connect to the database
        $pdo = connectDB();

        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO csv_data (name, email, age) VALUES (?, ?, ?)");

        // Import data from the CSV into the database
        foreach ($data as $row) {
            $name = $row[0];
            $email = $row[1];
            $age = (int)$row[2];
            $stmt->execute([$name, $email, $age]);
        }

        echo "CSV data imported successfully!";
    } else {
        echo "Error uploading the CSV file.";
    }
}
?>
