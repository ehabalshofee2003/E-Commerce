<?php
/*
 * Test: إدارة الموارد (Rate Limiting) - بشكل متتالي سريع
 * نرسل الطلبات بسرعة خيالية، لكن تتابعياً، عشان السيرفر يقدر يرد علينا بـ 429
 */

echo "Starting Rapid Sequential Test: Firing 15 requests rapidly...\n";
echo "Expected: First 10 SUCCESS, Next 5 BLOCKED (429)\n\n";

 $url = "http://127.0.0.1:8000/api/orders/protected";
 $totalRequests = 15;
 $success = 0;
 $blocked = 0;

 $payload = json_encode([
    "user_id" => 1,
    "product_id" => 1,
    "quantity" => 1
]);

for ($i = 0; $i < $totalRequests; $i++) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($httpCode == 200 || $httpCode == 201) {
        $success++;
        echo "✅ Request #" . ($i + 1) . " - Allowed\n";
    } elseif ($httpCode == 429) {
        $blocked++;
        echo "🛑 Request #" . ($i + 1) . " - BLOCKED (429 Too Many Requests)\n";
    } else {
        echo "❌ Request #" . ($i + 1) . " - Error (HTTP $httpCode)\n";
    }
    
    curl_close($ch);
}

echo "\n=====================================================\n";
echo "TOTAL ALLOWED: {$success} / {$totalRequests}\n";
echo "TOTAL BLOCKED (429): {$blocked} / {$totalRequests}\n";
echo "=====================================================\n";

if ($blocked > 0) {
    echo "✅ SUCCESS: Rate Limiter successfully protected the server!\n";
} else {
    echo "ℹ️  No blocking occurred. (Maybe wait 1 minute for limit to reset)\n";
}
?>