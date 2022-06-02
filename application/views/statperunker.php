<?php
// jika data nama unker tidak kosong, atau ombobox unit kerja telah dipilih
if ($nmunker == '')
{     
?>
    <center>
    <div class="panel panel-default" style="width: 50%">
        <div class="panel-body">
           <div class="alert alert-danger alert-dismissible" role="alert">              
              <b>Kesalahan...</b><br />Silahkan pilih unit kerja terlebih dahulu
            </div>  
          <button type="button" class="btn btn-success btn-sm" onclick="history.back(-1)">
          <span class="glyphicon glyphicon-search" aria-hidden="false"></span> Kembali</button>
        </div>
        </div>
    </center>
  <?php
}else
{
?>
<!-- Default panel contents -->
<center>
  <div class="panel panel-default"  style="width: 99%">
      <div class="panel-body">
        <table class='table table-condensed'>
          <tr>
            <?php
            //cek priviledge session user -- cetak_statistik_priv
            if ($this->session->userdata('cetak_statistik_priv') == "Y") { 
            ?>
            <td align='right'>
              <form method="POST" action="../pegawai/cetaknomperunker" target='_blank'>                
                <input type='hidden' name='id' id='id' maxlength='18' value='<?php echo $idunker; ?>'>
                <button type="submit" class="btn btn-success btn-sm">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Nominatif
                </button>
              </form>
            </td>
            <?php
            }
            ?>
            <td align='right' width='50'>
              <form method="POST" action="../pegawai/tampilunkerstat">
                <button type="submit" class="btn btn-primary btn-sm">
                  <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Kembali
                </button>
              </form>
            </td>
          </tr>
        </table> 

        <div class="panel panel-info">  
          <div class="panel-heading" align="left"><b>STATISTIK ASN ::: <?php echo $nmunker ?></b><br />
            <?php echo "Jumlah ASN : ".$jmlpeg ?>
          </div>
          <div style="padding:3px;overflow:auto;width:99%;height:450px;border:1px solid white" >
          <table class="table table-bordered table-hover">
            <tr>
              <td>
                <ul class="nav nav-tabs">
                      <!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
                      <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
                  <li class='active'><a href='#statpeg' data-toggle='tab'>Status Pegawai</a></li>
                  <li><a href='#golru' data-toggle='tab'>Golru</a></li>
                  <li><a href="#eselon" data-toggle="tab">Eselon</a></li>
                  <li><a href='#pend' data-toggle='tab'>Pendidikan</a></li>
                  <li><a href='#jenkel' data-toggle='tab'>Jenis Kelamin</a></li>
                  <li><a href='#agama' data-toggle='tab'>Agama</a></li>
                  <li><a href='#statkaw' data-toggle='tab'>Status Kawin</a></li>
                  <li><a href='#bup' data-toggle='tab'>Tahun BUP</a></li>
                  <li><a href='#usia' data-toggle='tab'>Kelompok Usia</a></li>
                  <li><a href='#keltu' data-toggle='tab'>Kelompok Tugas</a></li>
                </ul>

                <div class="tab-content">
                  <!-- awal konten tab status kepegawaian -->
                  <div class="tab-pane face in active" id="statpeg">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan STATUS PEGAWAI</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='400'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='60'><center><b>Status Pegawai</b></center></td>
                            <td width='60'><center><b>Jumlah</b></center></td>
                          </tr>
                          <tr>
                            <td><center>CPNS</center></td>
                            <td><center><?php echo $stcpns; ?></center></td>
                          </tr>
                          <tr>
                            <td><center>PNS</center></td>
                            <td><center><?php echo $stpns; ?></center></td>
                          </tr>
                          <tr>
                            <td><center><u>Total</u></center></td>
                            <td><center><u><?php echo $stcpns+$stpns; ?></u></center></td>
                          </tr>
                          </table>
                        </td>
                        <td></td>
                        </tr>
                        <tr class='info'>
                        <td width='1000' colspan='3'>
                          <table class='table table-condensed table-hover table-bordered'>
                            <tr>
                              <td width='100'><center><b>Golongan Ruang</b></center></td>
                              <td width='30' title='JURU MUDA'><center><b>I/a</b></center></td>
                              <td width='30' title='JURU MUDA TK. I'><center><b>I/b</b></center></td>
                              <td width='30' title='JURU'><center><b>I/c</b></center></td>
                              <td width='30' title='JURU TK. I'><center><b>I/d</b></center></td>
                              <td width='30' title='PENGATUR MUDA'><center><b>II/a</b></center></td>
                              <td width='30' title='PENGATUR MUDA TK. I'><center><b>II/b</b></center></td>
                              <td width='30' title='PENGATUR'><center><b>II/c</b></center></td>
                              <td width='30' title='PENGATUR TK. I'><center><b>II/d</b></center></td>
                              <td width='30' title='PENATA MUDA'><center><b>III/a</b></center></td>
                              <td width='30' title='PENATA MUDA TK. I'><center><b>III/b</b></center></td>
                              <td width='30' title='PENATA'><center><b>III/c</b></center></td>
                              <td width='30' title='PENATA TK. I'><center><b>III/d</b></center></td>
                              <td width='30' title='PEMBINA'><center><b>IV/a</b></center></td>
                              <td width='30' title='PEMBINA TK. I'><center><b>IV/b</b></center></td>
                              <td width='30' title='PEMBINA UTAMA MUDA'><center><b>IV/c</b></center></td>
                              <td width='30' title='PEMBINA UTAMA MADYA'><center><b>IV/d</b></center></td>
                              <td width='30' title='PEMBINA UTAMA'><center><b>IV/e</b></center></td>
                              <td width='30'><center><b>Jumlah</b></center></td>
                            </tr>
                            <tr>
                              <td><center>CPNS</center></td>
                              <td><center><?php echo $stcpns1a; ?></center></td>
                              <td><center><?php echo $stcpns1b; ?></center></td>
                              <td><center><?php echo $stcpns1c; ?></center></td>
                              <td><center><?php echo $stcpns1d; ?></center></td>
                              <td><center><?php echo $stcpns2a; ?></center></td>
                              <td><center><?php echo $stcpns2b; ?></center></td>
                              <td><center><?php echo $stcpns2c; ?></center></td>
                              <td><center><?php echo $stcpns2d; ?></center></td>
                              <td><center><?php echo $stcpns3a; ?></center></td>
                              <td><center><?php echo $stcpns3b; ?></center></td>
                              <td><center><?php echo $stcpns3c; ?></center></td>
                              <td><center><?php echo $stcpns3d; ?></center></td>
                              <td><center><?php echo $stcpns4a; ?></center></td>
                              <td><center><?php echo $stcpns4b; ?></center></td>
                              <td><center><?php echo $stcpns4c; ?></center></td>
                              <td><center><?php echo $stcpns4d; ?></center></td>
                              <td><center><?php echo $stcpns4e; ?></center></td>
                              <td><center><?php echo $stcpns1a+$stcpns1b+$stcpns1c+$stcpns1d+$stcpns2a+$stcpns2b+$stcpns2c+$stcpns2d+$stcpns3a+$stcpns3b+$stcpns3c+$stcpns3d+$stcpns4a+$stcpns4b+$stcpns4c+$stcpns4d+$stcpns4e; ?></center></td>
                            </tr>
                            <tr>
                              <td><center>PNS</center></td>
                              <td><center><?php echo $stpns1a; ?></center></td>
                              <td><center><?php echo $stpns1b; ?></center></td>
                              <td><center><?php echo $stpns1c; ?></center></td>
                              <td><center><?php echo $stpns1d; ?></center></td>
                              <td><center><?php echo $stpns2a; ?></center></td>
                              <td><center><?php echo $stpns2b; ?></center></td>
                              <td><center><?php echo $stpns2c; ?></center></td>
                              <td><center><?php echo $stpns2d; ?></center></td>
                              <td><center><?php echo $stpns3a; ?></center></td>
                              <td><center><?php echo $stpns3b; ?></center></td>
                              <td><center><?php echo $stpns3c; ?></center></td>
                              <td><center><?php echo $stpns3d; ?></center></td>
                              <td><center><?php echo $stpns4a; ?></center></td>
                              <td><center><?php echo $stpns4b; ?></center></td>
                              <td><center><?php echo $stpns4c; ?></center></td>
                              <td><center><?php echo $stpns4d; ?></center></td>
                              <td><center><?php echo $stpns4e; ?></center></td>
                              <td><center><?php echo $stpns1a+$stpns1b+$stpns1c+$stpns1d+$stpns2a+$stpns2b+$stpns2c+$stpns2d+$stpns3a+$stpns3b+$stpns3c+$stpns3d+$stpns4a+$stpns4b+$stpns4c+$stpns4d+$stpns4e; ?></center></td>
                            </tr>
                            </table>    
                            </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- akhir konten tab status kepegawaian -->

                  <!-- awal konten tab Golru -->
                  <div class="tab-pane face" id="golru">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan GOLONGAN RUANG</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='1000'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='100'><center><b>Golongan Ruang</b></center></td>
                            <td width='30' title='JURU MUDA'><center><b>I/a</b></center></td>
                            <td width='30' title='JURU MUDA TK. I'><center><b>I/b</b></center></td>
                            <td width='30' title='JURU'><center><b>I/c</b></center></td>
                            <td width='30' title='JURU TK. I'><center><b>I/d</b></center></td>
                            <td width='30' title='PENGATUR MUDA'><center><b>II/a</b></center></td>
                            <td width='30' title='PENGATUR MUDA TK. I'><center><b>II/b</b></center></td>
                            <td width='30' title='PENGATUR'><center><b>II/c</b></center></td>
                            <td width='30' title='PENGATUR TK. I'><center><b>II/d</b></center></td>
                            <td width='30' title='PENATA MUDA'><center><b>III/a</b></center></td>
                            <td width='30' title='PENATA MUDA TK. I'><center><b>III/b</b></center></td>
                            <td width='30' title='PENATA'><center><b>III/c</b></center></td>
                            <td width='30' title='PENATA TK. I'><center><b>III/d</b></center></td>
                            <td width='30' title='PEMBINA'><center><b>IV/a</b></center></td>
                            <td width='30' title='PEMBINA TK. I'><center><b>IV/b</b></center></td>
                            <td width='30' title='PEMBINA UTAMA MUDA'><center><b>IV/c</b></center></td>
                            <td width='30' title='PEMBINA UTAMA MADYA'><center><b>IV/d</b></center></td>
                            <td width='30' title='PEMBINA UTAMA'><center><b>IV/e</b></center></td>
                            <td width='30'><center><b>Total</b></center></td>
                          </tr>
                          <tr>
                              <td><center>Jumlah</center></td>
                              <td><center><?php echo $stcpns1a+$stpns1a; ?></center></td>
                              <td><center><?php echo $stcpns1b+$stpns1b; ?></center></td>
                              <td><center><?php echo $stcpns1c+$stpns1c; ?></center></td>
                              <td><center><?php echo $stcpns1d+$stpns1d; ?></center></td>
                              <td><center><?php echo $stcpns2a+$stpns2a; ?></center></td>
                              <td><center><?php echo $stcpns2b+$stpns2b; ?></center></td>
                              <td><center><?php echo $stcpns2c+$stpns2c; ?></center></td>
                              <td><center><?php echo $stcpns2d+$stpns2d; ?></center></td>
                              <td><center><?php echo $stcpns3a+$stpns3a; ?></center></td>
                              <td><center><?php echo $stcpns3b+$stpns3b; ?></center></td>
                              <td><center><?php echo $stcpns3c+$stpns3c; ?></center></td>
                              <td><center><?php echo $stcpns3d+$stpns3d; ?></center></td>
                              <td><center><?php echo $stcpns4a+$stpns4a; ?></center></td>
                              <td><center><?php echo $stcpns4b+$stpns4b; ?></center></td>
                              <td><center><?php echo $stcpns4c+$stpns4c; ?></center></td>
                              <td><center><?php echo $stcpns4d+$stpns4d; ?></center></td>
                              <td><center><?php echo $stcpns4e+$stpns4e; ?></center></td>
                              <td><center><?php echo $stcpns1a+$stcpns1b+$stcpns1c+$stcpns1d+$stcpns2a+$stcpns2b+$stcpns2c+$stcpns2d+$stcpns3a+$stcpns3b+$stcpns3c+$stcpns3d+$stcpns4a+$stcpns4b+$stcpns4c+$stcpns4d+$stcpns4e+$stpns1a+$stpns1b+$stpns1c+$stpns1d+$stpns2a+$stpns2b+$stpns2c+$stpns2d+$stpns3a+$stpns3b+$stpns3c+$stpns3d+$stpns4a+$stpns4b+$stpns4c+$stpns4d+$stpns4e; ?></center></td>
                            </tr>                                                    
                          </table>
                        </td>
                        <td></td>
                      </tr>
                    </table>
                    </div>
                  </div>
                  <!-- akhir konten tab Golru -->

                  <!-- awal konten tab Eselon -->
                  <div class="tab-pane face" id="eselon">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan ESELON</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='1000'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='100'><center><b>Eselonering</b></center></td>
                            <td width='30'><center><b>II/a</b></center></td>
                            <td width='30'><center><b>II/b</b></center></td>
                            <td width='30'><center><b>III/a</b></center></td>
                            <td width='30'><center><b>III/b</b></center></td>
                            <td width='30'><center><b>IV/a</b></center></td>
                            <td width='30'><center><b>IV/b</b></center></td>
                            <td width='30'><center><b>V</b></center></td>
                            <td width='30'><center><b>JFU</b></center></td>
                            <td width='30'><center><b>JFT</b></center></td>
                            <td width='30'><center><b>Total</b></center></td>
                          </tr>
                          <tr>
                              <td><center>Jumlah</center></td>
                              <td><center><?php echo $esl2a; ?></center></td>
                              <td><center><?php echo $esl2b; ?></center></td>
                              <td><center><?php echo $esl3a; ?></center></td>
                              <td><center><?php echo $esl3b; ?></center></td>
                              <td><center><?php echo $esl4a; ?></center></td>
                              <td><center><?php echo $esl4b; ?></center></td>
                              <td><center><?php echo $esl5; ?></center></td>
                              <td><center><?php echo $esljfu; ?></center></td>
                              <td><center><?php echo $esljft; ?></center></td>
                              <td><center><?php echo $esl2a+$esl2b+$esl3a+$esl3b+$esl4a+$esl4b+$esl5+$esljfu+$esljft; ?></center></td>
                            </tr>                                                    
                          </table>
                        </td>
                        <td></td>
                      </tr>
                    </table>                      
                    </div>
                  </div>
                  <!-- akhir konten tab Eselon -->

                  <!-- awal konten tab Pendidikan -->
                  <div class="tab-pane face" id="pend">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan PENDIDIKAN</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='1000'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='100'><center><b>Tingkat Pendidikan</b></center></td>
                            <td width='30'><center><b>SD</b></center></td>
                            <td width='30'><center><b>SMP</b></center></td>
                            <td width='30'><center><b>SMA</b></center></td>
                            <td width='30'><center><b>D1</b></center></td>
                            <td width='30'><center><b>D2</b></center></td>
                            <td width='30'><center><b>D3</b></center></td>
                            <td width='30'><center><b>D4</b></center></td>
                            <td width='30'><center><b>S1</b></center></td>
                            <td width='30'><center><b>S2</b></center></td>
                            <td width='30'><center><b>S3</b></center></td>
                            <td width='30'><center><b>Total</b></center></td>
                          </tr>
                          <tr>
                              <td><center>Jumlah</center></td>
                              <td><center><?php echo $tpsd; ?></center></td>
                              <td><center><?php echo $tpsmp; ?></center></td>
                              <td><center><?php echo $tpsma; ?></center></td>
                              <td><center><?php echo $tpd1; ?></center></td>
                              <td><center><?php echo $tpd2; ?></center></td>
                              <td><center><?php echo $tpd3; ?></center></td>
                              <td><center><?php echo $tpd4; ?></center></td>
                              <td><center><?php echo $tps1; ?></center></td>
                              <td><center><?php echo $tps2; ?></center></td>
                              <td><center><?php echo $tps3; ?></center></td>
                              <td><center><?php echo $tpsd+$tpsmp+$tpsma+$tpd1+$tpd2+$tpd3+$tpd4+$tps1+$tps2+$tps3; ?></center></td>
                            </tr>                                                    
                          </table>
                        </td>
                        <td></td>
                      </tr>
                    </table>                      
                    </div>
                  </div>
                  <!-- akhir konten tab Eselon -->

                  <!-- awal konten tab Jenis Kelamin -->
                  <div class="tab-pane face" id="jenkel">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan JENIS KELAMIN</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='400'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='60'><center><b>Jenis Kelamin</b></center></td>
                            <td width='60'><center><b>Jumlah</b></center></td>
                          </tr>
                          <tr>
                            <td><center>Laki-Laki</center></td>
                            <td><center><?php echo $lk; ?></center></td>
                          </tr>
                          <tr>
                            <td><center>Perempuan</center></td>
                            <td><center><?php echo $pr; ?></center></td>
                          </tr>
                          <tr>
                            <td><center><u>Total</u></center></td>
                            <td><center><u><?php echo $lk+$pr; ?></u></center></td>
                          </tr>
                          </table>
                        </td>
                        <td></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- akhir konten tab Jenis Kelamin -->

                   <!-- awal konten tab Agama -->
                  <div class="tab-pane face" id="agama">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan AGAMA</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='1000'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='100'><center><b>AGAMA</b></center></td>
                            <td width='30'><center><b>ISLAM</b></center></td>
                            <td width='30'><center><b>PROTESTAN</b></center></td>
                            <td width='30'><center><b>KATHOLIK</b></center></td>
                            <td width='30'><center><b>BUDHA</b></center></td>
                            <td width='30'><center><b>HINDU</b></center></td>
                            <td width='30'><center><b>KONGHUCHU</b></center></td>
                            <td width='30'><center><b>Total</b></center></td>
                          </tr>
                          <tr>
                              <td><center>Jumlah</center></td>
                              <td><center><?php echo $agislam; ?></center></td>
                              <td><center><?php echo $agprotestan; ?></center></td>
                              <td><center><?php echo $agkatholik; ?></center></td>
                              <td><center><?php echo $agbudha; ?></center></td>
                              <td><center><?php echo $aghindu; ?></center></td>
                              <td><center><?php echo $agkonghuchu; ?></center></td>
                              <td><center><?php echo $agislam+$agprotestan+$agkatholik+$agbudha+$aghindu+$agkonghuchu; ?></center></td>
                            </tr>                                                    
                          </table>
                        </td>
                        <td></td>
                      </tr>
                    </table>                      
                    </div>
                  </div>
                  <!-- akhir konten tab agama -->

                  <!-- awal konten tab status kawin -->
                  <div class="tab-pane face" id="statkaw">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan STATUS KAWIN</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='400'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='60'><center><b>Status Kawin</b></center></td>
                            <td width='60'><center><b>Jumlah</b></center></td>
                          </tr>
                          <tr>
                            <td><center>Belum Kawin</center></td>
                            <td><center><?php echo $skbelumkawin; ?></center></td>
                          </tr>
                          <tr>
                            <td><center>Kawin</center></td>
                            <td><center><?php echo $skkawin; ?></center></td>
                          </tr>
                          <tr>
                            <td><center>Janda/Duda</center></td>
                            <td><center><?php echo $skjandaduda; ?></center></td>
                          </tr>
                          <tr>
                            <td><center><u>Total</u></center></td>
                            <td><center><u><?php echo $skbelumkawin+$skkawin+$skjandaduda; ?></u></center></td>
                          </tr>
                          </table>
                        </td>
                        <td></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- akhir konten tab status kawin -->

                  <!-- awal konten tab tahun bup -->
                  <div class="tab-pane face" id="bup">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan TAHUN BUP</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='900'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='100'><center><b>Tahun BUP</b></center></td>
                            <td width='30'><center><b>2017</b></center></td>
                            <td width='30'><center><b>2018</b></center></td>
                            <td width='30'><center><b>2019</b></center></td>
                            <td width='30'><center><b>2020</b></center></td>
                            <td width='30'><center><b>2021</b></center></td>
                            <td width='30'><center><b>Total</b></center></td>
                          </tr>
                          <tr>
                              <td><center>Jumlah</center></td>
                              <td><center><?php echo $bup2017; ?></center></td>
                              <td><center><?php echo $bup2018; ?></center></td>
                              <td><center><?php echo $bup2019; ?></center></td>
                              <td><center><?php echo $bup2020; ?></center></td>
                              <td><center><?php echo $bup2021; ?></center></td>
                              <td><center><?php echo $bup2017+$bup2018+$bup2019+$bup2020+$bup2021; ?></center></td>
                            </tr>                                                    
                          </table>
                        </td>
                        <td></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- akhir konten tab tahun bup -->

                  <!-- awal konten tab kelompok usia -->
                  <div class="tab-pane face" id="usia">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan KELOMPOK USIA</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='900'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='100'><center><b>Kelompok Usia</b></center></td>
                            <td width='30'><center><b>18-25 Tahun</b></center></td>
                            <td width='30'><center><b>26-30 Tahun</b></center></td>
                            <td width='30'><center><b>31-35 Tahun</b></center></td>
                            <td width='30'><center><b>36-40 Tahun</b></center></td>
                            <td width='30'><center><b>41-45 Tahun</b></center></td>
                            <td width='30'><center><b>46-50 Tahun</b></center></td>
                            <td width='30'><center><b>51-55 Tahun</b></center></td>
                            <td width='30'><center><b>56-60 Tahun</b></center></td>                            
                            <td width='30'><center><b>Total</b></center></td>
                          </tr>
                          <tr>
                              <td><center>Jumlah</center></td>
                              <td><center><?php echo $usia1825; ?></center></td>
                              <td><center><?php echo $usia2630; ?></center></td>
                              <td><center><?php echo $usia3135; ?></center></td>
                              <td><center><?php echo $usia3640; ?></center></td>
                              <td><center><?php echo $usia4145; ?></center></td>
                              <td><center><?php echo $usia4650; ?></center></td>
                              <td><center><?php echo $usia5155; ?></center></td>
                              <td><center><?php echo $usia5660; ?></center></td>
                              <td><center><?php echo $usia1825+$usia2630+$usia3135+$usia3640+$usia4145+$usia4650+$usia5155+$usia5660; ?></center></td>
                            </tr>                                                    
                          </table>
                        </td>
                        <td></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- akhir konten tab kelompok usia -->

                  <!-- awal konten tab kelompok tugas -->
                  <div class="tab-pane face" id="keltu">
                    <br />            
                    <div class="panel panel-default">
                      <div class='panel-heading'><b>Rekapitulasi Jumlah dan Statistik ASN berdasarkan KELOMPOK TUGAS</b></div>
                      <table class='table table-condensed table-hover'>
                        <tr class='success'>
                        <td></td>
                        <td width='900'>
                          <table class='table table-condensed table-hover table-bordered'>
                          <tr>
                            <td width='100'><center><b>Kelompok Tugas</b></center></td>
                            <td width='30'><center><b>Pendidikan</b></center></td>
                            <td width='30'><center><b>Kesehatan</b></center></td>
                            <td width='30'><center><b>Penyuluh</b></center></td>
                            <td width='30'><center><b>Teknis</b></center></td>
                            <td width='30'><center><b>Total</b></center></td>
                          </tr>
                          <tr>
                              <td><center>Jumlah</center></td>
                              <td><center><?php echo $keltupendidikan; ?></center></td>
                              <td><center><?php echo $keltukesehatan; ?></center></td>
                              <td><center><?php echo $keltupenyuluh; ?></center></td>
                              <td><center><?php echo $keltuteknis; ?></center></td>
                              <td><center><?php echo $keltupendidikan+$keltukesehatan+$keltupenyuluh+$keltuteknis; ?></center></td>
                            </tr>                                                    
                          </table>
                        </td>
                        <td></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- akhir konten tab kelompok tugas -->


                </div>
              </td>
            </tr>      
          </table>
        </div>
      </div>
    </div>
  </div>
</center>
<?php
}
?>
