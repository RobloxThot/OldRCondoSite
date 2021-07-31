<?php
//I wouldn't use this thing unless you know how to send requests
//And I will not help you unless it's for Python.

header('Content-type: text/plain');
$changeKey = "RobloxBitch445";

#region Discord error posts
function exceptions_error_handler($message) {
    die($message);
}
#endregion

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_SERVER['HTTP_KEY'] == $changeKey){
            if ((json_decode(file_get_contents('php://input')) != NULL) ? true : false){
                $jsonFile = fopen("gameIds.json", "w") or die("Unable to open file!");
                fwrite($jsonFile, file_get_contents('php://input'));
                fclose($jsonFile);
                die("JSON has been updated!");
            }else{die("Invalid JSON");}
        } else {die("Wrong key!");}
    } else {
        //Scare kids who go here somehow
        echo ("Wow your fucking dumb thanks for your IP: {$_SERVER['HTTP_X_FORWARDED_FOR']}\n");
        die("     .-\"\"\"\"\"\"-.\n   .'          '.\n  /   O    -=-   \\\n :                :\n |                |\n : ',          ,' :\n  \  '-......-'  /\n   '.          .'\n     '-......-'");
    }
} catch (Error $e) {
    exceptions_error_handler("Updating game's JSON file failed");
}
?>
