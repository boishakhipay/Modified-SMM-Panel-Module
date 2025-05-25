
if ($methodId == 75) {
    $apiKey = htmlspecialchars($_POST["api_key"]);
    $exchangeRate = htmlspecialchars($_POST["exchange_rate"]);
    $methodExtras = [
        "api_key" => $apiKey,
        "exchange_rate" => $exchangeRate
    ];
}
