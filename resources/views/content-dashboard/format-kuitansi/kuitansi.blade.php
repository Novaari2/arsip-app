<page backtop="10mm" backbottom="10mm" backleft="7mm" backright="7mm">
    <page_header>
        {{-- <table style="width: 100%;"> --}}
            {{-- <tr> --}}
                {{-- <td style="width: 90px;"> --}}
                    {{-- <img src="assets/images/logo-kuitansi.png" alt="Logo" style="width: 90px;"> --}}
                {{-- </td> --}}
                {{-- <td style="width: 100px; hight: 100px; background-color: red">LOGO</td> --}}
                {{-- <td> --}}
                    <p style="text-align: center;">
                        <span style="font-weight: bold">KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</span><br>
                        DIREKTORAT JENDERAL KEKAYAAN NEGARA <br>
                        KANTOR WILAYAH DJKN KALIMANTAN SELATAN DAN TENGAH <br>
                        <span style="font-weight: bold">KANTOR PELAYANAN KEKAYAAN NEGARA DAN LELANG</span> <br>
                        <span style="font-weight: bold">BANJARMASIN</span> <br>
                        <span style="font-size: 8px">
                            JALAN PRAMUKA NO. 7, BANJARMASIN 70249 <br>
                            TELEPON(0511) 4281286,FAKSIMILE(0511) 428126, SITUS: www.djkn.kemenkeu.go.id
                        </span>
                    </p>
                {{-- </td> --}}
            {{-- </tr> --}}
        {{-- </table> --}}
        <hr style="border: 0.5px solid black">
    </page_header>
    <page_footer>
    </page_footer>
    <table style="margin-top: 120; margin-left: 300">
        <tr>
            <td>
                <u style="font-size: 20px; font-weight: bold">KUITANSI</u>
            </td>
        </tr>
        <tr>
            <td>
                Nomor: : /RL.320/58/{{ date('Y', strtotime($data->risalahLelang->tgl_lelang)) }}
            </td>
        </tr>
    </table>
    <table style="margin: 50 0 0 20;">
        <tr>
            <td style="font-size: 15px;">Tanggal Lelang</td>
            <td>:</td>
            <td>{{ date('d M Y', strtotime($data->risalahLelang->tgl_lelang)) }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Sudah Terima Dari</td>
            <td>:</td>
            <td>{{ $data->nama_pembeli }}, alamat {{ $data->alamat_pembeli }} Nomor KTP NIK. {{ $data->no_ktp }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Banyaknya Uang</td>
            <td>:</td>
            <td>Rp. {{ number_format($data->pokok_lelang + $data->bea_lelang, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Keterangan</td>
            <td>:</td>
            <td style="width: 300; text-align: justify">Pelunasan Kewajiban Pembayaran Lelang {{ $jenis_lelang->nama }} atas permohonan lelang {{ $data->risalahLelang->nama_pemohon }}, berupa {{ $data->uraian_barang }}, Nomor Lot {{ $data->no_lot_barang }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Pejabat lelang</td>
            <td>:</td>
            <td>{{ $pejabat->nama }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Pokok Lelang</td>
            <td>:</td>
            <td>Rp. {{ number_format($data->pokok_lelang, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Bea Lelang(2%)</td>
            <td>:</td>
            <td>Rp. {{ number_format($data->bea_pembeli, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>
            </td>
            <td></td>
            <td>_______________(+)</td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Jumlah</td>
            <td>:</td>
            <td>Rp. {{ number_format($data->pokok_lelang + $data->bea_pembeli, 0, ',', '.') }}</td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 100">
        <tr>
            <td style="width: 50%">Mengetahui,<br /> Atasan Langsung Bendahara Penerimaan <br /> Kepala Seksi Hukum dan Informasi</td>
            <td style="width: 50%;">Banjarmasin, {{ date('d M Y') }} <br /> Bendahara Penerimaan</td>
        </tr>
    </table>
    <table style="margin-top: 100; width: 100%">
        <tr>
            <td style="width: 50%">{{ $input['kepala_kantor'] }}</td>
            <td style="width: 50%;">{{ $input['saksi_1'] }}</td>
        </tr>
    </table>
    <table style="margin-top: 150;">
        <tr>
            <td>Keterangan</td>
        </tr>
        <tr>
            <td>Dibuat rangkap 3, antara lain:</td>
        </tr>
        <tr>
            <td>	Lembar Kesatu	: Asli (Putih) untuk Pembeli;</td>
        </tr>
        <tr>
            <td>	Lembar Kedua	: kuning untuk Bendahara Penerimaan;</td>
        </tr>
        <tr>
            <td>	Lembar Ketiga	: hijau untuk Pejabat Lelang Kelas I;</td>
        </tr>
    </table>
</page>
