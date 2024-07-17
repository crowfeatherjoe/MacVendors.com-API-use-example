<!DOCTYPE html>
<html>
<head>
    <title>MAC Address Lookup</title>
</head>
<body>
    <h1>MAC Address Lookup</h1>
    <form method="post" action="">
        <label for="mac_address">Enter MAC Address:</label>
        <input type="text" id="mac_address" name="mac_address" required>
        <button type="submit">Lookup</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mac_address = $_POST["mac_address"];

        $url = "https://api.macvendors.com/" . urlencode($mac_address);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        
        if ($response) {
            echo "<p>Vendor: $response</p>";
        } else {
            echo "<p>Not Found</p>";
        }
    }
    ?>
</body>
</html>
