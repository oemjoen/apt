<?php
$page = $_SERVER['PHP_SELF'];
$sec = "10";
include 'inc/cek_session.php';
include 'inc/inc.koneksi.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<!--<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page.'?module=home'?>'">-->
<title>E-APT</title>
<link rel="stylesheet" href="css/icon.css" type="text/css" />
<link rel="stylesheet" href="css/superfish.css" type="text/css" />
<link rel="stylesheet" href="css/style_content.css" type="text/css" />
<link rel="stylesheet" href="css/style_tabel.css" type="text/css" />


<script type="text/javascript" src="js/jquery-1.4.js"></script>
<script type="text/javascript" src="js/hoverIntent.js"></script>
<!-- untuk menu superfish -->
<script type="text/javascript" src="js/superfish.js"></script>

<!-- untuk datepicker -->
<link type="text/css" href="css/ui.all.css" rel="stylesheet" />   
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.datepicker.js"></script>
<script type="text/javascript" src="js/ui.datepicker-id.js"></script>

<!-- untuk autocomplite -->
<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>

<!-- plugin untuk tab -->
<link type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	   $('ul.sf-menu').superfish();
  });
</script>
</head>

<body>
<div class="box">
<div class="border">
<div class="style">
	<div class="header">
    	<span class="title">
        	<div align="center">
<!--        		<img src="images/header.jpg" width="840" height="120" />-->
            </div>
        </span>
    </div>
	<div class="menu">
   	 	<ul class="sf-menu">
			<li><a href="?module=home" class="icon home">Home</a></li>	
			<?php 
				//echo $userrr;
				//if ($cabangrr=='KPS'){ ?>
				<li>
					<a href="#" class="icon master">Order</a>
					<ul>				
<!--						<li><a href="?module=smsg" class="icon listdata">SMS Order</a></li>
-->						<li><a href="?module=ord" class="icon listdata">Buat Order</a></li>
						<li><a href="?module=ordli" class="icon listdata">List Order</a></li>
						<li><a href="?module=spli" class="icon listdata">List SP</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="icon master">Pelunasan</a>
					<ul>				
                        <li><a href="?module=dih" class="icon listdata">Buat DIH</a></li>
                        <li><a href="?module=lns" class="icon listdata">Buat Pelunasan</a></li>
                    </ul>
				</li>					
          <li><a href="logout.php" class="icon keluar">Keluar</a></li>	
		</ul>
    </div>
	<!--awal content -->
    <div class="content">
    	<?php
			include 'content.php';
		?>
    </div>
    <!--akhir content -->
    <div class="footer" align="center">
    	<p>Copyright &copy; Team IT <span class="cls_hdt">APT</span> 2017</p>
    	<p align="right">E-APT <span class="cls_hdt">Ver 1.0</span>.1.1.17</p>
    </div>
</div>
</div>
</div>

</body>
</html>