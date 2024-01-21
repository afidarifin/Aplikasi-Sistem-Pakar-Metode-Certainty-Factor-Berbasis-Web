<?php
/**
 * @package   Sistem Pakar Diagnosa Phising <SPK Phising>
 * @author    Afid Arifin <affinbara@gmail.com>
 * @version   v1.0
 * @copyright 02/07/2023
 * @license   /license/
 * @link      https://www.afid.web.id
 */
ini_set('display_errors', 0);
ob_start();

require_once 'includes/connect.php';
require_once 'includes/classes/Helper.php';

if($helper->is_logged()) {
  if($helper->cookie_role() == 1) {
    $helper->redirect('/admin/');
  }
}

$act = isset($_GET['act']) ? trim($_GET['act']) : '';
switch($act) {
  case 'submit':
    $title = 'Hasil Diagnosa';
    require_once 'includes/header.php';
    
    if(isset($_POST['submit'])) {
      $bobotCF = ['0', '1', '0.8', '0.6', '0.4', '0.2', '-0.2', '-0.4', '-0.6', '-0.8', '-1'];
      $gejala  = [];

      for($i = 0; $i < count($_POST['kondisi']); $i++) {
        $kondisi = explode('_', $_POST['kondisi'][$i]);
        if(strlen($_POST['kondisi'][$i]) > 1) {
          $gejala += [$kondisi[0] => $kondisi[1]];
        }
      }

      $sqlKondisi = $db->table('kondisi')
      ->orderBy('id_kondisi+0')
      ->all();
      if(count($sqlKondisi) > 0) {
        foreach($sqlKondisi as $dataKondisi) {
          $textKondisi[$dataKondisi->id_kondisi] = $dataKondisi->kondisi;
        }
      }

      $sqlGangguan = $db->table('gangguan')
      ->orderBy('id_gangguan+0')
      ->all();
      if(count($sqlGangguan) > 0) {
        foreach($sqlGangguan as $dataGangguan) {
          $textGangguanNama[$dataGangguan->id_gangguan]   = $dataGangguan->nama_gangguan;
          $textGangguanSaran[$dataGangguan->id_gangguan]  = $dataGangguan->saran_gangguan;
          $textGangguanDetail[$dataGangguan->id_gangguan] = $dataGangguan->detail;
        }
      }

      /** Mulai Hitung Certainty Factor */
      $cf_gangguan1 = [];
      $cf_gangguan2 = $db->table('gangguan')
      ->orderBy('id_gangguan DESC')
      ->all();
      
      if(count($cf_gangguan2) > 0) {
        foreach($cf_gangguan2 as $data_cf1) {
          $cf_total_temp  = 0;
          $cf             = 0;
          $cf_lama        = 0;
          $cf_pengetahuan = $db->table('pengetahuan')
          ->where('id_gangguan', $data_cf1->id_gangguan)
          ->all();

          if(count($cf_pengetahuan) > 0) {
            foreach($cf_pengetahuan as $data_cf2) {
              $kondisi   = explode('_', $_POST['kondisi'][0]);
              $cf_gejala = $kondisi[0];
              
              for($i = 0; $i < count($_POST['kondisi']); $i++) {
                $kondisi   = explode('_', $_POST['kondisi'][$i]);
                $cf_gejala = $kondisi[0];
                
                if($data_cf2->id_gejala == $cf_gejala) {
                  $cf = ($data_cf2->mb - $data_cf2->md) * $bobotCF[$kondisi[1]];
                  if(($cf >= 0) && ($cf * $cf_lama >= 0)) {
                    $cf_lama = $cf_lama + ($cf * (1 - $cf_lama));
                  }

                  if($cf * $cf_lama < 0) {
                    $cf_lama = ($cf_lama + $cf) / (1 - Min(abs($cf_lama), abs($cf)));
                  }

                  if(($cf < 0) && ($cf * $cf_lama >= 0)) {
                    $cf_lama = $cf_lama + ($cf * (1 + $cf_lama));
                  }
                }
              }
            }

            if($cf_lama > 0) {
              $cf_gangguan1 += [
                $data_cf1->id_gangguan => number_format($cf_lama, 4),
              ];
            }
          }
        }

        asort($cf_gangguan1);
        $np = 0;
        foreach($cf_gangguan1 as $key => $value) {
          $np++;
          $idpkt[$np] = $key;
          $nmpkt[$np] = $textGangguanNama[$key];
          $vlpkt[$np] = $value;
        }
        
        $persentase = round(($vlpkt[1] * 100), 2);
        if($persentase >= 30) {
          $diagnosis           = 'phising';
          $backgroundDiagnosis = 'bg-red';
        } elseif($persentase >= 10) {
          $diagnosis           = 'suspicious';
          $backgroundDiagnosis = 'bg-orange';
        } else {
          $diagnosis           = 'aman';
          $backgroundDiagnosis = 'bg-green';
        }
      }
      /** Akhir Hitung Certainty Factor */
    } else {
      $helper->redirect('/');
    }
    ?>
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <i class="icon fa fa-legal"></i>
                  Hasil Diagnosa
                </h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <p style="margin-left: 60px;width: 200px;height:200px;border-radius: 100%;font-size: 25px;justify-content: center;align-items: center;text-align: center;display: flex;text-transform: uppercase;" class="text-center <?php echo $backgroundDiagnosis; ?>">
                      <?php echo $diagnosis; ?>
                    </p>
                  </div>
                  <div class="col-md-8">
                    <?php
                      if($persentase >= 10 || $persentase >= 30) {
                        ?>
                          <h4 style="margin-top: -2px;color: red;font-size: 22px;">
                            <i class="icon fa fa-warning"></i>
                            Peringatan
                          </h4>
                          <p>
                            Berdasarkan masukkan Anda, hasil identifikasi sistem kami menyimpulkan bahwa gejala atau ciri-ciri situs phising sebagai berikut:
                            <ul style="list-style: none;margin-left: -22px;">
                              <?php
                                $ig = 0;
                                foreach($gejala as $key => $val) {
                                  $gejala_2 = $key;
                                  $kondisi  = $val;
                                  
                                  $sqlGejala = $db->table('gejala')
                                  ->where('id_gejala', $key)
                                  ->orderBy('id_gejala DESC')
                                  ->all();
                                  if(count($sqlGejala) > 0) {
                                    foreach($sqlGejala as $dataGejala) {
                                      ?>
                                        <li>
                                          <i class="icon fa fa-times-circle-o text-red"></i>
                                          <?php echo $dataGejala->nama_gejala; ?>
                                          (<b><?php echo $textKondisi[$kondisi]; ?></b>)
                                        </li>
                                      <?php
                                    }
                                  }
                                  $ig++;
                                }
                              ?>
                            </ul>
                            Telah teridentifikasi sebagai situs yang <?php echo ($diagnosis == 'phising' ? 'berbahaya' : ($diagnosis == 'suspicious' ? 'mencurigakan' : 'aman')); ?> untuk dikunjungi. Saran terbaik dari kami adalah sebagai berikut:
                            <ul style="list-style: none;margin-left: -22px;">
                              <?php
                                $srn = 0;
                                foreach($gejala as $dataKey => $dataValue) {
                                  $srn++;
                                  ?>
                                    <li>
                                      <i class="icon fa fa-check-square-o text-green"></i>
                                      <?php echo $textGangguanSaran[$dataKey]; ?>
                                    </li>
                                  <?php
                                }
                              ?>
                            </ul>
                          </p>
                        <?php
                      } else {
                        ?>
                          <h4 style="margin-top: -2px;color: green;font-size: 22px;">
                            <i class="icon fa fa-check"></i>
                            Selamat
                          </h4>
                          <p>
                            Berdasarkan masukkan Anda, hasil identifikasi sistem kami menyimpulkan bahwa gejala atau ciri-ciri situs phising sebagai berikut:
                            <ul style="list-style: none;margin-left: -22px;">
                              <?php
                                $ig = 0;
                                foreach($gejala as $key => $val) {
                                  $gejala_2 = $key;
                                  $kondisi  = $val;
                                  
                                  $sqlGejala = $db->table('gejala')
                                  ->where('id_gejala', $key)
                                  ->orderBy('id_gejala DESC')
                                  ->all();
                                  if(count($sqlGejala) > 0) {
                                    foreach($sqlGejala as $dataGejala) {
                                      ?>
                                        <li>
                                          <i class="icon fa fa-check-square-o text-green"></i>
                                          <?php echo $dataGejala->nama_gejala; ?>
                                          (<b><?php echo $textKondisi[$kondisi]; ?></b>)
                                        </li>
                                      <?php
                                    }
                                  }
                                  $ig++;
                                }
                              ?>
                            </ul>
                            Telah teridentifikasi sebesar <b>100%</b> sebagai situs yang aman untuk dikunjungi. Jagalah selalu keamanan data atau informasi pribadi Anda.
                          </p>
                        <?php
                      }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <i class="icon fa fa-info-circle"></i>
                  Detail
                </h3>
              </div>
              <div class="box-body">
                <?php
                  $det_id = 0;
                  foreach($gejala as $detKey => $detValue) {
                    $det_id++;
                    ?>
                      <h4 class="box-title">
                        <i class="icon fa fa-check-square-o text-green"></i>
                        <?php echo $textGangguanNama[$detKey]; ?>
                      </h4>
                      <p>
                        <?php echo $textGangguanDetail[$detKey]; ?>
                      </p>
                  <?php
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php
    require_once 'includes/footer.php';
  break;
  default:
    $title = 'Diagnosa';
    require_once 'includes/header.php';
    ?>
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="callout callout-info">
              <p>
                <i class="icon fa fa-bullhorn"></i>
                Silahkan memilih gejala dan kondisi yang sesuai, kemudian tekan tombol <i class="icon fa fa-search-plus"></i> PROSES untuk mulai mengidentifikasi phising dengan cepat.
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">
                  <i class="icon fa fa-stethoscope"></i>
                  Diagnosa Gangguan
                </h3>
              </div>
              <form action="diagnosa.php?act=submit" method="POST" role="form">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-striped table-hover">
                    <tr>
                      <th style="width: 10px;text-align: center;">NO</th>
                      <th style="width: 100px;text-align: center;">Kode</th>
                      <th style="text-align: center;">Gejala</th>
                      <th style="width: 150px;text-align: center;">Kondisi</th>
                    </tr>
                    <?php
                      $gejala = $db->table('gejala')
                      ->orderBy('id_gejala ASC')
                      ->all();

                      if(count($gejala) > 0) {
                        $id = 1;
                        foreach($gejala as $data1) {
                          ?>
                          <tr>
                            <td class="text-center"><?php echo $id; ?></td>
                            <td style="text-align: center;"><?php echo $data1->kode_gejala; ?></td>
                            <td><?php echo $data1->nama_gejala; ?></td>
                            <td>
                              <select name="kondisi[]" class="form-control select2">
                                <option value="0">--- Pilih ---</option>
                                <?php
                                  $kondisi = $db->table('kondisi')
                                  ->orderBy('id_kondisi ASC')
                                  ->all();

                                  if(count($kondisi) > 0) {
                                    $_id = 1;
                                    foreach($kondisi as $data2) {
                                      ?>
                                        <option value="<?php echo $data1->id_gejala; ?>_<?php echo $data2->id_kondisi; ?>">
                                          <?php echo $data2->kondisi; ?>
                                        </option>
                                      <?php
                                      $_id++;
                                    }
                                  }
                                ?>
                              </select>
                            </td>
                          </tr>
                          <?php
                          $id++;
                        }
                      } else {
                        ?>
                          <tr>
                            <td colspan="4" class="text-center">Tidak ada data saat ini.</td>
                          </tr>
                        <?php
                      }
                    ?>
                  </table>
                </div>
                <?php
                  if(count($gejala) != 0) {
                    ?>
                      <div class="box-footer" style="border-top: none;">
                        <button type="submit" name="submit" class="btn btn-success pull-right">
                          <i class="icon fa fa-search-plus"></i>
                          Proses
                        </button>
                      </div>
                    <?php
                  }
                ?>
              </form>
            </div>
          </div>
        </div>
      </section>
    <?php
    require_once 'includes/footer.php';
  break;
}
?>