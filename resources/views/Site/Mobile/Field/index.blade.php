@extends("Site.Mobile.layout")
{{-- Variables --}}
<?php
    $appHeader = trans("app.Tarlalar")
?>
{{-- appMenuHeader --}}
@section("section-main-appMenuHeader")
	@include("Site.Mobile.Component.appMenuHeader")
@endsection
{{-- Main --}}
@section("section-main")
	<div id="appCapsule">
	</div>
@endsection
{{-- appMenuBottom --}}
@section("section-main-appMenuBottom")
	@include("Site.Mobile.Component.appMenuBottom")
@endsection
