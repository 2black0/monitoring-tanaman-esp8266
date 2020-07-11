<?php
include_once("dbconnect.php");

  $ok = true;
  if (! isset($_GET['temp'])) {
      $ok = false;
  }

  if (! isset($_GET['huma'])) {
      $ok = false;
  }

  if (! isset($_GET['hums'])) {
      $ok = false;
  }

  if (! isset($_GET['pump'])) {
      $ok = false;
  }

  if (! isset($_GET['fan'])) {
      $ok = false;
  }

  if (! $ok) {
      print("Salah penggunaan!");
      exit();
  }

  $waktu = date("Y-m-d H:i:s");
  $suhu_udara = $_GET['temp'];
  $kelembaban_udara = $_GET['huma'];
  $kelembaban_tanah = $_GET['hums'];
  $status_pompa = $_GET['pump'];
  $status_kipas = $_GET['fan'];

  $sql = "INSERT INTO logsensor (waktu, suhu_udara, kelembaban_udara, kelembaban_tanah, status_pompa, status_kipas) " .
         "VALUES ('" .  $waktu. "','" . $suhu_udara . "','" . $kelembaban_udara . "','" . $kelembaban_tanah . "','" . $status_pompa . "','" . $status_kipas . "');";

  $hasil = mysqli_query($dbc, $sql);
  if ($hasil) {
      print("Data berhasil disimpan");
  } else {
      print("Data gagal disimpan");
  }

  exit();
