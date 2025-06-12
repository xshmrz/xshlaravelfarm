@extends("Site.Mobile.layout")
@section("section-main")

	<div id="appCapsule">
		<div class="listview-title mt-1">Notifications</div>
		<ul class="listview image-listview text inset">
			<li>
                <a href="javascript:void(0)" class="item">
                    <div class="in">
                        <div>{{ trans("app.Hesap Ayarları") }}</div>
                    </div>
                </a>
            </li>
			<li>
                <a href="javascript:void(0)" class="item">
                    <div class="in">
                        <div>{{ trans("app.Faturalarım") }}</div>
                    </div>
                </a>
            </li>
		</ul>
		<div class="listview-title mt-1">Notifications</div>
		<ul class="listview image-listview text inset">
			<li><a href="{{ route("site.profile.field") }}" class="item"><div class="in"><div>{{ trans("app.Tarlalar") }}</div></div></a></li>
			<li><a href="{{ route("site.profile.season") }}" class="item"><div class="in"><div>{{ trans("app.Sezonlar") }}</div></div></a></li>
			<li><a href="javascript:void(0)" class="item"><div class="in"><div>{{ trans("app.Müşteri/Tedarikçiler") }}</div></div></a></li>
			<li><a href="javascript:void(0)" class="item"><div class="in"><div>{{ trans("app.Personel") }}</div></div></a></li>
			<li><a href="javascript:void(0)" class="item"><div class="in"><div>{{ trans("app.Etiketler") }}</div></div></a></li>
		</ul>
	</div>

@endsection
