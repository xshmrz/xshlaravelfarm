<?php
    use Illuminate\Support\Facades\Route;
    Route::get('listing/find/{listingCategoryId}/{stateId}/{cityId}', [\App\Http\Controllers\Site\Custom::class, 'findListing'])->name('site.custom.find.listing');
    Route::get('appointment/find/{listingId}/{employeeId}/{day}', [\App\Http\Controllers\Site\Custom::class, 'findAppointmentAjax'])->name('site.custom.find.appointment.ajax');
    # ->
    Route::get("/demo", function () {

        Schema::table("location", function ($table) {
            $table->string("parent_id")->change();
        });

    });
