

<?php

/*  Fill this with your actual access token */
$x_access_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwbGF0Zm9ybV9jb2RlIjoiV2ViQCQhdDM4NzEyIiwiaXNzdWVkQXQiOiIyMDI1LTEwLTI3VDAzOjQ4OjEyLjczMFoiLCJwcm9kdWN0X2NvZGUiOiJ6ZWU1QDk3NSIsInR0bCI6ODY0MDAwMDAsImlhdCI6MTc2MTUzNjg5Mn0.W69p0NpyIpCN5NVfcBW0QmKnOt-m8AblI8GK9m8CDYo";
$authorization_token = "eyJraWQiOiJkZjViZjBjOC02YTAxLTQ0MWEtOGY2MS0yMDllMjE2MGU4MTUiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiI1N0I0ODg4RC01NDE0LTRGQjItQjMxQi0yMzdERkY5QUExMjciLCJkZXZpY2VfaWQiOiI1M2M5YzhjYi1kOTgyLTQ5MTYtOTM4Yy0xMzNhZmU4Yjk5NmYiLCJhbXIiOlsiZGVsZWdhdGlvbiJdLCJ0YXJnZXRlZF9pZCI6dHJ1ZSwiaXNzIjoiaHR0cHM6Ly91c2VyYXBpLnplZTUuY29tIiwidmVyc2lvbiI6MTEsImNsaWVudF9pZCI6InJlZnJlc2hfdG9rZW4iLCJhdWQiOlsidXNlcmFwaSIsInN1YnNjcmlwdGlvbmFwaSIsInByb2ZpbGVhcGkiLCJnYW1lLXBsYXkiXSwidXNlcl90eXBlIjoiUmVnaXN0ZXJlZCIsIm5iZiI6MTc2MTU3MzI2MywidXNlcl9pZCI6IjU3YjQ4ODhkLTU0MTQtNGZiMi1iMzFiLTIzN2RmZjlhYTEyNyIsInNjb3BlIjpbInVzZXJhcGkiLCJzdWJzY3JpcHRpb25hcGkiLCJwcm9maWxlYXBpIl0sInNlc3Npb25fdHlwZSI6IkdFTkVSQUwiLCJleHAiOjE3NjE5MTg4NjMsImlhdCI6MTc2MTU3MzI2MywidGVuYW50IjoiemVlNSIsImp0aSI6IjNkNzA4MjMwLTVhNTgtNDllZC04MDE5LTk3YWIyY2FlY2JmOSJ9.Icj5cjGFS9H9exqQxzy6UFiAUqLem1bBPgy2z4rCoaIqiXVWjyp5RafO05ZjGUKyCOuv4_1-9Bvj4EkD2RL9IKEKOnlQ8228BdHKLGglyVLNtvTdVg3FGa6oslMi2R2aPA7JYZGn2hPtreVmxXvTfKqaVPmnUOOupsa3Zq_sbdkBwNNeyhVHlktylDCbETUQWp6exTEzVKRso5-xi1ZA1k7qlUFngo_-x89MnFC-toww5wueg3BUIWOJZc7jmTOYsTrxHKTpj3bkaotf420OCyEf0kl6RjbZ4ussaatQlM4yrv0mxNjB0zv_MU0ZLzqn5sCL8gzga3RXGqd9cMOEgg";

if (isset($_GET["id"])) {
    $channel = $_GET["id"];
} else {
    exit("Error: Channel ID not found.");
}

$curl = curl_init();

$url="https://spapi.zee5.com/singlePlayback/getDetails/secure?channel_id=$channel&device_id=53c9c8cb-d982-4916-938c-133afe8b996f&platform_name=desktop_web&translation=en&user_language=en,hi,hr&country=IN&state=UP&app_version=4.26.1&user_type=register&check_parental_control=false&uid=57b4888d-5414-4fb2-b31b-237dff9aa127&ppid=53c9c8cb-d982-4916-938c-133afe8b996f&version=12";

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "application/json",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{
        "x-access-token": "' . $x_access_token. '",
        "Authorization": "' . $authorization_token . '"
    }',
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);

if ($response === false) {
    exit("cURL Error: " . curl_error($curl));
}

curl_close($curl);

$zx = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    exit("JSON Decode Error: " . json_last_error_msg());
}

if (isset($zx["keyOsDetails"]) && isset($zx["keyOsDetails"]["video_token"])) {
    $playit = $zx["keyOsDetails"]["video_token"];

    header("Location: $playit");
} else {
    exit("Error: Api Response Error.");
}

?>