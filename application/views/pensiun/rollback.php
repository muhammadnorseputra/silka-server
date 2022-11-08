<div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Pensiun Rollback</div>
            <div class="panel-body">
            <form action="../pensiun/rollback_act" method="post">
                <input type="hidden" value="<?= $peg_pensiun->nip ?>" name="nip">
                <table class="table table-bordered table-condensed">
                    <tr>
                        <td width="200">NIP</td>
                        <td width="10">:</td>
                        <td><?= $peg_pensiun->nip ?></td>
                    </tr>
                    <tr>
                        <td>NAMA</td>
                        <td width="10">:</td>
                        <td><?= $peg_pensiun->nama ?></td>
                    </tr>
                    <tr>
                        <td>GELAR DEPAN</td>
                        <td width="10">:</td>
                        <td><?= $peg_pensiun->gelar_depan ?></td>
                    </tr>
                    <tr>
                        <td>GELAR BELAKANG</td>
                        <td width="10">:</td>
                        <td><?= $peg_pensiun->gelar_belakang ?></td>
                    </tr>
                    <tr>
                        <td>TEMPAT LAHIR</td>
                        <td width="10">:</td>
                        <td><?= $peg_pensiun->tmp_lahir ?></td>
                    </tr>
                    <tr>
                        <td>TGL LAHIR</td>
                        <td width="10">:</td>
                        <td><?= $peg_pensiun->tgl_lahir ?></td>
                    </tr>
                    <tr>
                        <td>ALAMAT</td>
                        <td width="10">:</td>
                        <td><?= $peg_pensiun->alamat ?></td>
                    </tr>
                    <tr>
                        <td>JABATAN</td>
                        <td width="10">:</td>
                        <td><?= $peg_pensiun->nama_jabatan ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><button type="submit" class="btn btn-large btn-danger">ROLL BACK DATA</button></td>
                    </tr>
                </table>
            </form>
            </div>
        </div>
            
        </div>
    </div>
</div>
