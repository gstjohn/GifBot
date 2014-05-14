<?php

// This is the Giphy API key for public beta access
// It will work up to a certain rate limit.
// See: https://github.com/giphy/GiphyAPI#access-and-api-keys
define('GIPHY_API_KEY', 'dc6zaTOxFJmzC');

// maximum number to retrieve,
// can be overridden by gifbomb count
$limit = 25;
$count = 0;

// Get request
$trigger = $_GET['trigger_word']; // gif or gifbomb
$text = $_GET['text'];

// single use, or return multiples?
if ($trigger == 'gif') {
    $regex = '/^' . $trigger . ' (.+)$/';
    $results = preg_match($regex, $text, $matches);
    $search = $matches[1];
} else if ($trigger == 'gifbomb') {
    $regex = '/^' . $trigger . ' (\d+) (.+)$/';
    $results = preg_match($regex, $text, $matches);
    $count = $matches[1];
    $search = $matches[2];
}


echo $search . '<br /><br />';
echo $count . '<br /><br />';
// print_r($matches);


// fail if search string is empty
if ($search == '') {
    echo 'OK';
    exit;
}

// Query Giphy - http://giphy.com/
$response = file_get_contents('http://api.giphy.com/v1/gifs/search?q=' .
            urlencode($search) . '&api_key=' . GIPHY_API_KEY . '&limit=' . $limit . '&offset=0');
$response = json_decode($response);

// Pick a random GIF
$gifs  = $response->data;
$count = count($gifs);

// make sure we have an image
if ($count) {
    $image = $gifs[rand(0, $count - 1)]->images->original;
    $response = $image->url;
} else {
    $response = 'No image found for `' . $search . '`';
}

// Respond
header('Content-Type: application/json');
echo json_encode(array(
    'text' => $response
));

?>