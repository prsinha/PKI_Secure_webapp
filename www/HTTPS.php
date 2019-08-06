<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function isHTTPS()
{
        return (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on');
}

function hasValidClientCert()
{
        return (isset($_SERVER['SSL_CLIENT_VERIFY']) && strtoupper($_SERVER['SSL_CLIENT_VERIFY']) == 'SUCCESS');
}
if ( isHTTPS())
{
    echo 'is https';
}
else
{
    echo 'is not https';
}
echo $_SERVER['SSL_CLIENT_VERIFY'];
if (  hasValidClientCert())
{
    echo 'is  hasValidClientCert';
}
else
{
    echo 'is not  hasValidClientCert';
}
?>
