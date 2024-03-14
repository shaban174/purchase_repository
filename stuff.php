<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Information</title>
</head>
<body>
    <form id="deviceForm">
        <label for="deviceType">Choose a Device Type:</label>
        <select id="deviceType" name="deviceType">
            <option value="Laptop">Laptop</option>
            <option value="Printer">Printer</option>
            <option value="Mouse">Mouse</option>
            <option value="Keyboard">Keyboard</option>
            <option value="Headset">Headset</option>
        </select>
        <button type="button" onclick="getDeviceInfo()">Get Device Info</button>
    </form>

    <div id="deviceInfoContainer">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['device'])) {
                $selectedDevice = $_GET['device'];
                
                // Replace with your database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "purchase_project";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM organization_assets WHERE device_type = '$selectedDevice'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table border='1'>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>ID: " . $row['id'] . "</td>";
                        echo "<td>Device Type: " . $row['device_type'] . "</td>";
                        echo "<td>Brand: " . $row['brand'] . "</td>";
                        echo "<td>Model: " . $row['model'] . "</td>";
                        echo "<td>Specifications: " . $row['specifications'] . "</td>";
                        echo "<td>Serial Number: " . $row['serial_number'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No information available for the selected device type.";
                }

                $conn->close();
            }
        ?>
    </div>

    <script>
        function getDeviceInfo() {
            var selectedDevice = document.getElementById("deviceType").value;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("deviceInfoContainer").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "index.php?device=" + selectedDevice, true);
            xhr.send();
        }
    </script>
</body>
</html>
