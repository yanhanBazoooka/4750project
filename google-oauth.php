<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Database connection
$db = new PDO('mysql:host=localhost;dbname=league_tracker', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Google OAuth configuration
$google_oauth_client_id = '913443120825-98egbqh0vrsgc7510l6te6ouv50lb9sl.apps.googleusercontent.com';
$google_oauth_client_secret = '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';
$google_oauth_redirect_uri = 'https://localhost/4750project/google-oauth.php';
$google_oauth_version = 'v3';

if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Exchange code for access token
    $params = [
        'code' => $_GET['code'],
        'client_id' => $google_oauth_client_id,
        'client_secret' => $google_oauth_client_secret,
        'redirect_uri' => $google_oauth_redirect_uri,
        'grant_type' => 'authorization_code'
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);

    if (isset($response['access_token'])) {
        // Fetch user profile
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/' . $google_oauth_version . '/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);
        $profile = json_decode($response, true);

        if (isset($profile['email'])) {
            $email = $profile['email'];

            // Check if user exists and get their role, or create new user
            $stmt = $db->prepare("SELECT id, role_id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role_id'];
            } else {
                // Insert new user with default role (e.g., role_id 1 for regular users)
                $stmt = $db->prepare("INSERT INTO users (email, role_id) VALUES (?, 1)");
                $stmt->execute([$email]);
                $_SESSION['user_id'] = $db->lastInsertId();
                $_SESSION['user_role'] = 1;  // Default role
            }

            // Set additional session information
            $_SESSION['google_loggedin'] = true;
            $_SESSION['google_email'] = $email;

            // Redirect based on role
            header('Location: stats.php'); // Redirect to a stats page or wherever appropriate
            exit;
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    // Redirect to Google for authentication
    $params = [
        'response_type' => 'code',
        'client_id' => $google_oauth_client_id,
        'redirect_uri' => $google_oauth_redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    exit;
}
?>
