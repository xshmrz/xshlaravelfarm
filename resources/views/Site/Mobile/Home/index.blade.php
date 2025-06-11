@extends("Site.Mobile.layout")
@section("section-main")
	<div class="appHeader bg-primary text-light">
		<div class="left">
            <a href="javascript:void(0)" class="headerButton goBack">
               <i class="fe fe-chevron-left fs-4"></i>
            </a>
		</div>
		<div class="pageTitle">
			<span>{{ config("app.name") }}</span>
		</div>
		<div class="right">
			 <a href="javascript:void(0)" class="headerButton">
               <i class="fe fe-user fs-4"></i>
            </a>
		</div>
	</div>
	<div id="appCapsule">
		<div class="section header-card-section pt-1">
			<div class="header-card">
				<div class="header-card-top">
					<div class="left">
						<div class="text-dark fw-bold">{{ auth_model()->full_name }}</div>
						<div class="fw-bold">{{ auth_model()->location->parent_name }} / {{ auth_model()->location->name }}</div>
					</div>
					<div class="right">

					</div>
				</div>

			</div>
		</div>
		<ul class="listview link-listview inset mt-2">
            <li>
                <a href="#">
                    John Fonseca
                </a>
            </li>
			<li>
                <a href="#">
                    Sophie Silverton
                    <span class="text-muted">Text</span>
                </a>
            </li>
			<li>
                <a href="#">
                    Frank Sjögren
                    <span class="badge badge-primary">3</span>
                </a>
            </li>
		</ul>
	</div>
@endsection
