<?php require_once('Connections/lupus.php'); ?>
<?php
error_reporting(E_ALL); ini_set('display_errors','On');
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

$MM_restrictGoTo = "admin.php";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE images SET img=%s, title=%s, aciklama=%s, category=%s WHERE id=%s",
                       GetSQLValueString($_POST['img'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['comment'], "text"),
                       GetSQLValueString($_POST['category'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_lupus, $lupus);
  $Result1 = mysql_query($updateSQL, $lupus) or die(mysql_error());

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
  exit;
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_lupus, $lupus);
$query_Recordset1 = sprintf("SELECT * FROM images WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $lupus) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Başlıksız Belge</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- STYLE FOR OPENING IMAGE IN POPUP USING FANCYBOX-->
    <link href="assets/js/source/jquery.fancybox.css" rel="stylesheet" />
    <!--Font Awesome -->
    <link type="text/css" rel="stylesheet" href="assets/css/font-awesome.min.css">
</head>

<body>
<center><h1>Edit</h1></center>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  
  <div class="col-md-4 col-md-offset-4">
<div class="input-group margin-bottom-sm">
  <span class="input-group-addon"><i class="fa fa-link fa-fw"></i></span>
  <input id="img" name="img" class="form-control" type="text" placeholder="Image Link" value="<?php echo $row_Recordset1['img']; ?>" readonly>  <input id="id" name="id" class="form-control" type="text" placeholder="Image Link" value="<?php echo $row_Recordset1['id']; ?>" readonly>
</div>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-header fa-fw"></i></span>
  <input name="title" type="text" class="form-control" id="title" placeholder="Title" value="<?php echo $row_Recordset1['title']; ?>">
</div>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-paragraph fa-fw"></i></span>
  <input name="comment" type="text" class="form-control" id="comment" placeholder="Your Comment" value="<?php echo $row_Recordset1['aciklama']; ?>">
</div>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-list-ul fa-fw"></i></span>
  <input name="category" type="text" class="form-control" id="category" placeholder="Category" value="<?php echo $row_Recordset1['category']; ?>">
</div>
<button class="btn btn-lg btn-primary btn-block" type="submit">Change</button>
</div>
<input type="hidden" name="MM_insert" value="form1">
<input type="hidden" name="MM_update" value="form1">
</form>
<br>
<center><img src="img/<?php echo $row_Recordset1['img']; ?>" alt="" width="300" class="img-thumbnail"/></center>

<p>&nbsp;</p>
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
    <script>
</body>
</html><?php
mysql_free_result($Recordset1);
?><?php
mysql_free_result($Recordset1);
?><?php
mysql_free_result($Recordset1);
?>