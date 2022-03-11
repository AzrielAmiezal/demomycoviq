<?php

$global = file_get_contents("https://api.covid19api.com/summary");
$global_cases = json_decode($global, true);

echo "<pre>";
print_r($global_cases);
echo "</pre>";

// $total_countries = count($global_cases['Countries']);
// echo "NEGARA: " . strtoupper($global_cases['Countries'][105]['Country']) . "<br/>";
// echo "KES BAHARU: " . $global_cases['Countries'][105]['NewConfirmed'] . "<br/>";
// echo "JUMLAH KES KESELURUHAN: " . $global_cases['Countries'][105]['TotalConfirmed'] . "</br>";
// echo "KEMATIAN BAHARU: " . $global_cases['Countries'][105]['NewDeaths'] . "</br>";
// echo "JUMLAH KEMATIAN: " . $global_cases['Countries'][105]['TotalDeaths'] . "</br>";
// echo "KES SEMBUH BAHARU: " . $global_cases['Countries'][105]['NewRecovered'] . "</br>";
// echo "JUMLAH KES SEMBUH: " . $global_cases['Countries'][105]['TotalRecovered'] . "</br>";
//echo $global_cases['Global']['NewConfirmed'];

// $value = '<table class="table table-bordered">
//           <tr class="bg=primary">
//             <th>County</th>
//             <th>NewConfirmed</th>
//             <th>TotalConfirmed</th>
//             <th>NewDeaths</th>
//             <th>TotalDeaths</th>
//             <th>NewRecovered</th>
//             <th>TotalRecovered</th>
//           </tr>
// ';

// $i = 0;

// while ($i < 6) {

//   $value .= '<tr class="bg-dark text-white">';
//   $value .= '<td>' . $global_cases['Countries'][$i]['Country'] . '</td>';
//   $value .= '<td>' . $global_cases['Countries'][$i]['NewConfirmed'] . '</td>';
//   $value .= '<td>' . $global_cases['Countries'][$i]['TotalConfirmed'] . '</td>';
//   $value .= '<td>' . $global_cases['Countries'][$i]['NewDeaths'] . '</td>';
//   $value .= '<td>' . $global_cases['Countries'][$i]['TotalDeaths'] . '</td>';
//   $value .= '<td>' . $global_cases['Countries'][$i]['NewRecovered'] . '</td>';
//   $value .= '<td>' . $global_cases['Countries'][$i]['TotalRecovered'] . '</td>';

//   $value .= '</tr>';
//   $value .= '</table>';
// }





// echo $value;
