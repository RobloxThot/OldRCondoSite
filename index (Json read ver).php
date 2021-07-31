<?php
//Needed varibles

//you need to put a roblox cookie here blame roblox
$cookie = "_|WARNING:-DO-NOT-SHARE-THIS...";
$websiteName = "Condos";
$discordInvite = "https://discord.gg/";

#region Discord out of games and error webhook
function postToDiscord($message,$name,$avatarUrl){
    $json_data = json_encode(["content" => $message, "username" => $name, "avatar_url" => $avatarUrl], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    $ch = curl_init( "https://discord.com/api/webhooks/0/na" );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec( $ch );
    curl_close( $ch );
}
#endregion


try {
    $strJsonFileContents = file_get_contents("gameIds.json");
    $array = json_decode($strJsonFileContents, true);
    $gameIds = $array["gameIds"];
    shuffle($gameIds);
    $bannedCount = 0; //set count to 0 to beable to count bans later 
    $gameAmountCount = count($gameIds); //Get the ammount of games in list
} catch (Error $e) {
    exceptions_error_handler("Game id error ");
}

function sendCsrfRequest(){ //Send a request to get the CSRF token from roblox
    $csrfUrl = "https://auth.roblox.com/v2/login";

    function grabCsrfToken( $curl, $header_line ) { //Filter through the Roblox headers
        if(strpos($header_line, "x-csrf-token") !== false){
            global $csrf;
            $csrf = ltrim($header_line, "x-csrf-token: "); // set x-csrf-token var
        }
        return strlen($header_line);
    }

    $csrfCurl = curl_init();
    curl_setopt($csrfCurl, CURLOPT_URL, $csrfUrl);
    curl_setopt($csrfCurl, CURLOPT_POST, true);
    curl_setopt($csrfCurl, CURLOPT_HEADERFUNCTION, "grabCsrfToken");
    curl_setopt($csrfCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($csrfCurl,CURLOPT_RETURNTRANSFER,1);

    curl_exec($csrfCurl);
    curl_close($csrfCurl);
}

function checkGame($placeId){ //Finds what game works
    global $csrf, $cookie, $isPlayable;
    $gameUrl = "https://games.roblox.com/v1/games/multiget-place-details?placeIds=$placeId";

    $gameCurl = curl_init();
    curl_setopt($gameCurl, CURLOPT_URL, $gameUrl);

    $headers = array("X-CSRF-TOKEN: ".$csrf);
    curl_setopt($gameCurl, CURLOPT_COOKIE, '.ROBLOSECURITY='.$cookie);
    curl_setopt($gameCurl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($gameCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($gameCurl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($gameCurl, CURLOPT_RETURNTRANSFER,1);

    $resp = curl_exec($gameCurl);
    curl_close($gameCurl);
    $data = json_decode($resp);
    return $data[0]->isPlayable; //Get if you can play or not
}

try {
    sendCsrfRequest();
} catch (Error $e) {
    exceptions_error_handler($e);
}

?>
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'/>
		<title>
                <?php echo($pageName); ?>
		</title>
        <script async src="https://arc.io/widget.min.js#8c7d1Dmf"></script>
	    <style>
	    	@import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');
	    	@import url('https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');

	    	@keyframes glowing {
	    		0% {
                    filter: drop-shadow(0 0 0.25rem red);
	    		}
	    		50% {
                    filter: drop-shadow(0 0 0.50rem green);
	    		}
	    		100% {
                    filter: drop-shadow(0 0 0.25rem red);
	    		}
	    	}

	    	body {
    			background: url("https://www.teahub.io/photos/full/11-111196_gif-wallpaper.gif") no-repeat center center fixed; 
				background-repeat: no-repeat;
				background-position: bottom;
				background-size: cover;

				height: 100vh;
				width: 100%;

	    		font-family: 'Montserrat', sans-serif;
	    		min-height: 80vh;
	    		display: -webkit-box;
	    		display: flex;
	    		align-items: center;
	    		justify-content: center;
	    		flex-direction: column;
	    	}

	    	h1 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-weight: bold;
                filter: drop-shadow(0 0 0);
	    		animation: glowing 3500ms infinite;
	    	}

	    	h2 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-size: 350%;
	    	}

	    	h3 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-size: 150%;
	    	}
	    </style>

        <script>
            function fadeInPage() {
                for (let i = 1; i < 100; i++) {
                    fadeIn(i * 0.01);
                }
            
                function fadeIn(i) {
                    setTimeout(function() {
                        document.body.style.opacity = i;
                    }, 2000 * i);
                }
            }
        </script>
        <meta name="description" content="List of Condos made by Roblox thot for 𝕮𝖆$𝖍𝖒𝖔𝖓𝖊𝖞 𝕮𝖔𝖓$">

        <!-- Google / Search Engine Tags -->
        <meta name="theme-color" content="#85bb65">
        <meta itemprop="name" content="𝕮𝖆$𝖍𝖒𝖔𝖓𝖊𝖞 𝕮𝖔𝖓$">
        <meta itemprop="description" content="List of Condos made by Roblox thot for 𝕮𝖆$𝖍𝖒𝖔𝖓𝖊𝖞 𝕮𝖔𝖓$">
        <meta itemprop="image" content="https://cdn.discordapp.com/icons/693618792005369867/a_e7961a8108b529cbabfd81aeab66da57.gif?size=4096">

        <!-- Facebook Meta Tags -->
        <meta property="og:url" content="http://cashmoney-con.tk">
        <meta property="og:type" content="website">
        <meta property="og:title" content="𝕮𝖆$𝖍𝖒𝖔𝖓𝖊𝖞 𝕮𝖔𝖓$">
        <meta property="og:description" content="List of Condos made by Roblox thot for 𝕮𝖆$𝖍𝖒𝖔𝖓𝖊𝖞 𝕮𝖔𝖓$">
        <meta property="og:image" content="https://cdn.discordapp.com/icons/693618792005369867/a_e7961a8108b529cbabfd81aeab66da57.gif?size=4096">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="𝕮𝖆$𝖍𝖒𝖔𝖓𝖊𝖞 𝕮𝖔𝖓$">
        <meta name="twitter:description" content="List of Condos made by Roblox thot for 𝕮𝖆$𝖍𝖒𝖔𝖓𝖊𝖞 𝕮𝖔𝖓$">
        <meta name="twitter:image" content="https://cdn.discordapp.com/icons/693618792005369867/a_e7961a8108b529cbabfd81aeab66da57.gif?size=4096">
		<link rel='icon' type='image/gif' href='https://cdn.discordapp.com/icons/693618792005369867/a_e7961a8108b529cbabfd81aeab66da57.gif?size=4096'>
	</head>

	<body style="opacity:0" onload='fadeInPage()'>
		<h1 class="text-light">
                <?php echo($pageName); ?>
		</h1>
        <div class="btn-group mt-2 mb-4" role="group" aria-label="actionButtons">
			<a href="<?php echo($discordInvite); ?>" class="d-block btn btn-outline-light">
				Join the Discord
			</a>
		</div>
        <a>
            <?php
                try {
                    foreach ($gameIds as $gameId) {
                        echo "<h3 class=\"text-light\">";
                        $isPlayable = checkGame($gameId);
                        echo "<b>$gameId:</b> ";
                        if ($isPlayable){
                            echo "<a style=\"color: #dcdcdc\" href=\"https://www.roblox.com/games/$gameId\"><u>Click for game</u></a>";
                        }else{
                            echo "Game banned";
                            $bannedCount += 1;
                        }
                        echo "{$bannedCount}/{$gameAmountCount}<br></h3>";
                    }
                } catch (Error $e) {
                    exceptions_error_handler($e);
                }
                if($bannedCount == $gameAmountCount){
                    if ($array["hasPinged"] == false){
                        $array["hasPinged"] = true;
                        $newJsonString = json_encode($array);
                        file_put_contents('gameIds.json', $newJsonString);
                        postToDiscord("All {$gameAmountCount} game(s) are banned on the [site](https://cashmoney-con.tk/)!", "Game ID banned!","https://static3.depositphotos.com/1001097/123/i/600/depositphotos_1238353-stock-photo-forbidden-sign.jpg");
                    }
                }
            ?>
		</a>
    </body>
</html>