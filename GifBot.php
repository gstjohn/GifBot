<?php

// This is the Giphy API key for public beta access
// It will work up to a certain rate limit.
// See: https://github.com/giphy/GiphyAPI#access-and-api-keys
define('GIPHY_API_KEY', 'dc6zaTOxFJmzC');

// maximum number to retrieve
$limit = 25;
// the number of images to return
// can be overridden by gifbomb count
$num = 1;

// Get request
$trigger = $_POST['trigger_word']; // currently gif or gifbomb
$text = $_POST['text'];

// multiple images, or just a one-off?
if ($trigger == 'gifbomb') {
    $regex = '/^' . $trigger . ' (\d+) (.+)$/';
    $results = preg_match($regex, $text, $matches);
    $num = $matches[1];
    $search = $matches[2];
} else {
    $regex = '/^' . $trigger . ' (.+)$/';
    $results = preg_match($regex, $text, $matches);
    $search = $matches[1];
}

// fail if search string is empty
if ($search == '') {
    echo 'OK';
    exit;
}

// Query Giphy, parse data
$response = file_get_contents('http://api.giphy.com/v1/gifs/search?q=' .
            urlencode($search) . '&api_key=' . GIPHY_API_KEY . '&limit=' . $limit . '&offset=0');
$response = json_decode($response);
$gifs  = $response->data;
$count = count($gifs);

// prepare response
$response_data = array();
// make sure we have an image
if ($count) {
    // get random `$num` keys from response
    $keys = array_rand($gifs, $num);
    // array_rand returns the rancom index if `$num` is 1
    // else it returns an array of indexes if `$num` is greater than 1
    if (is_array($keys)) {
        // loop over the random keys, append image data to `$response_data`
        for ($i=1; $i<=count($keys); $i++) {
            $response_data[] = $gifs[$i]->images->original->url;
        }
    } else {
        // just a single key
        $response_data[] = $gifs[$keys]->images->original->url;
    }
} else {
    $response_data[] = 'No image found for `' . $search . '`';
}

// Respond
header('Content-Type: application/json');
echo json_encode(array(
    'text' => implode($response_data, ' ')
));

?>