<?php
    $field = Field()->find($id);
?>
@extends("Site.Mobile.layout")
@section("section-main")

	<div id="appCapsule">
		<div class="section header-card-section pt-1">
			<div class="header-card">
				<div class="header-card-top">
					<div class="left">
						<div class="text-dark fw-bold">{{ $field->name }}</div>
						<div class="fw-bold">{{ $field->location->parent_name }} / {{ $field->location->name }}</div>
					</div>
					<div class="right"></div>
				</div>
			</div>
		</div>
		<div class="section inset mt-2">
			<button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#actionSheetForm">{{ trans("app.Aktif Sezon Belirle") }}</button>
		</div>
	</div>
	<!-- Form Action Sheet -->
	<div class="modal fade action-sheet" id="actionSheetForm" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Deposit Money</h5>
				</div>
				<div class="modal-body">
					<div class="action-sheet-content">
						<form>

							<div class="form-group basic">
								<label class="label">Enter Amount</label>
								<div class="input-group">
									<span class="input-group-text" id="basic-addon1">$</span>
									<input type="date" class="form-control" placeholder="Enter an amount"
									       value="100">
								</div>
								<div class="input-info">Minimum $50</div>
							</div>
							<div class="form-group basic">
								<button type="button" class="btn btn-primary btn-block btn-lg"
								        data-bs-dismiss="modal">Deposit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- * Form Action Sheet -->
@endsection
