<?php
include("dbcon.php");
include("adnavbar.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #e1d76f;
        }

        #content {
        background-color: #fa980f;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 10px;
        margin: 40px auto;
        max-width: 600px;
        }

        #content form {
            margin-top: 20px;
        }

        #content form input[type="text"],
        #content form input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #content #button {
            display: flex;
            justify-content: center;
        }

        #content #button input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        #content #button input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            display:flex;
            justify-content: center;
            background-color: #ff1b1b;
            color: #000000;
            padding: 10px; 
            margin-top: 20px; 
            border-radius: 30px; 
        }
    <style>
    <link rel="stylesheet" href="admupd.css">
</head>
<body>
    <div id = 'content'>
        Report ID = <?php echo $_SESSION['reportid']; ?> <br>
        Type of animals = <?php echo $_SESSION['animal']; ?> <br>
        <form action='admupd.php' method='POST' enctype="multipart/form-data">
            Name: <input type='text' name='name'><br>
            Breed: <input type='text' name='breed'><br>
            Age: <input type='text' name='age'><br>
            photo: <input type='file' name="photo" id="photo"><br>
            <div id = 'button'>
                <input type="submit" name='upload' value="Upload">
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['upload'])) {

        if (!empty($_FILES['photo']['name'])) {
            $fileName = basename($_FILES['photo']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'jfif');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['photo']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                $img = $imgContent;
            } else {
                echo 'Only JPEG, JPG, PNG and GIF are allowed!';

            }
        }
        // assign ID
        $sql = "SELECT AnimalID
                FROM animal
                ORDER BY CAST(SUBSTRING_INDEX(AnimalID, 'A', -1) AS UNSIGNED) DESC LIMIT 1;";                             
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $ID = $row["AnimalID"];
            $IDnum = str_replace("A", "", $ID);
            $INTIDnum = (int)$IDnum;
            $addID = $INTIDnum + 1;
            $newID = "A{$addID}";
            }
        else{
            $newID = 'A1';
        }

        // Database insertion
        if(empty($_POST['name']) || empty($_POST['breed']) || empty($_POST['age'])){
    ?>
            <div class = 'message'><?php echo '**ALL FIELD MUST BE FILLED IN!';?></div>
    <?php
        }
        else{
            $ID = $newID;
            $SID = $_SESSION['SurrenderID'];
            $name = $_POST['name'];
            $type = $_SESSION['animal'];
            $breed = $_POST['breed'];
            $age = $_POST['age'];
            $status = 'available';

            // Insert query
            $sql = "INSERT INTO `animal`(`AnimalID`, `SurrenderID`, `A_name`, `Type`, `Breed`, `Age`, `Status`, `A_pic`) 
                    VALUES ('$ID','$SID','$name','$type','$breed','$age','$status', '$img')";
            try {
                mysqli_query($conn, $sql);
                echo '<script>
                window.location.replace("admresc.php");
                </script>';
    ?>


        <?php
            } catch (mysqli_sql_exception) {
        ?>
                <div class = 'message'><?php echo "**Could not update report!**"; ?></div>
    <?php
        }
        }
    }
    ?>
    <?php
    mysqli_close($conn)
    ?>
</body>

</html>