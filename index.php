<?php
$apiKey = '4b3dcb26308d31de83277300'; // Replace with your actual API key
$baseCurrency = 'USD'; // Default base currency

$exchangeRates = [];

// Fetch the exchange rates from the API
if (isset($_POST['convert'])) {
    $fromCurrency = $_POST['from_currency'];
    $toCurrency = $_POST['to_currency'];
    $amount = $_POST['amount'];

    $url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/$fromCurrency";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['result'] == 'success') {
        $exchangeRates = $data['conversion_rates'];
        $rate = $exchangeRates[$toCurrency];
        $convertedAmount = $amount * $rate;
    } else {
        $error = "Unable to fetch exchange rates. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="converter">
        <h1>Currency Converter</h1>
        <form method="post" action="index.php">
            <div class="input-group">
                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" required>
            </div>
            <div class="input-group">
                <label for="from_currency">From:</label>
                <select name="from_currency" id="from_currency" required>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="KES">KES</option>
                    <!-- Add more currencies as needed -->
                </select>
            </div>
            <div class="input-group">
                <label for="to_currency">To:</label>
                <select name="to_currency" id="to_currency" required>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="KES">KES</option>
                    <!-- Add more currencies as needed -->
                </select>
            </div>
            <button type="submit" name="convert">Convert</button>
        </form>

        <?php if (isset($convertedAmount)) { ?>
            <div class="result">
                <p><?php echo number_format($amount, 2) . " " . $fromCurrency . " = " . number_format($convertedAmount, 2) . " " . $toCurrency; ?></p>
            </div>
        <?php } elseif (isset($error)) { ?>
            <div class="error">
                <p><?php echo $error; ?></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
