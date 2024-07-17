<!DOCTYPE html>
<html>
<head>
    <title>MAC Address Lookup</title>
</head>
<body>
    <h1>MAC Address Lookup</h1>
    <form method="post" action="">
        <label for="mac_addresses">Enter MAC Addresses (one per line):</label><br>
        <textarea id="mac_addresses" name="mac_addresses" rows="10" cols="30" required></textarea><br>
        <button type="submit">Lookup</button>
    </form>

    <?php
    // Define your API token here
    $api_token = 'YOUR_API_TOKEN_HERE';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mac_addresses = $_POST["mac_addresses"];
        $mac_addresses_array = explode("\n", $mac_addresses);
        $mac_addresses_array = array_map('trim', $mac_addresses_array);

        echo "<h2>Lookup Results:</h2>";
        foreach ($mac_addresses_array as $mac_address) {
            if (!empty($mac_address)) {
                $url = "https://api.macvendors.com/" . urlencode($mac_address);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . $api_token
                ));
                $response = curl_exec($ch);
                if ($response === false) {
                    $error_msg = curl_error($ch);
                    echo "<p>MAC Address: $mac_address - Error: $error_msg</p>";
                } else {
                    echo "<p>MAC Address: $mac_address - Vendor: $response</p>";
                }
                curl_close($ch);
                
                // Delay the requests to 1 per second
                sleep(1);
            }
        }
    }
    ?>
</body>
</html>
