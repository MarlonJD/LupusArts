<?php require_once('Connections/lupus.php'); ?>
<?php require_once('counter.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_lupus, $lupus);
$query_Recordset1 = "SELECT * FROM images ORDER BY id DESC";
$Recordset1 = mysql_query($query_Recordset1, $lupus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_lupus, $lupus);
$query_Recordset2 = "SELECT distinct category FROM images";
$Recordset2 = mysql_query($query_Recordset2, $lupus) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_lupus, $lupus);
$query_Recordset3 = "SELECT * FROM images ORDER BY id DESC";
$Recordset3 = mysql_query($query_Recordset3, $lupus) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_lupus, $lupus);
$query_Recordset4 = "SELECT * FROM coms";
$Recordset4 = mysql_query($query_Recordset4, $lupus) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

function kacYorum($fonsiyonid, $database_lupus, $lupus) { 
mysql_select_db($database_lupus, $lupus);
$query_Recordset5 = sprintf("SELECT * FROM coms WHERE id = %s", GetSQLValueString($fonsiyonid, "int"));
$Recordset5 = mysql_query($query_Recordset5, $lupus) or die(mysql_error());
return $totalRows_Recordset5 = mysql_num_rows($Recordset5);

}


function boslukSil($string)
{
   $string = preg_replace("/\s+/", "", $string);
   $string = trim($string);
   return $string;
}

$i="0";
function kalanBul($bu, $buna) {
   global $kalan;
   $kalan = $bu % $buna;
	global $i;
	if ($kalan==1) { echo "btn btn-danger btn-sm"; }
	if ($kalan==2) { echo "btn btn-warning btn-sm"; }
 	if ($kalan==3) { echo "btn btn-success btn-sm"; }
 	if ($kalan==0) { echo "btn btn-primary btn-sm"; }

}
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="This website is a gallery of the personel artworks" />
    <meta name="author" content="Burak Karahan, burak.karahan@mail.ru" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Lupus Arts - Art Gallery</title>
    <!-- BOOTSTRAP STYLE SHEET -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- STYLE FOR OPENING IMAGE IN POPUP USING FANCYBOX-->
    <link href="assets/js/source/jquery.fancybox.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!--Font Awesome -->
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/loader.css">
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC:700' rel='stylesheet' type='text/css'>
    <style type="text/css">
    body,td,th {
	font-family: "Amatic SC", cursive;
}
    </style>
</head>
<body>

<div id="preloader">
	<div id="status"></div>
	<div id="loaderImage"></div>
</div>

    <!-- NAVBAR CODE END -->
    <section id="intro" data-speed="5" data-type="background">
		<div class="container">
			<div class="row-fluid">
		        <div class="span4 text-center">
		          <h2>Lupus Arts</h2>
		        </div>
		        <div class="span8 text-center">
		           <div class="social-media hidden-xs">
                    <a href="https://www.facebook.com/aneta.snihur" target="_blank" class="fa fa-facebook" data-toggle="tooltip" title="Facebook"></a>
                    <a href="https://www.instagram.com/lupusek/" target="_blank" class="fa fa-instagram" data-toggle="tooltip" title="Instagram"></a>
                    <a href="http://lupusowa.deviantart.com/" target="_blank" class="fa fa-deviantart" data-toggle="tooltip" title="Devianart"></a>
                    <a href="https://www.facebook.com/LupusowaArt/" target="_blank" class="fa fa-facebook" data-toggle="tooltip" title="Facebook"></a>
                </div>
		        </div>
	    	</div>
	    	<div class="hero-unit text-center">
                      Total Visitor: <span class="timer-visitor badge">0</span><br>
Total Comment: <span class="timer-visitor2 badge">0</span>    
	    	</div>
	    </div>
	</section>
    
    <!--Section 2 /-->
    <section id="home" data-speed="2" data-type="background">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12 col-sm-12">
 <!-- FILTER PORTFOLIO START -->
        <div class="row text-center" >
            <div class="col-md-12">
                <!--<hr /-->
                <div class="caegories">
                            <a href="#"  data-filter="*" class="active btn btn-info btn-sm">All</a>
                            <?php do { ?>
                            <a href="#" data-filter=".<?php print boslukSil($row_Recordset2['category']); ?>" class="<?php $i++; kalanBul($i,4); ?>"><?php echo $row_Recordset2['category']; ?></a>
                              <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
                    <hr />
                </div>
            </div>
        </div>
        <div class="row text-center" id="portfolio-div">
            <?php do { ?>
            <div class="col-md-4 col-sm-4 portfolio-item <?php print boslukSil($row_Recordset1['category']); ?>">
                  <div class="portfolio-img">
                  <img src="img/<?php echo $row_Recordset1['img']; ?>" class="img-responsive" alt="" />
                  </a>
                  </div>
			<div class="portfolio-content-wrap">
				                 <a class="fancybox fancybox.iframe" href="resim.php?id=<?php echo $row_Recordset1['id']; ?>" title="<?php echo $row_Recordset1['title']; ?>"><div class="potfolio-content">
					<h3 class="portfolio-title">
						<?php if (isset($row_Recordset1['title'])) { ?>
				<?php echo $row_Recordset1['title']; ?><?php } else { echo "Untitled"; } ?>
					</h3>
					<div class="portfolio-categories">
						<?php if (kacYorum($row_Recordset1['id'], $database_lupus, $lupus) != '0') { ?>
               			<h5> <i class="fa fa-comments-o" aria-hidden="true"></i> 
						<?php echo kacYorum($row_Recordset1['id'], $database_lupus, $lupus); ?></h5>
						<?php } ?>
                        <h6>Click for leave comments</h6>
					</div>
                    
				</div></a>
			</div>
                                        </br>

                
              </div>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

        </div>
        
        
         <!-- FILTER PORTFOLIO END -->       
            </div>

        </div>
    </div>
    </section>
    <section id="about" data-speed="4" data-type="background">
        <footer class="footer text-center">
      <div class="container">
        <span class="text-muted">Copyright © by Aneta Daria Śnihur<br>
These images may not be reproduced or used in any manner whatsoever without the express written permission of the publisher.<br>All rights reserved.</span>
      </div>
    </footer>
    </section>
    <!-- CONATINER END -->
    <!-- REQUIRED SCRIPTS FILES -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- REQUIRED BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!--  FANCYBOX PLUGIN -->
    <script src="assets/js/source/jquery.fancybox.js"></script>
    <!-- ISOTOPE SCRIPTS -->
    <script src="assets/js/jquery.isotope.js"></script>
    <!-- CUSTOM SCRIPTS REQIRED-->
    <script src="assets/js/custom.js"></script>
<script src="assets/js/init.js"></script>
<script src="assets/js/loader.js"></script>
    <script src="assets/js/jquery-countTo.js"></script>
<script type="text/javascript">
		var jsvar = <?php echo json_encode($counterVal); ?>;
		var yorum = <?php echo $totalRows_Recordset4 ?>;
	    $(".timer-visitor").countTo(jsvar, {"duration": 5});
		$(".timer-visitor2").countTo(yorum, {"duration": 5});
	</script> 
<script type="text/javascript">
$(".fancybox")
    .fancybox({
        openEffect  : 'none',
        closeEffect : 'none',
        nextEffect  : 'none',
        prevEffect  : 'none',
        padding     : 0,
        margin      : [10, 10, 10, 10] // Increase left/right margin
    });
                  </script>
</body>

</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

@mysql_free_result($Recordset5);
?>
