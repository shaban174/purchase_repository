<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "purchase_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch company names
$sql = "SELECT company_name FROM vendor";
$result = $conn->query($sql);

$company_names = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $company_names[] = $row["company_name"];
    }
}
$sql = "SELECT device_type, brand, specification, model, warranty FROM organization_assets";
$result = $conn->query($sql);

$company_names = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $company_names[] = $row["device_type"];
        $company_names[] = $row["brand"];
        $company_names[] = $row["model"];
        $company_names[] = $row["warranty"];
    }
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($company_names);
?> correct any errors and they are selecting from the same database but different tables
