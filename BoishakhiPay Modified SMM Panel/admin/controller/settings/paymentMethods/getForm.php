if ($method["methodId"] == 75) {
    $form .= '<div class="form-group mb-3"><label class="form-label">BoishakhiPay API Key</label>
    <input type="text"  name="api_key" class="form-control" value="' . $methodExtras["api_key"] . '"/></div>';

    $form .= '<div class="form-group mb-3"><label class="form-label">API Base URL</label>
    <input type="text"  name="api_url" class="form-control" value="' . $methodExtras["api_url"] . '" /></div>';

    $form .= '<div class="form-group mb-3"><label class="form-label">Exchange Rate [1 USD = ? BDT]</label>
    <input type="text"  name="exchange_rate" class="form-control" value="' . $methodExtras["exchange_rate"] . '"/></div>';
}
