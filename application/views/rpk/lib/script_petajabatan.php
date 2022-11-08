<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/datatables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/inc_tablesold.css') ?>"/>

<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/vfs_fonts.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2-bootstrap.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>

<!-- Input Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModallLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="#" method="post" id="form-review">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="inputModallLabel">REVIEW POSISI / PROYEKSI JABATAN</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <b>PNS YANG DIREVIEW</b>
            <div id="profile_pns"></div>
          </div>
        </div>
        <div id="alert"></div>
        <b>POSISI JABATAN</b>
        <table class="table table-bordered">
          <tr>
            <td width="200">
            Jabatan Pimpinan Tinggi (JPT)
            </td>
            <td>
            <select name="posisi_jabatan[]" class="form-control" id="JPT">
              <option value="">-- JPT --</option>
              <option value="pratama">PRATAMA</option>
              <option value="madya">MADYA</option>
              <option value="utama">UTAMA</option>
            </select>
            </td>
          </tr>
          <tr>
            <td width="200">
            Jabatan Administrasi (JA)
            </td>
            <td>
            <select name="posisi_jabatan[]" class="form-control" id="JA">
              <option value="">-- JA --</option>
              <option value="pelaksana">PELAKSANA</option>
              <option value="pengawas">PENGAWAS</option>
              <option value="administrator">ADMINISTRATOR</option>
            </select>
            </td>
          </tr>
          <tr>
            <td width="200">
            Jabatan Fungsional Terampil
            </td>
            <td>
            <select name="posisi_jabatan[]" class="form-control" id="JF_TERAMPIL">
              <option value="">-- JF TERAMPIL --</option>
              <option value="pemula">PEMULA</option>
              <option value="terampil">TERAMPIL</option>
              <option value="mahir">MAHIR</option>
              <option value="penyelia">PENYELIA</option>
            </select>
            </td>
          </tr>
          <tr>
            <td width="200">
            Jabatan Fungsional Ahli
            </td>
            <td>
            <select name="posisi_jabatan[]" class="form-control" id="JF_AHLI">
              <option value="">-- JF AHLI --</option>
              <option value="pertama">PERTAMA</option>
              <option value="muda">MUDA</option>
              <option value="madya">MADYA</option>
              <option value="utama">UTAMA</option>
            </select>
            </td>
          </tr>
          <tr>
            <td width="200">
            Rumpun Jabatan Fungsional
            </td>
            <td>
            <input type="text" name="posisi_jabatan[]" class="form-control" size="50" placeholder="Exp: Manajemen">
            </td>
          </tr>
        </table>
        <b>KEBUTUHAN JABATAN BERDASARKAN PETA JABATAN (Orang)</b><br>
        <input type="number" name="proyeksi_jabatan" class="form-control" size="20" style="width: 20%" id="proyeksi_jabatan" placeholder="0">
        <br>
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
  theme: "bootstrap",
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

select.on("change", function (e) { dataTable.draw(false) });

var dataTable = $("#tbl_petajabtan").DataTable({
  processing: true,
  serverSide: true,
  order: [[1, 'desc']], 
  deferRender: false,
  keys: false,
  autoWidth: true,
  select: false,
  searching: true,
  lengthChange:  true,
//   "scrollY": "300px",
  "scrollCollapse": true,
  ajax: {
      url: '<?= base_url("rpk/ajax_petajabatan") ?>',
      type: 'POST',
      data: function(s){
          s.unkerid = $("[name='unkerid']").val()
      }
  },
  columnDefs: [
            {
                "targets": [10,11],
                "orderable": false
            },
            {
                "targets": [3,4,5,6,7],
                "className": "dt-body-center dt-body-middle",
                "orderable": false
            },
            {
                "targets": [8],
                "className": "dt-body-center dt-body-middle",
                "orderable": false
            },
            {
                "targets": [9],
                "className": "dt-body-center dt-body-middle",
                "orderable": false
            },
            {
                "targets": [10],
                "className": "dt-body-center dt-body-middle",
                "orderable": false
            },
            {
                "targets": [0],
                "orderable": false,
                "className": "dt-body-center"
            },
            {
                "targets": [1],
                "orderable": true,
                "width": "15%"
            },
            {
                "targets": [2],
                "orderable": false,
                "width": "25%"
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
  dataTable.ajax.reload(null, false);
}

// AKSI HAPUS PETA JABATAN
$(document).on('click', 'button#Delete', function(e) {
  e.preventDefault();
  var _ = $(this);
  var $ID =  _.attr('data-id');
  var $NIP =  _.attr('data-nip');
  var $IDP =  _.attr('data-rpk-penilaian');
  if(confirm(`Apakah anda yakin akan menghapus penilaian tersebut ?`)) {
    $.post(`${baseUri}/delete_petajabatan`, {id: $ID, nip: $NIP, id_rpk_penilai: $IDP}, function(response) {
      // console.log(response);
      reload();
    }, 'json');
    return false;
  }
});

// AKSI INPUT NILAI
$(document).on("click", "button#Review",function(e) {
    var _ = $(this);
    var $ID = _.attr('data-id');
    var $NIP =  _.attr('data-nip');
    var $NAMAJAB =  _.attr('data-jabatan');
    var $KELASJAB =  _.attr('data-kelasjab');
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
    var $POSISI_JABATAN = '';
    $MODAL_INPUT.find('select[name="posisi_jabatan[]"]').on("change", function() {
      _this = $(this);
      $POSISI_JABATAN = _this.attr('id'); 
    });

    var formInput = $MODAL_INPUT.find('form#form-review');
    formInput.unbind().bind('submit', function(e) {
      e.preventDefault();
      var $FROM = $(this);
      var $DATA = $FROM.serializeArray();
      $DATA.push({name: 'id', value: $ID}, {name: 'pj', value: $POSISI_JABATAN}, {name: 'kelas', value: $KELASJAB});
      $.post(`${baseUri}/input_review`, $DATA, function(response) {
        // console.log(response);
        // MODAL_INPUT.hide();
        formInput[0].reset();
        reload();
        var msg = '';
        if(response.code == 200) {
          msg = `<div class="alert alert-success" role="alert">${response.msg}</div>`;
        } else {
          msg = `<div class="alert alert-danger" role="alert">${response.msg}</div>`;
        }
        $MODAL_INPUT.find("#alert").html(msg)
      }, 'json')
    })
});
</script>