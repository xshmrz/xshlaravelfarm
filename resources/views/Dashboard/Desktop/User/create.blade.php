@extends("Dashboard.Desktop.layout")
@section("section-main")
	<div class="bg-body-light border-bottom">
		<div class="content py-1 text-center">
			<nav class="breadcrumb bg-body-light py-2 mb-0">
				<span class="breadcrumb-item">{{ trans("app.Yönetim : Sistem") }}</span>
				<span class="breadcrumb-item active">{{ trans("app.Kullanıcı Ekle") }}</span>
			</nav>
		</div>
	</div>
	<div class="content content-full">
		<div class="block block-rounded block-bordered">
			<div class="block-header block-header-default">
				<h3 class="block-title">{{ trans("app.Kullanıcı Ekle") }}</h3>
				<div class="block-options">
				</div>
			</div>
			<div class="block-content block-content-full p-3 border-top">
				{{ form_builder()::open()->class(UserFrmCreate) }}
				<div class="row g-2">
					{{ form_builder()::input(first_name)->placeholder(trans("app.Ad"))->groupClass("col-md-6") }}
					{{ form_builder()::input(last_name)->placeholder(trans("app.Soyad"))->groupClass("col-md-6") }}
					{{ form_builder()::input(email)->placeholder(trans("app.E-Mail"))->groupClass("col-md-6") }}
					{{ form_builder()::input(gsm)->placeholder(trans("app.Telefon Numarası"))->groupClass("col-md-6") }}
					{{ form_builder()::input(address)->placeholder(trans("app.Adres"))->groupClass("col-md-12") }}
					{{ form_builder()::input(state)->placeholder(trans("app.İl"))->groupClass("col-md-6") }}
					{{ form_builder()::input(city)->placeholder(trans("app.İlçe"))->groupClass("col-md-6") }}
				</div>
				{{ form_builder()::close() }}
			</div>
			<div class="block-content block-content-full p-3 border-top bg-body-light">
				<button type="button" class="btn btn-sm btn-primary {{ UserBtnCreate }}" style="min-width:75px;"
				        data-form="{{ UserFrmCreate }}"
				        data-api="Create"
				        data-redirect="{{ route("dashboard.user.index") }}"
				        data-beforedata="beforeUserCreate">{{ trans("app.Kaydet") }}
				</button>
			</div>
		</div>
	</div>
@endsection
