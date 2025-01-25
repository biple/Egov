<?php
// Retrieve query parameters
$id = isset($_GET['id']) ? $_GET['id'] : '';
$first_name = isset($_GET['first_name']) ? $_GET['first_name'] : '';
$middle_name = isset($_GET['middle_name']) ? $_GET['middle_name'] : '';
$last_name = isset($_GET['last_name']) ? $_GET['last_name'] : '';
$dob_ad = isset($_GET['dob_ad']) ? $_GET['dob_ad'] : '';
$dob_bs = isset($_GET['dob_bs']) ? $_GET['dob_bs'] : '';
$gender = isset($_GET['gender']) ? $_GET['gender'] : '';
$id_number = isset($_GET['id_number']) ? $_GET['id_number'] : '';
$parent_name = isset($_GET['parent_name']) ? $_GET['parent_name'] : '';
$permanent_address = isset($_GET['permanent_address']) ? $_GET['permanent_address'] : '';
$permanent_city = isset($_GET['permanent_city']) ? $_GET['permanent_city'] : '';
$permanent_state = isset($_GET['permanent_state']) ? $_GET['permanent_state'] : '';
$temporary_address = isset($_GET['temporary_address']) ? $_GET['temporary_address'] : '';
$temporary_city = isset($_GET['temporary_city']) ? $_GET['temporary_city'] : '';
$temporary_state = isset($_GET['temporary_state']) ? $_GET['temporary_state'] : '';
$image_path = isset($_GET['photo_path']) ? $_GET['photo_path'] : ''; // New parameter for image path
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Identity Card</title>
    <style>
        /* Styles for the card */
        .card {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header styles */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .header h1 {
            margin-top: 10px;
        }

        /* Details styles */
        .details {
            line-height: 1.6;
        }

        .details p {
            margin: 10px 0;
        }

        .details strong {
            font-weight: bold;
            margin-right: 5px;
        }

        .submit-button {
            margin-top: 20px;
            text-align: left;
        }

        .submit-button button {
            background-color: crimson;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button button:hover {
            background-color: blue;
        }

    </style>
</head>
<body>

<?php
// Include the database connection file
include 'database_connection.php';

// SQL query to fetch data
$sql = "SELECT * FROM voter_details WHERE id = $id"; // Change the ID as needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the first row
    $row = $result->fetch_assoc();
    $name = $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"];
    $dob_ad = date("F j, Y", strtotime($row["dob_gregorian"]));
    $dob_bs = $row["dob_nepali"];
    $gender = ucfirst($row["gender"]);
    $id_number = $row["id_number"];
    $parent_name = $row["parent_first_name"] . " " . $row["parent_middle_name"] . " " . $row["parent_last_name"];
    $permanent_address = $row["permanent_address"] . ", " . $row["permanent_city"] . ", " . $row["permanent_state"];
    $temporary_address = $row["temporary_address"] . ", " . $row["temporary_city"] . ", " . $row["temporary_state"];
} else {
    echo "No data found";
}
$conn->close();
?>

<div class="card">
    <div class="header">
    <img src="<?php echo $image_path; ?>" alt="Profile Picture"> <!-- Dynamically fetch image -->
        <h1>Voter Identity Card</h1>
    </div>
    <div class="details">
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $dob_ad; ?> (A.D.) / <?php echo $dob_bs; ?> (B.S.)</p>
        <p><strong>Gender:</strong> <?php echo $gender; ?></p>
        <p><strong>ID Number:</strong> <?php echo $id_number; ?></p>
        <p><strong>Parent's Name:</strong> <?php echo $parent_name; ?></p>
        <p><strong>Permanent Address:</strong> <?php echo $permanent_address; ?></p>
        <p><strong>Temporary Address:</strong> <?php echo $temporary_address; ?></p>
    </div>

    <div class="submit-button">
        <button type="submit" id="submit_button">Print</button>
    </div>
</div>

<script>
    document.getElementById("submit_button").addEventListener("click", function() {
        alert("Please take the official documents and visit the nearby election office for official documentation.");
    });
</script>

</body>
</html>
