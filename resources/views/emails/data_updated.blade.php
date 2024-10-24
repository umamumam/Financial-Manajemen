<!DOCTYPE html>
<html>
<head>
    <title>Data Diperbarui</title>
</head>
<body>
    <h1>Data Diperbarui</h1>
    <h2>Data Sebelumnya:</h2>
    <ul>
        <li>Kategori: {{ $oldData['kategori_id'] }}</li>
        <li>Jumlah: {{ $oldData['jumlah'] }}</li>
        <li>Tanggal: {{ $oldData['tanggal'] }}</li>
        <li>Deskripsi: {{ $oldData['deskripsi'] }}</li>
    </ul>

    <h2>Data Baru:</h2>
    <ul>
        <li>Kategori: {{ $newData['kategori_id'] }}</li>
        <li>Jumlah: {{ $newData['jumlah'] }}</li>
        <li>Tanggal: {{ $newData['tanggal'] }}</li>
        <li>Deskripsi: {{ $newData['deskripsi'] }}</li>
    </ul>
</body>
</html>
