<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB</title>
    <link rel="stylesheet" href="allya.css">
</head>
<body>
    <center>
        <img src="logo-custom.png" alt="" width="250">
        <h1>PENGGAJIHAN</h1>
        <h1>GURU/KARYAWAN YAYASAN ASSALAAM</h1>
        <hr>
        <h3>Data Penggajihan</h3>

        <!-- Form Submission to PHP -->
        <form method="POST">
            <!-- Data Penggajihan -->
            <table>
                <tr>
                    <td><b>No</b></td>
                    <td><input type="text" name="no" required placeholder="No"></td>
                </tr>
                <tr>
                    <td><b>Nama</b></td>
                    <td><input type="text" name="nama" required placeholder="Nama"></td>
                </tr>
                <tr>
                    <td><b>Unit Pendidikan</b></td>
                    <td>
                        <select name="unit" required>
                            <option value="sd">SD</option>
                            <option value="smp">Smp</option>
                            <option value="sma">Sma</option>
                            <option value="smk">Smk</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Tanggal Gaji</b></td>
                    <td><input type="date" name="gaji" required></td>
                </tr>
            </table>

            <hr>
            <!-- Gaji dan Potongan ditampilkan secara horizontal -->
            <table style="width: 100%;">
                <tr>
                    <!-- Bagian Gaji -->
                    <td style="vertical-align: top; width: 50%;">
                        <h2>Gaji</h2>
                        <table>
                            <tr>
                                <td><b>Jabatan</b></td>
                                <td>
                                    <select name="jabatan" required>
                                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                                        <option value="Wakasek">Wakasek</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Karyawan">Karyawan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Lama Kerja</b></td>
                                <td>
                                    <input type="text" name="lama_kerja" style="width: 320px;" required placeholder="lama kerja"> 
                                </td>
                            </tr>
                            <tr>
                                <td><b>Status Kerja</b></td>
                                <td>
                                    <select name="status_kerja" required>
                                        <option value="Tetap">Tetap</option>
                                        <option value="Magang">Magang</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align: top; width: 50%;">
                        <h2>Potongan</h2>
                        <table>
                            <tr>
                                <td><b>BPJS</b></td>
                                <td><input type="number" name="bpjs" placeholder="BPJS" required></td>
                            </tr>
                            <tr>
                                <td><b>Pinjaman</b></td>
                                <td><input type="number" name="pinjaman" placeholder="Pinjaman" required></td>
                            </tr>
                            <tr>
                                <td><b>Cicilan</b></td>
                                <td><input type="number" name="cicilan" placeholder="Cicilan" required></td>
                            </tr>
                            <tr>
                                <td><b>Infaq</b></td>
                                <td><input type="number" name="infaq" placeholder="Infaq" required></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <hr>
            <button type="submit">Submit</button>
        </form>

        <?php
        class Karyawan {
            public $nama;
            public $jabatan;
            public $status;
            public $gaji;
            public $bonus;
            public $bpjs;
            public $pinjaman;
            public $tabungan;
            public $lainnya;

            public function __construct($nama, $jabatan, $status, $bpjs, $pinjaman, $tabungan, $lainnya) {
                $this->nama = $nama;
                $this->jabatan = $jabatan;
                $this->status = $status;
                $this->setGaji();
                $this->setBonus();
                $this->bpjs = $bpjs;
                $this->pinjaman = $pinjaman;
                $this->tabungan = $tabungan;
                $this->lainnya = $lainnya;
            }

            public function setGaji() {
                switch ($this->jabatan) {
                    case 'Kepala Sekolah':
                        $this->gaji = 10000000;
                        break;
                    case 'Wakasek':
                        $this->gaji = 7000000;
                        break;
                    case 'Guru':
                        $this->gaji = 5000000;
                        break;
                    case 'Karyawan':
                        $this->gaji = 2500000;
                        break;
                    default:
                        $this->gaji = 0;
                }
            }

   
            public function setBonus() {
                $this->bonus = ($this->status == 'Tetap') ? 1000000 : 0;
            }

            public function gajiBersih() {
                return ($this->gaji + $this->bonus) - ($this->bpjs + $this->pinjaman + $this->tabungan + $this->lainnya);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama = $_POST['nama'];
            $jabatan = $_POST['jabatan'];
            $status = $_POST['status_kerja'];
            $bpjs = $_POST['bpjs'];
            $pinjaman = $_POST['pinjaman'];
            $cicilan = $_POST['cicilan'];
            $infaq = $_POST['infaq'];

            $karyawan = new Karyawan($nama, $jabatan, $status, $bpjs, $pinjaman, $cicilan, $infaq);


            echo"<h1>STRUCK GAJI</h1>";

            echo "<br><b>Nama : $nama</b><br>";
            echo "<b>Jabatan: $jabatan</b><br>";
            echo "<b>Status : $status</b><br>";
            echo "<b>Gaji : Rp " . number_format($karyawan->gaji) . "</b><br>";
            echo "<b>Bonus : Rp " . number_format($karyawan->bonus) . "</b><br>";
            echo "<b>BPJS : Rp " . number_format($bpjs) . "</b><br>";
            echo "<b>Pinjaman: Rp " . number_format($pinjaman) . "</b><br>";
            echo "<b>Cicilan: Rp " . number_format($cicilan) . "</b><br>";
            echo "<b>Infaq : Rp " . number_format($infaq) . "</b><br>";

            echo "<h3>Gaji Bersih: Rp " . number_format($karyawan->gajiBersih()) . "</h3>";
        }
        ?>
    </center>
</body>
</html>