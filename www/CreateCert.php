<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateCert
 *
 * @author user1
 */
class CreateCert {


    function file_get_cert_key($certFile, $keyFile){

        $handle = fopen($certFile ,"r");
        $handle1 = fopen($keyFile ,"r");
        $certData=  fread($handle , filesize($certFile));
        $keyData = fread($handle1 , filesize($keyFile));
        fclose(handle);
        fclose(handle1);
        $certInfo[0]=$certData;
        $certInfo[1]=$keyData;
        return $certInfo;
    }
    //this function will receive $dn of the user . Create a csr sign it by the CA then stroe it in the filesystem
    //then convert teh certificate into .DER format and return it.
    function create_certificate($dn){

        $cn = $dn["commonName"];
        //get the CA certificate and key from the filesystem.
        $certFile ="C:/OpenSSL/keyStore/ca.cer";
        $keyFile ="C:/OpenSSL/keyStore/ca.key";
        $handle = fopen($certFile ,"r");
        $handle1 = fopen($keyFile ,"r");
        $certData=  fread($handle , filesize($certFile));
        $keyData = fread($handle1 , filesize($keyFile));
        fclose(handle);
        fclose(handle1);
        //create key for the client
        $clientKeys = openssl_pkey_new();
        $csr = openssl_csr_new($dn, $clientKeys);
        $cert = openssl_csr_sign($csr, $certData , $keyData, 100 );
        //save the certificate into the filesystem.
        openssl_x509_export_to_file($cert,"C:/OpenSSL/keyStore/user certificate/".$cn.".cer");
        //save certificate inside the pkcs12 keystore.
        openssl_pkcs12_export_to_file($cert,"C:/OpenSSL/keyStore/user certificate/".$cn.".p12",$clientKeys,"password");
        $dir = "C:/OpenSSL/keyStore/user certificate/".$cn.".cer";

        $sinha = file_get_contents($dir);//this value will be converted to .der to store into the ldap server.
        return $sinha;
    }
}
?>
