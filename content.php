<?php
include "inc/inc.koneksi.php";
include "inc/library.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_combobox.php";
include "inc/class_paging.php";
include "inc/fungsi_rupiah.php";
include "inc/fungsi_tanggal.php";
include "inc/fungsi_hdt.php";

$mod = $_GET['module'];

// Bagian Home
if ($mod=='home'){


	echo "<h2>E-APOTIK</h2>";
	echo "Selamat datang <b>$_SESSION[namalengkap] </b>, di APLIKASI APOTIK<br>";
	echo "Modul - Modul:<br>";
	echo "A. SMS Gateway<br>";
	echo "B. PESANAN<br>";
	echo "C. PENJUALAN<br>";
	echo "D. PIUTANG<br>";
	echo "E. PEMBELIAN<br>";
//	echo "&nbsp;&nbsp;&nbsp; - Kartu Gudang<br>";
	echo"<p>&nbsp;</p>
          <p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d")); 
  echo " | "; 
  echo date("H:i:s");
  echo " WIB</p>";
  
}
//users
elseif ($mod=='pengguna'){
    include "modul/m_users/users.php";
}
elseif ($mod=='smsg'){
//sms order
    include "modul/t_sms/sms.php";
}
elseif ($mod=='ord'){
//manual order
    include "modul/t_order/t_order.php";
}
elseif ($mod=='ordli'){
//manual order
    include "modul/t_order/list_ord.php";
}

elseif ($mod=='spli'){
//manual order
    include "modul/t_order/list_ord_sp.php";
}

elseif ($mod=='dih'){
//manual order
    include "modul/pelunasan/dih.php";
}
elseif ($mod=='lns'){
//manual order
    include "modul/lunas/po_beli.php";
}

// Apabila modul tidak ditemukan
else{
  echo "<b>MODUL BELUM ADA ATAU BELUM LENGKAP</b>";
}
?>
