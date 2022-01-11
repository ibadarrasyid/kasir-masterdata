<html>
    <head>
        <title>Bioadata PNS</title>
    </head>
    <style>
        .table-f, .table-f th, .table-f td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .table-c, .table-c th, .table-c td {
            border: none;
        }
        .tb_bg{
            vertical-align: top;
        }
        html{
            margin:15px 20px 50px;
        }
        .bg-gb{
            background: #e6e6e6;
            font-weight: bold;
        }
        .bg-g{
            background: #cccccc;            
        }
        .pad-st{
            padding-bottom: 3px;
        }
        .fo-normal{
            font-size: 12px;
        }
        .fo-lg{
            font-size: 14px;
        }
        .fo-bold{
            font-weight: bold;
        }
        .fo-center{
            text-align: center;
        }

        .tbl-data td {
            font-size: 12px;
            padding: 8px 4px;
        }

            .tbl-data .tbl-data-head {
                text-align: center;
            }
                .tbl-data .tbl-data-head td {
                    font-size: 14px;
                }

        .tbl-data .center {
            text-align: center;
        }
    </style>
    <body onload="window.print()">
        <div style="height: 60px">
            <img src="<?= base_url('/assets/img/app/' . $logo) ?>" style="height: 40px; width: 40px; float: left">
            <div class="fo-normal fo-bold" style="padding-top: 10px; border-bottom: 1px solid #000; float: left">PEMERINTAH DAERAH<?= $kota ?> <?= $nama ?><br><?= $skpd ?></div>
        </div>
        <div class="fo-lg fo-bold" style="text-align: center">PROFIL PNS<br><span style="border-bottom: 1px solid #000">PEMERINTAH DAERAH <?= $kota ?> <?= $nama ?></span></div>
        <div class="fo-bold fo-normal" style="margin-top: 8px">
            <span style="width: "></span>
            OPD/UNOR INDUK : <?= $peg['nama_unitkerja'] ?>
        </div>
        <div class="fo-bold fo-normal" style="margin-top: 8px">
            UNIT ORGANISASI (UNOR) : <?= $peg['nama_unit'] ?>
        </div>
        <hr>
        <table class="table-c fo-normal" style="width: 100%" cellpadding="4"> 
            <tr> 
                <td style="width: 30%;text-align: center;vertical-align: top" rowspan="17"><img src="<?= $peg['peg_foto'] ?>" width="170px" height="190px"></td>
                <td style="width: 17%">NAMA LENGKAP</td>
                <td class="fo-center" style="width: 3%">:</td>
                <td style="width: 50%"><?= $peg['peg_nama'] ?></td>
            </tr>
            <tr>
                <td>NIP</td>
                <td class="fo-center">:</td>
                <td><?= $peg['peg_nip'] ?></td>
            </tr>
            <tr>
                <td>TEMPAT LAHIR</td>
                <td class="fo-center">:</td>
                <td><?= $peg['peg_tempatlahir'] ?></td>
            </tr>
            <tr>
                <td>TANGGAL LAHIR</td>
                <td class="fo-center">:</td>
                <td><?= ($peg['peg_tgllahir'] == '') ? '' : date('d-m-Y', strtotime($peg['peg_tgllahir'])) ?></td>
            </tr>
            <tr>
                <td>AGAMA</td>
                <td class="fo-center">:</td>
                <td><?= $peg['peg_agama'] ?></td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: top">PANGKAT/GOL./RUANG TERAKHIR</td>
                <td class="fo-center">:</td>
                <td><?= strtoupper($kp['mgolongan_pangkat']) . '/' . $kp['mgolongan_nama'] . ' TMT.' . date('d-m-Y', strtotime($kp['gol_tmtgol'])) ?></td>
            </tr>
            <tr>
                <td></td> 
                <td>GAPOK. <?= number_format($kp['gol_gaji'], 0, ',', '.') ?></td> 
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: top">KGB TERAKHIR</td>
                <td class="fo-center">:</td>
                <td><?= 'TMT.' . $kgb['kgb_tmt'] . '  / TGL.' . $kgb['kgb_tglskgb'] ?></td>
            </tr>
            <tr>
                <td></td> 
                <td>GAPOK. <?= number_format($kgb['kgb_gaji'], 0, ',', '.') ?></td> 
            </tr>
            <tr>
                <td>TMT. CPNS/TMT. PNS</td>
                <td class="fo-center">:</td>
                <td><?= $peg['cpns_tmt'] . ' / ' . $peg['pns_tmt'] ?></td>
            </tr>
            <tr>
                <td>KEDUDUKAN/STAKEP</td>
                <td class="fo-center">:</td>
                <td><?= $kepeg['mket_keterangan'] . ' / ' . ($peg['peg_iscpns'] == 't' ? 'PNS' : 'CPNS') ?></td>
            </tr>
            <tr>
                <td>PENDIDIKAN/JURUSAN/PRODI/AKTA</td>
                <td class="fo-center">:</td>
                <td><?= $pdk['pdk_jurusan'] . ' / ' . (empty($pdk['pdk_tgllulus']) ? '' : date('Y', strtotime($pdk['pdk_tgllulus']))) ?></td>
            </tr>
            <tr>
                <td>STATUS PERKAWINAN / KETERANGAN GAJI</td>
                <td class="fo-center">:</td>
                <td><?= $peg['sts_menikah'] ?></td>
            </tr>
            <tr>
                <td>ESELON</td>
                <td class="fo-center">:</td>
                <td><?= $peg['eselon'] ?></td>
            </tr>
            <tr>
                <td>JABATAN/TMT./JENIS JABATAN</td>
                <td class="fo-center">:</td>
                <td><?= $peg['nama_jabatan'] . ' / ' . date('d-m-Y', strtotime($peg['tmtjabatan'])) . ' / ' . $peg['jnsdetail_nama'] ?></td>
            </tr>
            <tr>
                <td>UNIT ORGANISASI (UNOR)</td>
                <td class="fo-center">:</td>
                <td><?= $peg['nama_unit'] ?></td>
            </tr>
            <tr>
                <td>INFO PENTING</td>
                <td class="fo-center">:</td>
                <td><?= $peg['peg_info'] ?></td>
            </tr>
        </table>

        <br>
        <h4>Data CPNS</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Nomor dan Tanggal Pertek</td>
                <td>Gol Ruang</td>
                <td>TMT</td>
                <td>Nomor SK</td>
                <td>Tanggal SK</td>
                <td>Pejabat Yang Menetapkan</td>
            </tr>
            <tr>
                <td class="center">1</td>
                <td class="center">
                    <?= $peg['cpns_nopertek'] ?>
                    <br>
                    <?= date('d-m-Y', strtotime($peg['cpns_tglpertek'])) ?>
                </td>
                <td class="center"><?= $peg['cpns_mgolongan_id'] ?></td>
                <td class="center"><?= date('d-m-Y', strtotime($peg['cpns_tmt'])) ?></td>
                <td class="center"><?= $peg['cpns_nosk'] ?></td>
                <td class="center"><?= date('d-m-Y', strtotime($peg['cpns_tglsk'])) ?></td>
                <td class="center"><?= $peg['cpns_pejabat'] ?></td>
            </tr>
        </table>

        <br>
        <h4>Data PNS</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Pangkat</td>
                <td>Gol Ruang</td>
                <td>TMT</td>
                <td>Nomor SK</td>
                <td>Tanggal SK</td>
                <td>Pejabat Yang Menetapkan</td>
            </tr>
            <tr>
                <td class="center">1</td>
                <td></td>
                <td class="center"><?= $peg['pns_gol'] ?></td>
                <td class="center"><?= date('d-m-Y', strtotime($peg['pns_tmt'])) ?></td>
                <td class="center"><?= $peg['pns_nosk'] ?></td>
                <td class="center"><?= date('d-m-Y', strtotime($peg['pns_tglsk'])) ?></td>
                <td class="center"><?= $peg['pns_pejabat'] ?></td>
            </tr>
        </table>

        <br>
        <h4>Riwayat Kenaikan Pangkat</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Pangkat</td>
                <td>Gol Ruang</td>
                <td>TMT</td>
                <td>Nomor SK</td>
                <td>Tanggal SK</td>
                <td>Pejabat Yang Menetapkan</td>
            </tr>
            <tr>
                <td class="center">1</td>
                <td><?= $kp['mgolongan_pangkat'] ?></td>
                <td class="center"><?= $kp['mgolongan_nama'] ?></td>
                <td class="center"><?= date('d-m-Y', strtotime($kp['gol_tmtgol'])) ?></td>
                <td class="center"><?= $kp['gol_nosk'] ?></td>
                <td class="center"><?= date('d-m-Y', strtotime($kp['gol_tglsk'])) ?></td>
                <td></td>
            </tr>
        </table>

        <br>
        <h4>Riwayat Jabatan</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Unit Kerja</td>
                <td>Jenis Jabatan</td>
                <td>Nama Jabatan</td>
                <td>TMT/Angka Kredit</td>
                <td>Nomor dan Tanggal SK</td>
                <td>Gol. Eselon</td>
                <td>Pejabat Yang Menetapkan</td>
            </tr>

            <?php
            $no = 1;
            foreach ($rj as $v_rj) {
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td><?= $v_rj['rj_instansi'] ?></td>
                    <td><?= $v_rj['rj_jenisjab'] ?></td>
                    <td><?= $v_rj['rj_jabatan'] ?></td>
                    <td class="center"><?= date('d-m-Y', strtotime($v_rj['rj_tmtjabatan'])) ?></td>
                    <td class="center">
                        <?= $v_rj['rj_nosk'] ?>
                        <br>
                        <?= date('d-m-Y', strtotime($v_rj['rj_tglsk'])) ?>
                    </td>
                    <td class="center"><?= $v_rj['rj_eselon'] ?></td>
                    <td></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>

        <br>
        <h4>Riwayat Pendidikan</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Tahun Lulus</td>
                <td>Jurusan/Prodi</td>
                <td>Nama Sekolah</td>
            </tr>

            <?php
            $no = 1;
            foreach ($pdk as $v_pdk) {
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td class="center"><?= date('Y', strtotime($v_pdk['pdk_tgllulus'])) ?></td>
                    <td><?= $v_pdk['pdk_jurusan'] ?></td>
                    <td><?= $v_pdk['pdk_sekolah'] ?></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>

        <br>
        <h4>Riwayat Diklat Struktural/Fungsional</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Nama Diklat</td>
                <td>Tahun Lulus</td>
                <td>Nomor Sertifikat</td>
                <td>Tanggal Sertifikat</td>
                <td>Pejabat Yang Menetapkan</td>
            </tr>

            <?php
            $no = 1;
            foreach ($diklat_struktural as $v_diklat_struktural) {
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td><?= $v_diklat_struktural['dmj_nama'] ?></td>
                    <td class="center"><?= $v_diklat_struktural['dmj_thnlulus'] ?></td>
                    <td class="center"><?= $v_diklat_struktural['dmj_nosertifikat'] ?></td>
                    <td class="center"><?= date('d-m-Y', strtotime($v_diklat_struktural['dmj_tglpenetapan'])) ?></td>
                    <td><?= $v_diklat_struktural['mket_keterangan'] ?></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>

        <br>
        <h4>Riwayat Diklat Teknis/Kursus</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Nama Diklat</td>
                <td>Tahun Lulus</td>
                <td>Nomor Sertifikat</td>
                <td>Tanggal Sertifikat</td>
                <td>Penyelenggara</td>
            </tr>

            <?php
            $no = 1;
            foreach ($diklat_teknis as $v_diklat_teknis) {
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td><?= $v_diklat_teknis['ks_nama'] ?></td>
                    <td class="center"><?= date('Y', strtotime($v_diklat_teknis['ks_tglselesai'])) ?></td>
                    <td class="center"><?= $v_diklat_teknis['ks_nosertifikat'] ?></td>
                    <td class="center"><?= date('d-m-Y', strtotime($v_diklat_teknis['ks_tglsertifikat'])) ?></td>
                    <td><?= $v_diklat_teknis['ks_penyelenggara'] ?></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>

        <br>
        <h4>Riwayat Angka Kredit</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td rowspan="2">No</td>
                <td rowspan="2">Nama SK</td>
                <td rowspan="2">Tanggal SK</td>
                <td colspan="2">Tanggal Penilaian</td>
                <td colspan="2">Kredit</td>
                <td rowspan="2">Total Kredit</td>
            </tr>
            <tr class="bg-gb tbl-data-head">
                <td>Mulai</td>
                <td>Berakhir</td>
                <td>Utama</td>
                <td>Penunjang</td>
            </tr>

            <?php
            $no = 1;
            foreach ($ak as $v_ak) {
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td class="center"><?= $v_ak['pak_nosk'] ?></td>
                    <td class="center"><?= (!empty($v_ak['pak_tglsk'])) ? date('d-m-Y', strtotime($v_ak['pak_tglsk'])) : '' ?></td>
                    <td class="center"><?= (!empty($v_ak['pak_tglstart_penilaian'])) ? date('d-m-Y', strtotime($v_ak['pak_tglstart_penilaian'])) : '' ?></td>
                    <td class="center"><?= (!empty($v_ak['pak_tglend_penilaian'])) ? date('d-m-Y', strtotime($v_ak['pak_tglend_penilaian'])) : '' ?></td>
                    <td class="center"><?= number_format($v_ak['pak_kreditutama']) ?></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>

        <br>
        <h4>Riwayat Kenaikan Gaji Berkala</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td rowspan="2">No</td>
                <td rowspan="2">No SKGB</td>
                <td rowspan="2">Tanggal SKGB</td>
                <td rowspan="2">TMT</td>
                <td colspan="2">Masa Kerja</td>
                <td rowspan="2">Gaji Pokok</td>
                <td rowspan="2">Golongan</td>
                <td rowspan="2">Pejabat Yang Menetapkan</td>
            </tr>
            <tr class="bg-gb tbl-data-head">
                <td>Tahun</td>
                <td>Bulan</td>
            </tr>

            <?php
            $no = 1;
            foreach ($kgb as $v_kgb) {
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td class="center"><?= $v_kgb['kgb_noskgb'] ?></td>
                    <td class="center"><?= date('d-m-Y', strtotime($v_kgb['kgb_tglskgb'])) ?></td>
                    <td class="center"><?= date('d-m-Y', strtotime($v_kgb['kgb_tmt'])) ?></td>
                    <td class="center"><?= $v_kgb['kgb_mktahun'] ?></td>
                    <td class="center"><?= $v_kgb['kgb_mkbulan'] ?></td>
                    <td><?= $v_kgb['kgb_gaji'] ?></td>
                    <td><?= $v_kgb['mgolongan_nama'] ?></td>
                    <td><?= $v_kgb['mket_keterangan'] ?></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>

        <br>
        <h4>Data Suami/Istri</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Nama Suami/Istri</td>
                <td>Tempat Lahir</td>
                <td>Tanggal Lahir</td>
                <td>Tunjangan</td>
                <td>Status</td>
                <td>Pekerjaan</td>
            </tr>

            <?php
            $no = 1;
            foreach ($pasangan as $v_pasangan) {
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td><?= $v_pasangan['org_nama'] ?></td>
                    <td><?= $v_pasangan['org_tempatlahir'] ?></td>
                    <td class="center"><?= date('d-m-Y', strtotime($v_pasangan['org_tgllahir'])) ?></td>
                    <td></td>
                    <td><?= $v_pasangan['psg_statuskarsu'] ?></td>
                    <td></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>

        <br>
        <h4>Data Anak</h4>
        <table class="table-f tbl-data" style="width: 100%">
            <tr class="bg-gb tbl-data-head">
                <td>No</td>
                <td>Nama Anak</td>
                <td>Tempat Lahir</td>
                <td>Tanggal Lahir</td>
                <td>Tunjangan</td>
                <td>Status Dalam Keluarga</td>
                <td>Tingkat Pendidikan</td>
            </tr>

            <?php
            $no = 1;
            foreach ($anak as $v_anak) {
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td><?= $v_anak['org_nama'] ?></td>
                    <td><?= $v_anak['org_tempatlahir'] ?></td>
                    <td class="center"><?= date('d-m-Y', strtotime($v_anak['org_tgllahir'])) ?></td>
                    <td></td>
                    <td><?= $v_anak['ank_status'] ?></td>
                    <td></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </table>
        <hr/>
        <div style="text-align: center">
            <img src="<?= base_url('profil/qrcode/'.$peg['peg_id']) ?>" />
        </div>
    </body>
</html>