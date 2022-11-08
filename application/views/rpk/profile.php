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
  
  
  function showData(str1)
  {
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
      alert ("Browser does not support HTTP Request");
      return;
    }
    var url="rpk/tampilperunker";
    url=url+"?idunker="+str1;
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
      "<center><br/><img src=<?php echo '../assets/loading5.gif'; ?> /><br/>Loading...</center>";
    }
  } 
</script>
<div class="container text-center">
  <table class='table table-condensed'>
    <tr>
      <td align='center'>
        <form class="navbar-form navbar-center">
          <div class="form-group">
              <select name="id_unker" id="id_unker" onChange="showData(this.value)">
              <?php
                  echo "<option value=''>- Pilih Unit Kerja -</option>";
                  foreach($unker as $uk)
                  {
                      echo "<option value='".$uk['id_unit_kerja']."'>".$uk['nama_unit_kerja']."</option>";
                  }
              ?>
              </select>
          </div>
        </form>
      </td>
    </tr>
  </table>
</div>
<div>  
  <div id='tampil'>
    <center>
      <h3>Rancangan Pengembangan Karir</h3>
      <p>Silahkan pilih unit kerja anda</p> <hr>
    </center>
  </div>
</div>

<script>
    var baseUri = '<?= base_url() ?>rpk';
    $(document).on("click", "button#show_rekam_jejak",function(e) {
        var _ = $(this);
        var $NIP =  _.attr('data-nip');
        var $MODAL = $("#mymodal");
        $.getJSON(`${baseUri}/rekam_jejak_jabatan`, {nip: $NIP}, function(response) {
          // console.log();
          $MODAL.show();
          if(response.count > 0) {
            $MODAL.find('.modal-body').html(`<b>REKAM JEJAK JABATAN</b> <br> ${response.data}`)
            $MODAL.find('.modal-title').html(`${_.attr('data-profile')} / ${$NIP}`);
          } else {
            $MODAL.find('.modal-body').html('RIWAYAT KERJA TIDAK ADA')
          }
        });
    });
    $(document).on("click", "button#show_informasi_lainnya",function(e) {
        var _ = $(this);
        var $NIP =  _.attr('data-nip');
        var $MODAL = $("#mymodal");
        $.getJSON(`${baseUri}/informasi_lain`, {nip: $NIP}, function(response) {
          // console.log();
          var PIP = response.pip;
          $MODAL.show();
          $MODAL.find('.modal-body').html(
            `Satyalancana Karya Satya <br> <b>${response.satyalencana}</b> <br> <br>
            Riwayat Hukuman Disiplin <br> <b>${response.hukdis}</b> <br><br>
            Inovasi <br> <b>${response.inovasi}</b> <br><br>
            IP ASN (1 Tahun Terakhir)<br> <b>${PIP}</b> <br><br>`
          )
          $MODAL.find('.modal-title').html(`${_.attr('data-profile')} / ${$NIP}`);
        });
        $MODAL.find('.modal-body').html(`<b>INFORMASI LAINNYA</b> <br> ${_.attr('data-content')}`)
    });

    // AKSI INPUT NILAI
    $(document).on("click", "button#input-nilai",function(e) {
        var _ = $(this);
        var $NIP =  _.attr('data-nip');
        var $JNSJAB =  _.attr('data-jenisjab');
        var $UNKER =  _.attr('data-unker');
        var $NAMAJAB =  _.attr('data-jabatan');
        var $JABATAN_ID =  _.attr('data-jabatanid');
        var $UNKER_ID =  _.attr('data-unkerid');
        var $REKOMENDASI =  _.attr('data-rekomendasi');
        var $GOLRUID = _.attr('data-golruid');
        var $MODAL_INPUT = $("#inputModal");
        var $CONTAINER_PROFILE = $MODAL_INPUT.find('#profile_pns');
        $MODAL_INPUT.find("#alert").html('');
        $CONTAINER_PROFILE.html(`
          <table class="table table-bordered">
            <tr>
              <td>Nama</td>
              <td>${_.attr('data-nama')}</td>
            </tr>
            <tr>
              <td>NIP</td>
              <td>${$NIP}</td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>${$NAMAJAB}</td>
            </tr>
          </table>
        `)
        // JIKA PENILAIAN PERNAH DILAKUKAN
        $MODAL_INPUT.find('input[name="nilai-manajerial"]').val(_.attr('data-nilai-manajerial'));
        $MODAL_INPUT.find('input[name="nilai-sosiokultural"]').val(_.attr('data-nilai-sosiokultural'));
        $MODAL_INPUT.find('input[name="nilai-teknis"]').val(_.attr('data-nilai-teknis'));
        var selectRekomendasi = $MODAL_INPUT.find('select[name="rekomendasi_pengembangan"]');
        if($JNSJAB === "1") {
          $MODAL_INPUT.find('input[name="nilai-manajerial"]').prop("disabled", false);
          $MODAL_INPUT.find('input[name="nilai-sosiokultural"]').prop("disabled", false);
          $MODAL_INPUT.find('input[name="nilai-teknis"]').prop("disabled", false);
          selectRekomendasi.prop("disabled", true).css("opacity","0.1");
        } else {
          selectRekomendasi.prop("disabled", false).css("opacity","1").val($REKOMENDASI);
          $MODAL_INPUT.find('input[name="nilai-manajerial"]').prop("disabled", true);
          $MODAL_INPUT.find('input[name="nilai-sosiokultural"]').prop("disabled", true);
          $MODAL_INPUT.find('input[name="nilai-teknis"]').prop("disabled", true);
        }
        var formInput = $MODAL_INPUT.find('form#form-input-nilai');
        formInput.unbind().bind('submit', function(e) {
          e.preventDefault();
          var $FROM = $(this);
          var $DATA = $FROM.serializeArray();
          $DATA.push({name: 'nip', value: $NIP},{name: 'unker', value: $UNKER},
          {name: 'unker_id', value: $UNKER_ID},{name: 'jabatan_id', value: $JABATAN_ID},
          {name: 'namajabatan', value: $NAMAJAB}, {name: 'golru_id', value: $GOLRUID});
          // console.log($FROM.serialize());
          $.post(`${baseUri}/input_nilai`, $DATA, function(response) {
            // console.log(response);
            // formInput[0].reset();
            showData($("select[name='id_unker']").val());
            var msg = '';
            if(response.code == 200) {
              msg = `<div class="alert alert-success" role="alert">${response.msg}</div>`;
            } else {
              msg = `<div class="alert alert-danger" role="alert">${response.msg}</div>`;
            }
            $MODAL_INPUT.find("#alert").html(msg);
          }, 'json')
        })
    });

    // AKSI VALIDASI
    $(document).on("click", "button#validasi",function(e) {
        var _ = $(this);
        var $NIP =  _.attr('data-nip');
        var $ID = _.attr('data-id');
        $.getJSON(`${baseUri}/validasi`, {nip: $NIP, id_rpk_penilai: $ID}, function(response) {
          console.log(response);
          showData($("select[name='id_unker']").val());
        });
    });

    // SHOW HIDE COL
    $(document).on("click", "input[name='show_data_personal']", function() {
      var thead_dperson = $("th#th_datapersonal");
      var thead_profile = $("th#th_profile");
      var thead = $("th#th_ttl,th#th_status_kawin,th#th_agama,th#th_alamat");
      var tbody = $("td#th_ttl,td#th_status_kawin,td#th_agama,td#th_alamat");
        if($(this).is(":checked")) {
          thead.removeClass('hide')
          tbody.removeClass('hide')
          thead_dperson.attr('colspan', 7)
          thead_profile.attr('colspan', 16)
        } else {
          thead.addClass('hide')
          tbody.addClass('hide')
          thead_dperson.attr('colspan', 3)
          thead_profile.attr('colspan', 12)
        }
    });
</script>

<!-- Modal -->
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="mymodalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mymodalLabel">...</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
          <form method="POST" action="../pegawai/rwyjab"><input type="hidden" name="nip" id="nip" maxlength="18" value="198104072009041002">         
           <button type="submit" class="btn btn-default btn-outline">
            <span class="glyphicon glyphicon-sort" aria-hidden="true"></span>&nbsp;Perbaharuai Riwayat
          </button>
          </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Input Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModallLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?= base_url('rpk/input_nilai') ?>" method="post" id="form-input-nilai">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="inputModallLabel">Hasil Penilaian/Uji Kompetensi</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <b>PNS YANG DINILAI</b>
            <div id="profile_pns"></div>
          </div>
        </div>
        <div id="alert"></div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group has-warning">
              <label for="manajerial">Nilai/Deskripsi Kompetensi Manajerial</label>
                <input type="number" name="nilai-manajerial" class="form-control" id="manajerial" placeholder="Nilai Kompetensi Manajerial" require>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group has-warning">
              <label for="sosiokultural">Nilai/Deskripsi Kompetensi Sosiokultural</label>
              <input type="number"  name="nilai-sosiokultural" class="form-control" id="sosiokultural" placeholder="Nilai Kompetensi Sosiokultural" require>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group has-warning">
              <label for="teknis">Nilai/Deskripsi Kompetensi Teknis</label>
              <input type="number" name="nilai-teknis" class="form-control" id="teknis" placeholder="Nilai Kompetensi Teknis" require>
            </div>
          </div>
        </div>
        <div class="form-group has-warning">
          <label for="rekomendasi_pengembangan">Rekomendasi Pengembangan (Khusus NON Struktural)</label>
          <select class="form-control" name="rekomendasi_pengembangan" id="rekomendasi_pengembangan">
            <option value="">-- Pilih Rekomendasi --</option>
            <option value="Karir">Rekomendasi Pengembangan Karir</option>
            <option value="Kompetensi">Rekomendasi Pengembangan Kompetensi</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>