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
        <title>Stock Barang - Zahra Parfum</title>
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
                        <h1 class="mt-4">Stock Barang</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang
                                </button>
                                <a href="export.php" class="btn btn-success ml-3">Export Data</a>
                            </div>
                            <div class="card-body">

                                <?php
                                    $ambildatastock = mysqli_query($conn, "select * from stock_barang where stock < 1");
                                    while ($fetch=mysqli_fetch_array($ambildatastock)) {
                                        $parfum = $fetch['merk_parfum'];
                                    

                                ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Perhatian!</strong> Stock <?=$parfum;?> Telah Habis.
                                </div>
                                <?php
                                    }

                                ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Merk Parfum</th>
                                                <th>Ukuran</th>
                                                <th>Stock</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambilsemuadatastock = mysqli_query($conn,"select * from stock_barang order by merk_parfum ASC");
                                            $i = 1;
                                            while ($data=mysqli_fetch_array($ambilsemuadatastock)) {
                                                $merkparfum = $data['merk_parfum'];
                                                $ukuran = $data['ukuran'];
                                                $stock = $data['stock'];
                                                $satuan = $data['satuan'];
                                                $idp = $data['Id_Parfum'];
                                            
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$merkparfum;?></td>
                                                <td><?=$ukuran;?></td>
                                                <td><?=$stock;?></td>
                                                <td><?=$satuan;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idp;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idp;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                                <!-- edit The Modal -->
                                                <div class="modal fade" id="edit<?=$idp;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                          <h4 class="modal-title">Edit Barang</h4>
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                        <input type="text" name="merk_parfum" value="<?=$merkparfum;?>" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="ukuran" value="<?=$ukuran;?>" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="satuan" value="<?=$satuan;?>" class="form-control" required>
                                                        <br>
                                                        <input type="hidden" name="idp" value="<?=$idp;?>">
                                                        <button type="submit" class="btn-warning" name="updatebarang">Edit</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- delete The Modal -->
                                                <div class="modal fade" id="delete<?=$idp;?>">
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
                                                        <input type="hidden" name="idp" value="<?=$idp;?>">
                                                        <br>
                                                        <br>
                                                        <button type="submit" class="btn-danger" name="deletebarang">Hapus</button>
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
                            <div class="text-muted">Copyright &copy; Zahra Parfum 2023</div>
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
              <h4 class="modal-title">Tambah Barang</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post">
            <div class="modal-body">
            <input type="text" name="merk_parfum" placeholder="Merk Parfum" class="form-control" required>
            <br>
            <input type="text" name="ukuran" placeholder="ukuran" class="form-control" required>
            <br>
            <input type="text" name="satuan" placeholder="Satuan" class="form-control" required>
            <br>
            <input type="number" name="stock" placeholder="Stock" class="form-control" required>
            <br>
            <button type="submit" class="btn-primary" name="addnewbarang">Submit</button>
            </div>
            </form>
          </div>
        </div>
    </div>
</html>
