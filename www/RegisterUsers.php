<?php require_once('Connections/conn.php');

include "CreateCert.php";
include "LdapEntry.php";

function pem2der($pem_data) {
    //echo "i am here";
    $begin = "CERTIFICATE-----";
    $end   = "-----END";
    $pem_data = substr($pem_data, strpos($pem_data, $begin)+strlen($begin));
    $pem_data = substr($pem_data, 0, strpos($pem_data, $end));
    $der = base64_decode($pem_data);
    //echo "<p>der data withing the functiono is: ".$der;
    return $der;
}

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



                        if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "registerusers")) {

                            //$pattern = '/.*@.*\..*/';
                            $fname1   = $_POST['FName'];
                            $lname1= $_POST['LName'];
                            $password1= $_POST['password'];
                            $password22= $_POST['password2'];
                            $email1= $_POST['Email'];
                            $country1= $_POST['Country'];
                            $province1= $_POST['Province'];
                            $city1= $_POST['City'];
                            $orgname1= $_POST['OrganizationName'];
                            $orgunit1= $_POST['OrganizationUnit'];
                            if($fname1=="")
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter a first name.";
                            }
                            elseif($lname1=="")
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter a last name.";
                            }
                            elseif($password1=="" )
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter a password.";
                            }
                            elseif($password22=="")
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter a password to compare.";
                            }

                            elseif($email1=="")
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter an email address.";
                            }
                            elseif($country1=="Please select")
                            {
                                $emailclass = "errortext";
                                $message    = "Please select a country.";
                            }
                            elseif($province1=="")
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter a state or province name.";
                            }
                            elseif($city1=="")
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter a city name.";
                            }
                            elseif($orgname1=="")
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter a organization name.";
                            }
                            elseif($orgunit1=="")
                            {
                                $emailclass = "errortext";
                                $message    = "Please enter a organization unit.";
                            }


                            if($message=="")
                            {


                                $pswrd=md5( $_POST['password2']);
                                $max_ref="select count(userdetails.UserID) as id from userdetails ";
                                $ref=mysql_query($max_ref,$conn) or die(mysql_error());
                                $max=mysql_fetch_assoc($ref);
                                $newref=(int)$max['id']+1;
                                $newref=(string)$newref;
                                $len=strlen($newref);
                                $add="0";
                                $pad=3-$len;
                                $padstr=str_pad($add,$pad,STR_PAD_LEFT);
                                $newref=$padstr.$newref;
                                $newref="USR".$newref;

                                $insertSQL = sprintf("INSERT INTO 6120project.userdetails (UserID, FName, LName, Telephone, Address, DOB, Email,Password,Country,State, City,User_cn) VALUES (%s,  %s, %s, %s, %s, %s,  %s, %s, %s, %s, %s , %s )",
                                    GetSQLValueString($newref, "text"),
                                    GetSQLValueString($_POST['FName'], "text"),
                                    GetSQLValueString($_POST['LName'], "text"),
                                    GetSQLValueString($_POST['Telephone'], "text"),
                                    GetSQLValueString($_POST['Address'], "text"),
                                    GetSQLValueString($_POST['DOB'], "text"),
                                    GetSQLValueString($_POST['Email'], "text"),
                                    GetSQLValueString($pswrd, "text"),
                                    GetSQLValueString($_POST['Country'], "text"),
                                    GetSQLValueString($_POST['Province'], "text"),
                                    GetSQLValueString($_POST['City'], "text"),
                                    GetSQLValueString($_POST['FName'], "text"));

                                mysql_select_db($database_conn, $conn);
                                $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

                                $firstName= $_POST['FName'];
                                $lastName=  $_POST['LName'];
                                $phoneNo=   $_POST['Telephone'];
                                $address=   GetSQLValueString($_POST['Address'], "text");
                                $dob=       GetSQLValueString($_POST['DOB'], "text");
                                $email=    $_POST['Email'];
                                $pwd=	    GetSQLValueString($pswrd, "text");
                                $country=	$_POST['Country'];
                                $province=	$_POST['Province'];
                                $city= $_POST['City'];
                                $orgname= $_POST['OrganizationName'];
                                $orgunit= $_POST['OrganizationUnit'];

                                echo $firstName.$email.$country.$province.$city.$orgname.$orgunit."<p>";

                                $dn = array(
                    "countryName" => $country,
                    "stateOrProvinceName" =>$province,
                    "localityName" => $city,
                    "organizationName" => $orgname,
                    "organizationalUnitName" => $orgunit,
                    "commonName" => $firstName,
                    "emailAddress" => $email
                                );
                                //create the certificate and get it in .pem formatt.
                                $cert1= new CreateCert();
                                $pem_cert= $cert1->create_certificate($dn);

                               // echo $pem_cert;
                               //common name is same with the first name.
                                $ldaprecord['cn'] = $firstName;
                                $ldaprecord['givenName'] = $firstName." ".$lastName;
                                $ldaprecord['sn'] = $lastName;
                                $ldaprecord['objectclass'][0] = "top";
                                $ldaprecord['objectclass'][1] = "inetOrgPerson";
                                $ldaprecord['userCertificate;binary'] = pem2der($pem_cert);
                                //add the user into the ldap server.
                                $ldap1 = new LdapEntry();
                                $ldap1->insert_into_ldap($ldaprecord);


                                $insertGoTo = "login.php";
                                if (isset($_SERVER['QUERY_STRING'])) {
                                    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                                    $insertGoTo .= $_SERVER['QUERY_STRING'];
                                }
                                header(sprintf("Location: %s", $insertGoTo));
                            }
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
        <style>

                                    .errortext {
                                        font-family: Arial, Helvetica, sans-serif;
                                        font-size: 12px; color:red;
                                    }
        </style>
    </head>

    <body>

        <form method="post"  name="registerusers" id="registerusers">
            <table  width="86%" border="0" cellspacing="0" cellpadding="0"  align="center" >

                <tr bgcolor="#000000">
                    <td colspan="6" align="left" valign="top" BGCOLOR="#336666">
                <div align="center"></div></td></tr>
                <tr>

                    <td colspan="6" align="left" valign="top">
                        <br /><h1><br />
                    User Registration</h1> <br />  </td>
                </tr>
                <tr>

                    <td colspan="6" align="left" valign="top">
                        <?php if ($message != "") {
                            print '<span class="errortext">'.
                            $message."<span><br>\n";
                        }
                        ?><br />  </td>
                </tr>
                <tr>
                    <td width="26" align="left" valign="top">&nbsp;</td>
                    <td width="129" align="left" valign="top">First Name <span class="errortext">*</span></td>
                    <td width="281" align="left" valign="top"><input name="FName" type="text" id="FName" size="40" class="<?php print $emailclass; ?>" value="<?php echo $fname1; ?>"/>
                    <br /><br /></td>
                    <td width="24" align="left" valign="top">&nbsp;</td>
                    <td width="104" align="left" valign="top">Last Name <span class="errortext">*</span></td>
                    <td width="285" align="left" valign="top"><input name="LName" type="text" id="LName" size="40"  class="<?php print $emailclass; ?>" value="<?php echo $lname1; ?>"/></td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Email Address <span class="errortext">*</span></td>
                    <td align="left" valign="top"><input name="Email" type="text" id="Email" size="40"  class="<?php print $emailclass; ?>" value="<?php echo $email1; ?>"/>
                    <br /><br></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Date of Birth</td>
                    <td align="left" valign="top"><input type="text" name="DOB" size=20 /><a href="javascript:showCal('Calendar1')"><font color="#FF0000">Select Date</font></a></td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Enter Password <span class="errortext">*</span></td>
                    <td align="left" valign="top"><input name="password" type="password" id="password" size="40"  class="<?php print $emailclass; ?>" value="<?php echo $password1; ?>"/><br /><br /></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Confrim Password <span class="errortext">*</span></td>
                    <td align="left" valign="top"><input name="password2" type="password" id="password2" size="40"  class="<?php print $emailclass; ?>" value="<?php echo $password22; ?>"/></td>
                </tr>

                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Telephone Number</td>
                    <td align="left" valign="top"><input name="Telephone" type="text" id="Telephone" size="40" /><br /><br /></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Address</td>
                    <td align="left" valign="top"><input name="Address" type="text" id="Address" size="40" /></td>
                </tr>

                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Country <span class="errortext">*</span></td>
                    <td colspan="4" align="left" valign="top">
                        <select name="Country" >
                            <option value="NOTSELECTED" selected="selected">Please select</option>
                            <option value="US">United States</option>
                            <option value="AF">Afghanistan</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AG">Antigua And Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas</option>
                            <option value="BH">Bahrain</option>
                            <option value="BD">Bangladesh</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia</option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BV">Bouvet Island</option>
                            <option value="BR">Brazil</option>
                            <option value="IO">British Indian Ocean Territory</option>
                            <option value="BN">Brunei Darussalam</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="CF">Central African Republic</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="CN">China</option>
                            <option value="CX">Christmas Island</option>
                            <option value="CC">Cocos (Keeling) Islands</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo</option>
                            <option value="CD">Congo, DROC</option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="CI">Cote D'ivoire</option>
                            <option value="HR">Croatia</option>
                            <option value="CU">Cuba</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="TL">East Timor</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="GQ">Equatorial Guinea</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">Falkland Islands (Malvinas)</option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GH">Ghana</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GT">Guatemala</option>
                            <option value="GN">Guinea</option>
                            <option value="GW">Guinea-Bissau</option>
                            <option value="GY">Guyana</option>
                            <option value="HT">Haiti</option>
                            <option value="HM">Heard And Mc Donald Islands</option>
                            <option value="VA">Holy See (Vatican City State)</option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IR">Iran (Islamic Republic Of)</option>
                            <option value="IQ">Iraq</option>
                            <option value="IE">Ireland</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="KR">Korea, Republic Of</option>
                            <option value="KR">Korea, South</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">Lao People's Democratic Republic</option>
                            <option value="LV">Latvia</option>
                            <option value="LB">Lebanon</option>
                            <option value="LS">Lesotho</option>
                            <option value="LR">Liberia</option>
                            <option value="LY">Libyan Arab Jamahiriya</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MO">Macau</option>
                            <option value="MK">Macedonia</option>
                            <option value="MG">Madagascar</option>
                            <option value="MY">Malaysia</option>
                            <option value="MW">Malawi</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="MD">Moldova, Republic Of</option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="MM">Myanmar</option>
                            <option value="NA">Namibia</option>
                            <option value="NR">Nauru</option>
                            <option value="NP">Nepal</option>
                            <option value="NL">Netherlands</option>
                            <option value="NT">Netherlands Antilles</option>
                            <option value="NC">New Caledonia</option>
                            <option value="NZ">New Zealand</option>
                            <option value="NI">Nicaragua</option>
                            <option value="NE">Niger</option>
                            <option value="NG">Nigeria</option>
                            <option value="NU">Niue</option>
                            <option value="NF">Norfolk Island</option>
                            <option value="NO">Norway</option>
                            <option value="OM">Oman</option>
                            <option value="PK">Pakistan</option>
                            <option value="PA">Panama</option>
                            <option value="PG">Papua New Guinea</option>
                            <option value="PY">Paraguay</option>
                            <option value="PE">Peru</option>
                            <option value="PH">Philippines</option>
                            <option value="PN">Pitcairn</option>
                            <option value="PL">Poland</option>
                            <option value="PT">Portugal</option>
                            <option value="QA">Qatar</option>
                            <option value="RE">Reunion</option>
                            <option value="RO">Romania</option>
                            <option value="RU">Russia</option>
                            <option value="RW">Rwanda</option>
                            <option value="KN">Saint Kitts And Nevis</option>
                            <option value="LC">Saint Lucia</option>
                            <option value="VC">Saint Vincent And The Grenadines</option>
                            <option value="WS">Samoa</option>
                            <option value="SM">San Marino</option>
                            <option value="ST">Sao Tome And Principe</option>
                            <option value="SA">Saudi Arabia</option>
                            <option value="SN">Senegal</option>
                            <option value="CS">Serbia and Montenegro</option>
                            <option value="SC">Seychelles</option>
                            <option value="SL">Sierra Leone</option>
                            <option value="SG">Singapore</option>
                            <option value="SK">Slovakia</option>
                            <option value="SI">Slovenia</option>
                            <option value="SB">Solomon Islands</option>
                            <option value="SO">Somalia</option>
                            <option value="ZA">South Africa</option>
                            <option value="GS">S. Georgia And S. Sandwich Isles</option>
                            <option value="ES">Spain</option>
                            <option value="LK">Sri Lanka</option>
                            <option value="SH">St. Helena</option>
                            <option value="PM">St. Pierre And Miquelon</option>
                            <option value="SD">Sudan</option>
                            <option value="SR">Suriname</option>
                            <option value="SJ">Svalbard And Jan Mayen Islands</option>
                            <option value="SZ">Swaziland</option>
                            <option value="SE">Sweden</option>
                            <option value="CH">Switzerland</option>
                            <option value="SY">Syrian Arab Republic</option>
                            <option value="TW">Taiwan</option>
                            <option value="TJ">Tajikistan</option>
                            <option value="TZ">Tanzania, United Republic Of</option>
                            <option value="TH">Thailand</option>
                            <option value="TG">Togo</option>
                            <option value="TK">Tokelau</option>
                            <option value="TO">Tonga</option>
                            <option value="TT">Trinidad And Tobago</option>
                            <option value="TN">Tunisia</option>
                            <option value="TR">Turkey</option>
                            <option value="TM">Turkmenistan</option>
                            <option value="TC">Turks And Caicos Islands</option>
                            <option value="TV">Tuvalu</option>
                            <option value="UM">U.S. Minor Outlying Islands</option>
                            <option value="UG">Uganda</option>
                            <option value="UA">Ukraine</option>
                            <option value="AE">United Arab Emirates</option>
                            <option value="GB">United Kingdom</option>
                            <option value="UY">Uruguay</option>
                            <option value="UZ">Uzbekistan</option>
                            <option value="VU">Vanuatu</option>
                            <option value="VE">Venezuela</option>
                            <option value="VN">Viet Nam</option>
                            <option value="VG">Virgin Islands (British)</option>
                            <option value="VI">Virgin Islands (U.S.)</option>
                            <option value="WF">Wallis And Futuna Islands</option>
                            <option value="EH">Western Sahara</option>
                            <option value="YE">Yemen</option>
                            <option value="ZM">Zambia</option>
                            <option value="ZW">Zimbabwe</option>
                            <option value="XX">Other</option>
                    </select><br /><br /></td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">State <span class="errortext">*</span></td>
                    <td align="left" valign="top">

                    <input name="Province" type="text" id="Province" size="40"  class="<?php print $emailclass; ?>" value="<?php echo $province1; ?>"/><br /><br /></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">City <span class="errortext">*</span></td>
                    <td align="left" valign="top"><input name="City" type="text" id="City" size="40"  class="<?php print $emailclass; ?>" value="<?php echo $city1; ?>"/></td>
                </tr>

                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Organization Name <span class="errortext">*</span></td>
                    <td align="left" valign="top"><input name="OrganizationName" type="text" id="OrganizationName" size="40"  class="<?php print $emailclass; ?>" value="<?php echo $orgname1; ?>"/><br /><br /></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Organization Unit <span class="errortext">*</span></td>
                    <td align="left" valign="top"><input name="OrganizationUnit" type="text" id="OrganizationUnit" size="40"  class="<?php print $emailclass; ?>" value="<?php echo $orgunit1; ?>"/></td>
                </tr>

                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td colspan="4" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td colspan="4" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td colspan="4" align="left" valign="top"><input type="submit" name="Submit" id="Submit" value="Submit" />    </td>
                </tr>
                <tr>
                    <td colspan="6" align="left" valign="top">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="6"><DIV ALIGN="CENTER"><FONT SIZE="1" FACE="Tahoma">Copyright
                    2008 . All Rights Reserved</FONT></DIV></td>
                </tr>
                <tr>
                    <td colspan="6" BGCOLOR="#336666">&nbsp;</td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="registerusers" />
        </form>

    </body>
</html>

