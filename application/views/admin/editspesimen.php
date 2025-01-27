<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<script type="text/javascript">  
  function GetXmlHttpObject()
  {
    if (window.XMLHttpRequest)
      {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      return new XMLHttpRequest();
      }
    if (window.ActiveXObject)
      {
      // code for IE6, IE5
      return new ActiveXObject("Microsoft.XMLHTTP");
      }
    return null;
  }
  
  
  function showData(str1, str2, str3)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdataspesimen";
    url=url+"?status="+str1;
    url=url+"&nip="+str2;
    url=url+"&jab="+str3;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedData;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedData(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("tampil").innerHTML=xmlhttp.responseText;
    }

    if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("tampil").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Waiting...</center>";
    }
  } 
</script>

<center>  
  <div class="panel panel-default" style="width: 70%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../admin/carispesimen'>";          
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      
      <div class="panel panel-danger">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        EDIT SPESIMEN<br /><b><?php echo $nmunker; ?></b>
        </div>
        <?php
          // foreach($spes as $v):
        if($v != NULL):
        ?>
        <form method='POST' name='formeditspes' action='../admin/editspesimen_aksi'>
          <input type='hidden' name='idunker'  size='30' value='<?php echo $v['fid_unit_kerja']; ?>' />
          <table class="table">
            <tr>
              <td align='center'>              
              
                <table class='table table-condensed'>
                  <tr>
                    <td align='right'>Status :</td>
                    <td>
                      <select name="status" id="status" onChange="showData(this.value, formeditspes.nip.value, formeditspes.jabatan.value)" required />
                        <?php
                        if ($v['status'] == 'DEFINITIF') {
                          echo "<option value='DEFINITIF' selected>Definitif</option>";
                          echo "<option value='PLT'>Pelaksana Tugas</option>";
                          echo "<option value='PLH'>Pelaksana Harian</option>";
                          echo "<option value='AN'>Atas Nama</option>";
                          echo "<option value='PJ'>Penjabat</option>";
                        } else if ($v['status'] == 'PLT') {
                          echo "<option value='DEFINITIF'>Definitif</option>";
                          echo "<option value='PLT' selected>Pelaksana Tugas</option>";
                          echo "<option value='PLH'>Pelaksana Harian</option>";
                          echo "<option value='AN'>Atas Nama</option>";
                          echo "<option value='PJ'>Penjabat</option>";
                        } else if ($v['status'] == 'PLH') {
                          echo "<option value='DEFINITIF'>Definitif</option>";
                          echo "<option value='PLT'>Pelaksana Tugas</option>";
                          echo "<option value='PLH' selected>Pelaksana Harian</option>";
                          echo "<option value='AN'>Atas Nama</option>";
                          echo "<option value='PJ'>Penjabat</option>";
                        } else if ($v['status'] == 'AN') {
                          echo "<option value='DEFINITIF'>Definitif</option>";
                          echo "<option value='PLT'>Pelaksana Tugas</option>";
                          echo "<option value='PLH'>Pelaksana Harian</option>";
                          echo "<option value='AN' selected>Atas Nama</option>";
                          echo "<option value='PJ'>Penjabat</option>";
                        } else if ($v['status'] == 'PJ') {
                          echo "<option value='DEFINITIF'>Definitif</option>";
                          echo "<option value='PLT'>Pelaksana Tugas</option>";
                          echo "<option value='PLH'>Pelaksana Harian</option>";
                          echo "<option value='AN'>Atas Nama</option>";
                          echo "<option value='PJ' selected>Penjabat</option>";
                        }

                        ?>
                      </select>                            
                    </td>
                    <td rowspan='4' align='center' width='400'>
                    <div id='tampil'>
                    <?php
                    echo "<center><img src=".base_url()."photo/".$v['nip'].".jpg width='90' height='120'></center>";
                    ?>
                    </div>
                    </td>
                  </tr>
                  <tr>
                    <td align='right'>NIP :</td>
                    <td>
                    <input type='hidden' name='nip_lama'  size='30' maxlength='18' value='<?php echo $v['nip']; ?>' />
                    <input type='text' name='nip' size='30' maxlength='18' value='<?php echo $v['nip']; ?>' onChange='showData(formeditspes.status.value, this.value, formeditspes.jabatan.value)' />
                    </td>                  
                  </tr>
                  <tr>
                    <td align='right'>Jabatan :</td>
                    <td>
                    <input type="text" name='jabatan' size='120' maxlength='200'
			value='<?php echo $v['jabatan_spesimen']; ?>' onChange='showData(formeditspes.status.value, formeditspes.nip.value, this.value)'/>
                    </td>                  
                  </tr>
                  <tr>
                    <td align='right' colspan='2'></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table> 
        </form>
        <?php
        else:
        $nip_login = $this->session->userdata('nip');
        echo form_open(base_url('admin/tambahspesimen_aksi'));
        ?>
        <table class="table">
          <tr>
            <td align='center'>              
             
              <table class='table table-condensed'>
                <tr>
                  <td align='right'>Unit Kerja :</td>
                  <td>
                    <select name="unorid" id="unorid">
                      <?php foreach($this->madmin->getListUnor()->result() as $u): ?>
                        <option value="<?= $u->id_unit_kerja ?>"><?= $u->nama_unit_kerja ?></option>
                      <?php endforeach; ?>
                    </select>
                  </td>    
                </tr>
                <tr>
                  <td align='right'>Status :</td>
                  <td>
                    <select name="status" id="status" />
                      <?php
                        echo "<option value=''>Pilih status jabatan</option>";
                        echo "<option value='DEFINITIF'>Definitif</option>";
                        echo "<option value='PLT'>Pelaksana Tugas</option>";
                        echo "<option value='PLH'>Pelaksana Harian</option>";
                        echo "<option value='AN'>Atas Nama</option>";
                        echo "<option value='PJ'>Penjabat</option>";
                      ?>
                    </select>                            
                  </td>
                </tr>
                
                <tr>
                  <td align='right'>NIP :</td>
                  <td>
                  <input type='text' name='nip' size='30' maxlength='18'/>
                  </td>                  
                </tr>
                <tr>
                  <td align='right'>Jabatan :</td>
                  <td>
                  <input type="text" name='jabatan' size='60'/>
                  </td>                  
                </tr>
                <tr>
                  <td align='right' colspan='2'>
                    <button type="submit" class="btn btn-success"><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>&nbsp;Simpan</button>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <?php
        echo form_close();
        endif;
        ?>
      </div>      
    </div> <!-- end class="panel-body" -->
  </div>  
</center>
