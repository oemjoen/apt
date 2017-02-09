<script type="text/javascript">
$(document).ready(function() {						   
    $(function() {
        $("#theList tr:even").addClass("stripe1");
        $("#theList tr:odd").addClass("stripe2");

        $("#theList tr").hover(
            function() {
                $(this).toggleClass("highlight");
            },
            function() {
                $(this).toggleClass("highlight");
            }
        );
    });
	
	$(".jmlvalid").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
		{
			return false;
		}
	});
		
	function h_cek(){
		var cek 	= $(".cek:checked").length;
		$("#tot_cek").html('Jumlah Ceklist : '+cek);
	}

  $("#theList.retur tr")
  	.filter(":has(:checkbox:checked)")
	.addClass("klik")
	.end()
	.click(function(event) {		
		$(this).toggleClass("klik");
		if(event.target.type !== "checkbox") {
			$(":checkbox",this).attr("checked",function(){															
				return !this.checked;
			});
			h_cek();
		}
		
	});
	
	function buat_kode() {
		var	kode	= $("#cbo_beli").val();
		var tgl		= $("#txt_tgl_beli").val();
		var prins	= $("#cbo_prinsipal").val();
		$.ajax({
			type	: "POST",
			url		: "modul/lunas/buat_nomor.php",
			data	: "kode="+kode+"&tgl="+tgl+"&prins="+prins,
			dataType: "json",
			success	: function(data){
				$("#txt_kode").val(data.kode_pobeli);
				//alert(data.kode_pobeli);
			}
		});		
	}
	

	$("#simpan_pobeli").click(function(){
		
		var prins			= $("#cbo_prinsipal").val();
		var cek 			= $(".cek:checked").length;
		var	tgl				= $("#txt_tgl_beli").val();
		var	kode			= $("#cbo_beli").val();
		var kodepo_beli 	= $("#txt_kode").val();
		var kodeuser 		= $("#kode_user").val();
		
		if(prins.length == 0){
           alert("Maaf, Prinsipal tidak boleh kosong");
		   $("#cbo_prinsipal").focus();
		   return false;
         }
		 
		//buat_kode();	
		

		if(kodepo_beli.length == 0){
           alert("Maaf, Kode PO tidak boleh kosong");
		   $("#txt_tgl_beli").focus();
		   return false;
         }
		 
		if(tgl.length == 0){
           alert("Maaf, Tanggal Pembelian tidak boleh kosong");
		   $("#txt_tgl_beli").focus();
		   return false;
         }
		if(kode.length == 0){
           alert("Maaf, Kode Pembelian tidak boleh kosong");
		   $("#cbo_beli").focus();
		   return false;
         }	
		
		if (cek ==0){
			alert('Maaf, Anda belum memilik/cek data');
			return false;
		}
		
		for (var i = 1; i <= cek ; ++i) {
			//var id = $("#cek"+i).val();
			var jmlvalid = $("#jmlvalid"+i).val();
			var jml = $("#jum"+i).val();
			var kode_brg = $("#kode_brg"+i).val();
			var kode_supplier = $("#kode_supplier"+i).val();
			var cabang = $("#cabang"+i).val();
			var ket_pusat = $("#ket_pusat"+i).val();
			var ket_relokasi = $("#cbo_kode_relokasi"+i).val();
			var jmlvalidrelokasi = $("#jmlvalidrelokasi"+i).val();
			var cabangrelokasi = $("#cbo_cabang_relokasi"+i).val();
			//buat_kode();
			$.ajax({
			type	: "POST",
			url		: "modul/lunas/simpan.php",
			data	: "kodepo_beli="+kodepo_beli+
						"&kode="+kode+
						"&kodeuser="+kodeuser+
						"&tgl="+tgl+
						"&jml="+jml+
						"&jmlvalid="+jmlvalid+
						"&kode_brg="+kode_brg+
						"&ket_pusat="+ket_pusat+
						"&kode_supplier="+kode_supplier+
						"&cabang="+cabang+
						"&ket_relokasi="+ket_relokasi+
						"&jmlvalidrelokasi="+jmlvalidrelokasi+
						"&cabangrelokasi="+cabangrelokasi+
						"&prins="+prins,
			success	: function(data){
				$("#ket").html(data);
				//alert('OK');
			}
			});
		}
		
	});

});
</script>
<style type="text/css">
.klik {  
     background:#090; 
}     
</style>

<?php
include '../../inc/inc.koneksi.php';
$kode	= $_POST[kode];

echo "<table id='theList' class='retur' width='100%'>
		<tr>
			<th width='2%'>No.</th>
			<th width='2%'>Cek</th>
			<th>NoDIH</th>
			<th>Kode Pelanggan</th>
			<th>No Order</th>
			<th>Value Order</th>
			<th>Saldo Order</th>
			<th>Value Pelunasan</th>
		</tr>";
				
		$sql = "SELECT a.NoDIH as dih ,a.NoOrder as ord,a.KodePelanggan as pel,a.Value as val,(a.Value -  IFNULL(b.lun,0)) as sal 
                        FROM t_dih a
                    LEFT JOIN (SELECT NoOrder,KdPelanggan,SUM(ValuePelunasan) AS lun 
                                FROM t_lunas GROUP BY KdPelanggan,NoOrder)
                    	b ON a.NoOrder=b.NoOrder 
                    WHERE a.STATUS ='OpenDIH' AND a.NoDIH='$kode'";		
		//echo $sql;
		$query = mysql_query($sql);
		
		$no=1;
		while($r_data=mysql_fetch_array($query)){
			$total	= $r_data[jumlah_beli]*$r_data[harga_beli];
			//echo $qre;
            echo "
                <td align='center'>$no</td>
				<td align='center'><input type='checkbox' value='$r_data[NoOrder]' class='cek' id='cek$no'>
                <td align='center'>$r_data[dih]</td>
                <td align='center'>$r_data[pel]</td>
                <td align='center'>$r_data[ord]</td>
                <td align='center'>$r_data[val]</td>
                <td align='center'>$r_data[sal]</td>
                <td align='center'><input type='text' class='jmlvalid' id='jmlvalid$no' size='20' >
            </td></tr>";
/**
 * 			echo "<tr>
 * 					<td align='center'>$no</td>
 * 					<td align='center'><input type='checkbox' value='$r_data[kode_barang]' class='cek' id='cek$no'>
 * 					<input type='hidden' name='kode_brg$no'  id='kode_brg$no' value='$r_data[kode_barang]' >
 * 					<input type='hidden' name='kode_supplier$no'  id='kode_supplier$no' value='$r_data[kode_supplier]' >
 * 					<input type='hidden' name='cabang$no'  id='cabang$no' value='$r_data[cabang]' >
 * 					<input type='hidden' name='jum$no'  id='jum$no' value='$r_data[jumlah_beli]' >
 * 					</td>
 * 					<td align='center'>$r_data[namasupplier]</td>
 * 					<td>$r_data[kode_barang]</td>
 * 					<td>$r_data[namaproduk]</td>
 * 					<td align='center'>$r_data[jumlah_beli]</td>
 * 					<td align='center'>$r_data[diskon]</td>
 * 					<td align='center'>$r_data[satuan]</td>
 * 					<td align='center'>$r_data[ket_prinsipal]</td>
 * 					<td align='center'>$r_data[averg]</td>
 * 					<td align='center'>$r_data[stok]</td>
 * 					<td align='center'>$r_data[ratio]</td>
 * 					<td align='center'>$r_data[ket_cabang]</td>
 * 					<td align='center'>$r_data[status_barang]</td>
 * 					<td align='center'><input type='text' class='jmlvalid' id='jmlvalid$no' size='5' ></td>
 * 					<td align='center'><input type='text'  id='ket_pusat$no'  ></td>
 * 				</td></tr>";
 */
			$no++;
			$g_total = $g_total+$total;
		} ?>
	</table>
	<table width='100%'>
		<tr>
			<td><div id='tot_cek'></div></td>
		</tr>
	</table>
	
	<table width='100%'>
		<tr>
		  <td align='center'><button name='simpan_pobeli' id='simpan_pobeli'>SIMPAN</button>

			</td>
		</tr>
		</table>
