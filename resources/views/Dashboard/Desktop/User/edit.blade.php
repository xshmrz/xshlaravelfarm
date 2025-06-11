<?php
    $user = User()->find($id);
?>
@extends("Dashboard.Desktop.layout")
@section("section-main")
	<div class="bg-body-light border-bottom">
		<div class="content py-1 text-center">
			<nav class="breadcrumb bg-body-light py-2 mb-0">
				<span class="breadcrumb-item">{{ trans("app.Yönetim : Sistem") }}</span>
				<span class="breadcrumb-item">{{ trans("app.Kullanıcı Güncelle") }}</span>
				<span class="breadcrumb-item active text-primary">{{ $user->full_name }}</span>
			</nav>
		</div>
	</div>
	<div class="content content-full">
		{{ form_builder()::open()->class(UserFrmUpdate)->bind($user)->multipart() }}
		<div class="block block-rounded block-bordered">
			<div class="block-header block-header-default">
				<h3 class="block-title">{{ trans("app.Kullanıcı Güncelle") }}</h3>
				<div class="block-options">
				</div>
			</div>
			<div class="block-content block-content-full p-3 border-top">
				<div class="row g-2">
					{{ form_builder()::input(first_name)->placeholder(trans("app.Ad"))->groupClass("col-md-6") }}
					{{ form_builder()::input(last_name)->placeholder(trans("app.Soyad"))->groupClass("col-md-6") }}
					{{ form_builder()::input(email)->placeholder(trans("app.E-Mail"))->groupClass("col-md-6") }}
					{{ form_builder()::input(gsm)->placeholder(trans("app.Telefon Numarası"))->groupClass("col-md-6") }}
					{{ form_builder()::input(address)->placeholder(trans("app.Adres"))->groupClass("col-md-12") }}
					{{ form_builder()::input(state)->placeholder(trans("app.İl"))->groupClass("col-md-6") }}
					{{ form_builder()::input(city)->placeholder(trans("app.İlçe"))->groupClass("col-md-6") }}
					<div class="col-md-12">
						<input class="form-control" type="file" name="{{ EnumUpload::Profile }}">
					</div>
				</div>
			</div>
			<div class="block-content block-content-full p-3 border-top bg-body-light">
				<button type="button" class="btn btn-sm btn-primary {{ UserBtnUpdate }}" style="min-width:75px;"
				        data-id="{{ $id }}"
				        data-form="{{ UserFrmUpdate }}"
				        data-api="Update"
				        data-redirect="{{ route("dashboard.user.edit",$id) }}">{{ trans("app.Güncelle") }}
				</button>
				<button type="button" class="btn btn-sm btn-danger {{ UserBtnDelete }}" style="min-width:75px;"
				        data-id="{{ $id }}"
				        data-api="Delete"
				        data-redirect="{{ route("dashboard.user.index") }}">{{ trans("app.Sil") }}
				</button>
			</div>
		</div>
		{{ form_builder()::close() }}
	</div>
@endsection
