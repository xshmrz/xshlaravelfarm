<?php
    $appHeaderTitle      = config("app.name");
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
		<div class="section header-card-section pt-1">
			<div class="header-card">
				<div class="header-card-top">
					<div class="left">
						<div class="text-dark fw-bold">{{ auth_model()->full_name }}</div>
						<div class="fw-bold">{{ auth_model()->location->parent_name }} / {{ auth_model()->location->name }}</div>
					</div>
					<div class="right"></div>
				</div>
			</div>
		</div>
	</div>
@endsection
{{-- appMenuBottom --}}
@section("section-main-appMenuBottom")
	@include("Site.Mobile.Component.appMenuBottom")
@endsection
