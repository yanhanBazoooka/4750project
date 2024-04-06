<!DOCTYPE html>
<html>
<head>
    <title>Google Sign-In Demo</title>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="xxx">
</head>
<body>
<div class="g-signin2" data-onsuccess="onSignIn"></div>

<script>
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();

        // You can now send this profile information to your server to create a session, etc.
        console.log("ID: " + profile.getId());
        console.log("Name: " + profile.getName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // Redirect the user to the main page or perform other actions
        window.location.href = 'stats.php';
    }
</script>
</body>
</html>
