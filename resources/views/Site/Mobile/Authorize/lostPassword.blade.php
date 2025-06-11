@extends("Site.Mobile.layout-authorize")
@section("section-main")
	<div class="section mt-0 text-center">
		<img src="{{ placeholder(200,200) }}" alt="image" class="imaged w76 rounded mb-4">
		<h1>{{ config("app.name") }}</h1>
		<h4>{{ trans("app.Şifre Sıfırlama Formu") }}</h4>
	</div>
	<div class="section mb-5 p-2">
		{{ html()->form()->class(FrmLostPassword)->open() }}
		<div class="card">
			<div class="card-body pb-1">
				{{ pwa_input(trans("app.E-Posta Adresi"),html()->input("text",email)->class("form-control")) }}
			</div>
		</div>
		<div class="mt-2 text-center">
			<div><a href="{{ route("site.register") }}">{{ trans("app.Kayıt Ol") }}</a></div>
			<div><a href="{{ route("site.login") }}" class="text-muted">{{ trans("app.Giriş Yap") }}</a></div>
		</div>
		<div class="form-button-group transparent">
			<button type="button" class="btn btn-primary btn-block btn-lg">{{ trans("app.Şifremi Sıfırla") }}</button>
		</div>
		{{ html()->form()->close() }}
	</div>
@endsection
