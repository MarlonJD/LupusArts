<?php require_once('Connections/lupus.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "sign.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "78912";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "sign.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
$query_Recordset2 = "SELECT * FROM coms ORDER BY `date` DESC";
$Recordset2 = mysql_query($query_Recordset2, $lupus) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
<title>The Admin Panel</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- STYLE FOR OPENING IMAGE IN POPUP USING FANCYBOX-->
    <link href="assets/js/source/jquery.fancybox.css" rel="stylesheet" />
    <!--Font Awesome -->
    <link type="text/css" rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link href="assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
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
		</style>
</head>

<body>
<div class="container">



<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Welcome Dear Aneta!</a>
    </div>
     <ul class="nav navbar-nav">
      <li><a href="/">Home</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?php echo $logoutAction ?>"><span class="glyphicon fa fa-ban fa-fw"></span>Logout</a></li>
    </ul>
  </div>
</nav>


      <!-- Jumbotron -->
      <div class="jumbotron">
      <form action="panel.php" method="post" enctype="multipart/form-data">
      <label class="control-label">Select File</label>
      <input name="fileToUpload" id="fileToUpload" type="file" accept="image/*" class="file-loading">
      </form>
        <h1>Upload new image!</h1>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-12">
          <h2>Images</h2>
          <p class="text-danger">If you click delete, there is no confirmation anymore. This image will be remove permanatly.</p>
          <p><?php do { ?>
   <div class="col-md-2 col-sm-2"><img src="img/<?php echo $row_Recordset1['img']; ?>" class="img-thumbnail"><?php echo $row_Recordset1['id']; ?> - <?php echo nicetime($row_Recordset1['date']); ?> 
<a class="btn btn-danger" href="delete.php?id=<?php echo $row_Recordset1['id']; ?>"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
<a class="btn btn-info" href="edit.php?id=<?php echo $row_Recordset1['id']; ?>"><i class="fa fa-pencil fa-lg"></i> Edit</a>
</div>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?></p>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <h2>Delete Some Comments</h2>
          <p class="text-danger">If you click delete, there is no confirmation anymore. This image will be remove permanatly.</p>
          <p><?php do { ?>
   <div class="col-md-6 col-sm-6"><?php echo $row_Recordset2['id']; ?> - <?php echo $row_Recordset2['name']; ?>: <?php echo $row_Recordset2['text']; ?>, <?php echo nicetime($row_Recordset2['date']); ?>), IP: <?php echo $row_Recordset2['ip']; ?>
<a class="btn btn-danger" href="delete2.php?id=<?php echo $row_Recordset2['id']; ?>"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
</div>
  <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?></p>
        </div>
      </div>

      <!-- Site footer
      <footer class="footer">
        <p>&copy; 2015 Company, Inc.</p>
      </footer> -->

    </div>

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
    <script src="assets/js/fileinput.min.js"></script>
    <script>
$(document).on('ready', function() {
    $("#fileToUpload").fileinput({
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseLabel: "Pick Image",
        browseIcon: "<i class=\"fa fa-file-image-o\"></i> ",
        removeClass: "btn btn-danger",
        removeLabel: "Delete",
        removeIcon: "<i class=\"fa fa-trash\"></i> ",
        uploadClass: "btn btn-info",
        uploadLabel: "Upload",
        uploadIcon: "<i class=\"fa fa-upload\"></i> "
    });
});
</script>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
