 <?php
  include_once("dbconnect.php");

  //print("waktu, suhu_udara, kelembaban_udara, kelembaban_tanah, status_pompa, status_kipas <br>");
  $hasil = mysqli_query($dbc, "SELECT * FROM logsensor ORDER BY id_data DESC LIMIT 10");
  while ($baris = mysqli_fetch_row($hasil)) {
      $id_data    = $baris[0];
      $waktu      = $baris[1];
      $suhu_udara = $baris[2];
      $kelembaban_udara = $baris[3];
      $kelembaban_tanah = $baris[4];
      $status_pompa = $baris[5];
      $status_kipas = $baris[6];

      //print("$id_data, $waktu, $turbidity<br>");
      print("$waktu, $suhu_udara, $kelembaban_udara, $kelembaban_tanah, $status_pompa, $status_kipas <br>");
  }

  exit();
?>
