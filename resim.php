<?php require_once('Connections/lupus.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "yorum")) {
  $insertSQL = sprintf("INSERT INTO coms (id, name, text, ip) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['text'], "text"),
                       GetSQLValueString($_POST['ip'], "text"));

  mysql_select_db($database_lupus, $lupus);
  $Result1 = mysql_query($insertSQL, $lupus) or die(mysql_error());
}

$colname_Recordset3 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset3 = $_GET['id'];
}
mysql_select_db($database_lupus, $lupus);
$query_Recordset3 = sprintf("SELECT * FROM images WHERE id = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $lupus) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_lupus, $lupus);
$query_Recordset1 = sprintf("SELECT * FROM coms WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $lupus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

function GetIP(){
	if(getenv("HTTP_CLIENT_IP")) {
 		$ip = getenv("HTTP_CLIENT_IP");
 	} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 		$ip = getenv("HTTP_X_FORWARDED_FOR");
 		if (strstr($ip, ',')) {
 			$tmp = explode (',', $ip);
 			$ip = trim($tmp[0]);
 		}
 	} else {
 	$ip = getenv("REMOTE_ADDR");
 	}
	return $ip;
}

$ip_adresi = GetIP();

function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time() - 25200; 
    $unix_date         = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Başlıksız Belge</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC:700' rel='stylesheet' type='text/css'>
    <style type="text/css">
	body {
  font-family: 'Amatic SC', cursive;
  font-size: 29px;
  color: #777;
  background: #0a0a0a;
  background-image: -webkit-linear-gradient(#0f0f0f 1px, transparent 1px), -webkit-linear-gradient(left, #0f0f0f 1px, transparent 1px);
  background-image: linear-gradient(#0f0f0f 1px, transparent 1px), linear-gradient(to right, #0f0f0f 1px, transparent 1px);
  background-size: 3.33333vmin 3.33333vmin;
}
h1 {
	font-size:61px;
}

h2 {
	font-size:55px;
}

h3 {
	font-size:39px;
}

h4 {
	font-size:23px;
}

h5 {
	font-size:29px;
}

h6 {
	font-size:27px;
}

.badge {
    font-size: 27px;
}

.btn-sm, .btn-group-sm > .btn {
    font-size: 18px;
}

.baslik {
	font-size:28px;
	line-height: 35px;
	color: #BC0505;
}

.isim { 
	font-size:25px;
	color: #FFFFFF;
}

.yorum {
	font-size:21px;
}

.comments {
	  line-height: 25px;
}
.tarih {
	font-size:16px;
	}


	</style>
</head>
<body>
<div class="container">
	<div class="row"><!-- Row -->           
		<div class="col-xs-7">
            <div class="images">
				<img class="img-responsive" style="max-height: 540px;" src="img/<?php echo $row_Recordset3['img']; ?>" />
            </div>
			<?php echo $row_Recordset3['aciklama']; ?>
        </div><!-- /COL-XS-10 -->
     	<div class="col-xs-5">
    		<div class="comments">
    	      <span class="baslik">Comments</span><br><?php do { ?>
   	         <?php if (empty($row_Recordset1)){ echo "<span class='isim'>There is no comment for this Art...</span>"; } else { ?><span class="isim"><?php echo $row_Recordset1['name']; ?>: </span><span class="yorum"><?php echo $row_Recordset1['text']; ?></span><span class="tarih"> (<?php echo nicetime($row_Recordset1['date']);  ?>)</span><br>
    	      <?php } ?>  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
       		</div><!--/comments--><br>
            <form method="POST" action="<?php echo $editFormAction; ?>" name="yorum" id="yorum">
            <input name="user" type="text" autofocus required  class="form-control" id="user" placeholder="Your Name">
            <textarea name="text" maxlength="160" class="form-control" id="text" placeholder="Your Comment... (Max 160 Characters)"></textarea>
            <input name="id" type="hidden" id="id" value="<?php echo $row_Recordset3['id']; ?>">
            <input name="ip" type="hidden" id="ip" value="<?php echo $ip_adresi ?>">
            <input type="hidden" name="MM_insert" value="yorum">
            <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit">Send</button>
          </form>
   	  </div><!--/COL-CS-3-->
	</div><!-- /Row -->
</div><!-- /Container -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- REQUIRED BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!--  FANCYBOX PLUGIN -->
    <script src="assets/js/source/jquery.fancybox.js"></script>
    <!-- ISOTOPE SCRIPTS -->
    <script src="assets/js/jquery.isotope.js"></script>
    <!-- CUSTOM SCRIPTS REQIRED-->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/jquery-countTo.js"></script>
   
</body>
</html>
<?php
mysql_free_result($Recordset3);

mysql_free_result($Recordset1);
?>
