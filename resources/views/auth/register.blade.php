<!doctype html>
<html lang="pt-br">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="/favicon.png" type="image/png" />
	<!--plugins-->
	<link href="/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="/assets/css/pace.min.css" rel="stylesheet" />
	<script src="/assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="/assets/css/app.css" rel="stylesheet">
	<link href="/assets/css/icons.css" rel="stylesheet">
	<title>Company - Criar conta</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<div class="authentication-header"></div>
		<div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
					<div class="col mx-auto">
						<div class="my-4 text-center">
							<img src="/assets/images/logo-img.png" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="p-4 rounded">
									<div class="text-center">
										<img src="/img/logo-full.png" width="70%" alt="Logo da Company" />
										<h3 class="my-4">Criar conta</h3>
										<p>Já tem uma conta? <a href="{{ url('login') }}">Faça login aqui</a>
										</p>
									</div>
									{{-- <div class="d-grid">
										<a class="btn my-4 shadow-sm btn-white" href="javascript:;"> <span class="d-flex justify-content-center align-items-center">
                          <img class="me-2" src="/assets/images/icons/search.svg" width="16" alt="Image Description">
                          <span>Sign Up with Google</span>
											</span>
										</a> <a href="javascript:;" class="btn btn-facebook"><i class="bx bxl-facebook"></i>Sign Up with Facebook</a>
									</div>
									<div class="login-separater text-center mb-4"> <span>OR SIGN UP WITH EMAIL</span>
										<hr/>
									</div> --}}
									<div class="form-body">
										@if ($errors->any())
											<div class="alert alert-danger">
												<ul>
													@foreach ($errors->all() as $error)
														<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif

										<form class="row g-3" action="{{ url('/register') }}" method="POST">
											@csrf
											<input type="hidden" name="affiliate_token" value="{{ $_GET['af'] ?? '' }}">
											<div class="col-sm-12">
												<label for="inputFirstName" class="form-label">Nome completo</label>
												<input type="text" class="form-control" id="inputFirstName" placeholder="Digite seu nome" name="name" required value="{{ old('name') }}" />
											</div>
											<div class="col-6">
												<label for="inputEmailAddress" class="form-label">Email</label>
												<input type="email" class="form-control" id="inputEmailAddress" placeholder="Digite seu email" name="email" required value="{{ old('email') }}" />
											</div>
											<div class="col-6">
												<label for="inputEmailAddressConfirmation" class="form-label">Confirmar email</label>
												<input type="email" class="form-control" id="inputEmailAddressConfirmation" placeholder="Digite o email novamente" name="email_confirmation" required value="{{ old('email_confirmation') }}" />
											</div>
											<div class="col-6">
												<label for="inputChoosePassword" class="form-label">Senha</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="inputChoosePassword" value="" autocomplete="false" placeholder="Digite uma senha" name="password" required /> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											<div class="col-6">
												<label for="inputChoosePasswordConfirmation" class="form-label">Confirmar senha</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="inputChoosePasswordConfirmation" value="" autocomplete="false" placeholder="Digite a senha novamente" name="password_confirmation" required /> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											<div class="col-12">
												<label for="inputDocument" class="form-label">CPF</label>
												<input type="text" inputmode="number" class="form-control cpf" id="inputDocument" placeholder="Digite seu CPF" name="document" required value="{{ old('document') }}" />
											</div>
											<div class="col-12">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" required />
													<label class="form-check-label" for="flexSwitchCheckChecked">Concordo com todos os <span class="txt-primary">Termos</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary"><i class='bx bx-user'></i>Cadastrar</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="/assets/js/app.js"></script>
	<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
	<script src="{{ asset('js/masks.js') }}"></script>
</body>

</html>
