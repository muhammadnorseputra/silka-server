<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../admin/listuser'>";          
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method='POST' action='../admin/edituser_aksi'>
      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>EDIT USER</b>
        </div>
        <?php
          foreach($user as $v):
        ?>

        <table class="table">
          <tr>
            <td align='center'>              
             
              <table class='table table-condensed'>
                <tr>
                  <td align='right' colspan='2'>NIP :</td>
                  <td colspan='3'>
                  <input type="text" size='30' maxlength='18' value='<?php echo $v['nip']; ?>' disabled/>
                  <input type="hidden" name="nip" size='30' maxlength='18' value='<?php echo $v['nip']; ?>' />
                  </td>
                  <td rowspan='4' colspan='5' align='center'>
                  <?php
                  $lokasifile = './photo/';
                  $filename = $v['nip'].".jpg";

                  if (file_exists ($lokasifile.$filename)) {
                    $photo = "../photo/".$v['nip'].".jpg";
                  } else {
                    $photo = "../photo/nophoto.jpg";
                  }
                  echo "<center><img class='img-thumbnail' src='$photo' width='90' height='120'></center>";
                  ?>
                  </td>
                </tr>
                <tr>
                  <td align='right' colspan='2'>Nama :</td>
                  <td colspan='3'><input type="text" name="nama" size='30' maxlength='18' value='<?php echo $nama; ?>' disabled/>
                  </td>
                </tr>
                <tr>
                  <td align='right' colspan='2'>Username :</td>
                  <td colspan='3'>
                    <input type="hidden" name="unamelama" size='30' maxlength='18' value='<?php echo $v['username']; ?>' />
                    <input type="text" name="unamebaru" size='30' maxlength='18' value='<?php echo $v['username']; ?>' />
                  </td>
                </tr>
                <tr>
                  <td align='right' colspan='2'>Level :</td>
                  <td colspan='3'>
                    <select name="level" id="level" required />
                      <?php
                      if ($v['level'] == 'ADMIN') {
                        echo "<option value='ADMIN' selected>ADMIN</option>";
                        echo "<option value='USER'>USER</option>";
                        echo "<option value='TAMU'>TAMU</option>";
                      } else if ($v['level'] == 'USER') {
                        echo "<option value='ADMIN'>ADMIN</option>";
                        echo "<option value='USER' selected>USER</option>";
                        echo "<option value='TAMU'>TAMU</option>";
                      } else if ($v['level'] == 'TAMU') {
                        echo "<option value='ADMIN'>ADMIN</option>";
                        echo "<option value='USER'>USER</option>";
                        echo "<option value='TAMU' selected>TAMU</option>";
                      }

                      ?>
                    </select>                            
                  </td>
                </tr>
                <tr class='danger'>
                  <td colspan='10' align='center'>PRIVILEDGE</td>
                </tr>
                <tr class='danger'>
                  <td width='70' align='right'>Profil</td>
                  <td width='100'>
                    <?php
                    if ($v['profil'] == 'Y') {
                      echo "<input name='profil' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='profil' type='radio' value='N'>N";  
                    } else if ($v['profil'] == 'N') {
                      echo "<input name='profil' type='radio' value='Y'>Y &nbsp
                    <input name='profil' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>Edit Profil</td>
                  <td width='100'>
                    <?php
                    if ($v['edit_profil'] == 'Y') {
                      echo "<input name='edit_profil' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='edit_profil' type='radio' value='N'>N";  
                    } else if ($v['edit_profil'] == 'N') {
                      echo "<input name='edit_profil' type='radio' value='Y'>Y &nbsp
                    <input name='edit_profil' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>Cetak Profil</td>
                  <td width='100'>
                    <?php
                    if ($v['cetak_profil'] == 'Y') {
                      echo "<input name='cetakprofil' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='cetakprofil' type='radio' value='N'>N";  
                    } else if ($v['cetak_profil'] == 'N') {
                      echo "<input name='cetakprofil' type='radio' value='Y'>Y &nbsp
                    <input name='cetakprofil' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>Nominatif</td>
                  <td width='100'>
                    <?php
                    if ($v['nominatif'] == 'Y') {
                      echo "<input name='nominatif' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='nominatif' type='radio' value='N'>N";  
                    } else if ($v['nominatif'] == 'N') {
                      echo "<input name='nominatif' type='radio' value='Y'>Y &nbsp
                    <input name='nominatif' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='90' align='right'>Cetak Nominatif</td>
                  <td width='100'>
                    <?php
                    if ($v['cetak_nominatif'] == 'Y') {
                      echo "<input name='cetaknominatif' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='cetaknominatif' type='radio' value='N'>N";  
                    } else if ($v['cetak_nominatif'] == 'N') {
                      echo "<input name='cetaknominatif' type='radio' value='Y'>Y &nbsp
                    <input name='cetaknominatif' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                </tr>
                <tr class='danger'>
                  <td width='70' align='right'>Statistik</td>
                  <td width='100'>
                    <?php
                    if ($v['statistik'] == 'Y') {
                      echo "<input name='statistik' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='statistik' type='radio' value='N'>N";  
                    } else if ($v['statistik'] == 'N') {
                      echo "<input name='statistik' type='radio' value='Y'>Y &nbsp
                    <input name='statistik' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>                
                  <td width='90' align='right'>Cetak Statistik</td>
                  <td width='100'>
                    <?php
                    if ($v['cetak_statistik'] == 'Y') {
                      echo "<input name='cetakstatistik' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='cetakstatistik' type='radio' value='N'>N";  
                    } else if ($v['cetak_statistik'] == 'N') {
                      echo "<input name='cetakstatistik' type='radio' value='Y'>Y &nbsp
                    <input name='cetakstatistik' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>SOTK</td>
                  <td width='100'>
                    <?php
                    if ($v['sotk'] == 'Y') {
                      echo "<input name='sotk' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='sotk' type='radio' value='N'>N";  
                    } else if ($v['sotk'] == 'N') {
                      echo "<input name='sotk' type='radio' value='Y'>Y &nbsp
                    <input name='sotk' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>Cetak SOTK</td>
                  <td width='100'>
                    <?php
                    if ($v['cetak_sotk'] == 'Y') {
                      echo "<input name='cetaksotk' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='cetaksotk' type='radio' value='N'>N";  
                    } else if ($v['cetak_sotk'] == 'N') {
                      echo "<input name='cetaksotk' type='radio' value='Y'>Y &nbsp
                    <input name='cetaksotk' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>Usul Cuti</td>
                  <td width='100'>
                    <?php
                    if ($v['usulcuti'] == 'Y') {
                      echo "<input name='usulcuti' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='usulcuti' type='radio' value='N'>N";  
                    } else if ($v['usulcuti'] == 'N') {
                      echo "<input name='usulcuti' type='radio' value='Y'>Y &nbsp
                    <input name='usulcuti' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                </tr>
                <tr class='danger'>
                  <td width='70' align='right'>Proses Cuti</td>
                  <td width='100'>
                    <?php
                    if ($v['prosescuti'] == 'Y') {
                      echo "<input name='prosescuti' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='prosescuti' type='radio' value='N'>N";  
                    } else if ($v['prosescuti'] == 'N') {
                      echo "<input name='prosescuti' type='radio' value='Y'>Y &nbsp
                    <input name='prosescuti' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>Usul KGB</td>
                  <td width='100'>
                    <?php
                    if ($v['usulkgb'] == 'Y') {
                      echo "<input name='usulkgb' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='usulkgb' type='radio' value='N'>N";  
                    } else if ($v['usulkgb'] == 'N') {
                      echo "<input name='usulkgb' type='radio' value='Y'>Y &nbsp
                    <input name='usulkgb' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>Proses KGB</td>
                  <td width='100'>
                    <?php
                    if ($v['proseskgb'] == 'Y') {
                      echo "<input name='proseskgb' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='proseskgb' type='radio' value='N'>N";  
                    } else if ($v['proseskgb'] == 'N') {
                      echo "<input name='proseskgb' type='radio' value='Y'>Y &nbsp
                    <input name='proseskgb' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
                  <td width='70' align='right'>NON PNS</td>
                  <td width='100'>
                    <?php
                    if ($v['nonpns'] == 'Y') {
                      echo "<input name='nonpns' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='nonpns' type='radio' value='N'>N";  
                    } else if ($v['nonpns'] == 'N') {
                      echo "<input name='nonpns' type='radio' value='Y'>Y &nbsp
                    <input name='nonpns' type='radio' value='N' checked='checked'>N";  
                    }
                    ?>
                  </td>
		  <td width='70' align='right'>AKUN PNS</td>
                  <td width='100'>
                    <?php
                    if ($v['nonpns'] == 'Y') {
                      echo "<input name='akunpns' type='radio' value='Y' checked='checked'>Y &nbsp
                    <input name='akunpns' type='radio' value='N'>N";
                    } else if ($v['nonpns'] == 'N') {
                      echo "<input name='akunpns' type='radio' value='Y'>Y &nbsp
                    <input name='akunpns' type='radio' value='N' checked='checked'>N";
                    }
                    ?>
                  </td>
                </tr>
		<tr class='danger'>
                  <td width='70' align='right'>TPP</td>
                  <td width='100'>
                    <?php
                    if ($v['tpp'] == 'Y') {
                      echo "<input name='tpp' type='radio' value='Y' checked='checked'>Y &nbsp
                            <input name='tpp' type='radio' value='N'>N";
                    } else if ($v['tpp'] == 'N') {
                      echo "<input name='tpp' type='radio' value='Y'>Y &nbsp
                            <input name='tpp' type='radio' value='N' checked='checked'>N";
                    }
                    ?>
                  </td>
		</tr>
              </table>
            </td>
          </tr>
        </table>
        <?php
        endforeach;
        ?>
      </div>          
        <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
        </p>
      </form>
    </div> <!-- end class="panel-body" -->
  </div>  
</center>
<?php
if ($this->session->flashdata('pesan') <> ''){
  ?>
  <div class="alert alert-dismissible alert-danger">
    <?php echo $this->session->flashdata('pesan');?>
  </div>
  <?php
}
?>
