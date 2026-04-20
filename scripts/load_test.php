<?php
/*
 * Load Test for Laravel API
 */

echo "Starting Load Test: Firing 50 requests at the same time...\n\n";

// الرابط الصحيح لسيرفر لارافيل + مسار ال API
 $url = "http://127.0.0.1:8000/api/orders"; 

 $totalRequests = 50;
 $success = 0;

 $payload = json_encode([
    "user_id" => 1,         
    "product_id" => 1,
    "quantity" => 1
]);

// إنشاء الطلبات المتوازية
 $multiHandle = curl_multi_init();
 $curlHandles = [];

for ($i = 0; $i < $totalRequests; $i++) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    
    $curlHandles[$i] = $ch;
    curl_multi_add_handle($multiHandle, $ch);
}

// تنفيذ الطلبات في نفس الثانية
 $active = null;
do {
    curl_multi_exec($multiHandle, $active);
    curl_multi_select($multiHandle, 0.1);
} while ($active);

// جمع النتائج
for ($i = 0; $i < $totalRequests; $i++) {
    $response = curl_multi_getcontent($curlHandles[$i]);
    $httpCode = curl_getinfo($curlHandles[$i], CURLINFO_HTTP_CODE);
    
    if ($httpCode == 200 || $httpCode == 201) {
        $success++;
        echo "✅ Request #" . ($i + 1) . " - Success\n";
    } else {
        echo "❌ Request #" . ($i + 1) . " - Failed (HTTP $httpCode)\n";
    }
    
    curl_multi_remove_handle($multiHandle, $curlHandles[$i]);
    curl_close($curlHandles[$i]);
}

curl_multi_close($multiHandle);

echo "\n=====================================================\n";
echo "TOTAL SUCCESSFUL: {$success} / {$totalRequests}\n";
echo "=====================================================\n";
?>