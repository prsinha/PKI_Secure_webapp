<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LdapEntry
 *
 * @author user1
 */
class LdapEntry {

    var $LDAP ="localhost";// assuming the LDAP server is on this host
    var $MANAGER = "cn=Manager, dc=myserver, dc=dev";
    var $PWD ="secret";

    function insert_into_ldap($ldaprecord){
        $cn =$ldaprecord["cn"];
        $ds = ldap_connect ("ldaps://LdapServer")or die("fail to connect with ldap server in the location");

        if ($ds) {
            // bind with appropriate dn to give update access
            ldap_set_option ($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            $r = ldap_bind($ds,"cn=Manager, dc=myserver, dc=dev" ,"secret" ) or  die("could not bind with ldap server");
            if($r){
                echo "ldap bind successful";
            }
            else{
                echo "bind unsuccessful";
            }
            // add data to directory
            $dn ="cn=".$cn.",dc=myserver,dc=dev";
            $r= ldap_add($ds, $dn,$ldaprecord );
            if(!$r){
                echo "LDAP-ERRORNO: ".ldap_errno($ds)."<br />n";
                echo "LDAP-ERROR: ".ldap_error($ds)."<br />n";
            }
            //just to check..will omit later..
            if(ldap_error($ds)== "Success"){
                echo "<p>successful";
            }
            else{
                echo "<p>not successful";
            }
            ldap_close($ds);
        }//end of if
        else {
            echo "Unable to connect to LDAP server";
        }
    }
    function delete_from_ldap($del_cn){

        $ds = ldap_connect ("ldaps://LdapServer")or die("fail to connect with ldap server in the location");

        if ($ds) {
            // bind with appropriate dn to give update access
            ldap_set_option ($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            $r = ldap_bind($ds,"cn=Manager, dc=myserver, dc=dev" ,"secret" ) or  die("could not bind with ldap server");
            if($r){
                echo "ldap bind successful";
            }
            else{
                echo "bind unsuccessful";
            }
            // add data to directory
            $dn ="cn=".$del_cn.",dc=myserver,dc=dev";
            $r= ldap_delete($ds, $dn );
            if(!$r){
                echo "LDAP-ERRORNO: ".ldap_errno($ds)."<br />n";
                echo "LDAP-ERROR: ".ldap_error($ds)."<br />n";
            }
            //just to check..will omit later..
            if(ldap_error($ds)== "Success"){
                echo "<p>successful";
            }
            else{
                echo "<p>not successful";
            }
            ldap_close($ds);
        }//end of if
        else {
            echo "Unable to connect to LDAP server";
        }
    }
}
?>
