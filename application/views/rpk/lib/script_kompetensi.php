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
      <form action="#" method="post" id="form-input">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="inputModallLabel">PENYELARASAN KOMPETENSI</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <b>REVIEW</b>
            <div id="profile_pns"></div>
          </div>
        </div>
        <div id="alert"></div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group has-warning">
              <label for="manajerial">Syarat Nilai Kompetensi Manajerial</label>
                <input type="number" name="nilai-manajerial" class="form-control" id="manajerial" placeholder="Nilai Kompetensi Manajerial" require>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group has-warning">
              <label for="sosiokultural">Syarat Nilai Kompetensi Sosiokultural</label>
              <input type="number"  name="nilai-sosiokultural" class="form-control" id="sosiokultural" placeholder="Nilai Kompetensi Sosiokultural" require>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group has-warning">
              <label for="teknis">Syarat Nilai Kompetensi Teknis</label>
              <input type="number" name="nilai-teknis" class="form-control" id="teknis" placeholder="Nilai Kompetensi Teknis" require>
            </div>
          </div>
        </div>
        <div class="form-group has-warning">
          <label for="kompetensi_jabatan">Penyelarasan Kompetensi Jabatan</label>
          <input type="text" id="kompetensi_jabatan" name="kompetensi_jabatan" class="form-control" size="50" placeholder="Exp: Diklat Struktural">
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

<!-- Update Hasil Uji Kom -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="inputModallLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="#" method="post" id="form-update-nilai">
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
                <input type="number" name="nilai-manajerial" class="form-control" id="manajerial" placeholder="Nilai Kompetensi Manajerial">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group has-warning">
              <label for="sosiokultural">Nilai/Deskripsi Kompetensi Sosiokultural</label>
              <input type="number"  name="nilai-sosiokultural" class="form-control" id="sosiokultural" placeholder="Nilai Kompetensi Sosiokultural">
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group has-warning">
              <label for="teknis">Nilai/Deskripsi Kompetensi Teknis</label>
              <input type="number" name="nilai-teknis" class="form-control" id="teknis" placeholder="Nilai Kompetensi Teknis">
            </div>
          </div>
        </div>
        <div class="form-group has-warning">
          <label for="rekomendasi_pengembangan">Rekomendasi Pengembangan</label>
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
select.on("change", function (e) { tableKompetensi.draw(false) });
var tableKompetensi = $("#tbl_kompetensi").DataTable({
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
  ajax: {
      url: `${baseUri}/ajax_kompetensi`,
      type: 'POST',
      dataType: 'json',
      data: function(s){
          s.unkerid = $("[name='unkerid']").val()
      }
  },
  columnDefs: [
    {
        "targets": [9],
        "orderable": false,
        "className": "dt-head-center dt-head-middle",
    },
    {
        "targets": [1],
        "orderable": true,
        "className": "dt-head-center dt-head-middle",
    },
    {
        "targets": [5],
        "orderable": true,
        "className": "dt-head-center dt-head-middle dt-body-center dt-body-middle",
    },
    {
        "targets": [2,3,4,6,7,8,10],
        "orderable": false,
        "className": "dt-head-center dt-head-middle dt-body-center dt-body-middle",
        "createdCell": function (td, cellData, rowData, row, col) {
          if(cellData === null)
          {
            $(td).text('-')
          }
        }
    },
    {
        "targets": [0],
        "orderable": false,
        "className": "dt-head-center dt-head-middle dt-body-center",
        "createdCell": function (td, cellData, rowData, row, col) {
          if(col === 0)
          {
            $(td).css("background-color", "#cad2c5")
          }
        }
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
  tableKompetensi.ajax.reload(null, false);
}
// AKSI UPDATE SYARAT JABATAN
$(document).on('click', 'button#Input', function(e) {
  e.preventDefault();
  var _ = $(this);
  var $ID =  _.attr('data-id');
  var $NIP =  _.attr('data-nip');
  var $NAMA = _.attr('data-nama');
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
    </table>
  `)

  // JIKA PENILAIAN PERNAH DILAKUKAN
  $MODAL_INPUT.find('input[name="nilai-manajerial"]').val(_.attr('data-nilai-manajerial'));
  $MODAL_INPUT.find('input[name="nilai-sosiokultural"]').val(_.attr('data-nilai-sosiokultural'));
  $MODAL_INPUT.find('input[name="nilai-teknis"]').val(_.attr('data-nilai-teknis'));
  $MODAL_INPUT.find('input[name="kompetensi_jabatan"]').val(_.attr('data-kompetensi-jabatan'));
  var formInput = $MODAL_INPUT.find('form#form-input');
  formInput.unbind().bind('submit', function(e) {
    e.preventDefault();
    var $FROM = $(this);
    var $DATA = $FROM.serializeArray();
    $DATA.push({name: 'id', value: $ID});
    $.post(`${baseUri}/inputKompetensi`, $DATA, function(response) {
      console.log(response);
      // MODAL_INPUT.hide();
    //   formInput[0].reset();
      reload();
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

// AKSI UPDATE HASIL UJI KOM
$(document).on('click', 'button#Update', function(e) {
  e.preventDefault();
  var _ = $(this);
  var $ID =  _.attr('data-id');
  var $NIP =  _.attr('data-nip');
  var $NAMA = _.attr('data-nama');
  var $MODAL_INPUT = $("#updateModal");
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
    </table>
  `)

  // JIKA PENILAIAN PERNAH DILAKUKAN
  $MODAL_INPUT.find('input[name="nilai-manajerial"]').val(_.attr('data-nilai-manajerial'));
  $MODAL_INPUT.find('input[name="nilai-sosiokultural"]').val(_.attr('data-nilai-sosiokultural'));
  $MODAL_INPUT.find('input[name="nilai-teknis"]').val(_.attr('data-nilai-teknis'));
  $MODAL_INPUT.find('input[name="kompetensi_jabatan"]').val(_.attr('data-kompetensi-jabatan'));
  var formInput = $MODAL_INPUT.find('form#form-update-nilai');
  formInput.unbind().bind('submit', function(e) {
    e.preventDefault();
    var $FROM = $(this);
    var $DATA = $FROM.serializeArray();
    $DATA.push({name: 'id', value: $ID});
    $.post(`${baseUri}/updateUjiKom`, $DATA, function(response) {
      console.log(response);
      // MODAL_INPUT.hide();
    //   formInput[0].reset();
      reload();
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
</script>