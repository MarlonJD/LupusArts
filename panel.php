<?php require_once('Connections/lupus.php'); ?>
<?php
ob_start();
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO images (img, title, aciklama, category) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['img'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['comment'], "text"),
                       GetSQLValueString($_POST['category'], "text"));

  mysql_select_db($database_lupus, $lupus);
  $Result1 = mysql_query($insertSQL, $lupus) or die(mysql_error());

  $insertGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if(isset($_FILES['fileToUpload'])){
      $uploadOk = 1;
      $file_name = time()."_".$_FILES['fileToUpload']['name'];
      $file_size = $_FILES['fileToUpload']['size'];
      $file_tmp = $_FILES['fileToUpload']['tmp_name'];
      $file_type = $_FILES['fileToUpload']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['fileToUpload']['name'])));
      
      $expensions= array("jpeg","jpg","png","gif");
      
      if(in_array($file_ext,$expensions)=== false){
   	$errorcode="3"; // "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
      }
      
	  if (file_exists($file_name)) {
    $errorcode="1";// "Sorry, file already exists.";
    $uploadOk = 0;
}
	  
      if($file_size > 2097152) {
    $errorcode="2";//"Sorry, your file is too large.";
    $uploadOk = 0;
      }
      
      if($uploadOk==1) {
         move_uploaded_file($file_tmp,"img/".$file_name);
          $errorcode="5";
      }else{
          $errorcode="6";
      }
   }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Publishing new Image</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- STYLE FOR OPENING IMAGE IN POPUP USING FANCYBOX-->
    <link href="assets/js/source/jquery.fancybox.css" rel="stylesheet" />
    <!--Font Awesome -->
    <link type="text/css" rel="stylesheet" href="assets/css/font-awesome.min.css">
</head>

<body>

<?php if ($errorcode==1) { ?>
<div class="alert alert-warning">
  <strong>Warning!</strong> Sorry, file already exists.But you can still publish again.
</div>
<?php } ?>

<?php if ($errorcode==2) { ?>
<div class="alert alert-warning">
  <strong>Warning!</strong> Sorry, your file is too large.
</div>
<?php } ?>

<?php if ($errorcode==3) { ?>
<div class="alert alert-warning">
  <strong>Warning!</strong> Sorry, only JPG, JPEG, PNG & GIF files are allowed.
</div>
<?php } ?>

<?php if ($errorcode==5) { ?>
<div class="alert alert-success">
  <strong>Success!</strong> The file has been uploaded.
</div>
<?php } ?>


<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">

<div class="col-md-4 col-md-offset-4">
<div class="input-group margin-bottom-sm">
  <span class="input-group-addon"><i class="fa fa-link fa-fw"></i></span>
  <input id="img" name="img" class="form-control" type="text" placeholder="Image Link" value="<?php echo time()."_".$_FILES['fileToUpload']['name'];  ?>" readonly>
</div>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-header fa-fw"></i></span>
  <input id="title" name="title" class="form-control" type="text" placeholder="Title">
</div>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-paragraph fa-fw"></i></span>
  <input id="comment" name="comment" class="form-control" type="text" placeholder="Your Comment">
</div>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-list-ul fa-fw"></i></span>
  <input id="category" name="category" class="form-control" type="text" placeholder="Category">
</div>
<button class="btn btn-lg btn-primary btn-block" type="submit">Publish</button>
</div>
<input type="hidden" name="MM_insert" value="form1">
</form>

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
    <script src="assets/js/fileinput.min.js"></script>
    <script>
</body>
</html>