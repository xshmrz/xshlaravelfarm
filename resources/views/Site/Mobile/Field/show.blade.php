<?php
    $field = Field()->find($id);
    # ->
    $appHeaderTitle      = $field->name;
    $appHeaderBackButton = false;
?>
@extends("Site.Mobile.layout")
{{-- appMenuHeader --}}
@section("section-main-appMenuHeader")
	@include("Site.Mobile.Component.appMenuHeader")
@endsection
{{-- Main --}}
@section("section-main")
	<div id="appCapsule">
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
		<a href="javascript:void(0)" class="item"><div class="col"><i class="fe fe-check-circle fs-4"></i><strong>{{ trans("app.Takvim") }}</strong></div></a>
		<a href="javascript:void(0)" class="item {{ FieldBtnMdlCreate }}"><div class="col"><div class="action-button large"><i class="fe fe-plus fs-4 text-white"></i></div></div></a>
		<a href="javascript:void(0)" class="item"><div class="col"><i class="fe fe-settings fs-4"></i><strong>{{ trans("app.Ayarlar") }}</strong></div></a>
	</div>
@endsection

