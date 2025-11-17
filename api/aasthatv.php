<?php

$curl = curl_init();
$channel =$_GET['id'];
curl_setopt_array($curl, [
  CURLOPT_URL => "https://api-apac.revlet.net/service/api/v1/page/stream?path=channel/live/".$channel,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: */*",
    "Host: api-apac.revlet.net",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36",
    "box-id: 348e1804-1d40-e983-9958-05eac4a0f18b",
    "session-id: 36073abf-c4ed-4f48-8299-a1dd7e5845fe",
    "tenant-code: aastha"

  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);


$zx = json_decode($response, true);
$streamurl = $zx["response"]["streams"][0]["url"];
if ($err) {
  echo "cURL Error #:" . $err;
} else {
   echo $streamurl;
  header("Location:".$streamurl,true,301);
}

?>