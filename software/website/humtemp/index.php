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

		<h4>Waktu Update <span class="badge badge-secondary">2020-07-08 07:00:00</span></h4>

		<div class="row text-center">
			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title"> Suhu <br> Udara</h5>
						<h1 class="card-text">22°C</h1>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title">Kelembaban Udara</h5>
						<h1 class="card-text">90%</h1>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title">Kelembaban Tanah</h5>
						<h1 class="card-text">20%</h1>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title">Status Motor Pompa</h5>
						<h1 class="card-text">OFF</h1>
					</div>
				</div>
			</div>

			<div class="col-md">
				<div class="card" style="width: 12rem;">
					<div class="card-body">
						<h5 class="card-title">Status <br> Kipas</h5>
						<h1 class="card-text">ON</h1>
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
						<tr>
							<td>1</td>
							<td>2020-07-05 12:37:14</td>
							<td>22°C</td>
							<td>Sejuk</td>
							<td>90%</td>
							<td>Sangat Lembab</td>
							<td>20%</td>
							<td>Sangat Kering</td>
							<td>OFF</td>
							<td>ON</td>
						</tr>

						<tr>
							<td>2</td>
							<td>2020-07-05 12:37:14</td>
							<td>22°C</td>
							<td>Sejuk</td>
							<td>90%</td>
							<td>Sangat Lembab</td>
							<td>20%</td>
							<td>Sangat Kering</td>
							<td>OFF</td>
							<td>ON</td>
						</tr>

						<tr>
							<td>3</td>
							<td>2020-07-05 12:37:14</td>
							<td>22°C</td>
							<td>Sejuk</td>
							<td>90%</td>
							<td>Sangat Lembab</td>
							<td>20%</td>
							<td>Sangat Kering</td>
							<td>OFF</td>
							<td>ON</td>
						</tr>

						<tr>
							<td>4</td>
							<td>2020-07-05 12:37:14</td>
							<td>22°C</td>
							<td>Sejuk</td>
							<td>90%</td>
							<td>Sangat Lembab</td>
							<td>20%</td>
							<td>Sangat Kering</td>
							<td>OFF</td>
							<td>ON</td>
						</tr>

						<tr>
							<td>5</td>
							<td>2020-07-05 12:37:14</td>
							<td>22°C</td>
							<td>Sejuk</td>
							<td>90%</td>
							<td>Sangat Lembab</td>
							<td>20%</td>
							<td>Sangat Kering</td>
							<td>OFF</td>
							<td>ON</td>
						</tr>
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
