<?php
session_start();
//membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","stockbarang");


//menambah barang baru
if (isset($_POST['addnewbarang'])) {
	$merk_parfum = $_POST['merk_parfum'];
	$ukuran = $_POST['ukuran'];
	$satuan = $_POST['satuan'];
	$stock = $_POST['stock'];

	$addtotable = mysqli_query($conn,"insert into stock_barang (merk_parfum, ukuran, satuan, stock) values('$merk_parfum', '$ukuran','$satuan','$stock')");
	if ($addtotable) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
};

//menambah suplier
if (isset($_POST['addsuplier'])) {
	$namaSuplier = $_POST['namaSuplier'];
	$noTelpon = $_POST['noTelpon'];
	$alamat = $_POST['alamat'];

	$addtosuplier = mysqli_query($conn, "insert into suplier (nama_suplier, no_telpon, alamat) values('$namaSuplier','$noTelpon','$alamat')");
	if ($addtosuplier) {
		header('location:suplier.php');
	} else {
		echo "gagal";
		header('location:suplier.php');
	}
};

//menambah barang masuk
if (isset($_POST['addmasuk'])) {
	$parfumnya = $_POST['parfumnya'];
	$ukuran = $_POST['ukuran'];
	$supliernya = $_POST['supliernya'];
	$jumlah = $_POST['jumlah'];
	$satuan = $_POST['satuan'];

	$cekstocksaatini = mysqli_query($conn, "select * from stock_barang where merk_parfum='$parfumnya'");
	$ambildatanya = mysqli_fetch_array($cekstocksaatini);

	$stocksaatini = $ambildatanya['stock'];
	$tambahkanstocksaatinidenganjumlah = $stocksaatini+$jumlah;

	$addtomasuk = mysqli_query($conn, "insert into barang_masuk (merk_parfum, ukuran, suplier, jumlah, satuan) values('$parfumnya','$ukuran','$supliernya','$jumlah','$satuan')");
	$updatestockmasuk = mysqli_query($conn, "update stock_barang set stock= '$tambahkanstocksaatinidenganjumlah' where merk_parfum='$parfumnya'");
	if ($addtomasuk&&$updatestockmasuk) {
		header('location:masuk.php');
	} else {
		echo "gagal";
		header('location:masuk.php');
	}
};

//menambah barang keluar
if (isset($_POST['addkeluar'])) {
	$parfumnya = $_POST['parfumnya'];
	$ukuran = $_POST['ukuran'];
	$jumlah = $_POST['jumlah'];
	$satuan = $_POST['satuan'];

	$cekstocksaatini = mysqli_query($conn, "select * from stock_barang where merk_parfum='$parfumnya'");
	$ambildatanya = mysqli_fetch_array($cekstocksaatini);

	$stocksaatini = $ambildatanya['stock'];

	//alert jika barang keluar melebihi stock
	if ($stocksaatini >= $jumlah) {
		// kalau stock cukup
		$tambahkanstocksaatinidenganjumlah = $stocksaatini-$jumlah;

		$addtokeluar = mysqli_query($conn, "insert into barang_keluar (merk_parfum, ukuran, jumlah, satuan) values('$parfumnya', '$ukuran', '$jumlah','$satuan')");
		$updatestockmasuk = mysqli_query($conn, "update stock_barang set stock= '$tambahkanstocksaatinidenganjumlah' where merk_parfum='$parfumnya'");
		if ($addtokeluar&&$updatestockmasuk) {
			header('location:keluar.php');
		} else {
			echo "gagal";
			header('location:keluar.php');
		}
	} else {
		// kalau stock tidak cukup
		echo '
		<script>
			alert("Stock saat ini tidak mencukupi");
			window.location.href="keluar.php";
		</script>
		';
	}
};

//update stock barang
if (isset($_POST['updatebarang'])) {
	$idp = $_POST['idp'];
	$merkparfum = $_POST['merk_parfum'];
	$ukuran = $_POST['ukuran'];
	$satuan = $_POST['satuan'];

	$update = mysqli_query($conn, "update stock_barang set merk_parfum='$merkparfum', ukuran='$ukuran', satuan='$satuan' where Id_Parfum='$idp'");
	if ($update) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
};

//menghapus barang dari stock
if (isset($_POST['deletebarang'])) {
	$idp = $_POST['idp'];

	$hapus = mysqli_query($conn, "delete from stock_barang where Id_Parfum='$idp'");
	if ($hapus) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
};

//update daftar suplier
if (isset($_POST['updatesuplier'])) {
	$ids = $_POST['ids'];
	$namaSuplier = $_POST['nama_suplier'];
	$noTelpon = $_POST['no_telpon'];
	$alamat = $_POST['alamat'];

	$update = mysqli_query($conn, "update suplier set nama_suplier='$namaSuplier', no_telpon='$noTelpon', alamat='$alamat' where id_suplier='$ids'");
	if ($update) {
		header('location:suplier.php');
	} else {
		echo "gagal";
		header('location:suplier.php');
	}
};

//menghapus suplier
if (isset($_POST['deletesuplier'])) {
	$ids = $_POST['ids'];

	$hapus = mysqli_query($conn, "delete from suplier where id_suplier='$ids'");
	if ($hapus) {
		header('location:suplier.php');
	} else {
		echo "gagal";
		header('location:suplier.php');
	}
};

//edit barang masuk
if (isset($_POST['updatebarangmasuk'])) {
	$idm = $_POST['idm'];
	$merkparfum = $_POST['merk_parfum'];
	$ukuran = $_POST['ukuran'];
	$suplier = $_POST['suplier'];
	$jumlah = $_POST['jumlah'];

	$lihatstock = mysqli_query($conn, "select * from stock_barang where merk_parfum='$merkparfum'");
	$stocknya = mysqli_fetch_array($lihatstock);
	$stocksekrang = $stocknya['stock'];

	$jumlahskrng = mysqli_query($conn, "select * from barang_masuk where id_Masuk='$idm'");
	$jumlahnya = mysqli_fetch_array($jumlahskrng);
	$jumlahskrng = $jumlahnya['jumlah'];

	if ($jumlah>$jumlahskrng) {
		$selisih = $jumlah-$jumlahskrng;
		$kurangin = $stocksekrang + $selisih;
		$kurangistocknya = mysqli_query($conn, "update stock_barang set stock='$kurangin' where merk_parfum='$merkparfum'");
		$updatenya = mysqli_query($conn, "update barang_masuk set jumlah='$jumlah', ukuran='$ukuran', suplier='$suplier', merk_parfum='$merkparfum' where id_Masuk='$idm'");
			if ($kurangistocknya&&$updatenya) {
				header('location:masuk.php');
			} else {
				echo "gagal";
				header('location:masuk.php');
			};
	} else {
		$selisih = $jumlahskrng-$jumlah;
		$kurangin = $stocksekrang - $selisih;
		$kurangistocknya = mysqli_query($conn, "update stock_barang set stock='$kurangin' where merk_parfum='$merkparfum'");
		$updatenya = mysqli_query($conn, "update barang_masuk set jumlah='$jumlah', ukuran='$ukuran', suplier='$suplier', merk_parfum='$merkparfum' where id_Masuk='$idm'");
			if ($kurangistocknya&&$updatenya) {
				header('location:masuk.php');
			} else {
				echo "gagal";
				header('location:masuk.php');
			};
	}


};

//menghapus barang masuk
if (isset($_POST['deletebarangmasuk'])) {
	$merkparfum = $_POST['merkparfum'];
	$jumlah = $_POST['jml'];
	$idm = $_POST['idm'];

	$getdatastock = mysqli_query($conn, "select * from stock_barang where merk_parfum='$merkparfum'");
	$data = mysqli_fetch_array($getdatastock);
	$stok = $data['stock'];

	$selisih = $stok - $jumlah;

	$update = mysqli_query($conn, "update stock_barang set stock='$selisih' where merk_parfum='$merkparfum'");
	$hapusdata = mysqli_query($conn, "delete from barang_masuk where id_Masuk='$idm'");

	if ($update&&$hapusdata) {
		header('location:masuk.php');
	} else {
		header('location:masuk.php');
	}
};

//edit barang keluar
if (isset($_POST['updatebarangkeluar'])) {
	$idk = $_POST['idk'];
	$merkparfum = $_POST['merk_parfum'];
	$ukuran = $_POST['ukuran'];
	$jumlah = $_POST['jumlah'];

	$lihatstock = mysqli_query($conn, "select * from stock_barang where merk_parfum='$merkparfum'");
	$stocknya = mysqli_fetch_array($lihatstock);
	$stocksekrang = $stocknya['stock'];

	$jumlahskrng = mysqli_query($conn, "select * from barang_keluar where id_Keluar='$idk'");
	$jumlahnya = mysqli_fetch_array($jumlahskrng);
	$jumlahskrng = $jumlahnya['jumlah'];

	if ($jumlah>$jumlahskrng) {
		$selisih = $jumlah-$jumlahskrng;
		$kurangin = $stocksekrang - $selisih;
		$kurangistocknya = mysqli_query($conn, "update stock_barang set stock='$kurangin' where merk_parfum='$merkparfum'");
		$updatenya = mysqli_query($conn, "update barang_keluar set jumlah='$jumlah', ukuran='$ukuran', merk_parfum='$merkparfum' where id_Keluar='$idk'");
			if ($kurangistocknya&&$updatenya) {
				header('location:keluar.php');
			} else {
				echo "gagal";
				header('location:keluar.php');
			};
	} else {
		$selisih = $jumlahskrng-$jumlah;
		$kurangin = $stocksekrang + $selisih;
		$kurangistocknya = mysqli_query($conn, "update stock_barang set stock='$kurangin' where merk_parfum='$merkparfum'");
		$updatenya = mysqli_query($conn, "update barang_keluar set jumlah='$jumlah', ukuran='$ukuran', merk_parfum='$merkparfum' where id_Keluar='$idk'");
			if ($kurangistocknya&&$updatenya) {
				header('location:keluar.php');
			} else {
				echo "gagal";
				header('location:keluar.php');
			};
	}


};

//menghapus barang keluar
if (isset($_POST['deletebarangkeluar'])) {
	$merkparfum = $_POST['merkparfum'];
	$jumlah = $_POST['jml'];
	$idk = $_POST['idk'];

	$getdatastock = mysqli_query($conn, "select * from stock_barang where merk_parfum='$merkparfum'");
	$data = mysqli_fetch_array($getdatastock);
	$stok = $data['stock'];

	$selisih = $stok + $jumlah;

	$update = mysqli_query($conn, "update stock_barang set stock='$selisih' where merk_parfum='$merkparfum'");
	$hapusdata = mysqli_query($conn, "delete from barang_keluar where id_Keluar='$idk'");

	if ($update&&$hapusdata) {
		header('location:keluar.php');
	} else {
		header('location:keluar.php');
	}
};

//menambah admin baru
if (isset($_POST['addadmin'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$queryinsert = mysqli_query($conn, "insert into login (email, password) values ('$email', '$password')");

	if ($queryinsert) {
		header('location:admin.php');
	} else {
		header('location:admin.php');
	}
};

//edit data admin
if (isset($_POST['updateadmin'])) {
	$emailbaru = $_POST['emailadmin'];
	$passwordbaru = $_POST['passwordbaru'];
	$idnya = $_POST['idu'];

	$queryupdate = mysqli_query($conn, "update login set email='$emailbaru', password='$passwordbaru' where id_user='$idnya' ");

	if ($queryupdate) {
		header('location:admin.php');
	} else {
		header('location:admin.php');
	}
};

//hapus admin
if (isset($_POST['deleteadmin'])) {
	$id = $_POST['idu'];

	$querydelete = mysqli_query($conn, "delete from login where id_user='$id' ");

	if ($querydelete) {
		header('location:admin.php');
	} else {
		header('location:admin.php');
	}
};

?>