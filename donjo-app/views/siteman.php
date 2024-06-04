<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>SIDesa - Buleleng</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex">
	<link rel="stylesheet" href="http://localhost/OpenSID-2406.0.0/assets/css/login-style.css?va65feb01ccabe2b1e4230511a06c7915" media="screen">
	<link rel="stylesheet" href="http://localhost/OpenSID-2406.0.0/assets/css/login-form-elements.css?v8a15d7d3f7157e231e5c4769a6c96827" media="screen">
	<link rel="stylesheet" href="http://localhost/OpenSID-2406.0.0/assets/bootstrap/css/bootstrap.bar.css?vd05b2b1b9f5739fe64a0fa28741124b6" media="screen">
			<link rel='Stylesheet' href="http://localhost/OpenSID-2406.0.0/desa/pengaturan/siteman/siteman.css">
		<link rel="shortcut icon" href="http://localhost/OpenSID-2406.0.0/favicon.ico?v8e9d4d6135c7d035883f12aa37ead2d9" />
	<style type="text/css">
		body.login {
			background-image: url('http://localhost/OpenSID-2406.0.0/assets/css/images/latar_login.jpg?v4c6907b07cbb39745929ca335ee61ca4');
		}
	</style>
	<script src="http://localhost/OpenSID-2406.0.0/assets/bootstrap/js/jquery.min.js?vc9f5aeeca3ad37bf2aa006139b935f0a"></script>
	<script src="http://localhost/OpenSID-2406.0.0/assets/js/jquery.validate.min.js?v1a8dc8a74a2bb8fee9bbb298385174a3"></script>
	<script src="http://localhost/OpenSID-2406.0.0/assets/js/validasi.js?va2684af9b4e0ec6cf65cc54dfb17e280"></script>
	<script src="http://localhost/OpenSID-2406.0.0/assets/js/localization/messages_id.js?v6edf5c2c00243d494440c28b575eca12"></script>
		<script type="text/javascript">
		var csrfParam = 'sidcsrf';
		var getCsrfToken = () => document.cookie.match(new RegExp(csrfParam +'=(\\w+)'))[1]
	</script>
	<script src="http://localhost/OpenSID-2406.0.0/assets/js/anti-csrf.js?v40fdecf5f3d7feb30f54550ffc9220e6"></script>
</head>

<body class="login">
	<div class="top-content">
		<div class="inner-bg">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-4 form-box">
						<div class="form-top">
								<img src="https://sippn.menpan.go.id/images/article/large/logo-kab-morowali18.jpg" alt="" class="img-responsive" />
														
							<div class="login-footer-top">
								<h1>Desa Buleleng </h1>
								<h3>
									<br /><br /><b>Kodepos 94973									<br />Kecamatan Bungku Pesisir<br />Kabupaten Morowali								</h3>
							</div>
													</div>
						<div class="form-bottom">
							<form id="validasi" class="login-form" action="http://localhost/OpenSID-2406.0.0/index.php/siteman/auth" method="post">
																	<div class="form-group">
										<input name="username" type="text" autocomplete="off" placeholder="masukan nama pengguna"  class="form-username form-control required" maxlength="100">
									</div>
									<div class="form-group">
										<input id="password" name="password" type="password" autocomplete="off" placeholder="masukan kata sandi"  class="form-username form-control required" maxlength="100">
									</div>
																		<div class="form-group">
										<input type="checkbox" id="checkbox" class="form-checkbox"> Tampilkan kata sandi
										<a href="http://localhost/OpenSID-2406.0.0/index.php/siteman/lupa_sandi" class="btn" role="button" aria-pressed="true">Lupa Kata Sandi?</a>
									</div>
									<hr />
									<div class="form-group">
										<button type="submit" class="btn">Masuk</button>
									</div>
																								</form>
							<hr />
							<div class="login-footer-bottom"><b3>Copyright-2024 Syahrul</b3></div> <?= AmbilVersi() ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function start_countdown() {
			var times = eval(300) - eval(1717434054);
			var menit = Math.floor(times / 60);
			var detik = times % 60;
			timer = setInterval(function() {
				detik--;
				if (detik <= 0 && menit >= 1) {
					detik = 60;
					menit--;
				}

				if (menit <= 0 && detik <= 0) {
					clearInterval(timer);
					location.reload();
				} else {
					document.getElementById("countdown").innerHTML = "<b>User telah diblokir karena gagal login 3 kali silakan coba kembali dalam " + menit + " MENIT " + detik + " DETIK </b>";
				}
			}, 1000)
		}

		$('document').ready(function() {
			var pass = $("#password");
			$('#checkbox').click(function() {
				if (pass.attr('type') === "password") {
					pass.attr('type', 'text');
				} else {
					pass.attr('type', 'password')
				}
			});

			if ($('#countdown').length) {
				start_countdown();
			}

		});
	</script>
	<script src='https://www.google.com/recaptcha/api.js?hl=id'></script>
</body>

</html>