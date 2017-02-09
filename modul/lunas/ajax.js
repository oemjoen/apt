// JavaScript Document
$(document).ready(function() {
						   
/**
 * 	$("#txt_tgl_beli").datepicker({
 * 	  dateFormat      : "dd-mm-yy",        
 * 	  showOn          : "button",
 * 	  buttonImage     : "images/calendar.gif",
 * 	  buttonImageOnly : true,
 * 	  currentText	  : "Now",
 *       minDate         : "-0d",
 *       maxDate         : "+7d"				
 * 	});
 */
    
    	// format datepicker untuk tanggal
	$("#txt_tgl_beli").datepicker({
	  dateFormat      : "dd-mm-yy",        
	  showOn          : "button",
	  buttonImage     : "images/calendar.gif",
	  buttonImageOnly : true,
	  currentText	  : "Now",
      minDate         : "-0d",
      maxDate         : "+0d"
	});

	tampil_data();
	
	function tampil_data(){
		$("#info").load("modul/lunas/tampil_data.php");
	}

	/*
	var hal =0;
	$.ajax({
			type	: "GET",
			url		: "modul/lunas/tampil_data.php",
			data	: "hal="+hal,
			timeout	: 3000,
			beforeSend	: function(){		
				$("#info").html("<img src='loading.gif' />");			
			},				  
			success	: function(data){
				$("#info").html(data);
			}
	});	
	*/
	
	
	$("#cbo_kode").change(function() {
		//alert('tes');
		var tgl	= $("#txt_tgl_beli").val();
		var ap	= $("#ap").val();
		$.ajax({
			type	: "POST",
			url		: "modul/lunas/list_kode.php",
			data	: "tgl="+tgl,
			success	: function(data){
				$("#cbo_beli").html(data);
			}
		});

	});
	
	function buat_kode() {
		var	kode	= $("#txt_kode").val();
		var tgl		= $("#txt_tgl_beli").val();
		var prins	= $("#cbo_prinsipal").val();
		var cabang1 = $("#textcabang").val();
		$.ajax({
			type	: "POST",
			url		: "modul/lunas/buat_nomor.php",
			data	: "kode="+kode+"&tgl="+tgl+"&cabang1="+cabang1+"&prins="+prins,
			dataType: "json",
			success	: function(data){
				$("#txt_kode").val(data.kode_pobeli);
				//alert(data.kode_pobeli);
			}
		});		
	}
	
	$("#cari").click(function(){
		
		var	tgl		= $("#txt_tgl_beli").val();
		var	kode	= $("#cbo_beli").val();
        
        document.getElementById("cbo_beli").disabled = true;
	
		var error = false;

		if(tgl.length == 0){
           var error = true;
           alert("Maaf, Tanggal Pelunasan tidak boleh kosong");
		   $("#txt_tgl_beli").focus();
		   return (false);
         }
		if(kode.length == 0){
           var error = true;
           alert("Maaf, Kode DIH tidak boleh kosong");
		   $("#cbo_beli").focus();
		   return (false);
         }		 
		if(error == false){
		$.ajax({
			type	: "POST",
			url		: "modul/lunas/tampil_data.php",
			data	: "kode="+kode,
			//timeout	: 3000,
			beforeSend	: function(){		
				$("#info").html("<img src='loading.gif' />");			
			},				  
			success	: function(data){
				$("#info").html(data);
				//buat_kode();
			}
		});
		}
		return false; 
		
	});

	$("#cetak2").click(function() {
		var kode	= $("#txt_kode").val();
		window.location.href="modul/laporan/cetak_po.php?kode="+kode;
	});
	
	$("#cetakrel").click(function() {
		var kode	= $("#txt_kode").val();
		window.location.href="modul/laporan/cetak_po_relokasi.php?kode="+kode;
	});

	$("#tambah_po").click(function() {
		$(".input").val('');
		$("#txt_kode").val('');
		$("#txt_tgl_beli").val('');
		$("#cbo_beli").val('');
		$("#cbo_prinsipal").val('');
		location.reload(); 
		$("#txt_kode").focus();
	});

	$("#keluar").click(function(){
		document.location='?module=home';
	});

});

