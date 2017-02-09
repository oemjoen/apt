// JavaScript Document
$(document).ready(function() {

	function kosong(){
		$("#kodeproduk").val('');
		$("#nama_barang").val('');
		$("#satuan").val('');
		$("#text_isi_satuan").val('');		
		$("#text_berat_satuan").val('');
		$("#text_prinsipal").val('');
		$("#text_supplier").val('');
		$("#text_kat_khusus").val('');
		$("#text_kandungan").val('');
		$("#text_sediaan").val('');

	}
	
	var hal =0;
	$.ajax({
			type	: "GET",
			url		: "modul/barang/tampil_data.php",
			data	: "hal="+hal,
			//timeout	: 3000,
			beforeSend	: function(){		
				$("#info").html("<img src='loading.gif' />");			
			},				  
			success	: function(data){
				$("#info").html(data);
			}
	});	
	
	function barangbaru() {
		var hal =0;

		$.ajax({
				type	: "GET",
				url		: "modul/barang/tampil_data_pb.php",
				data	: "hal="+hal,
				//timeout	: 3000,
				beforeSend	: function(){		
					$("#info").html("<img src='loading.gif' />");			
				},				  
				success	: function(data){
					$("#info").html(data);
				}
		});		
	}
	
	$("#prodbaru").click(function(){
		barangbaru();	
		kodeproduk.focus();
	});
	
	$("#tambah").click(function(){
		kosong();	
		kodeproduk.focus();
	});

	$("#kodeproduk").autocomplete("modul/barang/list_barang.php", {
				width:100,
				//max: 10,
				scroll:true,
	});
	
	function cari_kode() {
		var kode	= $("#kodeproduk").val();
				
		$.ajax({
			type	: "POST",
			url		: "modul/barang/cari.php",
			data	: "kode="+kode,
			dataType: "json",
			success	: function(data){
				$("#kodeproduk").val(kode);
				$("#nama_barang").val(data.nama_barang);
				$("#satuan").val(data.satuan);
				$("#text_isi_satuan").val(data.text_isi_satuan);
				$("#text_berat_satuan").val(data.text_berat_satuan);
				$("#text_prinsipal").val(data.text_prinsipal);
				$("#text_supplier").val(data.text_supplier);
				$("#text_kat_khusus").val(data.text_kat_khusus);
				$("#text_kandungan").val(data.text_kandungan);
				$("#text_sediaan").val(data.text_sediaan);

			}
		});		
	}
	
	$("#kodeproduk").keyup(function() {
		cari_kode();
	});
	$("#kodeproduk").focus(function() {
		cari_kode();
	});

/*	$("#nama_barang").autocomplete("modul/barang/list_nama_barang.php", {
				width:300,
				//max: 10,
				scroll:true,
	});
	
	function cari_nama() {
		var kode	= $("#nama_barang").val();
				
		$.ajax({
			type	: "POST",
			url		: "modul/barang/cari_nama.php",
			data	: "kode="+kode,
			dataType: "json",
			success	: function(data){
				$("#kodeproduk").val(kode);
				$("#nama_barang").val(data.nama_barang);
				$("#satuan").val(data.satuan);
				$("#text_isi_satuan").val(data.text_isi_satuan);
				$("#text_berat_satuan").val(data.text_berat_satuan);
				$("#text_prinsipal").val(data.text_prinsipal);
				$("#text_supplier").val(data.text_supplier);
				$("#text_kat_khusus").val(data.text_kat_khusus);
			}
		});		
	}
	
	$("#nama_barang").keyup(function() {
		cari_nama();
	});
	$("#nama_barang").focus(function() {
		cari_nama();
	});*/
	


	$("#simpan").click(function(){
				
		var	kodeproduk				= $("#kodeproduk").val();
		var	nama_barang				= $("#nama_barang").val();
		var	satuan					= $("#satuan").val();
		var	text_isi_satuan			= $("#text_isi_satuan").val();		
		var	text_berat_satuan		= $("#text_berat_satuan").val();
		var text_prinsipal			= $("#text_prinsipal").val();
		var text_supplier			= $("#text_supplier").val();
		var text_kat_khusus			= $("#text_kat_khusus").val();
		var textcabang				= $("#textcabang").val();
		var textusername			= $("#textusername").val();
		var textkandungan			= $("#text_kandungan").val();
		var textsediaan				= $("#text_sediaan").val();
		
		var error = false;

		if(kodeproduk.length == 0){
           var error = true;
           alert("Maaf, Kode barang tidak boleh kosong");
		   $("#kodeproduk").focus();
		   return (false);
         }
		if(nama_barang.length == 0){
           var error = true;
           alert("Maaf, Nama Barang tidak boleh kosong");
		   $("#nama_barang").focus();
		   return (false);
         }
		if(satuan.length == 0){
           var error = true;
           alert("Maaf, Satuan tidak boleh kosong");
		   $("#satuan").focus();
		   return (false);
         }

		 		 
		if(error == false){
		$.ajax({
			type	: "POST",
			url		: "modul/barang/simpan.php",
			data	: "kodeproduk="+kodeproduk+
					"&nama_barang="+nama_barang+
					"&satuan="+satuan+
					"&text_isi_satuan="+text_isi_satuan+
					"&text_berat_satuan="+text_berat_satuan+
					"&text_prinsipal="+text_prinsipal+
					"&text_supplier="+text_supplier+
					"&textcabang="+textcabang+
					"&textkandungan="+textkandungan+
					"&textsediaan="+textsediaan+
					"&textusername="+textusername+
					"&text_kat_khusus="+text_kat_khusus,
			//timeout	: 3000,
			beforeSend	: function(){		
				$("#info").show();
				$("#info").html("<img src='loading.gif' />");			
			},				  
			success	: function(data){
				$("#info").show();
				$("#info").html(data);
			}
		});
		}
		return false; 
	});

	$("#hapus").click(function(){
				
		var	kodeproduk		= $("#kodeproduk").val();
		var	nama_barang		= $("#nama_barang").val();
	
		var error = false;

		if(kodeproduk.length == 0){
           var error = true;
           alert("Maaf, Kode barang tidak boleh kosong");
		   $("#kodeproduk").focus();
		   return (false);
         }
		if(nama_barang.length == 0){
           var error = true;
           alert("Maaf, Nama Barang tidak boleh kosong");
		   $("#nama_barang").focus();
		   return (false);
         }

		 		 
		if(error == false){
		$.ajax({
			type	: "POST",
			url		: "modul/barang/hapus.php",
			data	: "kodeproduk="+kodeproduk,
			//timeout	: 3000,
			beforeSend	: function(){		
				$("#info").show();
				$("#info").html("<img src='loading.gif' />");			
			},				  
			success	: function(data){
				$("#info").show();
				$("#info").html(data);
				kosong();
			}
		});
		}
		return false; 
	});


	$("#keluar").click(function(){
		document.location='?module=home';
	});

});

