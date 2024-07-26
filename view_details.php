<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Details</title>
</head>
<body>

<form action="view_details.php" method="get">
    Search: <input type="text" name="query">
    <input type="submit" value="Search">
    Sort by: 
    <!-- Add a sort button to sort by values -->
    <select name="sort">
        <option value="name">Name</option>
        <option value="usn">USN</option>
        <option value="phone">Phone Number</option>
    </select>
    <input type="submit" value="Sort">
</form>
<h2>View Details</h2>

<!-- Display Records -->
<table border="1">
    <tr>
        <th>Name</th>
        <th>USN</th>
        <th>Phone Number</th>
        <th>Delete Record</th>
        <th>Update Record</th>
    </tr>

    <?php
    $conn = new mysqli('localhost', 'root', '', 'wshop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $search_query = isset($_GET['query']) ? $_GET['query'] : '';
    $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';

    $stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE ? OR usn LIKE ? OR phone LIKE ? ORDER BY $sort_by");
    $search_query = "%$search_query%";
    $stmt->bind_param("sss", $search_query, $search_query, $search_query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["name"]) . "</td>
                    <td>" . htmlspecialchars($row["usn"]) . "</td>
                    <td>" . htmlspecialchars($row["phone"]) . "</td>
                    <td><form action='delete.php' method='post' style='display:inline-block;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                            <input type='submit' value='Delete'>
                        </form></td>
                    <td><form action='update.php' method='post' style='display:inline-block;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                            <input type='submit' value='Update'>
                        </form></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
    $stmt->close();
    $conn->close();
    ?>
</table>
</body>
</html>
