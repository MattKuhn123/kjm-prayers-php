<?php

$key = get_cfg_var("api_key");
$url = "https://vision.googleapis.com/v1/images:annotate?key=$key";

$bytes = file_get_contents($_FILES['file']['tmp_name']);
$encoded = base64_encode($bytes);
$data = [
    "requests" => array(
        "features" => array(
            "type" => "DOCUMENT_TEXT_DETECTION"
        ),
        "image" => [
            "content" => "$encoded"
        ]
    )
];

$options = [
    "http" => [
        "header" => "Content-type: application/json",
        "method" => "POST",
        "content" => json_encode($data),
    ],
    // TODO : SSL
    'ssl' => array(
        'verify_peer' => false,
    )
];

$text = "";
try {
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $json = json_decode($result);
    if ($json != null && count($json->responses) > 0 && isset($json->responses[0]->fullTextAnnotation)) {
        $text = $json->responses[0]->fullTextAnnotation->text;
    } else {
        $text = "Could not parse text from image";
    }
} catch (Exception $e) {
    $text = "error";
}

?>

<?= $text ?>