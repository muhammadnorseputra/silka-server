<div class="container">
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <h4>FILTER PER TAHUN</h4>
            <select name="tahun" id="tahun">
                <option value="">-- ALL --</option>
                <?php 
                    foreach($list_tahun as $t):
                    $selected = $tahun == $t->tahun ? 'selected' : '';
                ?>
                    <option value="<?= $t->tahun ?>" <?= $selected ?>>THN - <?= $t->tahun ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
  <div class="row">
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <b>REKAP BULANAN</b> 
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <th>BULAN</th>
                        <th>TOTAL SANTUNAN</th>
                        <th>TOTAL IURAN</th>
                    </thead>
                    <tbody>
                        <?php 
                            foreach(list_bulan() as $r):
                        ?>
                        <tr>
                            <td><?= bulan($r) ?></td>
                            <td><?= $this->korpri->santunan_bulanan(bulan($r), $tahun) ?></td>
                            <td>Rp. <?= nominal($this->korpri->iuran_bulanan(bulan($r), $tahun)) ?></td>
                        </tr>
                        <?php 
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <b>JENIS SANTUNAN</b> 
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <th>NAMA JENIS SANTUNAN</th>
                        <th>TOTAL SANTUNAN</th>
                        <th>TOTAL IURAN</th>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($jenis as $r):
                        ?>
                        <tr>
                            <td><?= $r->nama_jenis_tali_asih ?></td>
                            <td><?= $this->korpri->total_perjenis($r->id_jenis_tali_asih, $tahun) ?></td>
                            <td>Rp. <?= nominal($this->korpri->iuran_perjenis($r->id_jenis_tali_asih, $tahun)) ?></td>
                        </tr>
                        <?php 
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <b>TOTAL PER TAHUN</b> 
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <th>TAHUN</th>
                        <th>TOTAL SANTUNAN</th>
                        <th>TOTAL IURAN</th>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($list_tahun as $r):
                        ?>
                        <tr>
                            <td><?= $r->tahun ?></td>
                            <td><?= $this->korpri->total_pertahun($r->tahun) ?></td>
                            <td>Rp. <?= nominal($this->korpri->iuran_pertahun($r->tahun)) ?></td>
                        </tr>
                        <?php 
                            endforeach;
                        ?>
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td><b><?= $this->korpri->total_pertahun() ?></b></td>
                            <td><b>Rp. <?= nominal($this->korpri->iuran_pertahun()) ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>
<?php $this->load->view($js); ?>