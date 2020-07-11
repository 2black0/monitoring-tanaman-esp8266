<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">


	<title>Sistem Monitoring Tanaman</title>
</head>

<body>

	<?php
    include_once("dbconnect.php");
  ?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="index.php">Dashboard</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
					<a class="nav-item nav-link" href="about.php">About</a>
				</div>
			</div>
		</div>
	</nav>


	<div class="container">

		<div class="jumbotron jumbotron-fluid">
			<div class="container">
				<h1 class="display-4">Sistem Monitoring Tanaman</h1>
				<p class="lead">Sistem Monitoring Tanaman</p>
			</div>
		</div>

		<h4>Waktu Update <span class="badge badge-secondary">
				<?php
            $hasil = mysqli_query($dbc, "SELECT waktu FROM logsensor ORDER BY id_data DESC LIMIT 1");
            $hasil = $hasil->fetch_object()->waktu;
            echo $hasil;
          ?>
			</span>
		</h4>

		<div class="row text-center">
			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title"> Suhu <br> Udara</h5>
						<h1 class="card-text">
							<?php
                  $hasil = mysqli_query($dbc, "SELECT suhu_udara FROM logsensor ORDER BY id_data DESC LIMIT 1");
                  $hasil = $hasil->fetch_object()->suhu_udara;
                  printf("%.1f °C", $hasil);
                ?>
						</h1>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title">Kelembaban Udara</h5>
						<h1 class="card-text">
							<?php
                  $hasil = mysqli_query($dbc, "SELECT kelembaban_udara FROM logsensor ORDER BY id_data DESC LIMIT 1");
                  $hasil = $hasil->fetch_object()->kelembaban_udara;
                  printf("%d %%", $hasil);
              ?>
						</h1>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title">Kelembaban Tanah</h5>
						<h1 class="card-text">
							<?php
                $hasil = mysqli_query($dbc, "SELECT kelembaban_tanah FROM logsensor ORDER BY id_data DESC LIMIT 1");
                $hasil = $hasil->fetch_object()->kelembaban_tanah;
                printf("%d %%", $hasil);
              ?>
						</h1>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title">Status Motor Pompa</h5>
						<h1 class="card-text">
							<?php
                $hasil = mysqli_query($dbc, "SELECT status_pompa FROM logsensor ORDER BY id_data DESC LIMIT 1");
                $hasil = $hasil->fetch_object()->status_pompa;
                if ($hasil == 1) {
                    printf("ON");
                } else {
                    printf("OFF");
                }
              ?>
						</h1>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title">Status <br> Kipas</h5>
						<h1 class="card-text">
							<?php
                $hasil = mysqli_query($dbc, "SELECT status_kipas FROM logsensor ORDER BY id_data DESC LIMIT 1");
                $hasil = $hasil->fetch_object()->status_kipas;
                if ($hasil == 1) {
                    printf("ON");
                } else {
                    printf("OFF");
                }
              ?>
						</h1>
					</div>
				</div>
			</div>
		</div>

		<div class="row text-center">
			<div class="col-md">
				<br>
				<h3>Tabel</h3>
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th class="align-middle" scope="col">No</th>
							<th class="align-middle" scope="col">Waktu</th>
							<th class="align-middle" scope="col">Suhu Udara</th>
							<th class="align-middle" scope="col">Status Suhu Udara</th>
							<th class="align-middle" scope="col">Kelembaban Udara</th>
							<th class="align-middle" scope="col">Status Kelembaban Udara</th>
							<th class="align-middle" scope="col">Kelembaban Tanah</th>
							<th class="align-middle" scope="col">Status Kelembaban Tanah</th>
							<th class="align-middle" scope="col">Status Motor Pompa</th>
							<th class="align-middle" scope="col">Status Kipas</th>
						</tr>
					</thead>

					<tbody>

						<?php
              $hasil = mysqli_query($dbc, "SELECT * FROM logsensor ORDER BY id_data DESC LIMIT 10");
              $id = 0;
              $status = "";
              $datalabels = [];
              $valuelabels = [];
              while ($baris = mysqli_fetch_row($hasil)) {
                  array_push($datalabels, $baris[1]);
                  array_push($valuelabels, $baris[2]);

                  $id         += 1;
                  $id_data    = $baris[0];
                  $waktu      = $baris[1];
                  $suhu_udara  = $baris[2];
                  $kelembaban_udara  = $baris[3];
                  $kelembaban_tanah  = $baris[4];
                  $status_pompa  = $baris[5];
                  $status_kipas  = $baris[6];

                  if ($suhu_udara > 36) {
                      $status_suhu_udara = "Sangat Panas";
                  } elseif ($suhu_udara >= 34 && $suhu_udara <= 36) {
                      $status_suhu_udara = "Panas";
                  } elseif ($suhu_udara >= 24 && $suhu_udara < 34) {
                      $status_suhu_udara = "Normal";
                  } elseif ($suhu_udara >= 18 && $suhu_udara < 23) {
                      $status_suhu_udara = "Sejuk";
                  } else {
                      $status_suhu_udara = "Dingin";
                  }

                  if ($kelembaban_udara > 70) {
                      $status_kelembaban_udara = "Udara Basah";
                  } elseif ($kelembaban_udara >= 35 && $kelembaban_udara <= 70) {
                      $status_kelembaban_udara = "Udara Lembab";
                  } else {
                      $status_kelembaban_udara = "Udara Kering";
                  }

                  if ($kelembaban_tanah > 70) {
                      $status_kelembaban_tanah = "Tanah Basah";
                  } elseif ($kelembaban_tanah >= 35 && $kelembaban_tanah <= 70) {
                      $status_kelembaban_tanah = "Tanah Lembab";
                  } else {
                      $status_kelembaban_tanah = "Tanah Kering";
                  }

                  if ($status_pompa == 1) {
                      $status_pompa = "ON";
                  } else {
                      $status_pompa = "OFF";
                  }

                  if ($status_kipas == 1) {
                      $status_kipas = "ON";
                  } else {
                      $status_kipas = "OFF";
                  }

                  echo "<tr>";
                  echo "<td>$id</td>";
                  echo "<td>$waktu</td>";
                  echo "<td>$suhu_udara °C</td>";
                  echo "<td>$status_suhu_udara</td>";
                  echo "<td>$kelembaban_udara %</td>";
                  echo "<td>$status_kelembaban_udara</td>";
                  echo "<td>$kelembaban_tanah %</td>";
                  echo "<td>$status_kelembaban_tanah</td>";
                  echo "<td>$status_pompa</td>";
                  echo "<td>$status_kipas</td>";
                  echo "</tr>";
              }
            ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="js/jquery-3.5.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/Chart.js"></script>

</body>

</html>
