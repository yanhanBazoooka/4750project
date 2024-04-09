<!DOCTYPE html>
<html>
<head>
    <title>Google Sign-In Demo</title>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="890124439981-efpmk1iiv3b3h4abvfits56h1r3lukjm.apps.googleusercontent.com">
</head>
<body>
<div class="g-signin2" data-onsuccess="onSignIn"></div>

<script>
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();

        console.log("ID: " + profile.getId());
        console.log("Name: " + profile.getName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        window.location.href = 'stats.php';
    }
</script>
</body>
</html>
