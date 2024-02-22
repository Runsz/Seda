<?php
$db = mysqli_connect('localhost', 'root', '', 'db_seda');
if (!$db) {
    echo 'Koneksi Error';
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $no = $_POST['no'];
    $alamat = $_POST['alamat'];
    $armada = $_POST['armada'];
    $tgl_sewa = $_POST['tgl_sewa'];
    $durasi = $_POST['durasi'];
    $sopir = $_POST['sopir'];

    $query = "INSERT INTO `penyewaan`(`nama_penyewa`, `nik`, `no_hp`, `alamat`, `nama_armada`, `tanggal_sewa`, `durasi`, `sopir`) 
              VALUES ('$nama','$nik','$no','$alamat','$armada','$tgl_sewa',$durasi,'$sopir')";
    $save = mysqli_query($db, $query);

    if ($save) {
        echo '<script>alert("Data berhasil ditambahkan")</script>';
    }
}

$query = mysqli_query($db, "select * from armada");
$armada = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seda</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Form Penyewaan Armada</h1>
        <form action="index.php" method="post">
            <label for="">Nama</label>
            <input type="text" name="nama" required><br>
            <label for="">NIK</label>
            <input type="text" name="nik" required><br>
            <label for="">No HP</label>
            <input type="text" name="no" required><br>
            <label for="">Alamat</label>
            <input type="text" name="alamat" required><br>
            <label for="">Armada</label>
            <select name="armada" id="" required>
                <?php
                for ($i = 0; $i < count($armada); $i++) { ?>
                    <option value="<?php echo $armada[$i]['nama_armada'] ?>"><?php echo $armada[$i]['nama_armada'] ?></option>
                <?php } ?>
            </select><br>
            <label for="">Tanggal Sewa</label>
            <input type="date" name="tgl_sewa" required><br>
            <label for="">Durasi Sewa</label>
            <input type="number" name="durasi" class="durasi" required> Hari<br>
            <label for="">Pake Sopir</label>
            <select name="sopir" id="" required>
                <option value="iya">Iya</option>
                <option value="tidak">Tidak</option>
            </select><br>
            <div class="btn">
                <button class="reset" type="reset">Reset</button>
                <button class="simpan" type="submit" name="simpan">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>