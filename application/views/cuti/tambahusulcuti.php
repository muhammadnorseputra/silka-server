<!-- untuk inputan hanya angka dengan javascript -->
<!--
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
-->

<script type="text/javascript">
  $(document).ready(function () {
    $('.tanggal').datepicker({
      format: "dd-mm-yyyy",
      todayHighlight: true,
      clearBtn: true,
      autoclose:true
    });
    
    /*function laranganCuti() {
	  var tanggal_usul = $('input[name="tglmulai"]').val();
	  var tanggal_usul2 = $('input[name="tglselesai"]').val();
	  var msg = 'Sesuai dengan surat edaran menpan nomor 08 tahun 2021 tentang pembatasan bepergian keluar daerah atau cuti bagi ASN dalam masa pandemi covid-19 pada periode 6 Mei 2021 - 17 Mei 2021';
		  
	  var pecah_tgl_usul = tanggal_usul.split('-');
	  var get_bulan = pecah_tgl_usul['1']; 
	  
	  var pecah_tgl_usul2 = tanggal_usul2.split('-');
	  var get_bulan2 = pecah_tgl_usul2['1'];  
	   
		  if((tanggal_usul > '05-05-2021') && (tanggal_usul < '18-05-2021') && (get_bulan == '05')) {
		  	alert(msg);
		  	$('input[name="tglmulai"]').val('');
		  } 
		  if((tanggal_usul2 > '05-05-2021') && (tanggal_usul2 < '18-05-2021') && (get_bulan2 == '05')) {
		  	alert(msg);
		  	$('input[name="tglselesai"]').val('');
		  }
		  	
	  }*/
	  
	  
		$('select[name="id_jnscuti"]').on('change', function() {
			var jns = $(this).val();
			if(jns == '1') {
				/*$('.tanggal').on("change", laranganCuti);*/	
				$('input[name="tglmulai"]').val('');
				$('input[name="tglselesai"]').val('');	
			}
		});
		
	  
  });
  
  
	  
  
  

  //validasi textbox khusus angka
  function validAngka(a)
  {
    if(!/^[0-9.]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }
  }

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

  /*
  function showKetCuti(idjnscuti) {
  $.ajax({
    type: "POST",
    url: "<?php echo site_url('cuti/showketcuti'); ?>",
    data: "idjnscuti="+idjnscuti,
    success: function(data) {
      $("#KetCuti").html(data);
    },
    error:function (XMLHttpRequest) {
      alert(XMLHttpRequest.responseText);
    }
    })
  };
  */

  function showKetCuti(str1, str2, str3, str4)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }

    var url="showketcuti";
    url=url+"?idjnscuti="+str1;
    url=url+"&thn="+str2;
    url=url+"&nip="+str3;
    url=url+"&kel="+str4;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedKetCuti;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedKetCuti(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("KetCuti").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("KetCuti").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  }

  function showNama(str1, str2, str3)
  {
    //document.getElementById("nama").innerHTML= "NAMA";
    //window.location="getdatacuti?cmd=nama&nip=198104072009041002"
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="getdatacuti";
    url=url+"?thn="+str1;        
    url=url+"&nip="+str2;
    url=url+"&kel="+str3;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedNama;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }
  
  function stateChangedNama(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("nama").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("nama").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  } 
  
</script>

<center>  
  <div class="panel panel-default" style="width: 80%">
    <div class="panel-body">
      <?php
        echo "<form method='POST' action='../cuti/detailpengantar'>";          
        echo "<input type='hidden' name='id_pengantar' id='id_pengantar' value='$idpengantar'>";
        //echo "<input type='hidden' name='nip' id='nip' maxlength='18' value='$nip'>";
      ?>
        <p align="right">
          <button type="submit" class="btn btn-danger btn-sm">&nbsp
          <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>&nbspBatal&nbsp&nbsp&nbsp
          </button>
        </p>
      <?php
        echo "</form>";          
      ?>

      <form method="POST" name="formtambahusulcuti" action="../cuti/tambahusul_aksi">
      <input type='hidden' name='id_pengantar' id='id_pengantar' value='<?php echo $idpengantar; ?>'>

      <div class="panel panel-info">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>TAMBAH USUL CUTI</b>
        </div>
	
        <table class="table table-condensed">
          <tr>
	
            <td align='center'>                           
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='110'>No. Pengantar :</td>
                  <td width='300'><input type="text" name="nopengantar" value="<?php echo $nopengantar; ?>" disabled/></td>
                  <td align='right' width='110'>Tgl. Pengantar :</td>
                  <td width='200'><input type="text" name="tglpengantar" class="tanggal" value="<?php echo tgl_indo($tglpengantar); ?>" disabled /></td>
                  <td rowspan='1' align='center'>
		  </td>
                </tr>
		<tr>
                  <td align='right' class='warning'>Tahun Cuti :</td>
                  <td class='warning'>
                    <input type="text" name="tahun" id="tahun" size='8' maxlength='4' onkeyup="validAngka(this)" value="<?php echo date('Y'); ?>" 
		    onChange="showKetCuti(formtambahusulcuti.id_jnscuti.value, this.value, formtambahusulcuti.nip.value, 'CUTI LAINNYA')" required />
                  </td>
		  <td rowspan='3' colspan='2' class='warning' align='center'>
			<span class='text-primary'>Silahkan entri data Tahun Cuti, NIP dan Jenis Cuti</span>
			<div id='nama'></div>
		  </td>
                  <td width='280' rowspan='3' colspan='2' class='warning' align='center'>
			<span class='text-primary'>Saat ini, HANYA CUTI TAHUNAN mewajibkan DATA SKP TAHUNAN</span>
			<div id='KetCuti'></div>
		  </td>
                </tr>
                <tr>
                  <td align='right' class='warning'>NIP :</td>
                  <!-- NIP ini hanya untuk pencarian, NIP yang disimpan ke database pada Controller cuti.php getdatacuti(), dengan metode ajax -->
		  <td class='warning'>
			<input type="text" name="nip" id="nip" size='25' maxlength='18' onkeyup="validAngka(this)"
			onChange="showNama(formtambahusulcuti.tahun.value, this.value, 'CUTI LAINNYA')" 
			value='' required />
		  </td>
		</tr>                
                <tr>
                  <td align='right' class='warning'>Jenis Cuti :</td>
                  <td class='warning'>
                    <select name="id_jnscuti" id="id_jnscuti" 
		    onChange="showKetCuti(this.value, formtambahusulcuti.tahun.value, formtambahusulcuti.nip.value, 'CUTI LAINNYA')" 
		    required>			
                      <?php
                      echo "<option value=''>- Pilih Jenis Cuti -</option>";
                      foreach($jnscuti as $jc)
                      {
                        echo "<option value='".$jc['id_jenis_cuti']."'>".$jc['nama_jenis_cuti']."</option>";
                      }
                      ?>
                    </select>
                  </td>
                </tr> 
                <tr>
                  <td align='right'>Jumlah :</td>
                  <td><input type="text" name="jml" size='8' maxlength='2' onkeyup="validAngka(this)" required/>
                  <select name="satuan_jml" id="satuan_jml" required />
                    <option value='' selected>- Pilih Satuan -</option>
                    <option value='HARI'>HARI</option>
                    <option value='BULAN'>BULAN</option>
                  </select>                      
                  </td>
                  <td align='right'>Tanggal Cuti :</td>
                  <td colspan='3'>
                    <input type="text" name="tglmulai" size='12' class="tanggal" required /> s/d 
		    <input type="text" name="tglselesai" size='12' class="tanggal" required />
                  </td>
                </tr>
                <tr>
                  <td align='right'>Alamat :</td>
                  <td colspan='6'>
                    <input type="text" name="alamat" size='90' maxlength='200' required/>
                  </td>                  
                </tr>
                <tr>
                <td align='right' colspan='2'>Catatan Pejabat Kepegawaian</td>
                <td align='center' colspan='2'>Catatan / Pertimbangan Atasan Langsung</td>
                <td align='left' colspan='2'>Keputusan Pejabat Yang Berwenang</td>
                </tr>
                <tr>
                  <td colspan='2' align='right'>
                    <textarea id="catatan_pej_kepeg" name="catatan_pej_kepeg" rows="7" cols="35" required></textarea>
                  </td>
                  <td colspan='2' align='center'>
                    <textarea id="catatan_atasan" name="catatan_atasan" rows="7" cols="35"></textarea>
                  </td>
                  <td colspan='3' align='left'>
                    <textarea id="keputusan_pej" name="keputusan_pej" rows="7" cols="35"></textarea>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
	
      </div>
       <!-- Tombol submit ada pada file cuti.php function getdatacuti() dengan metode ajax -->
       <!-- 
        <p align="right">
          <button type="submit" class="btn btn-success btn-sm">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbspSimpan
          </button>
        </p>
        -->        
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
