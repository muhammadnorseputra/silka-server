<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/datatables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/inc_tablesold.css') ?>"/>

<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/vfs_fonts.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2-material.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>

<!-- Input Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModallLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="#" method="post" id="form-input" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="inputModallLabel">RENCANA PENGEMBANGAN KARIR</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <b>PNS YANG DIREKOMENDASIKAN</b>
            <div id="profile_pns"></div>
          </div>
        </div>
        <div id="alert"></div>
        <div style="border: 1px solid #ccc; padding: 18px 8px; border-radius: 8px">
          <div class="form-group">
            <label for="rekomendasi_penempatan" class="col-sm-4 control-label">REKOMENDASI PENEMPATAN</label>
            <div class="col-sm-8">
              <select name="rekomendasi_penempatan" id="rekomendasi_penempatan"></select>
            </div>
          </div>
          <div class="form-group">
            <label for="rekomendasi_jabatan" class="col-sm-4 control-label">REKOMENDASI JABATAN</label>
            <div class="col-sm-8">
              <select name="rekomendasi_jabatan" id="rekomendasi_jabatan" class="form-control" disabled></select>
            </div>
          </div>
          <div class="form-group">
            <label for="lowongan_jabatan" class="col-sm-4 control-label">LOWONGAN KEBUTUHAN JABATAN</label>
            <div class="col-sm-3">
              <input type="number"  class="form-control" name="lowongan_jabatan"/>
            </div>
          </div>
          <div class="form-group">
            <label for="rencana_posisi_jabatan" class="col-sm-4 control-label">JPT</label>
            <div class="col-sm-8">
              <select name="rencana_posisi_jabatan[]" class="form-control" id="JPT">
                <option value="">-- JPT --</option>
                <option value="pratama">PRATAMA</option>
                <option value="madya">MADYA</option>
                <option value="utama">UTAMA</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="rencana_posisi_jabatan" class="col-sm-4 control-label">JA</label>
            <div class="col-sm-8">
            <select name="rencana_posisi_jabatan[]" class="form-control" id="JA">
              <option value="">-- JA --</option>
              <option value="pelaksana">PELAKSANA</option>
              <option value="pengawas">PENGAWAS</option>
              <option value="administrator">ADMINISTRATOR</option>
            </select>
            </div>
          </div>
          <div class="form-group">
            <label for="rencana_posisi_jabatan" class="col-sm-4 control-label">JF TERAMPIL</label>
            <div class="col-sm-8">
            <select name="rencana_posisi_jabatan[]" class="form-control" id="JF_TERAMPIL">
              <option value="">-- JF TERAMPIL --</option>
              <option value="pemula">PEMULA</option>
              <option value="terampil">TERAMPIL</option>
              <option value="mahir">MAHIR</option>
              <option value="penyelia">PENYELIA</option>
            </select>
            </div>
          </div>
          <div class="form-group">
            <label for="rencana_posisi_jabatan" class="col-sm-4 control-label">JF AHLI</label>
            <div class="col-sm-8">
            <select name="rencana_posisi_jabatan[]" class="form-control" id="JF_AHLI">
              <option value="">-- JF AHLI --</option>
              <option value="pertama">PERTAMA</option>
              <option value="muda">MUDA</option>
              <option value="madya">MADYA</option>
              <option value="utama">UTAMA</option>
            </select>
            </div>
          </div>
          <div class="form-group">
            <label for="bentuk_pengembangan_karir" class="col-sm-4 control-label">BENTUK PENGEMBANGAN KARIR</label>
            <div class="col-sm-8">
              <select name="bentuk_pengembangan_karir" id="bentuk_pengembangan_karir" class="form-control">
                <option value="">-- BENTUK PENGEMBANGAN KARIR --</option>
                <option value="VERTIKAL">VERTIKAL</option>
                <option value="HORIZONTAL">HORIZONTAL</option>
                <option value="DIAGONAL">DIAGONAL</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="waktu_pelaksanaan" class="col-sm-4 control-label">WAKTU PELAKSANAAN (Tahun ke)</label>
            <div class="col-sm-8">
              <select name="waktu_pelaksanaan" id="waktu_pelaksanaan" class="form-control">
                <option value="">-- TAHUN KE --</option>
                <?php 
                $tahun = 5;
                for($i=1;$i<=$tahun;$i++): 
                  $tahun_string = date('Y') + $i;
                  echo '<option value="'.$i.'">'.$i.' ('.$tahun_string.')</option>';
                endfor;
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="mekanisme_pengisian" class="col-sm-4 control-label">MEKANISME PENGISIAN</label>
            <div class="col-sm-8">
              <select name="mekanisme_pengisian" id="mekanisme_pengisian" class="form-control">
                <option value="">-- MEKANISME PENGISIAN --</option>
                <option value="SELEKSI TERBUKA">SELEKSI TERBUKA</option>
                <option value="SELEKSI TERTUTUP">SELEKSI TERTUTUP</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="prosedur_pengisian" class="col-sm-4 control-label">PRODSEDUR PENGISIAN</label>
            <div class="col-sm-8">
              <select name="prosedur_pengisian" id="prosedur_pengisian" class="form-control">
                <option value="">-- PRODSEDUR PENGISIAN --</option>
                <option value="ROTASI">ROTASI</option>
                <option value="PROMOSI">PROMOSI</option>
                <option value="MUTASI">MUTASI</option>
              </select>
            </div>
          </div>
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

<script>
var baseUri = '<?= base_url() ?>rpk';
var select = $("#unker").select2({
  width: '25%',
  placeholder: {
    id: '-1',
    text: '-- Pilih Unit Kerja --'
  },
  selectOnClose: false,
  allowClear: true,
  theme: "material",
  //minimumInputLength: 5,
  ajax: {
    url: `${baseUri}/getUnker`,
    type: 'POST',
    dataType: 'json',
    quietMillis: 650,
    data: function(params) {
      return {
        searchParm: params.term
      };
    },
    processResults: function(response) {
      return {
        results: response.items
      };
    },
    cahce: true
  }
});
var rekomendasiPenempatan = $("select#rekomendasi_penempatan").select2({
  dropdownParent: $('#inputModal'),
  width: '100%',
  placeholder: {
    id: '-1',
    text: '-- Pilih Unit Kerja --'
  },
  selectOnClose: false,
  allowClear: true,
  theme: "material",
  //minimumInputLength: 5,
  ajax: {
    url: `${baseUri}/getUnker`,
    type: 'POST',
    dataType: 'json',
    quietMillis: 650,
    data: function(params) {
      return {
        searchParm: params.term
      };
    },
    processResults: function(response) {
      return {
        results: response.items
      };
    },
    cahce: false,
  }
});
select.on("change", function (e) { tableInsntansi.draw(false) });
rekomendasiPenempatan.on("change", function (e) { 
  var unkerID = $(this).val();
  // pilih_jabatan('JST', unkerID);
  $("select[name='rekomendasi_jabatan']").select2({
    dropdownParent: $('#inputModal'),
    disabled: unkerID != null ? false : true,
    selectOnClose: false,
    allowClear: true,
    theme: "material",
    quietMillis: 1000,
    placeholder: {
      id: '-1',
      text: '-- REKOMENDASI JABATAN --'
    },
    ajax: {
      url: `${baseUri}/getJabatan`,
      type: 'POST',
      dataType: 'json',
      data: function(params) {
        return {
          unkerId: unkerID,
          searchParm: params.term
        };
      },
      processResults: function(response) {
        return {
          results: response.items
        };
      },
      cahce: true,
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });
});

var tableInsntansi = $("#tbl_instansi").DataTable({
  processing: true,
  serverSide: true,
  order: [[1, 'desc']],   
  deferRender: false,
  keys: false,
  autoWidth: true,
  select: false,
  searching: true,
  lengthChange:  true,
  scrollY: "400px",
  scrollX: true,
  scrollCollapse: true,
  fixedColumns:   {
      left: 1
  },
  ajax: {
      url: `${baseUri}/ajax_instansi`,
      type: 'POST',
      dataType: 'json',
      data: function(s){
          s.unkerid = $("[name='unkerid']").val()
      }
  },
  columnDefs: [
    {
        "targets": [2],
        "orderable": false,
        "className": "dt-head-center dt-head-middle",
    },
    {
        "targets": [0],
        "orderable": false,
        "className": "dt-head-center dt-body-center",
        "createdCell": function (td, cellData, rowData, row, col) {
          if(col === 0)
          {
            $(td).css("background-color", "#cad2c5")
          }
        }
    },
    {
        "targets": [1],
        "orderable": true,
        "className": "dt-head-center",
        "width": "12%"
    },
    {
        "targets": [5],
        "orderable": false,
        "className": "dt-head-center dt-head-middle dt-body-middle dt-body-center"
    },
    {
        "targets": [6,7,8,9],
        "orderable": false,
        "className": "dt-head-center dt-head-middle dt-body-middle dt-body-center"
    },
    {
        "targets": [10,11,12,13],
        "orderable": false,
        "className": "dt-head-center dt-head-middle dt-body-middle dt-body-center"
    },
    {
        "targets": [14],
        "orderable": false,
        "className": "dt-head-center dt-body-middle"
    },
    {
        "targets": [3],
        "orderable": false,
        "className": "dt-head-center dt-head-middle",
        "width": "12%"
    },
    {
        "targets": [4],
        "orderable": false,
        "className": "dt-head-center dt-head-middle",
        "width": "12%"
    }
  ],
  language: {
    search: "Pencarian: ",
    processing: "Mohon Tunggu, Processing...",
    paginate: {
      previous: "Sebelumnya",
      next: "Selanjutnya"
    },
    emptyTable: "No matching records found"
  }
});

function reload() {
  tableInsntansi.ajax.reload(null, false);
}

// AKSI REKOMENDASI PENEMPATAN
$(document).on('click', 'button#Input', function(e) {
  e.preventDefault();
  var _ = $(this);
  var $ID =  _.attr('data-id');
  var $NIP =  _.attr('data-nip');
  var $NAMA = _.attr('data-nama');
  var $NAMAJAB =  _.attr('data-jabatan');
  var $MODAL_INPUT = $("#inputModal");
  var $CONTAINER_PROFILE = $MODAL_INPUT.find('#profile_pns');
  $MODAL_INPUT.find("#alert").html('');
  $CONTAINER_PROFILE.html(`
    <table class="table table-bordered">
      <tr>
        <td>Nama</td>
        <td>${$NAMA}</td>
      </tr>
      <tr>
        <td>NIP</td>
        <td>${$NIP}</td>
      </tr>
      <tr>
        <td width="30%">Jabatan Saat Ini</td>
        <td>${$NAMAJAB}</td>
      </tr>
    </table>
  `)
  var $POSISI_JABATAN = '';
  $MODAL_INPUT.find('select[name="rencana_posisi_jabatan[]"]').on("change", function() {
    _this = $(this);
    $POSISI_JABATAN = _this.attr('id'); 
  });
  
  var formInput = $MODAL_INPUT.find('form#form-input');
  formInput.unbind().bind('submit', function(e) {
    e.preventDefault();
    var $FROM = $(this);
    var $DATA = $FROM.serializeArray();
    $DATA.push({name: 'id', value: $ID}, {name: 'pj', value: $POSISI_JABATAN});
    $.post(`${baseUri}/inputRpk`, $DATA, function(response) {
      console.log($DATA);
      // MODAL_INPUT.hide();
      formInput[0].reset();
      reload();
      var msg = '';
      if(response.code == 200) {
        msg = `<div class="alert alert-success" role="alert">${response.msg}</div>`;
        select.val(null).trigger('change');
        rekomendasiPenempatan.val(null).trigger('change');
      } else {
        msg = `<div class="alert alert-danger" role="alert">${response.msg}</div>`;
      }
      $MODAL_INPUT.find("#alert").html(msg);
    }, 'json')
  })
});

</script>