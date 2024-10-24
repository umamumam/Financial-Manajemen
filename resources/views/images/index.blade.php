<!-- resources/views/images/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gambar</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Jika menggunakan Bootstrap -->
</head>
<body>

    <div class="container">
        <h1>Daftar Gambar</h1>
        <div class="row">
            @foreach ($images as $image)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('storage/' . $image->filename) }}" class="card-img-top" alt="Gambar">
                        <div class="card-body">
                            <h5 class="card-title">Gambar {{ $loop->iteration }}</h5>
                            <p class="card-text">Deskripsi gambar atau informasi lainnya.</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
