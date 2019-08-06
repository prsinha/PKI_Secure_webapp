<?php require_once('Connections/conn.php'); ?>
<?php
session_start();
if(isset($_SESSION['user_name']))

{
$uid=$_SESSION['user_id'];
$user_name=$_SESSION['user_name'];

mysql_select_db($database_conn, $conn);
$query_userdet = "SELECT * FROM userdetails WHERE UserID = '$uid'";
$userdet = mysql_query($query_userdet, $conn) or die(mysql_error());
$row_userdet = mysql_fetch_assoc($userdet);
$totalRows_userdet = mysql_num_rows($userdet);

$date =date("Y/m/d");
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "registerusers")) {
  $updateSQL = sprintf("UPDATE userdetails SET FName=%s, MName=%s, LName=%s, Telephone=%s, Address=%s, DOB=%s, Email=%s, Country=%s, `State`=%s, City=%s WHERE UserID='$uid'",
                       GetSQLValueString($_POST['FName'], "text"),
                       GetSQLValueString($_POST['MName'], "text"),
                       GetSQLValueString($_POST['LName'], "text"),
                       GetSQLValueString($_POST['Telephone'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['DOB'], "text"),
                       GetSQLValueString($user_name, "text"),
                       GetSQLValueString($_POST['Country'], "text"),
                       GetSQLValueString($_POST['Province'], "text"),
                       GetSQLValueString($_POST['City'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::  Register  ::</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="cal2.js">
/*
Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/
</script>
<script language="javascript" src="cal_conf2.js"></script>

</head>

<body>

<form action="<?php echo $editFormAction; ?>" method="POST"  name="registerusers" id="registerusers">
<table  width="72%" border="0" cellspacing="0" cellpadding="0"  align="center" > 
<tr > 
<td colspan="4" align="left" valign="top" style="background:url(image/top.gif);width:900px; height:96px;" ><FONT FACE="Tahoma" SIZE="6">
  Document Library</FONT><pre><FONT FACE="Tahoma">Group Name</FONT></pre>
</td>
  </tr>
  <tr bgcolor="#000000"> 
  <td colspan="4" align="left" valign="top" BGCOLOR="#336666">
   <div align="center"><?php include('menu.php'); ?></div></td></tr>
  
  <tr>
    <td width="228" rowspan="16" align="left" valign="top"><br />
      <?php include("sideadminmenu.php")?>        <br /></td>
    <td colspan="3" align="left" valign="top"><br /><h1><br />
    User Registration</h1> <br /> </td>
    </tr>
  <tr>
   <td width="38" align="left" valign="top">&nbsp;</td>
    <td width="185" align="left" valign="top">First Name</td>
    <td width="449" align="left" valign="top"><input name="FName" type="text" id="FName" value="<?php echo $row_userdet['FName']; ?>" size="50" />
      <br /><br /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Middle Name</td>
    <td align="left" valign="top"><input name="MName" type="text" id="MName" value="<?php echo $row_userdet['MName']; ?>" size="50" /><br /><br></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Last Name</td>
    <td align="left" valign="top"><input name="LName" type="text" id="LName" value="<?php echo $row_userdet['LName']; ?>" size="50"/><br /><br /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Email Address</td>
    <td align="left" valign="top"><input name="Email" disabled="disabled" type="text" id="Email" value="<?php echo $row_userdet['Email']; ?>" size="50"  /><br /><br /></td>
  </tr>
  
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Telephone Number</td>
    <td align="left" valign="top"><input name="Telephone" type="text" id="Telephone" value="<?php echo $row_userdet['Telephone']; ?>" size="50" /><br /><br /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Address</td>
    <td align="left" valign="top"><input name="Address" type="text" id="Address" value="<?php echo $row_userdet['Address']; ?>" size="50" /><br /><br /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Date Of Birth</td>
    <td align="left" valign="top"><input name="DOB" type="text" value="<?php echo $row_userdet['DOB']; ?>" size=20>  <a href="javascript:showCal('Calendar1')"><font color="#FF0000">Select Date</font></a> <br /><br /></tr>

  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Country</td>
    <td align="left" valign="top"><script language="javascript">
function changeSTATE( COUNTRYvalue )
{
  if ( document.registerusers.STATE != null )
  {
    if ( COUNTRYvalue == "US" )
    {
	  document.registerusers.Province.disabled=true;
	  document.registerusers.STATE.disabled=false;
      document.registerusers.STATE.options.length = 63
      document.registerusers.STATE.options.selectedIndex = 0
      document.registerusers.STATE.options[0] = new Option( "Please select", "NOTSELECTED" )
      document.registerusers.STATE.options[1] = new Option( "Alabama", "AL" )
      document.registerusers.STATE.options[2] = new Option( "Alaska", "AK" )
      document.registerusers.STATE.options[3] = new Option( "Arizona", "AZ" )
      document.registerusers.STATE.options[4] = new Option( "Arkansas", "AR" )
      document.registerusers.STATE.options[5] = new Option( "California", "CA" )
      document.registerusers.STATE.options[6] = new Option( "Colorado", "CO" )
      document.registerusers.STATE.options[7] = new Option( "Connecticut", "CT" )
      document.registerusers.STATE.options[8] = new Option( "Delaware", "DE" )
      document.registerusers.STATE.options[9] = new Option( "District of Columbia", "DC" )
      document.registerusers.STATE.options[10] = new Option( "Florida", "FL" )
      document.registerusers.STATE.options[11] = new Option( "Georgia", "GA" )
      document.registerusers.STATE.options[12] = new Option( "Hawaii", "HI" )
      document.registerusers.STATE.options[13] = new Option( "Idaho", "ID" )
      document.registerusers.STATE.options[14] = new Option( "Illinois", "IL" )
      document.registerusers.STATE.options[15] = new Option( "Indiana", "IN" )
      document.registerusers.STATE.options[16] = new Option( "Iowa", "IA" )
      document.registerusers.STATE.options[17] = new Option( "Kansas", "KS" )
      document.registerusers.STATE.options[18] = new Option( "Kentucky", "KY" )
      document.registerusers.STATE.options[19] = new Option( "Louisiana", "LA" )
      document.registerusers.STATE.options[20] = new Option( "Maine", "ME" )
      document.registerusers.STATE.options[21] = new Option( "Maryland", "MD" )
      document.registerusers.STATE.options[22] = new Option( "Massachusetts", "MA" )
      document.registerusers.STATE.options[23] = new Option( "Michigan", "MI" )
      document.registerusers.STATE.options[24] = new Option( "Minnesota", "MN" )
      document.registerusers.STATE.options[25] = new Option( "Mississippi", "MS" )
      document.registerusers.STATE.options[26] = new Option( "Missouri", "MO" )
      document.registerusers.STATE.options[27] = new Option( "Montana", "MT" )
      document.registerusers.STATE.options[28] = new Option( "Nebraska", "NE" )
      document.registerusers.STATE.options[29] = new Option( "Nevada", "NV" )
      document.registerusers.STATE.options[30] = new Option( "New Hampshire", "NH" )
      document.registerusers.STATE.options[31] = new Option( "New Jersey", "NJ" )
      document.registerusers.STATE.options[32] = new Option( "New Mexico", "NM" )
      document.registerusers.STATE.options[33] = new Option( "New York", "NY" )
      document.registerusers.STATE.options[34] = new Option( "North Carolina", "NC" )
      document.registerusers.STATE.options[35] = new Option( "North Dakota", "ND" )
      document.registerusers.STATE.options[36] = new Option( "Ohio", "OH" )
      document.registerusers.STATE.options[37] = new Option( "Oklahoma", "OK" )
      document.registerusers.STATE.options[38] = new Option( "Oregon", "OR" )
      document.registerusers.STATE.options[39] = new Option( "Pennsylvania", "PA" )
      document.registerusers.STATE.options[40] = new Option( "Puerto Rico", "PR" )
      document.registerusers.STATE.options[41] = new Option( "Rhode Island", "RI" )
      document.registerusers.STATE.options[42] = new Option( "South Carolina", "SC" )
      document.registerusers.STATE.options[43] = new Option( "South Dakota", "SD" )
      document.registerusers.STATE.options[44] = new Option( "Tennessee", "TN" )
      document.registerusers.STATE.options[45] = new Option( "Texas", "TX" )
      document.registerusers.STATE.options[46] = new Option( "Utah", "UT" )
      document.registerusers.STATE.options[47] = new Option( "Vermont", "VT" )
      document.registerusers.STATE.options[48] = new Option( "Virginia", "VA" )
      document.registerusers.STATE.options[49] = new Option( "Washington", "WA" )
      document.registerusers.STATE.options[50] = new Option( "West Virginia", "WV" )
      document.registerusers.STATE.options[51] = new Option( "Wisconsin", "WI" )
      document.registerusers.STATE.options[52] = new Option( "Wyoming", "WY" )
      document.registerusers.STATE.options[53] = new Option( "American Samoa", "AS" )
      document.registerusers.STATE.options[54] = new Option( "Federated States Of Micronesia", "FM" )
      document.registerusers.STATE.options[55] = new Option( "Guam", "GU" )
      document.registerusers.STATE.options[56] = new Option( "Marshall Islands", "MH" )
      document.registerusers.STATE.options[57] = new Option( "Northern Mariana Islands", "MP" )
      document.registerusers.STATE.options[58] = new Option( "Palau", "PW" )
      document.registerusers.STATE.options[59] = new Option( "Virgin Islands", "VI" )
      document.registerusers.STATE.options[60] = new Option( "Armed Forces Americas", "AA" )
      document.registerusers.STATE.options[61] = new Option( "Armed Forces Canada/Europe/Africa/MiddleEast", "AE" )
      document.registerusers.STATE.options[62] = new Option( "Armed Forces Pacific", "AP" )
    }
    else if ( COUNTRYvalue == "CA" )
    {
	  document.registerusers.Province.disabled=true;
	  document.registerusers.STATE.disabled=false;
      document.registerusers.STATE.options.length = 14
      document.registerusers.STATE.options.selectedIndex = 0
      document.registerusers.STATE.options[0] = new Option( "Please select", "NOTSELECTED" )
      document.registerusers.STATE.options[1] = new Option( "Alberta", "AB" )
      document.registerusers.STATE.options[2] = new Option( "British Columbia", "BC" )
      document.registerusers.STATE.options[3] = new Option( "Manitoba", "MB" )
      document.registerusers.STATE.options[4] = new Option( "New Brunswick", "NB" )
      document.registerusers.STATE.options[5] = new Option( "Newfoundland", "NF" )
      document.registerusers.STATE.options[6] = new Option( "Northwest Territories", "NT" )
      document.registerusers.STATE.options[7] = new Option( "Nova Scotia", "NS" )
      document.registerusers.STATE.options[8] = new Option( "Nunavut", "NU" )
      document.registerusers.STATE.options[9] = new Option( "Ontario", "ON" )
      document.registerusers.STATE.options[10] = new Option( "Prince Edward Island", "PE" )
      document.registerusers.STATE.options[11] = new Option( "Quebec", "QC" )
      document.registerusers.STATE.options[12] = new Option( "Saskatchewan", "SK" )
      document.registerusers.STATE.options[13] = new Option( "Yukon", "YT" )
    }
    else
    {
	document.registerusers.Province.disabled=false;
	document.registerusers.STATE.disabled=true;
      document.registerusers.STATE.options.length = 1
      document.registerusers.STATE.options.selectedIndex = 0
      document.registerusers.STATE.options[0] = new Option( "Not applicable", "NOTAPPLICABLE" )
	 
    }
  }
}

function changeprovince( STATEvalue )
{
document.registerusers.Province.value=STATEvalue;
}
</script>
<select name="Country"  onchange="changeSTATE(this.options[this.selectedIndex].value)">
  <option value="NOTSELECTED" selected="selected" <?php if (!(strcmp("NOTSELECTED", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Please select</option>
  <option value="US" <?php if (!(strcmp("US", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>United States</option>
  <option value="AF" <?php if (!(strcmp("AF", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Afghanistan</option>
  <option value="AL" <?php if (!(strcmp("AL", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Albania</option>
  <option value="DZ" <?php if (!(strcmp("DZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Algeria</option>
  <option value="AS" <?php if (!(strcmp("AS", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>American Samoa</option>
  <option value="AD" <?php if (!(strcmp("AD", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Andorra</option>
<option value="AO" <?php if (!(strcmp("AO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Angola</option>
  <option value="AI" <?php if (!(strcmp("AI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Anguilla</option>
  <option value="AQ" <?php if (!(strcmp("AQ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Antarctica</option>
  <option value="AG" <?php if (!(strcmp("AG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Antigua And Barbuda</option>
  <option value="AR" <?php if (!(strcmp("AR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Argentina</option>
  <option value="AM" <?php if (!(strcmp("AM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Armenia</option>
  <option value="AW" <?php if (!(strcmp("AW", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Aruba</option>
  <option value="AU" <?php if (!(strcmp("AU", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Australia</option>
<option value="AT" <?php if (!(strcmp("AT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Austria</option>
  <option value="AZ" <?php if (!(strcmp("AZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Azerbaijan</option>
  <option value="BS" <?php if (!(strcmp("BS", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bahamas</option>
  <option value="BH" <?php if (!(strcmp("BH", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bahrain</option>
  <option value="BD" <?php if (!(strcmp("BD", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bangladesh</option>
  <option value="BB" <?php if (!(strcmp("BB", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Barbados</option>
  <option value="BY" <?php if (!(strcmp("BY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Belarus</option>
  <option value="BE" <?php if (!(strcmp("BE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Belgium</option>
  <option value="BZ" <?php if (!(strcmp("BZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Belize</option>
  <option value="BJ" <?php if (!(strcmp("BJ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Benin</option>
  <option value="BM" <?php if (!(strcmp("BM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bermuda</option>
  <option value="BT" <?php if (!(strcmp("BT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bhutan</option>
  <option value="BO" <?php if (!(strcmp("BO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bolivia</option>
  <option value="BA" <?php if (!(strcmp("BA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bosnia and Herzegovina</option>
  <option value="BW" <?php if (!(strcmp("BW", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Botswana</option>
  <option value="BV" <?php if (!(strcmp("BV", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bouvet Island</option>
  <option value="BR" <?php if (!(strcmp("BR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Brazil</option>
<option value="IO" <?php if (!(strcmp("IO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>British Indian Ocean Territory</option>
  <option value="BN" <?php if (!(strcmp("BN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Brunei Darussalam</option>
  <option value="BG" <?php if (!(strcmp("BG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Bulgaria</option>
  <option value="BF" <?php if (!(strcmp("BF", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Burkina Faso</option>
  <option value="BI" <?php if (!(strcmp("BI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Burundi</option>
  <option value="KH" <?php if (!(strcmp("KH", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cambodia</option>
  <option value="CM" <?php if (!(strcmp("CM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cameroon</option>
  <option value="CA" <?php if (!(strcmp("CA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Canada</option>
  <option value="CV" <?php if (!(strcmp("CV", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cape Verde</option>
  <option value="KY" <?php if (!(strcmp("KY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cayman Islands</option>
  <option value="CF" <?php if (!(strcmp("CF", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Central African Republic</option>
  <option value="TD" <?php if (!(strcmp("TD", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Chad</option>
  <option value="CL" <?php if (!(strcmp("CL", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Chile</option>
  <option value="CN" <?php if (!(strcmp("CN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>China</option>
  <option value="CX" <?php if (!(strcmp("CX", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Christmas Island</option>
  <option value="CC" <?php if (!(strcmp("CC", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cocos (Keeling) Islands</option>
<option value="CO" <?php if (!(strcmp("CO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Colombia</option>
  <option value="KM" <?php if (!(strcmp("KM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Comoros</option>
  <option value="CG" <?php if (!(strcmp("CG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Congo</option>
  <option value="CD" <?php if (!(strcmp("CD", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Congo, DROC</option>
  <option value="CK" <?php if (!(strcmp("CK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cook Islands</option>
  <option value="CR" <?php if (!(strcmp("CR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Costa Rica</option>
  <option value="CI" <?php if (!(strcmp("CI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cote D'ivoire</option>
  <option value="HR" <?php if (!(strcmp("HR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Croatia</option>
  <option value="CU" <?php if (!(strcmp("CU", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cuba</option>
  <option value="CY" <?php if (!(strcmp("CY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Cyprus</option>
  <option value="CZ" <?php if (!(strcmp("CZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Czech Republic</option>
  <option value="DK" <?php if (!(strcmp("DK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Denmark</option>
  <option value="DJ" <?php if (!(strcmp("DJ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Djibouti</option>
  <option value="DM" <?php if (!(strcmp("DM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Dominica</option>
  <option value="DO" <?php if (!(strcmp("DO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Dominican Republic</option>
  <option value="TL" <?php if (!(strcmp("TL", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>East Timor</option>
  <option value="EC" <?php if (!(strcmp("EC", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Ecuador</option>
  <option value="EG" <?php if (!(strcmp("EG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Egypt</option>
  <option value="SV" <?php if (!(strcmp("SV", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>El Salvador</option>
  <option value="GQ" <?php if (!(strcmp("GQ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Equatorial Guinea</option>
  <option value="ER" <?php if (!(strcmp("ER", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Eritrea</option>
  <option value="EE" <?php if (!(strcmp("EE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Estonia</option>
  <option value="ET" <?php if (!(strcmp("ET", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Ethiopia</option>
  <option value="FK" <?php if (!(strcmp("FK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Falkland Islands (Malvinas)</option>
  <option value="FO" <?php if (!(strcmp("FO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Faroe Islands</option>
  <option value="FJ" <?php if (!(strcmp("FJ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Fiji</option>
  <option value="FI" <?php if (!(strcmp("FI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Finland</option>
  <option value="FR" <?php if (!(strcmp("FR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>France</option>
  <option value="GA" <?php if (!(strcmp("GA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Gabon</option>
  <option value="GM" <?php if (!(strcmp("GM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Gambia</option>
  <option value="GE" <?php if (!(strcmp("GE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Georgia</option>
  <option value="DE" <?php if (!(strcmp("DE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Germany</option>
  <option value="GH" <?php if (!(strcmp("GH", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Ghana</option>
  <option value="GI" <?php if (!(strcmp("GI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Gibraltar</option>
  <option value="GR" <?php if (!(strcmp("GR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Greece</option>
  <option value="GL" <?php if (!(strcmp("GL", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Greenland</option>
  <option value="GD" <?php if (!(strcmp("GD", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Grenada</option>
  <option value="GP" <?php if (!(strcmp("GP", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Guadeloupe</option>
  <option value="GT" <?php if (!(strcmp("GT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Guatemala</option>
  <option value="GN" <?php if (!(strcmp("GN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Guinea</option>
  <option value="GW" <?php if (!(strcmp("GW", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Guinea-Bissau</option>
  <option value="GY" <?php if (!(strcmp("GY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Guyana</option>
  <option value="HT" <?php if (!(strcmp("HT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Haiti</option>
  <option value="HM" <?php if (!(strcmp("HM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Heard And Mc Donald Islands</option>
  <option value="VA" <?php if (!(strcmp("VA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Holy See (Vatican City State)</option>
  <option value="HN" <?php if (!(strcmp("HN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Honduras</option>
  <option value="HK" <?php if (!(strcmp("HK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Hong Kong</option>
  <option value="HU" <?php if (!(strcmp("HU", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Hungary</option>
  <option value="IS" <?php if (!(strcmp("IS", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Iceland</option>
  <option value="IN" <?php if (!(strcmp("IN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>India</option>
  <option value="ID" <?php if (!(strcmp("ID", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Indonesia</option>
  <option value="IR" <?php if (!(strcmp("IR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Iran (Islamic Republic Of)</option>
  <option value="IQ" <?php if (!(strcmp("IQ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Iraq</option>
  <option value="IE" <?php if (!(strcmp("IE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Ireland</option>
  <option value="IL" <?php if (!(strcmp("IL", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Israel</option>
  <option value="IT" <?php if (!(strcmp("IT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Italy</option>
  <option value="JM" <?php if (!(strcmp("JM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Jamaica</option>
  <option value="JP" <?php if (!(strcmp("JP", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Japan</option>
  <option value="JO" <?php if (!(strcmp("JO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Jordan</option>
  <option value="KZ" <?php if (!(strcmp("KZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Kazakhstan</option>
  <option value="KE" <?php if (!(strcmp("KE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Kenya</option>
  <option value="KI" <?php if (!(strcmp("KI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Kiribati</option>
  <option value="KR" <?php if (!(strcmp("KR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Korea, Republic Of</option>
  <option value="KR" <?php if (!(strcmp("KR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Korea, South</option>
  <option value="KW" <?php if (!(strcmp("KW", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Kuwait</option>
  <option value="KG" <?php if (!(strcmp("KG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Kyrgyzstan</option>
  <option value="LA" <?php if (!(strcmp("LA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Lao People's Democratic Republic</option>
  <option value="LV" <?php if (!(strcmp("LV", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Latvia</option>
  <option value="LB" <?php if (!(strcmp("LB", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Lebanon</option>
  <option value="LS" <?php if (!(strcmp("LS", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Lesotho</option>
  <option value="LR" <?php if (!(strcmp("LR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Liberia</option>
  <option value="LY" <?php if (!(strcmp("LY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Libyan Arab Jamahiriya</option>
  <option value="LI" <?php if (!(strcmp("LI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Liechtenstein</option>
<option value="LT" <?php if (!(strcmp("LT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Lithuania</option>
  <option value="LU" <?php if (!(strcmp("LU", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Luxembourg</option>
  <option value="MO" <?php if (!(strcmp("MO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Macau</option>
  <option value="MK" <?php if (!(strcmp("MK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Macedonia</option>
  <option value="MG" <?php if (!(strcmp("MG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Madagascar</option>
  <option value="MY" <?php if (!(strcmp("MY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Malaysia</option>
  <option value="MW" <?php if (!(strcmp("MW", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Malawi</option>
  <option value="MV" <?php if (!(strcmp("MV", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Maldives</option>
  <option value="ML" <?php if (!(strcmp("ML", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Mali</option>
  <option value="MT" <?php if (!(strcmp("MT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Malta</option>
  <option value="MQ" <?php if (!(strcmp("MQ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Martinique</option>
  <option value="MR" <?php if (!(strcmp("MR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Mauritania</option>
  <option value="MU" <?php if (!(strcmp("MU", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Mauritius</option>
  <option value="YT" <?php if (!(strcmp("YT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Mayotte</option>
  <option value="MX" <?php if (!(strcmp("MX", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Mexico</option>
  <option value="MD" <?php if (!(strcmp("MD", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Moldova, Republic Of</option>
  <option value="MC" <?php if (!(strcmp("MC", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Monaco</option>
  <option value="MN" <?php if (!(strcmp("MN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Mongolia</option>
  <option value="MS" <?php if (!(strcmp("MS", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Montserrat</option>
  <option value="MA" <?php if (!(strcmp("MA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Morocco</option>
  <option value="MZ" <?php if (!(strcmp("MZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Mozambique</option>
  <option value="MM" <?php if (!(strcmp("MM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Myanmar</option>
  <option value="NA" <?php if (!(strcmp("NA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Namibia</option>
  <option value="NR" <?php if (!(strcmp("NR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Nauru</option>
  <option value="NP" <?php if (!(strcmp("NP", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Nepal</option>
  <option value="NL" <?php if (!(strcmp("NL", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Netherlands</option>
  <option value="NT" <?php if (!(strcmp("NT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Netherlands Antilles</option>
  <option value="NC" <?php if (!(strcmp("NC", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>New Caledonia</option>
  <option value="NZ" <?php if (!(strcmp("NZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>New Zealand</option>
  <option value="NI" <?php if (!(strcmp("NI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Nicaragua</option>
  <option value="NE" <?php if (!(strcmp("NE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Niger</option>
  <option value="NG" <?php if (!(strcmp("NG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Nigeria</option>
  <option value="NU" <?php if (!(strcmp("NU", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Niue</option>
  <option value="NF" <?php if (!(strcmp("NF", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Norfolk Island</option>
  <option value="NO" <?php if (!(strcmp("NO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Norway</option>
  <option value="OM" <?php if (!(strcmp("OM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Oman</option>
  <option value="PK" <?php if (!(strcmp("PK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Pakistan</option>
  <option value="PA" <?php if (!(strcmp("PA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Panama</option>
  <option value="PG" <?php if (!(strcmp("PG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Papua New Guinea</option>
  <option value="PY" <?php if (!(strcmp("PY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Paraguay</option>
  <option value="PE" <?php if (!(strcmp("PE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Peru</option>
  <option value="PH" <?php if (!(strcmp("PH", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Philippines</option>
  <option value="PN" <?php if (!(strcmp("PN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Pitcairn</option>
  <option value="PL" <?php if (!(strcmp("PL", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Poland</option>
  <option value="PT" <?php if (!(strcmp("PT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Portugal</option>
  <option value="QA" <?php if (!(strcmp("QA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Qatar</option>
<option value="RE" <?php if (!(strcmp("RE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Reunion</option>
  <option value="RO" <?php if (!(strcmp("RO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Romania</option>
  <option value="RU" <?php if (!(strcmp("RU", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Russia</option>
  <option value="RW" <?php if (!(strcmp("RW", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Rwanda</option>
  <option value="KN" <?php if (!(strcmp("KN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Saint Kitts And Nevis</option>
  <option value="LC" <?php if (!(strcmp("LC", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Saint Lucia</option>
  <option value="VC" <?php if (!(strcmp("VC", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Saint Vincent And The Grenadines</option>
  <option value="WS" <?php if (!(strcmp("WS", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Samoa</option>
  <option value="SM" <?php if (!(strcmp("SM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>San Marino</option>
  <option value="ST" <?php if (!(strcmp("ST", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Sao Tome And Principe</option>
  <option value="SA" <?php if (!(strcmp("SA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Saudi Arabia</option>
  <option value="SN" <?php if (!(strcmp("SN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Senegal</option>
  <option value="CS" <?php if (!(strcmp("CS", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Serbia and Montenegro</option>
  <option value="SC" <?php if (!(strcmp("SC", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Seychelles</option>
  <option value="SL" <?php if (!(strcmp("SL", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Sierra Leone</option>
  <option value="SG" <?php if (!(strcmp("SG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Singapore</option>
  <option value="SK" <?php if (!(strcmp("SK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Slovakia</option>
  <option value="SI" <?php if (!(strcmp("SI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Slovenia</option>
  <option value="SB" <?php if (!(strcmp("SB", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Solomon Islands</option>
  <option value="SO" <?php if (!(strcmp("SO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Somalia</option>
  <option value="ZA" <?php if (!(strcmp("ZA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>South Africa</option>
  <option value="GS" <?php if (!(strcmp("GS", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>S. Georgia And S. Sandwich Isles</option>
  <option value="ES" <?php if (!(strcmp("ES", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Spain</option>
<option value="LK" <?php if (!(strcmp("LK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Sri Lanka</option>
  <option value="SH" <?php if (!(strcmp("SH", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>St. Helena</option>
  <option value="PM" <?php if (!(strcmp("PM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>St. Pierre And Miquelon</option>
  <option value="SD" <?php if (!(strcmp("SD", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Sudan</option>
<option value="SR" <?php if (!(strcmp("SR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Suriname</option>
  <option value="SJ" <?php if (!(strcmp("SJ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Svalbard And Jan Mayen Islands</option>
  <option value="SZ" <?php if (!(strcmp("SZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Swaziland</option>
  <option value="SE" <?php if (!(strcmp("SE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Sweden</option>
  <option value="CH" <?php if (!(strcmp("CH", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Switzerland</option>
<option value="SY" <?php if (!(strcmp("SY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Syrian Arab Republic</option>
  <option value="TW" <?php if (!(strcmp("TW", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Taiwan</option>
  <option value="TJ" <?php if (!(strcmp("TJ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Tajikistan</option>
  <option value="TZ" <?php if (!(strcmp("TZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Tanzania, United Republic Of</option>
  <option value="TH" <?php if (!(strcmp("TH", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Thailand</option>
  <option value="TG" <?php if (!(strcmp("TG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Togo</option>
  <option value="TK" <?php if (!(strcmp("TK", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Tokelau</option>
  <option value="TO" <?php if (!(strcmp("TO", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Tonga</option>
  <option value="TT" <?php if (!(strcmp("TT", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Trinidad And Tobago</option>
  <option value="TN" <?php if (!(strcmp("TN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Tunisia</option>
  <option value="TR" <?php if (!(strcmp("TR", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Turkey</option>
  <option value="TM" <?php if (!(strcmp("TM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Turkmenistan</option>
  <option value="TC" <?php if (!(strcmp("TC", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Turks And Caicos Islands</option>
  <option value="TV" <?php if (!(strcmp("TV", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Tuvalu</option>
  <option value="UM" <?php if (!(strcmp("UM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>U.S. Minor Outlying Islands</option>
  <option value="UG" <?php if (!(strcmp("UG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Uganda</option>
  <option value="UA" <?php if (!(strcmp("UA", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Ukraine</option>
  <option value="AE" <?php if (!(strcmp("AE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>United Arab Emirates</option>
  <option value="GB" <?php if (!(strcmp("GB", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>United Kingdom</option>
  <option value="UY" <?php if (!(strcmp("UY", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Uruguay</option>
  <option value="UZ" <?php if (!(strcmp("UZ", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Uzbekistan</option>
  <option value="VU" <?php if (!(strcmp("VU", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Vanuatu</option>
  <option value="VE" <?php if (!(strcmp("VE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Venezuela</option>
  <option value="VN" <?php if (!(strcmp("VN", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Viet Nam</option>
  <option value="VG" <?php if (!(strcmp("VG", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Virgin Islands (British)</option>
  <option value="VI" <?php if (!(strcmp("VI", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Virgin Islands (U.S.)</option>
  <option value="WF" <?php if (!(strcmp("WF", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Wallis And Futuna Islands</option>
  <option value="EH" <?php if (!(strcmp("EH", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Western Sahara</option>
  <option value="YE" <?php if (!(strcmp("YE", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Yemen</option>
<option value="ZM" <?php if (!(strcmp("ZM", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Zambia</option>
  <option value="ZW" <?php if (!(strcmp("ZW", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Zimbabwe</option>
  <option value="XX" <?php if (!(strcmp("XX", $row_userdet['Country']))) {echo "selected=\"selected\"";} ?>>Other</option>
</select><br /><br /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">State</td>
    <td align="left" valign="top">
    <select name="STATE" onchange="changeprovince(this.options[this.selectedIndex].value)" disabled="disabled" >
      <option value="NOTAPPLICABLE" selected="selected" <?php if (!(strcmp("NOTAPPLICABLE", $row_userdet['State']))) {echo "selected=\"selected\"";} ?>>Not applicable</option>
</select><br /><br />
    <input name="Province" type="text"  id="Province" value="<?php echo $row_userdet['State']; ?>" size="50"/><br /><br /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">City</td>
    <td align="left" valign="top"><input name="City" type="text" id="City" value="<?php echo $row_userdet['City']; ?>" size="50" /><br /><br /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><input type="submit" name="Submit" id="Submit" value="Submit" />    </td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="top">&nbsp;</td>
    </tr>
  
  <tr>
    <td colspan="4"><DIV ALIGN="CENTER"><FONT SIZE="1" FACE="Tahoma">Copyright 
2008 . All Rights Reserved</FONT></DIV></td>
  </tr>
  <tr>
   <td colspan="4" BGCOLOR="#336666">&nbsp;</td>
   </tr> 
</table>

<input type="hidden" name="MM_update" value="registerusers" />
</form>

</body>
</html>
<?php
mysql_free_result($userdet);
 }else{

 header("location:login.php");

}

?>

