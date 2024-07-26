<!DOCTYPE html>
<html>
<head>
    <title>Add Details</title>
</head>
<body>
    <h2>Add Details</h2>
    <form action="add_details.php" method="post">
        Name: <input type="text" name="name" required><br>
        USN: <input type="text" name="usn" required><br>
        Phone Number: <input type="text" name="phone" required><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <form action="view_details.php" method="get">
        <input type="submit" value="View Records">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $usn = $_POST['usn'];
        $phone = $_POST['phone'];

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'wshop');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert data
        $sql = "INSERT INTO students (name, usn, phone) VALUES ('$name', '$usn', '$phone')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
