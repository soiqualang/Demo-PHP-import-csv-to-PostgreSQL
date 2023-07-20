# Demo-PHP-import-csv-to-PostgreSQL
Demo PHP import csv to PostgreSQL

To create a PHP application that imports a CSV file into PostgreSQL, you'll need to follow these steps:

1. Set up a PostgreSQL database and create a table to store the CSV data.
2. Create a form to upload the CSV file.
3. Process the uploaded CSV file and insert the data into the PostgreSQL table.

Here's a basic example to get you started:

1. Set up the PostgreSQL database and create a table:

Assuming you have PostgreSQL installed and running, create a table named `csv_data` with the appropriate columns to match your CSV file data.

```sql
CREATE TABLE csv_data (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    age INT
);
```

2. Create the HTML form to upload the CSV file (`index.html`):

```html
<!DOCTYPE html>
<html>
<head>
    <title>CSV Importer</title>
</head>
<body>
    <h2>Import CSV File to PostgreSQL</h2>
    <form action="import.php" method="post" enctype="multipart/form-data">
        Select CSV File:
        <input type="file" name="csv_file" id="csv_file">
        <input type="submit" value="Import" name="submit">
    </form>
</body>
</html>
```

3. Create the PHP script to handle the CSV import (`import.php`):

```php
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
```

Make sure to replace `'localhost'`, `'your_database_name'`, `'your_username'`, and `'your_password'` with your actual PostgreSQL database credentials.

Save the `index.html` and `import.php` files in the same directory on your web server. When you access the `index.html` page, you can upload a CSV file using the form, and the PHP script (`import.php`) will handle the CSV import into the PostgreSQL database.

Note: This is a basic example for demonstration purposes. In a production environment, you should add appropriate error handling, data validation, and security measures (e.g., sanitizing input, protecting against SQL injection). Also, consider using a library like `fgetcsv()` for more robust CSV parsing.