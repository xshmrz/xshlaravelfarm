@extends("Site.Mobile.layout-authorize")
@section("section-main")
	<div class="section mt-0 text-center">
		<img src="{{ placeholder(200,200) }}" alt="image" class="imaged w76 rounded mb-4">
		<h1>{{ config("app.name") }}</h1>
		<h4>{{ trans("app.Kayıt Formu") }}</h4>
	</div>
	<div class="section mb-5 p-2">
		{{ html()->form()->class(FrmRegister)->open() }}
		<div class="card">
			<div class="card-body pb-1">
				{{ pwa_input(trans("app.Ad"),html()->input("text",first_name)->class("form-control")) }}
				{{ pwa_input(trans("app.Soyad"),html()->input("text",last_name)->class("form-control")) }}
				{{ pwa_input(trans("app.E-Posta Adresi"),html()->input("text",email)->class("form-control")) }}
				{{ pwa_input(trans("app.Gsm No"),html()->input("text",gsm)->class("form-control")) }}
			</div>
		</div>
		<div class="mt-2 text-center">
			<div><a href="{{ route("site.login") }}">{{ trans("app.Giriş Yap") }}</a></div>
			<div><a href="{{ route("site.lostPassword") }}" class="text-muted">{{ trans("app.Şifremi Unuttum") }}</a></div>
		</div>
		<div class="form-button-group transparent">
			<button type="button" class="btn btn-primary btn-block btn-lg">{{ trans("app.Kayıt Ol") }}</button>
		</div>
		{{ html()->form()->close() }}
	</div>
@endsection
