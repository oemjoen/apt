// JavaScript Document

function Left(str, n){
	if (n <= 0)
	    return "";
	else if (n > String(str).length)
	    return str;
	else
	    return String(str).substring(0,n);
}
function Right(str, n){
    if (n <= 0)
       return "";
    else if (n > String(str).length)
       return str;
    else {
       var iLen = String(str).length;
       return String(str).substring(iLen, iLen - n);
    }
}

$(document).ready(function() {
	//membuat text kode barang menjadi Kapital
	$("#txt_kode_barang").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});

	// format datepicker untuk tanggal
	$("#txt_tgl_beli").datepicker({
	  dateFormat      : "dd-mm-yy",        
	  showOn          : "button",
	  buttonImage     : "images/calendar.gif",
	  buttonImageOnly : true,
	  currentText	  : "Now",
      minDate         : "-0d",
      maxDate         : "+7d"
	});
//	$("#txt_tgl_beli").datepicker("setDate", Now.Date);

	$("#txt_tgl_beli_list").datepicker({
	  dateFormat      : "dd-mm-yy",        
	  showOn          : "button",
	  buttonImage     : "images/calendar.gif",
	  buttonImageOnly : true,
	  currentText	  : "Now",
      minDate         : "-0d",
      maxDate         : "+7d"
	});
	
	//hanya angka yang dapat dientry
	$("#txt_jumlah").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
		{
			return false;
		}
	});

	$("#txt_bonus").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
		{
			return false;
		}
	});
	
	$("#txt_hargajual").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
		{
			return false;
		}
	});

	function cekratio(){
		var nilairatio	= $("#txt_ratio").val();

		if (nilairatio >= 2) {
			document.getElementById("txt_ratio").style.backgroundColor = "red";
		}else{
			document.getElementById("txt_ratio").style.backgroundColor = "#00FFFF";
		}
		
	}

	function disableTxt() {
		//document.getElementById("txt_diskon").disabled = true;
		//document.getElementById("txt_diskon").style.backgroundColor = "red";
		//cekratio();
	}
	function undisableTxt() {
		//document.getElementById("txt_diskon").disabled = false;
		//document.getElementById("txt_diskon").style.backgroundColor = "white";
		//cekratio();
	}
		
	//disableTxt();
	
	// $("#txt_kode_barang").keyup(function(){
			// var kodeprins	= $("#txt_prinsipal_prod").val();
			// var kodeekat	= $("#txt_kode_barang").val();			
	
			// if ((kodeprins == 24) && (kodeekat.substring(0,2) != "EK")) {
				//$("#txt_diskon").val('');
				// undisableTxt();
			// }else{
				// $("#txt_diskon").val('');
				// disableTxt();
			// }
		// });

	// $("#txt_kode_barang").focus(function(){
			// var kodeprins	= $("#txt_prinsipal_prod").val();
			// var kodeekat	= $("#txt_kode_barang").val();			
	
			// if ((kodeprins == 24) && (kodeekat.substring(0,2) != "EK")) {
				//$("#txt_diskon").val('');
				// undisableTxt();
			// }else{
				// $("#txt_diskon").val('');
				// disableTxt();
			// }
		// });	

	// $("#txt_kode_barang").blur(function(){
			// var kodeprins	= $("#txt_prinsipal_prod").val();
			// var kodeekat	= $("#txt_kode_barang").val();			
	
			// if ((kodeprins == 24) && (kodeekat.substring(0,2) != "EK")) {
				//$("#txt_diskon").val('');
				// undisableTxt();
			// }else{
				// $("#txt_diskon").val('');
				// disableTxt();
			// }
		// });

	// $("#txt_jumlah").focus(function(){
			// var kodeprins	= $("#txt_prinsipal_prod").val();
			// var kodeekat	= $("#txt_kode_barang").val();			
	
			// if ((kodeprins == 24) && (kodeekat.substring(0,2) != "EK")) {
				//$("#txt_diskon").val('');
				// undisableTxt();
			// }else{
				// $("#txt_diskon").val('');
				// disableTxt();
			// }
		// });
	
	function kosong(){
		$(".detail_readonly").val('');
		$(".input_detail").val('');
	}
	
	function cari_nomor() {
		var no		= 1;
		var cabang1	= $("#textcabang").val();
		var tgl		= $("#txt_tgl_beli").val();	
		var noerdit = $("#kodeedit").val();
		var kap = $("#textKodeAP").val();
		
		
		$.ajax({
			type	: "POST",
			url		: "modul/pelunasan/cari_nomor.php",
			data	: "&tgl="+tgl+"&cabang1="+cabang1+"&noerdit="+noerdit+"&kap="+kap,
			dataType : "json",
			success	: function(data){
				$("#txt_kode_beli").val(data.nomor);
				$("#cbo_supplier").val(data.supp);
				$("#txt_tgl_beli").val(data.tglpredit);
				tampil_data();
			}
		});		
	}

	function tampil_data() {
		var kode 	= $("#txt_kode_beli").val();
		$.ajax({
				type	: "POST",
				url		: "modul/pelunasan/tampil_data.php",
				data	: "kode="+kode,
				//timeout	: 6000,
				beforeSend	: function(){		
					$("#info").html("<img src='loading.gif' />");			
				},				  
				success	: function(data){
					$("#info").html(data);
				}
		});			
	}

	
	cari_nomor();
	
//	$("#txt_kode_barang").autocomplete("modul/pelunasan/list_barang.php?cabang=$('#txt_kode_barang').val()&kodeAP=$('#textKodeAP').val()", {
//				width:250,
//				max: 10,
//				scroll:true,
//	});
//
    var kd = $('#textcabang').val();
    var ap = $('#textKodeAP').val();
	$("#txt_kode_barang").autocomplete("modul/pelunasan/list_barang.php?kd="+kd+"&ap="+ap, {
				width:250,
				max: 10,
				scroll:true,
	});

	
	function cari_kode() {
		var kode	= $("#txt_kode_barang").val();
		var cabang	= $("#textcabang").val();
		var kodepr	= $("#txt_kode_beli").val();
		
		$.ajax({
			type	: "POST",
			url		: "modul/pelunasan/cari_barang.php",
			data	: "kode="+kode+"&cabang="+cabang+"&kodepr="+kodepr,
			dataType : "json",
			success	: function(data){
				//alert (cabang); 
				$("#txt_tgl").val(data.TglOrder);
				$("#txt_kodepel").val(data.KodePelanggan);
				$("#txt_namapel").val(data.namapel);
				$("#txt_total").val(data.total);
				$("#txt_saldo").val(data.saldo);
				$("#txt_total1").val(data.total1);
				$("#txt_saldo1").val(data.saldo1);
				$("#txt_kode_sls").val(data.sls);
				//$("#txt_jumlah").focus();
			}
		});	
		cekratio();
	}
	
	$("#txt_kode_barang").keyup(function() {
		cari_kode();
		//cekratio();
	});
	$("#txt_kode_barang").focus(function() {
		cari_kode();
		//cekratio();
	});
	
	//mengalikan jumlah dengan harga
	// $("#txt_jumlah").keyup(function(){
		// var jml		= $("#txt_jumlah").val();
		// var harga	= $("#txt_harga").val();
		// if (jml.length!='') {
			// var total	= parseInt(jml)*parseInt(harga);
			// $("#txt_total").val(total);
		// }else{
			// $("#txt_total").val(0);
		// }
	// });
	
	$("#cbo_retail").change(function() {
		var	koder	= $("#cbo_retail").val();
		var cabang1 = $("#textcabang").val();
		$.ajax({
			type	: "POST",
			url		: "modul/pelunasan/tampil_limit.php",
			data	: "koder="+koder+"&cabang1="+cabang1,
			success	: function(data){
				$("#info2").html(data);
				$("#txt_kode_barang").focus();
			}
		});		
	});	



	$("#tambah_detail").click(function(){
		kosong();	
		$("#txt_kode_barang").focus();
	});

	
	$("#simpan").click(function(){
		var kode			= $("#txt_kode_beli").val();	
		var TglDIH          = $("#txt_tgl_beli").val();	
		var noOrder			= $("#txt_kode_barang").val();	
		var tglF			= $("#txt_tgl").val();	
		var sls             = $("#cbo_retail").val();
		var kpel			= $("#txt_kodepel").val();
		var kdsls           = $("#txt_kode_sls").val();
		var kap   			= $("#textKodeAP").val();
		var tot				= $("#txt_total1").val();
		var sld   			= $("#txt_saldo1").val();
		var cabang			= $("#textcabang").val();	
		var username		= $("#textusername").val();	

		var error = false;
		
		//alert(reta.length);

	if(kode.length == 0){
	   var error = true;
	   alert("Maaf, Kode DIH tidak boleh kosong");
	   $("#txt_kode_beli").focus();
	   return (false);
        }
    

	if(sls.length == 0){
           var error = true;
           alert("Maaf, Penagih tidak boleh kosong");
		   $("#txt_kode_beli").focus();
		   return (false);
        }


	if(TglDIH.length == 0){
           var error = true;
           alert("Maaf, Tanggal DIH tidak boleh kosong");
		   $("#txt_tgl_beli").focus();
		   return (false);
         }

	if(noOrder.length == 0){
           var error = true;
           alert("Maaf, Nomor Order tidak boleh kosong");
		   $("#txt_kode_barang").focus();
		   return (false);
        }
	 

		if(error == false){
		  document.getElementById("cbo_retail").disabled = true;
			$.ajax({
				type	: "POST",
				url		: "modul/pelunasan/simpan.php",
				data	: "kode="+kode+
							"&TglDIH="+TglDIH+
							"&noOrder="+noOrder+
							"&tglF="+tglF+
							"&sls="+sls+
							"&kpel="+kpel+
							"&kap="+kap+
							"&tot="+tot+
							"&sld="+sld+
                            "&kdsls="+kdsls+
							"&username="+username+
							"&cabang="+cabang,
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
		return (false); 
	});
	
	$("#cetak2").click(function() {
		var kode	= $("#txt_kode_beli").val();
		var error = false;
		
		if(kode.length == 0){
           var error = true;
           alert("Maaf, Kode Pembelan tidak boleh kosong");
		   $("#txt_kode_beli").focus();
		   return (false);
         }
		window.location.href="modul/laporan/cetak_pr.php?kode="+kode;
	});

	$("#tambah_beli").click(function() {
		window.location.href='media.php?module=dih';
		$(".input").val('');
		kosong();
		cari_nomor();
		$("#txt_tgl_beli").focus();
	});

	$("#keluar").click(function(){
		document.location='?module=home';
	});

});

