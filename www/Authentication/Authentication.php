<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Authentication
 *
 * @author user1
 */
class Authentication {

       var $dn = "dc=myserver, dc=dev";
       var $LDAP = "localhost";
       var $VALID = "authenticated";
       var $INVALID = "not authenticated";
       var $LDAP_UNREACHABLE = "unreachable";
       var $NO_CERT_INFO = "No certificate information found.";
       var $HASH_ALG = 'md5';

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

    function getCert_from_ldap($userName ){
        $ds = ldap_connect ($LDAP);
    	if ($ds)
        {
            //$dn = "dc=myserver, dc=dev";
            //$filter="(User Name=$userName,userPassword=$passWord)";
            $filter="(cn=.$userName)";
            $justthese = array("userCertificate;binary");
            $sr=ldap_search($ds, $dn, $filter, $justthese);
            $entry =ldap_first_entry($ds, $sr);
            $attributes = ldap_get_attributes($ds,$entry);
            $cert_der =$attributes["userCertificate;binary"][0];
            $cert_pem= der2pem($cert_der);
            openssl_x509_export($cert_pem,$cert_pem_string);

            ldap_close ($ds);
            return $cert_pem_string;
        }
    }

    function authenticate( $userName ){

            ldap_set_option ($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            // using anonymous binding.
            ldap_bind ($ds);
            //take the client certificate from the web server.
            $loginCert = openssl_x509_read($_SERVER["SSL_CLIENT_CERT"]);
            //convert the certificate into string.
            openssl_x509_export( $cert1 , $login_cert_String );
            //this part is for retrieving information from the ldap.
            $login_cert_hash = hash($HASH_ALG , $login_cert_String);
            //get the certificate string from the LDAP.
            $ldap_cert_string = getCert_from_ldap($userName);
            $ldap_cert_hash = hash($HASH_ALG , $ldap_cert_string);

            if( strcmp ($ldap_cert_hash,$login_cert_hash) ==  0 )
            {
                return $VALID;
            }
            else{
                return $INVALID;
            }
     }
}
?>
