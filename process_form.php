<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    include 'database_connection.php';

    // Initialize variables to store form data
    $first_name = $middle_name = $last_name = $dob_gregorian = $dob_nepali = $gender = $id_number = "";
    $parent_first_name = $parent_middle_name = $parent_last_name = $has_spouse = "";
    $spouse_first_name = $spouse_middle_name = $spouse_last_name = "";
    $permanent_address = $permanent_city = $permanent_state = "";
    $temporary_address = $temporary_city = $temporary_state = "";

    // Function to sanitize and validate form inputs
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Retrieve and sanitize form data
    $first_name = test_input($_POST["first_name"]);
    $middle_name = test_input($_POST["middle_name"]);
    $last_name = test_input($_POST["last_name"]);
    $dob_gregorian = test_input($_POST["dob_year"]) . "-" . test_input($_POST["dob_month"]) . "-" . test_input($_POST["dob_day"]);
    $dob_nepali = test_input($_POST["nepali_dob_year"]) . "-" . test_input($_POST["nepali_dob_month"]) . "-" . test_input($_POST["nepali_dob_day"]);
    $gender = test_input($_POST["gender"]);
    $id_number = test_input($_POST["id_number"]);
    $parent_first_name = test_input($_POST["parent_first_name"]);
    $parent_middle_name = test_input($_POST["parent_middle_name"]);
    $parent_last_name = test_input($_POST["parent_last_name"]);
    $has_spouse = isset($_POST["has_spouse"]) ? "yes" : "no"; // Convert checkbox value to "yes" or "no"

    // Check if spouse's name fields are set
    $spouse_first_name = isset($_POST["spouse_first_name"]) ? test_input($_POST["spouse_first_name"]) : "";
    $spouse_middle_name = isset($_POST["spouse_middle_name"]) ? test_input($_POST["spouse_middle_name"]) : "";
    $spouse_last_name = isset($_POST["spouse_last_name"]) ? test_input($_POST["spouse_last_name"]) : "";

    $permanent_address = test_input($_POST["permanent_street"]);
    $permanent_city = test_input($_POST["permanent_city"]);
    $permanent_state = test_input($_POST["permanent_state"]);
    $temporary_address = test_input($_POST["temporary_street"]);
    $temporary_city = test_input($_POST["temporary_city"]);
    $temporary_state = test_input($_POST["temporary_state"]);

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // SQL query to insert data into the database
    $sql = "INSERT INTO voter_details (first_name, middle_name, last_name, dob_gregorian, dob_nepali, gender, id_number, parent_first_name, parent_middle_name, parent_last_name, has_spouse, spouse_first_name, spouse_middle_name, spouse_last_name, permanent_address, permanent_city, permanent_state, temporary_address, temporary_city, temporary_state, photo_path)
    VALUES ('$first_name', '$middle_name', '$last_name', '$dob_gregorian', '$dob_nepali', '$gender', '$id_number', '$parent_first_name', '$parent_middle_name', '$parent_last_name', '$has_spouse', '$spouse_first_name', '$spouse_middle_name', '$spouse_last_name', '$permanent_address', '$permanent_city', '$permanent_state', '$temporary_address', '$temporary_city', '$temporary_state', '$target_file')";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        // Retrieve the last inserted voter's ID
        $last_inserted_id = $conn->insert_id;

        // Query to fetch the data of the last inserted voter
        // Close database connection
        $conn->close();

        // Redirect to the voter ID card page with voter's ID as a query parameter
        header("Location: votercard.php?id=$last_inserted_id&first_name=$first_name&middle_name=$middle_name&last_name=$last_name&dob_ad=$dob_ad&dob_bs=$dob_bs&gender=$gender&id_number=$id_number&parent_name=$parent_name&permanent_address=$permanent_address&permanent_city=$permanent_city&permanent_state=$permanent_state&temporary_address=$temporary_address&temporary_city=$temporary_city&temporary_state=$temporary_state&photo_path=$target_file");        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
} else {
    // If the form is not submitted, redirect to the form page or show an error message
    echo "Form submission error";
}
?>
