<?php
require 'function.php';
require 'cek.php';

$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Keluar</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">ZAHRA PARFUME</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
           
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"><p class="text-light"><?=$email;?></p></div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="suplier.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Suplier
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Kelola Admin
                            </a>
                            <br>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Barang Keluar</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang keluar
                                </button>
                                <br>
                                <div class="row mt-4">
                                    <div class="col">
                                        <form method="post" class="form-inline">
                                            <label>Pilih Tanggal</label>
                                            <input type="date" name="tgl_awal" class="form-control ml-3">
                                            <input type="date" name="tgl_akhir" class="form-control ml-3">
                                            <button type="submit" name="filter_tgl" class="btn btn-info ml-3">Cari</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Merk Parfum</th>
                                                <th>Ukuran</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                //untuk filter tanggal
                                                if(isset($_POST['filter_tgl'])) {
                                                    $awal = $_POST['tgl_awal'];
                                                    $akhir = $_POST['tgl_akhir'];

                                                    if($awal!=null || $akhir!=null) {

                                                        $ambilsemuadatastock = mysqli_query($conn, "select * from barang_keluar where tanggal BETWEEN '$awal' and DATE_ADD('$akhir', INTERVAL 1 DAY) order by id_Keluar DESC");
                                                    } else {
                                                        $ambilsemuadatastock = mysqli_query($conn, "select * from barang_keluar");
                                                    }

                                                } else {
                                                    $ambilsemuadatastock = mysqli_query($conn, "select * from barang_keluar");
                                                }
                                                    while ($data=mysqli_fetch_array($ambilsemuadatastock)) {
                                                        $idk = $data['id_Keluar'];
                                                        $tanggal = $data['tanggal'];
                                                        $merkparfum = $data['merk_parfum'];
                                                        $ukuran = $data['ukuran'];
                                                        $jumlah = $data['jumlah'];
                                                        $satuan = $data['satuan'];
                                            
                                            ?>
                                            <tr>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$merkparfum;?></td>
                                                <td><?=$ukuran;?></td>
                                                <td><?=$jumlah;?></td>
                                                <td><?=$satuan;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idk;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idk;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                                <!-- edit The Modal -->
                                                <div class="modal fade" id="edit<?=$idk;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                          
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                          <h4 class="modal-title">Edit Barang Keluar</h4>
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                            
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                        <input type="text" name="merk_parfum" value="<?=$merkparfum;?>" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="ukuran" value="<?=$ukuran;?>" class="form-control" required>
                                                        <br>
                                                        <input type="number" name="jumlah" value="<?=$jumlah;?>" class="form-control" required>
                                                        <br>
                                                        <input type="hidden" name="merk_parfum" value="<?=$merkparfum;?>">
                                                        <input type="hidden" name="idk" value="<?=$idk;?>">
                                                        <button type="submit" class="btn-warning" name="updatebarangkeluar">Edit</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- delete The Modal -->
                                                <div class="modal fade" id="delete<?=$idk;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                          
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang?</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                            
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus <?=$merkparfum;?>?
                                                        <input type="hidden" name="merkparfum" value="<?=$merkparfum;?>">
                                                        <input type="hidden" name="jml" value="<?=$jumlah;?>">
                                                        <input type="hidden" name="idk" value="<?=$idk;?>">
                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn-danger" name="deletebarangkeluar">Hapus</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
        <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Tambah Barang Keluar</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post">
            <div class="modal-body">
            
            <!-- memanggil daftar parfumnya -->
            <select name="parfumnya" class="form-control">
                <?php
                    $ambilsemuadatanya = mysqli_query($conn,"select * from stock_barang order by merk_parfum ASC");
                    while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                        $merkparfumnya = $fetcharray['merk_parfum'];        
                ?>

                <option value="<?=$merkparfumnya;?>"><?=$merkparfumnya;?></option>

                <?php 
                    }
                ?>
            </select>
            <br>
            <input type="text" name="ukuran" placeholder="ukuran" class="form-control" required>
            <br>
            <input type="number" name="jumlah" placeholder="Jumlah" class="form-control" required>
            <br>
            <input type="text" name="satuan" placeholder="Satuan" class="form-control" required>
            <br>
            <button type="submit" class="btn-primary" name="addkeluar">Submit</button>
            </div>
            </form>
          </div>
        </div>
    </div>
</html>
