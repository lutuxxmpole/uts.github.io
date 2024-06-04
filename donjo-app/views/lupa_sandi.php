

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>OpenSID Desa - Siteman - Lupa Sandi</title>
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
                            <a href="http://localhost/OpenSID-2406.0.0/index.php/"><img src="https://sippn.menpan.go.id/images/article/large/logo-kab-morowali18.jpg" alt="" class="img-responsive" /></a>
                            <div class="login-footer-top">
                                <h1>Desa </h1>
                                <h3>
                                    <br /><br />Kodepos                                     <br />Kecamatan <br />Kabupaten                                 </h3>
                            </div>
                                                    </div>
                        <div class="form-bottom">
                            <form id="validasi" class="login-form" action="http://localhost/OpenSID-2406.0.0/index.php/siteman/kirim_lupa_sandi" method="post">
                                <div class="form-group">
                                    <input name="email" type="text" placeholder="Email Pengguna" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <a href="#" id="b-captcha" onclick="document.getElementById('captcha').src = 'http://localhost/OpenSID-2406.0.0/index.php/captcha'; return false" style="color: #000000;">
                                        <img id="captcha" src="http://localhost/OpenSID-2406.0.0/index.php/captcha" alt="CAPTCHA Image" />
                                    </a>
                                </div>
                                <div class="form-group captcha">
                                    <input name="captcha_code" type="text" class="form-control" maxlength="6" placeholder="Masukkan kode diatas" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn">Kirim Lupa Sandi</button>
                                </div>
                            </form>
                            <hr />
                            <div class="login-footer-bottom"><a><i>Sistem Informasi Kelurahan Mendui</i></a> 2406.0.0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $('#b-captcha').click();
</script>

</html>