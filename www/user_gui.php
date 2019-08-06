<html>
<body>
<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    include 'Connections/db_open.php';
    if(isset($_POST['upload']))
    {   
	$max_ref="select max(files.FID) as id from files ";
$ref=mysql_query($max_ref,$conn) or die(mysql_error());
$max=mysql_fetch_assoc($ref);
$newref=(int)$max['id']+1;
$newref=(string)$newref;
$len=strlen($newref);
$add="0";
$pad=7-$len;
$padstr=str_pad($add,$pad,STR_PAD_LEFT);
$newref=$padstr.$newref;

        $fileName = $_FILES['userfile']['name'];
		$fdetails=$_POST['details'];
        $tmpName  = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];
        $fp = fopen($tmpName, 'r');
        $content = fread($fp, $fileSize);
        $content = addslashes($content);
        fclose($fp);
		echo $fileName.'<br>'.$tmpName.'<br>'.$fileSize.'<br>'.$fileType.'<br>'.$fp.'<br>';
		/*echo '<br>'.$content;*/
        if(!get_magic_quotes_gpc()){
            $fileName = addslashes($fileName);}
       $query = "INSERT INTO files (FID ,FName, FDetails, FSize, FType, FContent ) VALUES ('$newref','$fileName', '$fdetails', '$fileSize', '$fileType', '$content')";
        mysql_query($query) or die('Error, query failed'); 
        $query = "SELECT MAX(id) FROM files";
        $result=mysql_query($query);
        list($file_id) = mysql_fetch_row($result);
       /* $query = "INSERT INTO fileuser (idfile, iduser, r, w, o) VALUES ('$file_id', '$user_id', '1', '1', '1')";
        mysql_query($query);*/
    }

   print("<table width='40%' border='0' align='center' cellpadding='0' cellspacing='0'><tr>");
    print("<td>( <a href='index.php'>LogOut</a> )</td>");
    if($_SESSION['isadmin'] == 1)
        print("<td align='right'>( <a href='admin_gui.php'>Admin</a> )</td>");
    print("</tr></table>");
            
    $sql = "SELECT * FROM files ";
    $result = mysql_query($sql);
    $rows = mysql_num_rows($result);
    print("<table width='60%' border='0' align='center' cellpadding='0' cellspacing='0'>");
    print("<tr><td bgcolor='#d5a8f9' class='mnuheader' >");
    print("<div align='center'><font size='5'><strong>Files List</strong></font></div></td></tr></table>");
    print("<table width='60%' border='0' align='center' cellpadding='0' cellspacing='0'>");
    print(" <tr><td>Filename</td><td>Type</td><td>Size</td><td align='center'>Download</td><td  align='center'>Rename</td><td align='center'>Delete</td>");
    if($_SESSION['isadmin'] == 1) print("<td align='center'>ACL</td>");
    print("</tr>");
    
    $color = "#e5ecf9";
    for ($i = 0; $i < $rows; $i++) {
        if($i % 2 == 0 ) {  $color = "#d5e8f9";   }
        else             {  $color = "#e5ecf9";   }
        $data = mysql_fetch_object($result);
        print("<tr bgcolor=$color><td>$data->name</td><td>$data->type</td><td>$data->size</td>");
        print("<td align = 'center'><a href='file_download.php?id=$data->id'><IMG src='download.png' align=middle border=0 width=20 height=20></a></td>");
        print("<td align = 'center'><input name='name_file' type='text' id='name_file$data->id'><input type='image' name='done1' src='rename.png' width=20 height=20></td>");
        print("<td align = 'center'><a href='file_delete.php?id=$data->id'><IMG src='delete.png' align=middle border=0 width=20 height=20></a></td>");
        if($_SESSION['isadmin'] == 1) 
        print("<td align = 'center'><a href='acl.php?id=$data->id'><IMG src='users.png' align=middle border=0 width=20 height=20></a></td>");
        print(" </tr>\n");
   }
   mysql_free_result($result);
?> 
   
<table width='60%' border='0' align='center' cellpadding='0' cellspacing='0'>
   <tr><td bgcolor='#d5a8f9' class='mnuheader' >
   <div align='center'><font size='5'><strong>File Upload</strong></font></div></td>
   </tr></table>
   
<form action="" method="post" enctype="multipart/form-data" name="uploadform">
  <table width="350" align="center" border="0" cellpadding="1" cellspacing="1" class="box">
    <tr><td width="400">
    Details<input name="details" id="details" type="text" size="80" maxlength="255"><br><br>
      <input name="userfile" type="file" class="box" id="userfile">
       </td>
      <td width="80">
      <input name="upload" type="submit" class="box" id="upload" value="Upload"></td>
    </tr></table></form>
</body>
</html>
