<?php
if (!defined('ADDFUNDS')) {
    http_response_code(404);
    die();
}

$apiKey = $methodExtras["api_key"];
$apiUrl = rtrim($methodExtras["api_url"], "/");
$exchangeRate = $methodExtras["exchange_rate"];
$payeeName = $user["name"] ?: "User";
$payeeEmail = $user["email"] ?: "test@test.com";
$paymentURL = site_url("payment/" . $methodCallback);
$orderId = md5(RAND_STRING(5) . time());

$insert = $conn->prepare(
    "INSERT INTO payments SET
client_id=:client_id,
payment_amount=:amount,
payment_method=:method,
payment_mode=:mode,
payment_create_date=:date,
payment_ip=:ip,
payment_extra=:extra"
);

$insert->execute([
    "client_id" => $user["client_id"],
    "amount" => $paymentAmount,
    "method" => $methodId,
    "mode" => "Automatic",
    "date" => date("Y.m.d H:i:s"),
    "ip" => GetIP(),
    "extra" => $orderId
]);

$requestData = [
    'full_name'    => $payeeName,
    'email'        => $payeeEmail,
    'amount'       => (float) round($paymentAmount * $exchangeRate, 2),
    'redirect_url' => $paymentURL,
    'cancel_url'   => site_url("addfunds?status=cancelled"),
    'metadata'     => ['order_id' => $orderId]
];

$postUrl = $apiUrl . "/create";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $postUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($requestData),
    CURLOPT_HTTPHEADER => [
        "X-API-KEY: " . $apiKey,
        "Content-Type: application/json"
    ],
]);

$upresponse = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    errorExit("cURL Error #:" . $err);
}

$result = json_decode($upresponse, true);

if (!empty($result['payment_url'])) {
    $paymentUrl = $result['payment_url'];
    $redirectForm = '
    <script type="text/javascript">
        // কোনো AJAX বা ফর্ম ছাড়া সরাসরি উইন্ডো রিডাইরেক্ট
        window.location.href = "' . $paymentUrl . '";
    </script>';
} else {
    errorExit($result['message'] ?? 'Unknown error from payment gateway.');
}

$response["success"] = true;
$response["message"] = "Redirecting to BoishakhiPay...";
$response["content"] = $redirectForm;
