
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/datatables.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/tables/inc_tablesold.css') ?>"/>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/diklat/tables/vfs_fonts.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/sweetalert/sweetalert.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/sweetalert/sweetalert.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/select2/css/select2-bootstrap.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/select2/js/select2.min.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/diklat/inputtags/bootstrap-tagsinput.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/diklat/inputtags/bootstrap-tagsinput.js') ?>"></script> -->


<script>
$(document).ready(function(){

    $("#unker, #jabstruk, #jabatan_filter_data,#unkerfilter2").select2({
        placeholder: 'Select On Filtered Data',
        allowClear: true,
        theme: "bootstrap",
        dir: "ltl",
        width: '380px' 
    });	

});
</script>

<script>

    var dataTables = $("#tableSyarat").DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        order: [[ 1, "desc"]], 
        deferRender: true,
        keys: false,
        autoWidth: false,
        select: true,
        ajax: {
            url: '<?= base_url("diklat/get_syarat") ?>',
            type: 'POST',
            data: function(s){
                s.unkerid = $("[name='unkerid']").val(),
                s.jabatanid = $("[name='jabatanid']").val()
            }
        },
         fixedHeader: {
             header: true,
             footer: false
         },
        columnDefs: [
            {
                "targets": [0],
                "orderable": false,
                "className": 'dt-center',
                "width": "3%"
            },
            {
                "targets": [1],
                "orderable": true,
                "className": 'dt-left',
                "width": "20%"
            },
            {
                "targets": [2],
                "orderable": true,
                "className": 'dt-left',
                "width": "20%"
            },
            {
                "targets": [3],
                "orderable": false,
                "className": 'dt-center',
                "width": "15%"
            },
            {
                "targets": [4],
                "orderable": false,
                "className": 'dt-center',
                "width": "3%"
            },
            {
                "targets": [5],
                "orderable": false,
                "className": 'dt-center',
                "width": "3%"
            }
        ],
        language: {
				search: "Pencarian: ",
				processing: "Mohon Tunggu, Processing...",
				paginate: {
					previous: "Sebelumnya",
					next: "Selanjutnya"
				}
			}
    });

	function reload() {
        dataTables.ajax.reload(null, false);
	}

    
	var sel = $("#filtercari");
	sel.on("click", function() {
	    dataTables.draw();
	});


    var dataTables2 = $("#tableSyaratJF").DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        order: [],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        autoWidth: false,
        keys: false,
        "deferRender": true,
        responsive: true,
        fixedColumns:   true,
        "pagingType": "full_numbers",
        ajax: {
            url: '<?= base_url("diklat/get_usul_diklat") ?>',
            type: 'POST',
            data: function(s){
                s.unkerid = $("[name='unkerid2']").val(),
                s.checkstatus = $("[name='checkstatus']").val(),
                s.checkjst = $("[name='checkjst']").val(),
                s.tahun = $("[name='tahun']").val()
            }
        },
        // fixedHeader: {
        //     header: true,
        //     footer: true
        // },
        columnDefs: [
            {
                "targets": [0,2,5,4,6,7,8,9,12,13],
                "orderable": false
            },
            {
                "targets": [10],
                "orderable": true,
                "className": 'dt-head-center'
            },
            {
                "targets": [11],
                "orderable": false,
                "className": 'dt-center'
            }
        ],
        language: {
				search: "Pencarian: ",
				processing: "Mohon Tunggu, Processing...",
				paginate: {
					previous: "Sebelumnya",
					next: "Selanjutnya"
				},
                emptyTable: "Data Table Tidak Ditemukan"
			}
    });

    // dataTables2.cells('[name="checkboxlist"]').select();

    $("[name='unkerid2'],[name='tahun'],[name='checkjst'],[name='checkstatus']").on('change', function() {
        dataTables2.draw();
    });
    

    function update_status(id, val) {
        $.post('<?= base_url("diklat/update_status"); ?>', {setdata: val, getid: id}, function(result){
          //dataTables2.ajax.reload();
        });
    }

    function update_catatan(id, val) {
        // var val = $("[name='catatan']").val();
        $.post('<?= base_url("diklat/update_catatan"); ?>', {data: val, id: id}, function(result) {
          //dataTables2.ajax.reload();
          $("span.msg").show().html(result);
          setTimeout(function() {
          	$("span.msg").hide();
          }, 3000);
        });
    }

    function hapus_usulan(id) {
      var r = confirm("Apakah anda yakin akan menghapus diklat tersebut?");
      if(r) {
        $.post('<?= base_url('diklat/hapus_usulan') ?>/'+ id, function(res) {
          alert(res);
          dataTables2.ajax.reload();
        }, 'json');
      }
    }

    // function hapuslist() {
    //     var selected = $('[name=checkboxlist]:checked').map(function(){
	//      return $(this).val();
	//     }).get();	
	//     var count = selected.length;
    //     // $.delete('');
    // }
	// function get_data_syarat() {
	// //     var unkerfilter = $("#unkerfilter2").val();
	// //     var jabatanfilter = $("#jabatan_filter_data").val();

	// //     if (unkerfilter != null && jabatanfilter != null) {
	// //         var oke = 'unkeriddata=' + unkerfilter + '&jabataniddata=' + jabatanfilter;
	// //     } else {
	// //         var oke = '';
	// //     }

	// //     $.ajax({
	// //         type: 'POST',
	// //         data: oke,
	// //         url: '<?php echo base_url()."diklat/get_syarat" ?>',
	// //         dataType: 'json',
	// //         success: function(data) {
	// //             if (data != '') {
	// //                 var no = 1;
	// //                 var baris = '';
	// //                 for (var i = 0; i < data.length; i++) {

	// //                     var dataSd = data[i].nama_syarat_diklat;
	// //                     // var pisah = dataSd.split(",");

	// //                     // var a = 0;
	// //                     // var putdata = '';
	// //                     // var rno = 1;
	// //                     // while (a < pisah.length) {
	// //                     //     putdata += "<b>" + rno + ".</b> " + pisah[a] + " ";
	// //                     //     a++;
	// //                     //     rno++;
	// //                     // }
	// //                     // if (pisah == '') {
	// //                     //     showdata = "<b class='text-danger'>KOSONG</b>";
	// //                     // } else {
	// //                     //     showdata = putdata;
	// //                     // }

	// //                     baris += '<tr>' +
	// //                         '<td align="center">' + no + '</td>' +
	// //                         '<td>'+"<span class='text-danger'><b>" + data[i].nama_jabatan + '</b></span></td>' +
	// //                         '<td style="text-transform:uppercase;">' + dataSd + '</td>' +
	// //                         '<td align="center"><button class="btn btn-xs btn-info" onclick="edit(' + data[i].id_syarat_diklat + ')" data-toggle="modal" class="modal" data-target="#myModalEdit"><i class="glyphicon glyphicon-edit"></i>_Edit</button> <button class="btn btn-xs btn-danger" onclick="hapus(' + data[i].id_syarat_diklat + ')"><i class="glyphicon glyphicon-trash"></i>_Hapus</button></td>' +
	// //                         +'</tr>';

	// //                     no++;
	// //                 }
	// //                 $("#myData").html(baris);
	// // 				datatable();

	// //             } else {
	// //                 $("#myData").html("<tr><td colspan='5' align='center'><b class='text-muted text-center'><i class='glyphicon glyphicon-search'></i> Baris Kosong</b></td></tr>");
	// //             }
	// //         }
	// //     });
	// // }
</script>


<script>
unker();

// SELECT UNIT KERJA
function unker() {
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url()."diklat/get_unker" ?>',
        dataType: 'json',
        success: function(hasil) {
            $("#unker,#unkerfilter2").html(hasil);
        }
    });
}

$("#myModalAdd").on("hidden.bs.modal", function(e) {
    reset_form();
});

function reset_form() {
    $("#unker, #jabstruk").select2('val', [0]);    
    $(".teknis_fungsional").css("display", "none");
    $("[name='nama_diklat']").val('');
    var id1 = $("#inlineRadio1");
    var id2 = $("#inlineRadio2");
    id2.prop("disabled", false).prop("checked", false);
}
// SELECT JABATAN STRUKTURAL
$("#unker,#unkerfilter2").on("change", function() {
    var unker = $(this).val();
    if (unker == 0) {
        $("#jabstruk").prop('disabled', true);
    } else {
        $("#jabstruk").prop('disabled', false);

        if ($("#unkerfilter2").val() != 0) {
            $("#filtercari,#jabatan_filter_data").prop("disabled", false);
        } else {
            $("#filtercari,#jabatan_filter_data").prop("disabled", true);
            dataTables.ajax.reload();
        }

        $.ajax({
            url: '<?php echo base_url()."diklat/get_jabstruk" ?>',
            type: 'POST',
            data: 'idunker=' + unker,
            dataType: 'json',
            success: function(data) {
                $("#jabstruk,#jabatan_filter_data").html(data);
            }
        });
    }
});


$("#jabstruk").on("change", function() {
    var id1 = $("#inlineRadio1");
    var id2 = $("#inlineRadio2");
    
    id1.prop("disabled", true);
    id2.prop("disabled", false).prop("checked", true);
    $(".teknis_fungsional").css("display", "block");
    $("#nm").prop("disabled", false);

    $("#save").prop("disabled", false);
});

$("[name='jnsjb']").on("change", function() {
    var id1 = $("#inlineRadio1");
    var id2 = $("#inlineRadio2");
    if (id1[0].checked || id2[0].checked) {
        $("#nm").prop("disabled", false);
        if (id1[0].checked) {
            $(".struktural").css("display", "block");
            $(".teknis_fungsional").css("display", "none");
        } else if (id2[0].checked) {
            $(".struktural").css("display", "none");
            $(".teknis_fungsional").css("display", "block");
        }
    }
});

function toSave() {
    var cekjab = $("[name= 'jabstruk']");
    if (cekjab.val() != "") {
        var n_jab = cekjab.val();
    } else {
        var n_jab = $("[name= 'jabfu']").val();
    }

    var id1 = $("#inlineRadio1");
    var id2 = $("#inlineRadio2");

    if (id1[0].checked) {
        var jns_jab = id1.val();
        var nm_dik = $("[name='nama_dik']:checked").map(function() {
            return $(this).val();
        }).get();
    } else if (id2[0].checked) {
        var jns_jab = id2.val();
        var nm_dik = $("[name='nama_diklat']").val();
    }

    $.ajax({
        type: 'POST',
        data: 'n_jab=' + n_jab + '&jns_jab=' + jns_jab + '&nm_dik=' + nm_dik,
        url: '<?php echo base_url()."diklat/p_tambahdata" ?>',
        dataType: 'json',
        beforeSend: function() {
            $("#save").append("<center style='position:relative; top:-3px; right:-3px; margin-left:5px; float:right;' id='loader'><img width='12' height='12' src='<?php echo base_url()." / assets / diklat / ajax_loader.gif " ?>'></center>");
            $("#save").prop("disabled", true);
        },
        success: function(hasil) {

            $('#msg').html(hasil.pesan);
            dataTables.ajax.reload();
            // location.reload();
        },
        complete: function() {
            // $("#collapseAdd").fadeOut();
            // unker();
            $("#save").prop("disabled", false);
            $("#loader").remove();
            // $("#inlineCheckbox1,#inlineCheckbox2,#inlineCheckbox3,#inlineCheckbox4,#inlineCheckbox5").prop("checked", false);
            // $("#inlineRadio1,#inlineRadio2").prop("checked", false);
            $("#nm").val("");
        }
    });
}

function edit(id) {
    $.ajax({
        type: 'POST',
        data: 'id=' + id,
        url: '<?php echo base_url()."diklat/editdata" ?>',
        dataType: 'json',
        success: function(oke) {
            $("span#title-edit").html("<b>" + oke[0].nama_jabatan + "</b> <span class='pull-right' style='position:relative; top:8px; right:13px;'> NO URUT: " + oke[0].id_syarat_diklat + "</span>");
            $("#id_syarat_diklat").val(oke[0].id_syarat_diklat);
            var idunker = oke[0].id_unit_kerja;
            var unker = oke[0].nama_unit_kerja;
            var nama_jab = oke[0].nama_jabatan;
            $("#nama_jabatan").html(nama_jab);

            var nd = oke[0].nama_syarat_diklat;

            var jns = oke[0].jenis_syarat_diklat;

            var ido1 = $("#inlineRadioFilter1");
            var ido2 = $("#inlineRadioFilter2");

             var kata = nd.split(",");

            var nm_d = $("[name='nama_dik_fil']").val(kata);

            if (jns == 'STRUKTURAL') {
            	

                ido1.prop("checked", true);

                ido2.prop("disabled", true);
                ido1.prop("disabled", false);
                $(".struktural_fil").css("display", "block");
                $(".teknis_fungsional_fil").css("display", "none");

                var kata = nd.slice(",");
                



            } else {
                ido2.prop("checked", true);

                ido2.prop("disabled", false);
                ido1.prop("disabled", true);
                $(".teknis_fungsional_fil").css("display", "block");
                $(".struktural_fil").css("display", "none");
                $("#nm_diklat_filter").val(nd);
            }

            var id_jabatan = oke[0].fid_jabatan;
            $("#jabatanid").val(id_jabatan);

            $("#nm_diklat_filter").val(nd);
            $("#unkerfilter").html(unker);
            $("#unkerid").val(idunker);
            jabstruk_filter();
        }
    });
}

// SELECT JABATAN STRUKTURAL FILTERING
function jabstruk_filter() {
    var unkerid = $("#unkerid").val();
    $.ajax({
        url: '<?php echo base_url()."diklat/get_jabstruk" ?>',
        type: 'POST',
        data: 'idunker=' + unkerid,
        dataType: 'json',
        success: function(dataoke) {
            $("#jabatanfilter").html(dataoke);
        }
    });
}

function update() {
    var id = $("#id_syarat_diklat").val();
    var jabatan = $("#jabatanfilter");


    if (jabatan.val() == 0) {
        var jab = $("#jabatanid").val();
    } else {
        var jab = jabatan.val();
    }

    var id1 = $("#inlineRadioFilter1");
    var id2 = $("#inlineRadioFilter2");

    if (id1[0].checked) {
        var jns_jab = id1.val();
        var diklat = $("[name='nama_dik_fil']:checked").map(function() {
            return $(this).val();
        }).get();
    } else if (id2[0].checked) {
        var jns_jab = id2.val();
        var diklat = $("#nm_diklat_filter").val();
    }

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url()."diklat/updatedata" ?>',
        dataType: 'json',
        data: 'id=' + id + '&jnsjab=' + jns_jab + '&jab=' + jab + '&diklat=' + diklat,
        success: function(rest) {
            dataTables.ajax.reload();
            swal({
                title: "Success!",
                text: "Data Telah Diupdate",
                type: "success",
                timer: "1500",
                showConfirmButton: false
            });
            var counter = 1;
            var counterId = setInterval(function() {

                counter = 1;
                $("#myModalEdit").modal('hide');
                if (counter == 1) {
                    clearInterval(counterId);
                }
            }, 1700);
        },
        complete: function() {
            $("#jabatanfilter").css("display", "none");
            $("span#nama_jabatan").css("display", "block");
            $("a#l_edit").css("display", "block");
            $("a#r_edit").css("display", "none");
            $("span.info").css("display", "none");
        }
    });
}

function hapus(id) {
    swal({
        title: "Apakah anda yakin?",
        text: "Anda akan menghapus data tersebut Secara Permanent!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Ya, Hapus !",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'POST',
                data: 'id=' + id,
                url: '<?php echo base_url()."diklat/hapus_data" ?>',
                success: function() {
                    dataTables.ajax.reload();
                },
                complete: function() {
                    swal({
                        title: "Sukses",
                        text: "1 Baris Data Telah Dihapus",
                        showConfirmButton: false,
                        type: "success",
                        timer: 1500
                    });
                }
            });
        } else {
            swal({
                title: "Cencel",
                text: "Data Batal Di Hapus",
                showConfirmButton: false,
                type: "error",
                timer: 1500
            });
        }
    });
}

function sysc_usulan(id) {
	$("#myModalApprv").modal('show');
	$.ajax({
		type: 'GET',
        url: '<?php echo base_url()."diklat/apprv_diklat_struktural" ?>',
        data: {id: id},
        dataType: 'html',
        success: function(result) {
        	$("#myModalApprv .modal-content").find(".modal-body").html(result);
        }
	});
}

$(document).on('submit', 'form[name="sinkron_usulan"]', function(e) {
	e.preventDefault();
	var _self = $(this);
	var _action = _self.attr('action');
	var _data = _self.serialize();
	
	var r = confirm("Apakah anda yakin akan melakukan sinkronisasi?");
	if (r == true) {
	  $.post(_action, _data, function(response) {
	  	alert(response.pesan);
	  	dataTables2.ajax.reload();
	  	_self[0].reset();
		$("#myModalApprv").modal('hide');
	  }, 'json');
	} else {
	  return "You pressed Cancel!";
	}
});
</script>
