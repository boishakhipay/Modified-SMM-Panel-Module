if ($methodId == 75) {
    $apiKey = htmlspecialchars($_POST["api_key"]);
    $apiUrl = htmlspecialchars($_POST["api_url"]);
    $exchangeRate = htmlspecialchars($_POST["exchange_rate"]);
    $methodExtras = [
        "api_key" => $apiKey,
        "api_url" => $apiUrl,
        "exchange_rate" => $exchangeRate
    ];
}
