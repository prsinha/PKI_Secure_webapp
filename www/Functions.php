<?
function isHTTPS()
{
        return (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on');
}

function hasValidClientCert()
{
        return (isset($_SERVER['SSL_CLIENT_VERIFY']) && strtoupper($_SERVER['SSL_CLIENT_VERIFY']) == 'SUCCESS');
}
function getClientCertCN()
{
        if (isset($_SERVER['SSL_CLIENT_S_DN_CN'])) {       return $_SERVER['SSL_CLIENT_S_DN_CN'];    }
}
function getClientCertDN()
{
        if (isset($_SERVER['SSL_CLIENT_S_DN'])) {        return $_SERVER['SSL_CLIENT_S_DN'];    }
}
function getClientCertGN()
{
        if (isset($_SERVER['SSL_CLIENT_S_DN_G'])) {       return $_SERVER['SSL_CLIENT_S_DN_G'];    }
}
function getClientCertSN()
{
     if (isset($_SERVER['SSL_CLIENT_S_DN_S'])) {        return $_SERVER['SSL_CLIENT_S_DN_S'];    }
}
function getClientCertO()
{
    if (isset($_SERVER['SSL_CLIENT_S_DN_O'])) {       return $_SERVER['SSL_CLIENT_S_DN_O'];   }
}
function getClientCertOU()
{
     if (isset($_SERVER['SSL_CLIENT_S_DN_OU'])) {         return $_SERVER['SSL_CLIENT_S_DN_OU'];     }
}
function getClientCertValidityStart()
{
     if (isset($_SERVER['SSL_CLIENT_V_START'])) {        return $_SERVER['SSL_CLIENT_V_START'];     }
}
function getClientCertValidityEnd()
{
    if (isset($_SERVER['SSL_CLIENT_V_END'])) {         return $_SERVER['SSL_CLIENT_V_END'];    }
}
function getSSLChipherType()
{
     if (isset($_SERVER['SSL_CIPHER'])) {        return $_SERVER['SSL_CIPHER'];    }
}
function getIssuerCertDN()
{
    if (isset($_SERVER['SSL_CLIENT_I_DN'])) {        return $_SERVER['SSL_CLIENT_I_DN'];    }
}
function getIssuerCertCN()
{
     if (isset($_SERVER['SSL_CLIENT_I_CN'])) {        return $_SERVER['SSL_CLIENT_I_CN'];    }
}
function getIssuerCertC()
{
     if (isset($_SERVER['SSL_CLIENT_I_C'])) {        return $_SERVER['SSL_CLIENT_I_C'];    }
}
function getIssuerCertO()
{
     if (isset($_SERVER['SSL_CLIENT_I_O'])) {        return $_SERVER['SSL_CLIENT_I_O'];    }
 }
function getIssuerCertOU()
{
     if (isset($_SERVER['SSL_CLIENT_I_OU'])) {        return $_SERVER['SSL_CLIENT_I_OU'];    }
}
function getIssuerCertST()
{
     if (isset($_SERVER['SSL_CLIENT_I_ST'])) {        return $_SERVER['SSL_CLIENT_I_ST'];     }
}
function jsTWinAlert($msg="You don't have the permit!")
{
    echo '<script> top.alert("'. $msg .'"); </script>';
}
function add_log($uid, $action, $target){
         $date = date('y-m-d H:i');
         if (!$uid && !$action && !$target){
              die ('need userid action and target to insert into log');
         }else{
              mysql_query("INSERT INTO log set userid='$uid', action='$action', target='$target', date='$date'") or die('Error to insert into log');
         }
}
?>