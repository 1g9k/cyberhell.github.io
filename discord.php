<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetUsername = $_POST['username'];
    $discordURL = 'https://discord.com/api/v9/unique-username/username-attempt-unauthed';
    $postData = json_encode(array("username" => $targetUsername));
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $postData
        )
    );
    $context = stream_context_create($options);
    $response = file_get_contents($discordURL, false, $context);

    if ($response !== false) {
        $responseData = json_decode($response, true);
        if (isset($responseData['taken']) && $responseData['taken'] === true) {
            echo "taken";
        } elseif (isset($responseData['taken']) && $responseData['taken'] === false) {
            echo "available";
        } else {
            echo "An error occurred while checking the username availability.";
        }
    } else {
        echo "Failed to check the username availability.";
    }
}
?>
