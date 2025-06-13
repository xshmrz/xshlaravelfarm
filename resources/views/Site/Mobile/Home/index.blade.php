@extends("Site.Mobile.layout")
{{-- Variables --}}
<?php ?>
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
		<ul class="listview link-listview inset mt-2">
			@foreach(Field()->where([user_id => auth_model()->id])->get() as $field)
				<li>
	                <a href="{{ route("site.field.show",$field->id) }}">
	                    <div>
		                    <div>{{ $field->name }}</div>
		                    <div class="text-muted">{{ $field->location->parent_name }} / {{ $field->location->name }}</div>
	                    </div>
		                <div></div>
	                </a>
	            </li>
			@endforeach
		</ul>
	</div>
@endsection
{{-- appMenuBottom --}}
@section("section-main-appMenuBottom")
	@include("Site.Mobile.Component.appMenuBottom")
@endsection
