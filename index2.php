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
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Lupus Gallery</title>
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
</head>
<body>

<div id="preloader">
	<div id="status"></div>
	<div id="loaderImage"></div>
</div>

    <!-- NAVBAR CODE END -->
    <div class="container">
        <div class="row text-center">
            <div class="col-md-2 lupus col-sm-2">
                <h2>Lupus Arts</h2>
               <div class="social-media hidden-xs">
                    <a href="https://www.facebook.com/aneta.snihur" target="_blank" class="fa fa-facebook" data-toggle="tooltip" title="Facebook"></a>
                    <a href="https://www.instagram.com/lupusek/" target="_blank" class="fa fa-instagram" data-toggle="tooltip" title="Instagram"></a>
                    <a href="http://lupusowa.deviantart.com/" target="_blank" class="fa fa-deviantart" data-toggle="tooltip" title="Devianart"></a>
                    <a href="https://www.facebook.com/LupusowaArt/" target="_blank" class="fa fa-facebook" data-toggle="tooltip" title="Facebook"></a>
                </div>

Total Visitor: <span class="timer-visitor badge">0</span>

            </div>
            <div class="col-md-10 col-sm-10">
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
            <div class="col-md-4 col-sm-4 <?php print boslukSil($row_Recordset1['category']); ?>">
                <a class="fancybox-media" title="<?php echo $row_Recordset1['aciklama']; ?>" href="img/<?php echo $row_Recordset1['img']; ?>">
                  <img src="img/<?php echo $row_Recordset1['img']; ?>" class="img-responsive " alt="" />
                </a>
                <h3><?php if (isset($row_Recordset1['title'])) { ?><?php echo $row_Recordset1['title']; ?><?php } ?></h3>
              </div>
              </br>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </div>
         <!-- FILTER PORTFOLIO END -->       
            </div>

        </div>
    </div>
    
        <footer class="footer text-center">
      <div class="container">
        <span class="text-muted">Copyright © by Aneta Daria Śnihur<br>
These images may not be reproduced or used in any manner whatsoever without the express written permission of the publisher.<br>All rights reserved.</span>
      </div>
    </footer>
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
    <script src="assets/js/loader.js"></script>
    <script src="assets/js/jquery-countTo.js"></script>
    <script type="text/javascript">
		var jsvar = <?php echo json_encode($counterVal); ?>;
	    $(".timer-visitor").countTo(jsvar, {"duration": 5});
	</script>

</body>

</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
