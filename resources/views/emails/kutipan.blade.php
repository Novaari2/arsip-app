<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kutipan Lelang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }
        p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h3 style="text-align: center; margin-bottom: 20px;">Kutipan Lelang</h3>
    <p>Berikut adalah detail kutipan lelang Anda:</p>
    <table>
        <tr>
            <td>Nama</td>
            <td>{{ $details['data']->risalahLelang->nama_pemohon }}</td>
        </tr>
        <tr>
            <td>Nomor Surat Permohonan</td>
            <td>{{ $details['data']->risalahLelang->no_permohonan }}</td>
        </tr>
        <tr>
            <td>Nomor Surat Penetapan</td>
            <td>{{ $details['data']->risalahLelang->no_risalah }}</td>
        </tr>
        <tr>
            <td>Tempat Lelang</td>
            <td>{{ $details['data']->risalahLelang->tempat_lelang }}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td>Rp. {{ number_format($details['data']->pokok_lelang, 0, ',', '.') }}</td>
        </tr>
    </table>
    <p style="margin-top: 20px;">Terima kasih telah menggunakan layanan kami. Jika Anda memiliki pertanyaan atau masalah, jangan ragu untuk menghubungi kami.</p>
    <p>Salam hormat,</p>
    <p>Pejabat Lelang</p>
</body>
</html>