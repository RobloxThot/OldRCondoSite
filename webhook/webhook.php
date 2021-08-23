<?php
$chatlogWebhook = "https://discord.com/api/webhooks/0/logger";
$logSpammersIp = "https://discord.com/api/webhooks/0/iplogger";

function realRobloxRQ() {
    $postData = json_decode(file_get_contents('php://input'), true);
    $ciphertext = $postData['url'];
    $chat = $postData['chat'];
    $name = $postData['name'];
    $hexColor = $postData['hex'];

    function getUserID($userName) {
        $url = "https://api.roblox.com/users/get-by-username?username={$userName}";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        $resp = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($resp);
        return $data->{"Id"}; //Get if you can play or not
    }
    $userID = getUserID($name);

    //=======================================================================================================
    // Create new webhook in your Discord channel settings and copy&paste URL
    //=======================================================================================================

    $webhookurl = $chatlogWebhook;

    //=======================================================================================================
    // Compose message. You can use Markdown
    // Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
    //========================================================================================================

    $timestamp = date("c", strtotime("now"));

    $json_data = json_encode([

        // Username
        "username" => "{$name}:{$userID}",

        // Avatar URL.
        "avatar_url" => "https://www.roblox.com/headshot-thumbnail/image?userId={$userID}&width=420&height=420&format=png",
        // Embeds Array
        "embeds" => [
            [
                // Embed Title
                //"title" => "Username: ". $name,

                // Embed Type
                "type" => "rich",

                // Embed Description
                //"description" => "Click the link below.",

                // URL of title link
                "url" => "https://v3rmillion.net/member.php?action=profile&uid=1385488",

                // Timestamp of embed must be formatted as ISO8601
                "timestamp" => $timestamp,

                // Embed left border color in HEX
                "color" => hexdec( $hexColor ),

                // Additional Fields array
                "fields" => [
                    // Field 1
                    [
                        "name" => "Chat message:",
                        "value" => "". $chat,
                        "inline" => true
                    ]
                ]
            ]
        ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


    $ch = curl_init( $webhookurl );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec( $ch );
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
    // echo $response;
    //echo $httpcode;
    curl_close( $ch );

    if ($httpcode == 204) {
      echo "\nWebhook sent :)\n";
    } else {
      echo "\nWebhook may have not been sent";
      echo "\nPlease dm me on discord";
      echo "\nMy tag is \"Roblox Thot#0001\"";
      echo "\n";
    }
}


function fakeRobloxRQ() {

    //=======================================================================================================
    // Create new webhook in your Discord channel settings and copy&paste URL
    //=======================================================================================================

    $webhookurl = $logSpammersIp

    //=======================================================================================================
    // Compose message. You can use Markdown
    // Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
    //========================================================================================================

    $timestamp = date("c", strtotime("now"));

    $json_data = json_encode([

        // Username
        "username" => "Spammer",

        // Embeds Array
        "embeds" => [
            [
                // Embed Title
                //"title" => "Username: ". $name,

                // Embed Type
                "type" => "rich",

                // Timestamp of embed must be formatted as ISO8601
                "timestamp" => $timestamp,

                // Embed left border color in HEX
                "color" => hexdec( $hexColor ),

                // Additional Fields array
                "fields" => [
                    // Field 1
                    [
                        "name" => "IP of dumb ass:",
                        "value" => $_SERVER['REMOTE_ADDR'],
                        "inline" => true
                    ]
                ]
            ]
        ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


    $ch = curl_init( $webhookurl );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec( $ch );
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
    // echo $response;
    //echo $httpcode;
    curl_close( $ch );

    if ($httpcode == 204) {
      echo "\nWebhook sent :)\n";
    } else {
      echo "\nWebhook may have not been sent";
      echo "\nPlease dm me on discord";
      echo "\nMy tag is \"Roblox Thot#0001\"";
      echo "\n";
    }
}

function CheckUser($header){
    $arr = array('roblox', 'Roblox');
    foreach ($arr as &$value) {
        if (strpos($header, $value) !== false){
            return true;
        }
    }
    return false;
}

function GiveFile($file){
    echo file_get_contents($file);
}

if (CheckUser($_SERVER['HTTP_USER_AGENT'])){
    #What Roblox will see
    realRobloxRQ();
}else{
    #What some one going to the page will get
    fakeRobloxRQ();
    header('Location: https://www.youtube.com/watch?v=7SCIckO3fTY');
}