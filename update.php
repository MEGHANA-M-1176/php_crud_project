<!DOCTYPE html>
<html>
<head>
    <title>Update Details</title>
</head>
<body>
    <h2>Update Details</h2>

    <?php
    $id = $_POST['id'];

    $conn = new mysqli('localhost', 'root', '', 'wshop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM students WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        Name: <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br>
        USN: <input type="text" name="usn" value="<?php echo $row['usn']; ?>" required><br>
        Phone Number: <input type="text" name="phone" value="<?php echo $row['phone']; ?>" required><br>
        <input type="submit" name="submit" value="Update">
    </form>
    <?php
    } else {
        echo "No record found";
    }
    $conn->close();

    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $usn = $_POST['usn'];
        $phone = $_POST['phone'];

        $conn = new mysqli('localhost', 'root', '', 'wshop');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE students SET name='$name', usn='$usn', phone='$phone' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $conn->close();
        header("Location: view_details.php");
    }
    ?>
</body>
</html>
