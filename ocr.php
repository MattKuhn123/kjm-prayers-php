<?php

$key = get_cfg_var("apiKey");
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
    $text = $json->responses[0]->fullTextAnnotation->text;
} catch (Exception $e) {
    $text = "error";
}

?>

<textarea required id="prayer" name="prayer" rows="6" rows="6"><?= $text ?></textarea>