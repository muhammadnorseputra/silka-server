<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2-material.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>
<script>
var baseUri = '<?= base_url() ?>rpk';
var select = $("#unker").select2({
  width: '45%',
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
select.on("change", function (e) {
    let _ = $(this); 
    // console.log(_.val());
    ajax_rekap(_.val());
});

var $container = $("#result");
function ajax_rekap(unker_id) {
    $.getJSON(`${baseUri}/ajax_rekap`, {id: unker_id}, function(res) {
        console.log(res)
        if(unker_id == null || res.total_all == 0) {
            $container.html('')
            return false;
        }
        $container.html(`
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Total Keseluruhan Pegawai</h3>
                        </div>
                        <div class="panel-body">
                            <span style="font-size: 32px">${res.total_all}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Total Tahap Input Nilai</h3>
                        </div>
                        <div class="panel-body">
                            <span style="font-size: 32px">${res.total_input_nilai}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Total Sudah Di Validasi</h3>
                        </div>
                        <div class="panel-body">
                            <span style="font-size: 32px">${res.total_validasi}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary" onClick="unduh(${unker_id})" data-validasi="${res.total_validasi}" type="button"><i class="glyphicon glyphicon-print"></i> Unduh Data</button>
                </div>
            </div>
        `)
    })
}

function unduh(unker_id) {
    window.open(`${baseUri}/unduhData/${unker_id}`, "_blank");
}
</script>