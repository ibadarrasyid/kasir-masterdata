<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nominatif PNS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<style>
    /* http://meyerweb.com/eric/tools/css/reset/ 
    v2.0 | 20110126
    License: none (public domain)
    */

    html, body, div, span, applet, object, iframe,
    h1, h2, h3, h4, h5, h6, p, blockquote, pre,
    a, abbr, acronym, address, big, cite, code,
    del, dfn, em, img, ins, kbd, q, s, samp,
    small, strike, strong, sub, sup, tt, var,
    b, u, i, center,
    dl, dt, dd, ol, ul, li,
    fieldset, form, label, legend,
    table, caption, tbody, tfoot, thead, tr, th, td,
    article, aside, canvas, details, embed, 
    figure, figcaption, footer, header, hgroup, 
    menu, nav, output, ruby, section, summary,
    time, mark, audio, video {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        /* font: inherit; */
        /* vertical-align: baseline; */
    }
    /* HTML5 display-role reset for older browsers */
    article, aside, details, figcaption, figure, 
    footer, header, hgroup, menu, nav, section {
        display: block;
    }
    body {
        line-height: 1;
    }
    ol, ul {
        list-style: none;
    }
    blockquote, q {
        quotes: none;
    }
    blockquote:before, blockquote:after,
    q:before, q:after {
        content: '';
        content: none;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    .table-f, .table-f th, .table-f td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    .table-f th {
        background: #ededed;
    }
    .table-c, .table-c th, .table-c td {
        border: none;
    }
    .table-c td { 
        padding-bottom: 0; 
        padding-left: 5px;
        font-size: 14px;
        font-weight: bold;
        text-align: left;
        line-height: 1.3;
        vertical-align: middle;
    }
    .mt-0{
        margin-top: 0; 
    }
    .mb-0{
        margin-bottom: 0; 
    }

    .header {
        max-width: 700px;
        margin: 0 auto 30px;
        font-weight: bold;
        text-align: center;
    }
    .header h1 {
        text-transform: uppercase;
        font-size: 19px;
    }
    .header h1:after{
        content: '';
        display: block;
        width: 98%;
        height: 1px;
        background-color: lightgray;
        margin: 5px auto;
    }
    .header h2 {
        font-size: 15px;
    }

    .header-table { margin-bottom: 5px; }
    .header-table::after {
        content: "";
        clear: both;
        display: table;
    }
    .header-table .unit-kerja {
        font-size: 15px;
        font-weight: bold;
        font-style: italic;
        float: left;
    }
    .header-table .unit-kerja span {
        display: inline-block;
        margin-left: 20px;
    }
    .header-table .jumlah-data {
        float: right;
        font-size: 10px;
    }
    .header-table .jumlah-data span { font-weight: bold; }

    table > thead > tr th {
        font-size: 12px;
        line-height: 1;
    }
    table {
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
    table th {
        padding: .5% 0;
    }
    table th:last-child, table td:last-child { border-right: 0; }

    tr td { 
        padding-top: 10px;
        padding-left: 10px;
        padding-bottom: 30px;
        font-size: 10px;
        line-height: 25px;
        vertical-align: top;
        text-align: center;
    }
    tr td:first-child, .td-center {
        padding: 10px 0 0;
    }

    table > thead > tr th, .nama, .tempat-lahir, .umur  { text-transform: uppercase; }

    .font-xs { font-size: 8px; }
    .font-sm { font-size: 10px; }
    .nama {
        font-weight: bold;    
        display: inline-block;
        margin-bottom: 10px;
    }
    .pangkat, .jabatan, .status-kepegawain {
        display: inline-block;
        margin-bottom: 20px;
        line-height: 12px;
        margin-top: 8px;
    }
    .font-tnr {
        font-family: 'Times New Roman', Times, serif;
    }
    .kolom-2 { text-align: left; }
    .lh-normal { 
        line-height: 12px;
        display: inline-block;
        margin-top: 6px;
    }
    .lh-medium { 
        line-height: 20px;
        display: inline-block;
    }
    .foto {
        width: 50px;
        height: 50px;
        margin: 8px auto 0;
    }
    .signature {
        margin-top: 40px;
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        line-height: 1.3;
        text-transform: uppercase;
    }
    .signature .signature-bottom {
        margin-top: 80px;
        line-height: 1.5;
    }
    .signature .signature-bottom .signature-nama {
        text-decoration: underline;
    }
</style>
<body>
    <table class="table-c" style="width: 300px; margin-bottom: 20px; border-bottom: 2px solid #000;">
        <tbody>
            <tr>
                <td style="width: 15%">
                    <img src="<?= base_url('/assets/img/app/' . $logo) ?>" style="width:50px; height: 50px;" /></td>
                <td style="width: 85%">
                    <h2 class="mt-0 mb-0">PEMERINTAH KABUPATEN SORONG</h2>
                    <h3 class="mt-0 mb-0">BADAN KEPEGAWAIAN DAERAH</h3>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="header">
        <h1 class="font-tnr">DAFTAR NOMINATIF PEGAWAI NEGERI SIPIL <br><?= $title ?></h1>
        <h2>PERIODE : Friday, May 31, 2019</h2>
    </div>
    <div class="header-table">
        <p class="unit-kerja font-tnr">Unit Kerja : <span><?= $nama_opd ?></span></p>
        <p class="jumlah-data">Jumlah : <span><?= $total_nominatif ?></span></p>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width:3%; text-align: center;">No</th>
                <th rowspan="2" style="width:18%;">Nama <br> Tempat Lahir <br> Tanggal Lahir <br> NIP BARU</th>
                <th rowspan="2" style="width:12%; text-align: center;"> NIP LAMA <br> NO. KARPEG <br> TMT CPNS <br> TMT PNS</th>
                <th rowspan="2" style="width:10%;">PANGKAT <br> GOLONGAN <br> RUANG <br> TMT</th>
                <th rowspan="2" style="width:12%;">PENDIDIKAN <br> TERAKHIR <br> JURUSAN/PRODI <br> TAHUN LULUS <br> DIKLAT <br> PENJENJANGAN</th>
                <th rowspan="2" style="width:6%;">JENIS <br> KELAMIN <br> FOTO</th>
                <th rowspan="2" style="width:15%;">JABATAN <br> TMT JABATAN <br> ESELON <br> UNOR</th>
                <th rowspan="2" style="width:8%;">STATUS KEPEGAWAIAN <br> JENIS JABATAN <br> AGAMA</th>
                <th colspan="3">TANGGUNGAN <br> KELUARGA</th>
                <th colspan="2">RUMAH <br> DINAS</th>
            </tr>
            <tr>
                <th class="font-sm">Istri</th>
                <th class="font-sm">Suami</th>
                <th class="font-sm">Anak</th>
                <th class="font-sm">Dapat</th>
                <th class="font-sm">Tidak</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach($nominatif as $val) { 
            ?>
                <tr>
                <td><?= $no ?></td>
                <td class="kolom-2">
                    <b><span class="nama"><?= $val['peg_nama'] ?></span></b> <br>
                    <span class="tempat-lahir"><?= $val['peg_tempatlahir'] ?></span> <br>
                    <?= $val['peg_tgllahir'] ?> <br>
                    <b><?= $val['peg_nip'] ?></b>
                </td>
                <td><?= $val['peg_karpeg'] . '<br/>' . $val['cpns_tmt'] . '<br/>' . $val['pns_tmt'] ?></td>
                <td>
                    <span class="font-tnr pangkat"><?= $val['gol']['mgolongan_pangkat'] ?></span> <br>
                    <span class="font-tnr"><?= $val['gol']['mgolongan_nama'] ?></span><br>
                    <?= $val['gol']['gol_tmtgol'] ?>
                </td>
                <td>
                    <span class="lh-normal"><?= $val['pendidikan']['pdk_jurusan'] ?></span><br>
                    <?= $val['pendidikan']['pdk_tgllulus'] ?>
                </td>
                <td class="td-center">
                    <span class="font-xs"><?= $val['peg_gender'] ?></span><br>
                    <img src="<?= $val['src_img'] ?>" alt="" class="foto">
                </td>
                <td>
                    <span class="jabatan"><?= $val['jab']['rj_jabatan'] ?></span><br>
                    <span class="lh-medium">
                        <?= $val['rj_tmtjabatan'] ?> <br>
                        <?= $val['jab']['rj_eselon'] ?><br>
                        <?= $val['jab']['rj_unor'] ?>
                    </span>
                </td>
                <td>
                    <span class="status-kepegawaian"><?= $val['peg_iscpns'] ?></span><br>
                    <?= $val['jab']['rj_jenisjab'] ?><br>
                    <?= $val['peg_agama'] ?>
                </td>
                <td class="td-center"><?= $val['tanggungan']['istri'] ?></td>
                <td class="td-center"><?= $val['tanggungan']['suami'] ?></td>
                <td class="td-center"><?= $val['tanggungan']['anak'] ?></td>
                <td class="td-center"></td>
                <td class="td-center"></td>
            </tr>
            <?php 
            $no++;
            } 
            ?>
        </tbody>
    </table>
    <div class="signature font-tnr">
        <p style="width: 300px;margin: 0 auto;"><?= $signature['nama_jabatan'] ?></p>
        <p class="signature-bottom">
            <span class="signature-nama"><?= $signature['peg_nama'] ?></span><br>
            <?= strtoupper($signature['mgolongan_pangkat']) ?><br>
            NIP.<?= $signature['peg_nip'] ?>
        </p>
    </div>
</body>
</html>