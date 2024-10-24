{{-- <!DOCTYPE html>
<html>
<head>
    <title>Test Email</title>
</head>
<body>
    <h1>Ini adalah email test dari Laravel!</h1>
    <p>Jika Anda menerima email ini, berarti konfigurasi email Anda sudah benar.</p>
</body>
</html> --}}
<!DOCTYPE html>
<html>
<head>
    <title>Test Email</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>
</body>
</html>