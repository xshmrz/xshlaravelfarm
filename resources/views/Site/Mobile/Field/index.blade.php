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
		<div class="modal fade action-sheet {{ FieldMdlCreate }}" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{ trans("app.Tarla Ekle") }}</h5>
					</div>
					<div class="modal-body">
						<div class="action-sheet-content">
							<form class="{{ FieldFrmCreate }}">
								{{ html()->input("hidden","user_id",auth_model()->id) }}
								{{ pwa_input(trans("app.Tarla Adı"),html()->input("text","name")->class("form-control")) }}
								{{ pwa_input(trans("app.İl"),html()->select("location_parent_id",Location()->findState()->pluck("name","id"))->placeholder(trans("app.Şehir Seç"))->data("location-select","state")->class("form-control custom-select")) }}
								{{ pwa_input(trans("app.İl"),html()->select("location_id",[])->placeholder(trans("app.İlçe Seç"))->data("location-select","city")->class("form-control custom-select")) }}
								<div class="form-group basic">
									<button type="button" class="btn btn-primary btn-block btn-lg {{ FieldBtnCreate }}">{{ trans("app.Kaydet") }}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Form Action Sheet -->
	</div>
	<script>
        $(function () {
            Field.BtnMdlCreate.click(function () {
                xsh.showModal(Field.MdlCreate);
            });
            Field.BtnCreate.click(function () {
                Field.Create({
                                 data: xsh.getFormData(Field.FrmCreate),
                                 ok  : function (response) {
                                     xsh.showNotification({
                                                              message : response.message,
                                                              callback: () => { xsh.refreshPage(); }
                                                          });
                                 }
                             });
            });
            $('[data-location-select="state"]').on('change', function () {
                const location_parent_id = $(this).val();
                const location_id        = $(this).closest('form').find('[data-location-select="city"]');
                location_id.find('option:not(:first)').remove();
                if (location_parent_id) {
                    Location.GetAll({
                                        q : {
                                            'where[parent_id]': location_parent_id,
                                            'orderBy[name]'   : 'asc'
                                        },
                                        ok: function (response) {
                                            response.data.forEach(function (item) {
                                                location_id.append(
                                                    $('<option>').val(item.id).text(item.name)
                                                );
                                            });
                                        }
                                    });
                }
            });
        });
	</script>
@endsection
{{-- appMenuBottom --}}
@section("section-main-appMenuBottom")
	<div class="appBottomMenu">
		<a href="javascript:void(0)" class="item {{ FieldBtnMdlCreate }}"><div class="col"><div class="action-button large"><i class="fe fe-plus fs-4 text-white"></i></div></div></a>
	</div>
@endsection

