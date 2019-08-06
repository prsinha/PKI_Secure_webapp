<?php
	require_once('Connections/conn.php');
    include 'Connections/db_open.php';
	session_start();
	echo "<h3>Certificate Authentication.</h3>";
	//function for converting pem data into der data.
	function pem2der($pem_data) {
        $begin = "CERTIFICATE-----";
        $end   = "-----END";
        $pem_data = substr($pem_data, strpos($pem_data, $begin)+strlen($begin));
        $pem_data = substr($pem_data, 0, strpos($pem_data, $end));
        $der = base64_decode($pem_data);
        return $der;
    }

	//converting der data into pem.
    function der2pem($der_data) {
        $pem = chunk_split(base64_encode($der_data), 64, "\n");
        $pem = "-----BEGIN CERTIFICATE-----\n".$pem."-----END CERTIFICATE-----\n";
        return $pem;
    }
    //connect with ldap remotely.
    $ds = ldap_connect ("ldaps://LdapServer");
	if ($ds)
	{
		ldap_set_option ($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		// anonymous binding as we dont need to do any modification.
		ldap_bind ($ds);
        //get client certificate from the Apache server.
		$cert1 = openssl_x509_read($_SERVER["SSL_CLIENT_CERT"]);
		//$derData = pem2der($pem_data);
        //convert certificate into string for comparison.
		openssl_x509_export($cert1,$certString);
		$cert = openssl_x509_parse($cert1);
		$cn=$cert['subject']['CN'];

		//this part is for retrieving information from the ldap.
        $dn = "dc=myserver, dc=dev";
        //we are interested only about those certificate which common name is equal the common name of the certificate
        //which is provided by Apache.
        $filter="(cn=$cn)";
        $justthese = array("userCertificate;binary","cn");
        $sr=ldap_search($ds, $dn, $filter, $justthese);
        $info = ldap_get_entries($ds, $sr);
        $entry =ldap_first_entry($ds, $sr);
        $attributes = ldap_get_attributes($ds,$entry);
        $certificate =$attributes["userCertificate;binary"][0];
        //convert certificate into .PEM format for further processing.
        $cert2= der2pem($certificate);
        openssl_x509_export($cert2,$certS);
		//Hash comparison for authentication...
        if(strcmp(hash('md5',$certString),hash('md5',$certS))== 0)
        {			
			$_SESSION['user_cn'] = $cn;
            echo "Authenticated as :" .$_SESSION['user_cn'];
		   //header("location:home.php");
        }
        else{
            echo "Certificate is not valid";
        }
 	}
    //close the connection.
 	ldap_close ($ds);

	$date =date('l jS \of F Y h:i:s A');
	//this function gets the ip address to use it for logging purpose
	function getRealIpAddr()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
			{
			  $ip=$_SERVER['HTTP_CLIENT_IP'];
			}
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
			{
			  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
			  $ip=$_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
	

    if ($_SESSION['user_cn'])
    {
        $sql = "SELECT UserID,Email,RID  FROM userdetails WHERE  User_cn = '".$_SESSION['user_cn']."'";		
       $result = mysql_query($sql) or die (mysql_error());
        $num = mysql_num_rows($result);
        if ( $num != 0 ) {
            list($user_id,$user_name,$role_id) = mysql_fetch_row($result);
            $_SESSION['user_id']= $user_id;
            $_SESSION['user_name']= $user_name;
            $_SESSION['role_id']= $role_id;
            if (isset($_GET['ret']) && !empty($_GET['ret']))
            {           header("Location: $_GET[ret]");
            } else{     header("location:home.php");}
		
		$x= getRealIpAddr();
		$logdetails ="User : ".$user_name." Logged in on ".$date." from ".$x;
			$max_ref="select count(logdetails.LID) + 1 as id from logdetails ";
			$ref=mysql_query($max_ref,$conn) or die(mysql_error());
			$max=mysql_fetch_assoc($ref);
			$newref=(int)$max['id'];
			$newref="LOG".$newref;
		$query = "INSERT INTO logdetails  (LID, LDetails) VALUES ('$newref', '$logdetails')";
        mysql_query($query) or die('Error, query failed');
		}
		else
		{ 
			$msg="Incorect username or password";
			$x= getRealIpAddr();
			$logdetails ="User : ".$user_name." was unable to log in on ".$date." from ".$x;
			$max_ref="select count(logdetails.LID) + 1 as id from logdetails ";
			$ref=mysql_query($max_ref,$conn) or die(mysql_error());
			$max=mysql_fetch_assoc($ref);
			$newref=(int)$max['id'];
			$newref="LOG".$newref;
			$query = "INSERT INTO logdetails  (LID, LDetails) VALUES ('$newref', '$logdetails')";
        	mysql_query($query) or die('Error, query failed');
		}	
	}

?>