<?php
$db = mysqli_connect('localhost', 'root', '', 'db_seda');
if (!$db) {
    echo 'Koneksi Error';
}

$query = "select * from penyewaan";
$save = mysqli_query($db, $query);
$penyewaan = mysqli_fetch_all($save, MYSQLI_ASSOC);

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $query = mysqli_query($db, "delete from penyewaan where id=$id");
    if ($query) {
        header('Location:index.php');
    }
}
if (isset($_GET['setuju'])) {
    $id = $_GET['setuju'];
    $status = 'Disetujui';

    $query = mysqli_query($db, "update penyewaan set status='$status' where id=$id");
    if ($query) {
        header('Location:index.php');
    }
}
if (isset($_POST['sort'])) {
    function sorting(&$arr)
    {
        for ($i = 0; $i < count($arr); $i++) {
            $swap = false;
            for ($j = 0; $j < count($arr) - $i - 1; $j++) {
                if (strtotime($arr[$j]['tanggal_sewa']) > strtotime($arr[$j + 1]['tanggal_sewa'])) {
                    $sementara = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $sementara;
                    $swap = true;
                }
            }
            if ($swap == false) {
                break;
            }
        }
    }

    sorting($penyewaan);
}
if (isset($_POST['search'])) {
    $key = $_POST['key'];
    function search($arr, $key)
    {
        $new = [];
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i]['tanggal_sewa'] == $key) {
                array_push($new, $arr[$i]);
            }
        }
        return $new;
    }

    $result = search($penyewaan, $key);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penyewaan</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="wrapper">
        <h1>Data Penyewaan</h1>
        <div class="atas">
            <form class="sort" action="index.php" method="post">
                <button type="submit" name="sort">Urutkan Berdasarkan Tanggal Penyewaan</button>
            </form>
            <form class="search" action="index.php" method="post">
                <input type="date" value="<?php echo date('Y-m-d') ?>" name="key">
                <button type="submit" name="search">Cari Tanggal</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Nama</td>
                    <td>NIK</td>
                    <td>No HP</td>
                    <td>Alamat</td>
                    <td>Armada</td>
                    <td>Tanggal Sewa</td>
                    <td>Durasi Sewa</td>
                    <td>Memakai Sopir</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!isset($_POST['search'])) {
                    for ($i = 0; $i < count($penyewaan); $i++) { ?>
                        <tr>
                            <td><?php echo $penyewaan[$i]['id'] ?></td>
                            <td><?php echo $penyewaan[$i]['nama_penyewa'] ?></td>
                            <td><?php echo $penyewaan[$i]['nik'] ?></td>
                            <td><?php echo $penyewaan[$i]['no_hp'] ?></td>
                            <td><?php echo $penyewaan[$i]['alamat'] ?></td>
                            <td><?php echo $penyewaan[$i]['nama_armada'] ?></td>
                            <td><?php echo $penyewaan[$i]['tanggal_sewa'] ?></td>
                            <td><?php echo $penyewaan[$i]['durasi'] . " Hari" ?></td>
                            <td><?php echo $penyewaan[$i]['sopir'] ?></td>
                            <td><?php echo $penyewaan[$i]['status'] == null ? "Belum Disetujui" : $penyewaan[$i]['status']  ?></td>
                            <td>
                                <a href="index.php?setuju=<?php echo $penyewaan[$i]['id'] ?>"><button class="setuju" type="button">Setujui</button></a>
                                <a href="index.php?hapus=<?php echo $penyewaan[$i]['id'] ?>"><button class="hapus" type="button">Hapus</button></a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    for ($i = 0; $i < count($result); $i++) { ?>
                        <tr>
                            <td><?php echo $result[$i]['id'] ?></td>
                            <td><?php echo $result[$i]['nama_penyewa'] ?></td>
                            <td><?php echo $result[$i]['nik'] ?></td>
                            <td><?php echo $result[$i]['no_hp'] ?></td>
                            <td><?php echo $result[$i]['alamat'] ?></td>
                            <td><?php echo $result[$i]['nama_armada'] ?></td>
                            <td><?php echo $result[$i]['tanggal_sewa'] ?></td>
                            <td><?php echo $result[$i]['durasi'] . " Hari" ?></td>
                            <td><?php echo $result[$i]['sopir'] ?></td>
                            <td><?php echo $result[$i]['status'] == null ? "Belum Disetujui" : $result[$i]['status']  ?></td>
                            <td>
                                <a href="index.php?setuju=<?php echo $result[$i]['id'] ?>"><button class="setuju" type="button">Setujui</button></a>
                                <a href="index.php?hapus=<?php echo $result[$i]['id'] ?>"><button class="hapus" type="button">Hapus</button></a>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>