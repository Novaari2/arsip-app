<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <p style="text-align: center; font-size: 15px; margin-top: 50;">
            KUTIPAN RISALAH LELANG<br>
            DIREKTORAT JENDERAL KEKAYAAN NEGARA<br>
            KANWIL DJKN KALIMANTAN SELATAN DAN TENGAH<br>
            KPKNL BANJARMASIN<br>
        </p>
        <p style="text-align: center; font-size: 12px; margin-top: 10;">
            KUTIPAN RISALAH LELANG<br>
            NOMOR: {{ $data->risalahLelang->no_risalah }}
        </p>
    </page_header>
    <page_footer>
    </page_footer>
    <table style="margin-left: 20pt; margin-top: 150;">
        <tr>
            <td>Pada Hari ini, Selasa,</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ date('j F Y', strtotime($data->risalahLelang->tgl_lelang)) }}</td>
        </tr>
        <tr>
            <td>Pukul</td>
            <td>:</td>
            <td>{{ date('h:i', strtotime($data->risalahLelang->created_at)) }}</td>
        </tr>
        <tr>
            <td>Tempat Lelang</td>
            <td>:</td>
            <td>{{ $data->risalahLelang->tempat_lelang }}</td>
        </tr>
        <tr>
            <td>Oleh saya, pejabat Lelang</td>
            <td>:</td>
            <td>{{ $pejabat->nama }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $pejabat->nip }}</td>
        </tr>
        <tr>
            <td>Nomor SK Pengangkatan</td>
            <td>:</td>
            <td>{{ $pejabat->sk_pengangkatan }}</td>
        </tr>
        <tr>
            <td>Nomor Surat Tugas</td>
            <td>:</td>
        </tr>
        <tr>
            <td>Dilakukan penjualan lelang atas permohonan,</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->risalahLelang->nama_pemohon }}</td>
        </tr>
        <tr>
            <td>Nomor Surat Permohonan</td>
            <td>:</td>
            <td>{{ $data->risalahLelang->no_permohonan }}</td>
        </tr>
        <tr>
            <td>Nomor Surat Penetapan</td>
            <td>:</td>
            <td>{{ $data->risalahLelang->no_penetapan }}</td>
        </tr>
        <tr>
            <td>Jenis Lelang</td>
            <td>:</td>
            <td>{{ $jenis_lelang->nama }}</td>
        </tr>
        <tr>
            <td>Nama Pejabat Penjual</td>
            <td>:</td>
            <td>{{ $data->risalahLelang->nama_penjual ?? '-' }}</td>
        </tr>
        <tr>
            <td>Surat Penunjukan Penjual</td>
            <td>:</td>
        </tr>
        <tr>
            <td>Objek Lelang yang Terjual</td>
        </tr>
        <tr>
            <td>Uraian</td>
            <td>:</td>
            <td>{{ $data->uraian_barang }}</td>
        </tr>
        <tr>
            <td>Nama Pembeli</td>
            <td>:</td>
            <td>{{ $data->nama_pembeli }}</td>
        </tr>
        <tr>
            <td>Nomor KTP/SIM/Paspor</td>
            <td>:</td>
            <td>{{ $data->no_ktp }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat_pembeli }}</td>
        </tr>
        <tr>
            <td>Harga Pembelian</td>
            <td>:</td>
            <td>{{ $data->pokok_lelang }}</td>
        </tr>
        <tr>
            <td>Catatan</td>
            <td>:</td>
            <td>{!! $input['catatan'] !!}</td>
        </tr>
    </table>
    <table style="margin-top: 30; width: 100%">
        <tr>
            <td style="width: 33%; text-align: left">Penjual</td>
            <td style="width: 33%; text-align: center">Pembeli</td>
            <td style="width: 33%; text-align: right">Pejabat Lelang</td>
        </tr>
        <tr>
            <td style="text-align: left">Ttd</td>
            <td style="text-align: center">Ttd</td>
            <td style="text-align: right">Ttd</td>
        </tr>
    </table>
    <table style="margin-top: 70; width: 100%">
        <tr>
            <td style="width: 33%; text-align: left">{{ $data->risalahLelang->nama_penjual ?? '' }}</td>
            <td style="width: 33%; text-align: center">{{ $data->nama_pembeli ?? '' }}</td>
            <td style="width: 33%; text-align: right">{{ $pejabat->nama ?? '' }} <br> NIP {{ $pejabat->nip ?? '' }}</td>
        </tr>
    </table>
    <table style="margin-top: 80; width: 100%">
        <tr>
            <td style="width: 33%; text-align: left">Saksi II</td>
            <td style="width: 33%; text-align: center">Saksi I</td>
            <td style="width: 33%;">sebagai Akta Jual Beli Banjarmasin, 20 Januari 2024</td>
        </tr>
        <tr>
            <td style="text-align: left">Ttd</td>
            <td style="text-align: center">Ttd</td>
            <td>Kepala Kantor</td>
        </tr>
    </table>
    <table style="margin-top: 70; width: 100%">
        <tr>
            <td style="width: 33%; text-align: left">{{ $input['saksi_2'] }}</td>
            <td style="width: 33%; text-align: center">{{ $input['saksi_1'] }}</td>
            <td style="width: 33%">{{ $input['kepala_kantor'] }}</td>
        </tr>
    </table>
</page>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <p style="text-align: center; font-size: 20px; margin-top: 70;">SYARAT DAN KETENTUAN LELANG</p>
    </page_header>
    <table style="margin-top: 70; width: 100%">
        <tr>
            <td style="width: 50%">
                <p style="text-align: justify; font-size: 10px; padding-right: 5px">
                    ------Penjualan lelang ini dilakukan menurut Undang-Undang Lelang (Vendu Reglement,  Ordonantie  28  Pebruari 1908 Staatsblad 1908:189 sebagaimana telah beberapa kali diubah terakhir dengan Staatsblad 1941:3) jis. Peraturan Menteri Keuangan dan Peraturan Direktur Jenderal Kekayaan Negara terkait Lelang. ---------------------------------Peserta Lelang dapat mengajukan penawaran dalam lelang ini setelah menunjukkan identitas diri dan menyetorkan uang jaminan penawaran lelang/ menyerahkan garansi bank jaminan penawaran lelang sesuai Pengumuman Lelang, dengan ketentuan:----------------------------Dalam hal Jaminan Penawaran Lelang berupa uang, berlaku ketentuan sebagai berikut:------------------------------------------------------------<br>
                    1. Uang Jaminan dari Peserta Lelang yang disahkan sebagai Pembeli akan diperhitungkan dengan pelunasan kewajiban pembayaran lelang;---------------------------------------------------------------------<br>
                    2. Uang Jaminan dari Peserta Lelang yang tidak disahkan sebagai Pembeli akan dikembalikan seluruhnya tanpa potongan apapun, di luar mekanisme perbankan;------------------------------------------------------<br>
                    3. Uang Jaminan akan disetorkan ke Kas Negara sebagai Penerimaan Negara Bukan Pajak yang berlaku pada Kementerian Keuangan, jika Pembeli tidak melunasi kewajiban pembayaran lelang sesuai ketentuan.--------------------------------------------<br>
                    -----Dalam hal penawaran lelang dilakukan tanpa kehadiran melalui internet, maka:------------------------------------------------------------------------<br>
                    1.Penawaran lelang dilakukan secara tertutup atau terbuka dengan menggunakan aplikasi lelang melalui internet.--------------------------<br>
                    2.Peserta Lelang yang mengajukan penawaran, telah menyetujui Syarat dan Ketentuan Pelaksanaan Lelang Dengan Penawaran Melalui Internet yang tercantum dalam aplikasi lelang melalui internet.------------------------------------------------------------------------<br>
                    3.Ketentuan dan syarat yang ditetapkan dalam penawaran lelang mengikat bagi Peserta Lelang yang mengajukan penawaran.-------<br>
                    -----Dalam hal terdapat beberapa Peserta Lelang yang mengajukan penawaran tertinggi dengan nilai yang sama melalui internet, melalui email, dan/atau melalui tromol pos, Pejabat Lelang mengesahkan Peserta Lelang yang penawarannya diterima lebih dulu sebagai Pembeli.<br>-----------------------------------------------------------------------------------------Dalam hal dilakukan penawaran secara bersamaan, dan terdapat penawaran tertinggi dengan nilai yang sama antara Peserta Lelang yang mengajukan penawaran melalui internet cara tertutup (closed bidding), melalui email, dan/atau melalui tromol pos dengan Peserta Lelang yang mengajukan penawaran secara tertulis dengan kehadiran, Pejabat Lelang berhak mengesahkan Pembeli dengan cara melakukan pengundian di antara Peserta Lelang yang mengajukan penawaran tertinggi yang sama tersebut.-------------------------------------------------------------Dalam hal terjadi gangguan teknis dalam pelaksanaan lelang tanpa kehadiran melalui internet cara tertutup (closed bidding) berlaku ketentuan sebagai berikut:<br>
                    1. Apabila gangguan teknis terjadi sebelum lelang dimulai yang mengakibatkan aplikasi lelang melalui internet tidak dapat beroperasi hingga berakhir jam kerja pada hari pelaksaan lelang, maka lelang dibatalkan oleh Pejabat Lelang.-----------------------------<br>
                    2. Apabila gangguan teknis terjadi setelah lelang dimulai dan aplikasi lelang melalui internet beroperasi kembali sebelum jam kerja berakhir pada hari pelaksanaan lelang, maka penawaran tertinggi yang masuk ditetapkan sebagai Pemenang Lelang oleh Pejabat Lelang.----------------------------------------------------------------<br>
                    -----Dalam hal terjadi gangguan teknis dalam pelaksanaan lelang tanpa kehadiran melalui internet cara terbuka (open bidding) berlaku ketentuan sebagai berikut:------------------<br>
                    1.Apabila gangguan teknis terjadi sebelum lelang dimulai yang mengakibatkan aplikasi lelang melalui internet tidak dapat beroperasi hingga berakhir jam kerja pada hari pelaksanaan lelang, maka lelang dibatalkan oleh Pejabat Lelang.-------------------<br>
                    2.Apabila gangguan teknis terjadi sebelum lelang dimulai namun aplikasi lelang melalui internet beroperasi kembali sebelum jam kerja berakhir pada hari pelaksanaan lelang, maka lelang dimulai oleh Pejabat Lelang dengan jangka waktu penawaran paling kurang 2 (dua) jam.----------------------------------------------------------<br>
                    -----Dalam hal terjadi gangguan teknis dalam pelaksanaan lelang yang dilakukan secara bersamaan antara lelang dengan kehadiran peserta dan lelang tanpa kehadiran peserta yang menyebabkan lelang tanpa kehadiran peserta tidak dapat digunakan, lelang dengan kehadiran peserta tetap sah dan mengikat.---------------------------------------------------- -----Peserta Lelang yang mengajukan penawaran tertinggi dan telah mencapai atau melampaui Nilai Limit yang ditetapkan oleh Penjual, disahkan sebagai Pembeli oleh saya Pejabat Lelang pada saat pelaksanaan lelang hari ini juga.----------------------------------------------------- -----Bea Lelang dalam pelaksanaan lelang ini dipungut sesuai dengan ketentuan dalam Peraturan Pemerintah tentang Tarif atas Jenis Penerimaan Negara Bukan Pajak yang Berlaku pada Kementerian Keuangan.--------------------------------------------------------------------------------
                </p>
            </td>
            <td style="width: 50%;">
                <p style="font-size: 10px; text-align: justify; padding-left: 0">
                    -----Pelunasan kewajiban pembayaran lelang oleh Pembeli dilakukan secara tunai paling lama 5 (lima) hari kerja setelah pelaksanaan lelang.-------Pembayaran dengan cek/giro hanya dapat diterima dan dianggap sah sebagai pelunasan kewajiban pembayaran lelang oleh Pembeli, jika cek/giro tersebut dikeluarkan oleh bank anggota kliring, dananya mencukupi dan dapat diuangkan.--------------------------------------------
                    ----------Peserta Lelang yang telah disahkan sebagai Pembeli bertanggung jawab sepenuhnya dalam pelunasan kewajiban pembayaran lelang dan biaya-biaya resmi lainnya berdasarkan peraturan perundang-undangan pada lelang ini walaupun dalam penawarannya itu ia bertindak selaku kuasa dari seseorang, perusahaan atau badan hukum------------------------------Dengan mengajukan penawaran pada lelang ini, Peserta Lelang wajib mematuhi dan menundukkan diri pada syarat dan ketentuan lelang sebagaimana tertuang dalam Risalah Lelang ini, syarat dan ketentuan lelang yang ditempel pada papan  pengumuman,  syarat dan ketentuan  pada pengumuman lelang, syarat dan ketentuan lelang yang ditayangkan pada aplikasi lelang melalui internet, dan syarat dan ketentuan yang tercantum pada formulir penawaran.------------------------------Pembeli yang tidak melunasi kewajiban pembayaran lelang sesuai ketentuan (Pembeli Wanprestasi), maka pada hari kerja berikutnya pengesahannya sebagai Pembeli dibatalkan secara tertulis oleh Pejabat Lelang, tanpa mengindahkan ketentuan sebagaimana yang dimaksud dalam Pasal 1266 dan 1267 Kitab Undang-undang Hukum Perdata dan dapat dituntut ganti rugi oleh Penjual.-----------------------
                    --------------------------Pembeli tidak diperkenankan mengambil/menguasai Barang yang dibelinya sebelum memenuhi kewajiban pembayaran lelang. Apabila Pembeli melanggar ketentuan ini maka dianggap telah melakukan suatu tindak kejahatan yang dapat dituntut oleh Penegak Hukum.---------------------Barang yang telah terjual pada lelang ini menjadi hak dan tanggungan Pembeli dan  harus dengan segera mengurus Barang tersebut.------------------------------------------------------------------------------------ -----Bea Perolehan Hak Atas Tanah dan Bangunan (BPHTB) dipungut berdasarkan ketentuan peraturan perundang-undangan yang mengatur Bea Perolehan Hak Atas Tanah dan Bangunan.--------------------------------- -----Pajak Penghasilan Atas Penghasilan dari Pengalihan Hak Atas Tanah dan/atau Bangunan dipungut berdasarkan ketentuan peraturan perundang-undangan yang mengatur Pembayaran Pajak Penghasilan Atas Penghasilan dari Pengalihan Hak Atas Tanah dan/atau Bangunan.-----Biaya balik nama barang, tunggakan pajak berikut denda-dendanya serta biaya lainnya sesuai ketentuan, menjadi tanggung jawab sepenuhnya Pembeli-------------------------------------------------------------------------Pembeli akan  diberikan Kutipan Risalah Lelang untuk kepentingan balik nama setelah menunjukkan kuitansi pelunasan pembayaran lelang. Apabila yang dilelang berupa tanah dan/atau bangunan harus disertai dengan menunjukkan asli Surat Setoran BPHTB.-------------------------------
                    -----Apabila tanah dan/atau bangunan yang akan dilelang ini berada dalam keadaan berpenghuni, maka pengosongan tersebut sepenuhnya menjadi tanggung jawab Pembeli. Apabila pengosongan tersebut tidak dapat dilakukan secara sukarela, maka Pembeli berdasarkan ketentuan peraturan perundang-undangan dapat meminta penetapan Ketua Pengadilan setempat untuk pengosongannya.---------------------------------------
                    -Jika Pembeli tidak mendapatkan izin dari instansi pemberi izin untuk membeli barang yang dilelang sehingga jual beli ini menjadi batal, maka ia dengan ini oleh Penjual diberi kuasa penuh yang tidak dapat ditarik kembali dengan hak untuk memindahkan kuasa itu untuk mengalihkan barang itu kepada pihak lain atas nama Penjual dengan dibebaskan dari pertanggungjawaban sebagai kuasa dan jika ada menerima uang ganti kerugian yang menjadi hak sepenuhnya dari Pembeli. Adapun uang pembelian yang sudah diberikan kepada Penjual tersebut di atas tidak dapat ditarik kembali oleh Pembeli.-------------------------Pejabat Lelang Kelas I/KPKNL tidak menanggung kebenaran keterangan-keterangan yang diberikan secara lisan pada waktu penjualan tentang keadaan sesungguhnya dan keadaan hukum atas barang yang dilelang tersebut, seperti luasnya, batas-batasnya, perjanjian sewa-menyewa sepenuhnya menjadi risiko Pembeli.-----------------Penawar/Pembeli dianggap sungguh-sungguh telah mengetahui apa yang telah ditawar olehnya. Apabila terdapat kekurangan/kerusakan baik yang terlihat ataupun yang tidak terlihat, maka Penawar/Pembeli tidak berhak untuk menolak atau menarik diri kembali setelah pembelian disahkan dan melepaskan segala hak untuk meminta kerugian atas sesuatu apapun juga.------------------------------------------Untuk segala hal yang berhubungan dengan atau diakibatkan oleh pembelian dalam lelang ini, para Pembeli dianggap telah memilih tempat kedudukan umum yang tetap dan tidak dapat diubah pada KPKNL Banjarmasin.-------------------------------------------------------------------------Khusus untuk pembelian dalam lelang ini sepanjang tidak ditentukan dalam Risalah Lelang ini, maka Penawar/Pembeli tunduk pada hukum perdata dan hukum dagang yang berlaku di Indonesia.----
                </p>
            </td>
        </tr>
    </table>
</page>
