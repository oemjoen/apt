<?php
  include_once('../../inc/inc.koneksi.php');
  include_once('../../inc/fungsi_hdt.php');
  include_once('../../inc/fungsi_indotgl.php');
  
  date_default_timezone_set('Asia/Jakarta'); 
  
	
  	$kode	= $_GET[kode];
	
   		if(empty($kode)){
			echo "<h1>Maaf, data tidak ditemukan</h1><br>";
			//$query = "SELECT * FROM po_pembelian WHERE jumlah_beli_valid<>0";
		}else{
//		  SELECT * FROM t_order WHERE NoOrder='ORD/BDGAPCICAH/00001'
			$query 	= "SELECT a.`Cabang`, a.`KodeApotik`,b.`Nama Faktur` AS nmApt,a.`KodePelanggan`,
                        	d.`Nama Faktur` AS nmP,a.`KodeProduk`,c.`Produk`,c.`Satuan`,
                        	a.`NoOrder`,d.`Alamat`,a.TglOrder,b.Alamat AS apAlm
                        FROM t_order a, mpelanggan b, mproduk c, mretail d
                        WHERE a.NoOrder='$kode' AND
                        	a.`KodeProduk`=c.`Kode Produk` AND a.`KodeApotik`=b.`Kode` AND
                        	a.`KodePelanggan`=d.`Kode`";
			}	 
	
  	$sql 	= mysql_query($query);
	$row	= mysql_num_rows($sql);

    while($dataJud=mysql_fetch_array($sql)){
            $apotik = $dataJud['KodeApotik'];
            $apotikN = $dataJud['nmApt'];
            $apotikAlm = $dataJud['apAlm'];
            $apt = $dataJud['KodePelanggan'];
            $aptN = $dataJud['nmP'];
            $aptAlm = $dataJud['Alamat'];
            $tglOrd = $dataJud['TglOrder'];
        }
        
        
        
	$namacabang = cari_nama_cabang2($kode);
	$total_qty_po = total_barang_po($kode);
	$kode_pr = kode_pr_po($kode);
	$namasupp_po =nama_supplier_po($kode);
	$tanggal_po_beli = tgl_indo(tanggal_po($kode));
	
   if ($row>0) {
	
	//Definisi
    define('FPDF_FONTPATH','../font/');
    require('fpdf.php');

    class PDF extends FPDF{
        
    function garis(){
            $this->SetLineWidth(1);
            $this->Line(10,11,220,11);
            $this->SetLineWidth(0);
            $this->Line(10,12,220,12);
            }
	   function FancyTable(){
  	
		$kode	= $_GET[kode];   		
		if(empty($kode)){
/**
		 * 			$query = "SELECT a.*,b.`satuan` FROM po_pembelian a
		 * 						LEFT JOIN `mstproduk` b ON a.`kode_barang`=b.`kodeproduk` 
		 * 					WHERE a.jumlah_beli_valid<>0";
		 */		}else{
			$query 	= "SELECT a.`Cabang`, a.`KodeApotik`,b.`Nama Faktur`,
                        	d.`Nama Faktur` AS nmF,a.`KodeProduk`,c.`Produk`,c.`Satuan`,
                        	a.`NoOrder`,a.Banyak, a.Diskon, a.Total
                        FROM t_order a, mpelanggan b, mproduk c, mretail d
                        WHERE a.NoOrder='$kode' AND
                        	a.`KodeProduk`=c.`Kode Produk` AND a.`KodeApotik`=b.`Kode` AND
                        	a.`KodePelanggan`=d.`Kode`";
 		     } 
		
		
		
		$sql 	= mysql_query($query);
		$row	= mysql_num_rows($sql);

		
		$w=array(5,15,15,105,20,30,15);
	    //$w=array(10,22,60,20,20,20,20,20);

		$no=1;
        $totval=0;
        while($data=mysql_fetch_array($sql)){
			$popusatket = produk_pusat_po($data['KodeProduk']);
			if (empty($popusatket)){$popusatket = $data['ket_prinsipal'];}
			
			$diskonitem = produk_diskon_popr($data['NoOrder'],$data['KodeProduk']);
			
			$hargabeliproduk = "";
					  	
		  $this->SetFont('arial','',10);
		  $this->Cell($w[0],6,$no,1,0,'C',$fill);
		  $this->Cell($w[1],6,$data['Banyak'],1,0,'C',$fill);
		  $this->Cell($w[2],6,$data['Satuan'],1,0,'L',$fill);
		  $this->SetFont('arial','',10);
		  $this->Cell($w[3],6,$data['Produk'],1,0,'L',$fill);
		  $this->SetFont('arial','',8);		  
		  $this->Cell($w[4],6,$data['KodeProduk'],1,0,'L',$fill);
		  $this->SetFont('arial','',7);
		  $this->Cell($w[6],6,$data['Diskon'],1,0,'C',$fill);
		  $this->Cell($w[5],6,number_format($data['Total']),1,0,'R',$fill);
          $this->Ln();  
		  $no++;
          $totval = $totval + intval($data['Total']);
        }
        	$this->Cell(array_sum($w),0,'','T');
            $this->Ln(1); 
        	$this->SetFont('arial','B',10);	
        	$this->Cell(210,5,'Total    : Rp. '.number_format($totval),0,1,'R',false);
      }
	}
	
    //Instanciation of inherited class
	$A4[0]=210;
	$A4[1]=297;
	$Q[0]=216;
	$Q[1]=279;
	$S[0]=230;
	$S[1]=290;
    $pdf=new PDF('P','mm',$S);
//	$pdf->SetMargins(1,1,1,1);
	$pdf->SetTopMargin(1);	
    $pdf->Open();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTitle('ORDER');
    $pdf->SetAuthor('(c) SST-ITEDP');
    $pdf->SetCreator('AP MITRA with fpdf');
//	$tgl = date('d M Y');
	$tgl = $tglOrd;
//	$pdf->Image('images/logo_sp.png',11,2,100);
//	$pdf->Ln(2);
    $pdf->garis();    
    $pdf->SetFont('arial','B',13);
    $pdf->Cell(0,5,$apotikN,0,1,'L');
    $pdf->Cell(0,5,$apotikAlm,0,1,'L');
	$pdf->Ln(2);
    $pdf->SetFont('arial','B',12);
    $pdf->Cell(0,5,'ORDER',0,1,'C');
	$pdf->Ln(2);
    $pdf->SetFont('arial','B',9);
    $pdf->Cell(105,5,'No. ORDER        : '.$kode,0,0,'L');
    $pdf->Cell(105,5,'Kepada Yth: ',0,1,'R');
    $pdf->Cell(105,5,'Tanggal              : '.tgl_indo($tgl),0,0,'L');
	$pdf->Cell(105,5,$aptN,0,1,'R');
	$pdf->Cell(210,5,$aptAlm,0,1,'R');
    $pdf->SetX(10);
	$pdf->Ln(1);
	$pdf->SetFont('arial','B',8);
	$pdf->SetLineWidth(.1);
	$pdf->SetFillColor(229,229,229);
	$pdf->Cell(5,5,'No.',1,0,'C',true);
	$pdf->Cell(15,5,'Qty',1,0,'C',true);
	$pdf->Cell(15,5,'Satuan',1,0,'C',true);
	$pdf->Cell(105,5,'Nama Barang',1,0,'C',true);
	$pdf->Cell(20,5,'Kode Barang',1,0,'C',true);
	$pdf->Cell(15,5,'Disc(%)',1,0,'C',true);
	$pdf->Cell(30,5,'Value',1,1,'C',true);
	$pdf->SetFont('arial','',12);
	$pdf->SetLineWidth(.1);
	$pdf->FancyTable();	
	$pdf->Ln(1);
 
	$pdf->Ln(1);
	$pdf->SetFont('arial','',7);	
	$pdf->Cell(60,3,'Penerima Pesanan, ',0,0,'C',false);
	$pdf->Cell(60,3,'Pemesan, ',0,0,'C',false);
	$pdf->Cell(60,3,'Mengetahui, ',0,1,'C',false);
	$pdf->Cell(60,3,'Penanggung Jawab',0,0,'C',false);
	$pdf->Cell(60,3,'Apoteker Penanggung Jawab',0,0,'C',false);
	$pdf->Cell(60,3,'Penanggung Jawab',0,1,'C',false);
		
	$pdf->Ln(10);
	$pdf->Cell(60,3,'_______________________',0,0,'C',false);
	$pdf->Cell(60,3,'_______________________',0,0,'C',false);
	$pdf->Cell(60,3,'_______________________',0,1,'C',false);
	$pdf->Cell(60,3,'Cap & Nama',0,0,'C',false);
	$pdf->Cell(60,3,'Cap & Nama',0,0,'C',false);
	$pdf->Cell(60,3,'Cap & Nama',0,1,'C',false);
	$pdf->Cell(60,3,'',0,0,'C',false);
	$pdf->Cell(60,3,'',0,0,'C',false);
	$pdf->Cell(60,3,'',0,1,'C',false);
	
	$pdf->SetFont('arial','I',5);
	$pdf->Cell(60,3,'*',0,0,'L',false);
	$pdf->Cell(60,3,'*',0,0,'L',false);
	$pdf->Cell(60,3,'*',0,1,'L',false);	
	
	$pdf->Output('Order_'.$apotik.'_'.$kode.'.pdf','D'); //D=Download, I= ,
  } else {
    echo "<h1>Maaf, data tidak ditemukan</h1><br>";
  }
?>