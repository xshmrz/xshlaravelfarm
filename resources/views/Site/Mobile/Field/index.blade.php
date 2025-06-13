<?php
    $appHeaderTitle      = trans("app.Tarlalar");
    $appHeaderBackButton = false;
    # ->
    $fieldDt = Field()->where([user_id => auth_model()->id])->get();
?>
@extends("Site.Mobile.layout")
{{-- appMenuHeader --}}
@section("section-main-appMenuHeader")
	@include("Site.Mobile.Component.appMenuHeader")
@endsection
{{-- Main --}}
@section("section-main")
	<div id="appCapsule">
		<ul class="listview link-listview inset mt-2">
			@foreach($fieldDt as $field)
				<li>
					<a href="{{ route("site.field.show", $field->id) }}">
						<div>
							<div>{{ $field->name }}</div>
							<div class="text-muted">{{ $field->location->parent_name }} / {{ $field->location->name }}</div>
						</div>
					</a>
				</li>
			@endforeach
		</ul>
		<!-- Form Action Sheet -->
		<div class="modal fade action-sheet" id="{{ FieldMdlCreate }}" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{ trans("app.Tarla Ekle") }}</h5>
					</div>
					<div class="modal-body">
						<div class="action-sheet-content">
							<form>
								{{ pwa_input(trans("app.Tarla Adı"),html()->input("text",name)->class("form-control")) }}
								{{ pwa_input(trans("app.İl"),html()->select("state",Location()->findState()->pluck(name,id))->placeholder(trans("app.Şehir Seç"))->class("form-control custom-select")) }}
								{{ pwa_input(trans("app.İlçe"),html()->input("text","city")->class("form-control")) }}
								<div class="form-group basic">
									<button type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">{{ trans("app.Kaydet") }}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Form Action Sheet -->
	</div>
@endsection
{{-- appMenuBottom --}}
@section("section-main-appMenuBottom")
	<div class="appBottomMenu">
		<a href="javascript:void(0)" class="item" data-bs-toggle="modal" data-bs-target="#{{ FieldMdlCreate }}"><div class="col"><div class="action-button large"><i class="fe fe-plus fs-4 text-white"></i></div></div></a>
	</div>
@endsection
