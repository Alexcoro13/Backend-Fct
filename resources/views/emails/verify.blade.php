<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
    <h1>Hello, {{ $user }}</h1>
    <p>Thank you for registering. Please verify your email address by clicking the following link:</p>
    <a href="{{ $url }}">Verify my email</a>
    <p>If you didn't create this account, you can ignore this message.</p>
</body>
</html>
