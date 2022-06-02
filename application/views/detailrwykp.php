<?php  
if(isset($_POST['submit'])){

  $sql = "SELECT * FROM riwayat_pekerjaan WHERE fid_golru='".$_POST['id']."'";
  $query = mysql_query($sql);
  $row = mysql_fetch_array($query);

  echo jsson_encode($row); 
}
?>