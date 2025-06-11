@extends("Dashboard.Desktop.layout")
@section("section-main")
	<div class="bg-body-light border-bottom">
		<div class="content py-1 text-center">
			<nav class="breadcrumb bg-body-light py-2 mb-0">
				<span class="breadcrumb-item">{{ trans("app.Yönetim : Sistem") }}</span>
				<span class="breadcrumb-item active">{{ trans("app.Anasayfa") }}</span>
			</nav>
		</div>
	</div>
	<div class="content content-full">
		<div class="block block-rounded block-bordered">
			<div class="block-header block-header-default">
				<h3 class="block-title">{{ trans("app.Harita") }}</h3>
				<div class="block-options">

				</div>
			</div>
			<div class="block-content block-content-full p-0 border-top overflow-x-auto">
				<div id="map" style="height: 500px;"></div>
			</div>
		</div>
	</div>
@endsection
