<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Lelang</title>
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
    <h3 style="text-align: center; margin-bottom: 20px;">Kuitansi Lelang</h3>
    <p>Terima kasih atas transaksi yang Anda lakukan. Berikut adalah detail kuitansi Anda:</p>
    <table>
        <tr>
            <td>Nama</td>
            <td>{{ $details['data']->nama_pembeli }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{ $details['data']->alamat_pembeli }}</td>
        </tr>
        <tr>
            <td>Kuitansi</td>
            <td>{{ $details['data']->risalahLelang->no_risalah }}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td>Rp. {{ number_format($details['data']->pokok_lelang + $details['data']->bea_lelang, 0, ',', '.') }}</td>
        </tr>
    </table>
    <p style="margin-top: 20px;">Terima kasih telah menggunakan layanan kami. Jika Anda memiliki pertanyaan atau masalah, jangan ragu untuk menghubungi kami.</p>
    <p>Salam hormat,</p>
    <p>Pejabat Lelang</p>
</body>
</html>