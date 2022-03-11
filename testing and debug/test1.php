<?php
$a = 0;
foreach ($days as $d) :
  $a = 1;
  $daySesi1 = 1;
  $daySesi2 = 1;
  $startDate = new DateTime($d['tarikh_mula']);
  $endDate = new DateTime($d['tarikh_tamat']);
  //$s = date('s');

?>
  <?php for ($i = $startDate; $i <= $endDate; $i->modify('+1 day')) :
    //$date = new DateTime('01-03-2022');
    //$time1 = $i->format('Y-m-d');
    //$time2 = $date->format('Y-m-d');
    // $hour = 13;
    // $minute = 00;

    $date = new DateTime('01-03-2022');
    $time1 = $i->format('Y-m-d');
    $time2 = $date->format('Y-m-d');

    // $hour = date('G');
    // $minute = date('i');
  ?>
    <tr align="center">
      <td><?= $a++; ?></td>
      <td><?= $i->format("D, d/m/Y"); ?></td>
      <td>
        <!-- <?php
              // if ($i == '28-02-2022' && $hour == 00 && $minute == 49) {
              //   echo 'Sesi 1';
              //   //echo $date;
              //   echo $result . "(1)";
              // } else {
              //   echo $result . "(2)";
              // 
              ?>
              //   <a href="borang_health_status.php?hari=<?= $daySesi1++; ?>&sesi=1">Sesi 1</a>
              // <?php
                  // }
                  ?> -->
        <?php
        // if ($time1 == $time2 && ($hour >= 00 && $minute >= 00) && ($hour < 13 && $minute < 00)) {
        if ($time1 == $time2 && ($hour >= 00 && $minute >= 00) && ($hour <= 12 && $minute <= 59)) {
          //echo 'Sesi 1';
          //echo '$I: ' . $i;
          //echo $date;
          //echo $result . "(1)";
          // echo $time2;
          // echo $time1;
        ?>
          <a href="borang_health_status.php?hari=<?= $daySesi1++; ?>&sesi=1"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
        <?php
        } else {
        ?>
          <a href="borang_health_status.php?hari=<?= $daySesi1++; ?>&sesi=1">link 1</a>
        <?php
          // echo '<i class="fa fa-question-circle" aria-hidden="true"></i>';
          // echo Sesi 1
          // echo $time2;
          // echo $time1;
          //   echo $time2;
          // 
        }
        ?>
      </td>
      <td>
        <?php
        if ($time1 == $time2 && ($hour >= 13 && $minute >= 00) && ($hour <= 23 && $minute <= 59)) {
          //echo 'Sesi 1';
          //echo '$I: ' . $i;
          //echo $date;
          //echo $result . "(1)";
          // echo $time2;
          // echo $time1;
        ?>
          <a href="borang_health_status.php?hari=<?= $daySesi2++; ?>&sesi=2"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
        <?php
        } else {
          echo '<i class="fa fa-question-circle" aria-hidden="true"></i>';
          // echo Sesi 2;
          // echo $time2;
          // echo $time1;
          //   echo $time2;
          // 
        }
        ?>
      </td>
    </tr>
  <?php endfor; ?>
<?php endforeach; ?>