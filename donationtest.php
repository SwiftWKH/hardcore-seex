<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form</title>
    <style>
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
    </style>
</head>
<body>

<div class="container"> 
    <h2>Make a Donation</h2>
    <p>"Your donation to an animal shelter can mean the world to those furry friends waiting for a loving family. It's not just about the cash; 
        it's about giving hope to those who've been left behind. Your kindness provides them with food, shelter, and care, but most importantly, 
        it lets them know they're not alone—that there are folks out there who really care. With your help, we can give these pets the second chance they deserve, 
        full of love, warmth, and the promise of a better tomorrow. Your donation isn't just a handout; it's a lifeline, 
        bringing comfort and joy to those who need it most."</p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="amount">Amount(RM):</label>
        <input type="number" id="amount" name="amount" required><br><br>
        <input type="submit" value="Donate">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $amount = $_POST['amount']; 

        session_start(); 

        // Check if the user is logged in
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // Retrieve the member ID and name from the session
            $memberID = $_SESSION['memberID']; 
            $name = $_SESSION['name'];


            $date = date("Y-m-d H:i:s");

            $conn = new mysqli('localhost', 'username', 'password', 'donation');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO donation (MemberID, Amount, Date) VALUES (?, ?, ?)");
            $stmt->bind_param("ids", $memberID, $amount, $date);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Donation recorded successfully.<br>";
                echo "Certificate:<br>";
                echo "This is to certify that $name has generously donated RM $amount.<br>";
            } else {
                echo "Error: Unable to record donation.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Error: User not logged in.";
        }
    }
    ?>

</div> 

</body>
</html>