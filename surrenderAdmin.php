<?php

include 'dbcon.php';
include 'adnavbar.php'; 

$sql = "SELECT * FROM Surrender";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Pet Surrender Data</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        #navi {
    height: 64px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

    #navi ul {
    width: 100%;
    text-align: center;
    display: inline;
    margin: 0;
    background-color: #94f3f1;
}

    #navi ul li {
    display: inline-block;
    margin-right: -4px;
    position: relative;
}

    #navi ul li a {
    display: block;
    padding: 15px 20px;
    color: #000000;
    text-decoration: none;
    transition: color 1s;
}

    #navi ul li:hover a {
    color: rgb(247, 248, 246);
}

    #navi ul li:hover {
    background-color: #00e70f;
    border-radius: 20px;
}
    </style>
</head>
<body>

<div id= "navi">
                <ul>
                    <li>
                        <a href="admreport.php">^Reported cases^</a>
                    </li>
                    <li>
                        |
                    </li>
                    <li>
                        <a href="admresc.php">Animal Rescued</a>
                    </li>
                </ul>
        </div>

<h2 style="text-align: center;">Pet Surrender Table</h2>

<table>
    <thead>
        <tr>
            <th>Surrender ID</th>
            <th>Member ID</th>
            <th>Pet Name</th>
            <th>Type</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Status</th>
            <th>Action</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['SurrenderID'] . "</td>";
            echo "<td>" . $row['MemberID'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Breed'] . "</td>";
            echo "<td>" . $row['Age'] . "</td>";
            echo "<td>" . $row['Surrenderstatus'] . "</td>";
            echo "<td><form method='post' action=''>";
            echo "<input type='hidden' name='surrenderID' value='" . $row['SurrenderID'] . "'>";
            echo "<input type='submit' name='approve' value='Accept'>";
            echo "</form></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php
if(isset($_POST['approve'])) {
    $surrenderID = $_POST['surrenderID'];
    $update_sql = "UPDATE Surrender SET Surrenderstatus='approved' WHERE SurrenderID='$surrenderID'";
    if(mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Status updated successfully.')</script>";;
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>

</body>
</html>