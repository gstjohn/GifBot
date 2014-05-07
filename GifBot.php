<?php

// Get request
$trigger = $_POST['trigger_word'];
$search  = trim(substr($_POST['text'], strlen($trigger) + 1));

if ($search == '') {
    echo 'OK';
    exit;
}

// Query Giphy - http://giphy.com/
$limit    = 25;
$response = file_get_contents('http://api.giphy.com/v1/gifs/search?q=' . urlencode($search) . '&api_key=dc6zaTOxFJmzC&limit=' . $limit . '&offset=0');
$response = json_decode($response);

// Pick a random GIF
$gifs  = $response->data;
$count = count($gifs);
$image = $gifs[rand(0, $count - 1)]->images->original;

// Respond with GIF
header('Content-Type: application/json');
echo json_encode(array(
    'text' => $image->url
));