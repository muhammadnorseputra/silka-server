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

  function showKetCuti(str1, str2, str3, str4, str5)
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
    url=url+"&idpengantar="+str2;	
    url=url+"&thn="+str3;
    url=url+"&nip="+str4;
    url=url+"&kel="+str5;
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

  function showNama(str1, str2, str3, str4)
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
    url=url+"?idpengantar="+str1;
    url=url+"&thn="+str2;
    url=url+"&nip="+str3;
    url=url+"&kel="+str4;
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

  function showJmlHari(str1, str2, str3)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="showjmlhari";
    url=url+"?jmlhk="+str1;
    url=url+"&tglmulai="+str2;
    url=url+"&tglselesai="+str3;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=stateChangedJmlHari;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
  }

  function stateChangedJmlHari(){
    if (xmlhttp.readyState==4)
    {
      document.getElementById("jmlhari").innerHTML=xmlhttp.responseText;
    }if (xmlhttp.readyState==1 || xmlhttp.readyState=="loading") {
      document.getElementById("jmlhari").innerHTML=
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Silahkan tunggu</center><br/>";
    }
  }
  
</script>

<?php
        $get_jnsasn = $this->mcuti->get_jnsasn($idpengantar);
        if ($get_jnsasn == "PNS") {
                $ket_jnsasn = "PNS";
                $cljns = "success";
                $lbspan = "<span class='label label-success'>Jenis ASN : PNS</span>";
        } else if ($get_jnsasn == "PPPK") {
                $ket_jnsasn = "PPPK";
                $cljns = "warning";
                $lbspan = "<span class='label label-warning'>Jenis ASN : PPPK</span>";
        }
?>

<center>  
  <div class="panel panel-default" style="width: 90%">
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

      <?php 
      if ($get_jnsasn == "PNS") {
      ?>
       	<form method="POST" name="formtambahusulcuti" action="../cuti/tambahusul_aksi">
      <?php
      } else  if ($get_jnsasn == "PPPK") {
      ?>
	<form method="POST" name="formtambahusulcuti" action="../cuti/tambahusulpppk_aksi">
      <?php
      }
      ?>

      <input type='hidden' name='id_pengantar' id='id_pengantar' value='<?php echo $idpengantar; ?>'>

    <div class="row">
     <div class="col-md-9">  
      <div class="panel panel-<?php echo $cljns; ?>" style="width: 100%">
        <div class='panel-heading' align='left'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        <b>TAMBAH USUL CUTI <?php echo $ket_jnsasn; ?></b>
        </div>
	
        <table class="table table-condensed">
          <tr>	
            <td align='center'>                           
              <table class="table table-condensed">
                <tr>
                  <td align='right' width='130'>No. Pengantar :</td>
                  <td width='100'><input type="text" name="nopengantar" size='40' class="" value="<?php echo $nopengantar; ?>" disabled /></td>
                  <td align='right' width='150'>Tgl. Pengantar :</td>
                  <td width='100'><input type="text" name="tglpengantar" class="tanggal" value="<?php echo tgl_indo($tglpengantar); ?>" disabled /></td>
                </tr>
		<tr>
                  <td align='right' class='<?php echo $cljns; ?>'>Tahun Cuti :</td>
                  <td class='<?php echo $cljns; ?>'>
                    <input type="text" name="tahun" id="tahun" size='8' maxlength='4' onkeyup="validAngka(this)" value="<?php echo date('Y'); ?>" 
		    onChange="showKetCuti(formtambahusulcuti.id_jnscuti.value, formtambahusulcuti.id_pengantar.value, this.value, formtambahusulcuti.nip.value, 'CUTI LAINNYA')" required />
                  </td>
		  <td rowspan='3' colspan='1' class='<?php echo $cljns; ?>' align='left'>
			<span class='text-info'><b>Step I.</b> Entri Tahun Cuti, NIP / NIPPPK dan Jenis Cuti</span>
		  </td>
		  <td rowspan='3'  class='<?php echo $cljns; ?>' align='center'>
			<div id='nama'></div>
		  </td>
                  <!--
		  <td width='120' rowspan='3' colspan='2' class='<?php echo $cljns; ?>' align='center'>
			<div id='KetCuti'><span class='text-primary'></span></div>
		  </td>
		  -->
                </tr>
                <tr>
                  <td align='right' class='<?php echo $cljns; ?>'>Nomor Induk <?php echo $ket_jnsasn; ?> :</td>
                  <!-- NIP ini hanya untuk pencarian, NIP yang disimpan ke database pada Controller cuti.php getdatacuti(), dengan metode ajax -->
		  <td class='<?php echo $cljns; ?>'>
			<input type="text" name="nip" id="nip" size='25' maxlength='18' onkeyup="validAngka(this)"
			onChange="showNama(formtambahusulcuti.id_pengantar.value, formtambahusulcuti.tahun.value, this.value, 'CUTI LAINNYA')" 
			value='' required />
		  </td>
		</tr>                
                <tr>
                  <td align='right' class='<?php echo $cljns; ?>'>Jenis Cuti :</td>
                  <td class='<?php echo $cljns; ?>'>
                    <select name="id_jnscuti" id="id_jnscuti" 
		    onChange="showKetCuti(this.value, formtambahusulcuti.id_pengantar.value, formtambahusulcuti.tahun.value, formtambahusulcuti.nip.value, 'CUTI LAINNYA')" 
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
		<tr class='active'>
		  <td align='right'>Tanggal Mulai :</td>
		  <td>
		     <input type="text" name="tglmulai" size='12' class="tanggal" value="<?php echo date('d-m-Y'); ?>"
                     onChange="showJmlHari(formtambahusulcuti.jml_hk.value, this.value, formtambahusulcuti.tglselesai.value)" required />
		  </td>
		  <td align='left' colspan='2' rowspan='3'>
                    <div id='jmlhari'>Jumlah Hari</div>
                  </td>
		</tr>
		<tr class='active'>
                  <td align='right'>Tanggal Selesai :</td>
                  <td>
                     <input type="text" name="tglselesai" size='12' class="tanggal" value="<?php echo date('d-m-Y'); ?>"
                     onChange="showJmlHari(formtambahusulcuti.jml_hk.value, formtambahusulcuti.tglmulai.value, this.value)" required /><br/>
                  </td>
                </tr>
		<tr class='active'>
                  <td align='right'>Jumlah Hari Kerja :</td>
                  <td>
                     <select name="jml_hk" id="jml_hk"
                      onChange="showJmlHari(this.value, formtambahusulcuti.tglmulai.value, formtambahusulcuti.tglselesai.value)" required />
                      <option value='' selected>- Jumlah Hari Kerja -</option>
                      <option value='5'>5 Hari Kerja</option>
                      <option value='6'>6 Hari Kerja</option>
                    </select>
                  </td>
                </tr>	
                <tr>
                  <td align='right'>Alamat :</td>
                  <td colspan='4'>
                    <input type="text" name="alamat" size='120' maxlength='200' required/><br/>
		    <span class='text-danger'><small>Tulis alamat domisili dan No. Telepon yang dapat dihubungi selama melaksanakan Cuti</small></span>	
                  </td>                  
                </tr>
                <tr>
		  <td></td>
                  <td colspan='1' align='center'>
                    <textarea id="catatan_pej_kepeg" name="catatan_pej_kepeg" rows="7" cols="35" placeholder='Catatan Pengelola Kepegawaian...' required></textarea>
                  </td>
                  <td colspan='1' align='center'>
                    <textarea id="catatan_atasan" name="catatan_atasan" rows="7" placeholder='Catatan dan Pertimbangan Atasan Langsung...' cols="35"></textarea>
                  </td>
                  <td colspan='1' align='center'>
                    <textarea id="keputusan_pej" name="keputusan_pej" rows="7" placeholder='Keputusan Pejabat yang berwenang...' cols="35"></textarea>
                  </td>
                </tr>
		<tr>
		<td align='right'>Link Dokumen</td>
		<td colspan='4'>
                    <input type="text" name="dokumen" size='100' maxlength='250' required/><br/>
                    <span class='text-danger'><small>Copy Paste link Cloud Storage dokumen pendukung (SKP Tahun Terakhir, Surat Keterangan Dokter, dll)</small></span>
                </td>
		</tr>
		<tr>
                <td width='' colspan='4' class='<?php echo $cljns; ?>' align='center'>
                        <div id='KetCuti'></div>
                </td>
          	</tr>
              </table>
            </td>
          </tr>
        </table>
	
      </div>
    </div> <!-- end Kolom Kiri -->
    <div class='col-md-3' align='left'>
	<div style="padding:3px;overflow:auto;width:99%;height:600px;border:1px solid white" >
	<div class="list-group">
          <a href="#" class="list-group-item disabled"><b>LIBUR NASIONAL DAN CUTI BERSAMA<br/>TAHUN 2025</b></a>
	<?php
	$get_libur = $this->mcuti->liburcutibersama('2025')->result_array();
	//$get_libur = $this->mcuti->liburcutibersama(date('Y'))->result_array();
	foreach($get_libur as $gl) {
		echo "<a href='#' class='list-group-item'><span class='text-danger'>".namahari_indo(date('l', strtotime($gl['tgl']))).", ".tgl_indo($gl['tgl'])."</span>";
		echo "<div><small>".$gl['keterangan']."</small></div>";
		echo "</a>";	
	}
	?>
	</div>
	</div> <!-- End Scrollbar -->
    </div> <!-- emd Kolom Kanan -->
   </div> <!-- end Row -->
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
