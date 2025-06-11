<?php
    namespace App\Http\Controllers\Site;
    use App\Http\Controllers\Controller;
    class Custom extends Controller {
        public function findListing($listingCategoryId, $stateId, $cityId) {
            $this->data["listingCategoryId"] = $listingCategoryId;
            $this->data["stateId"]           = $stateId;
            $this->data["cityId"]            = $cityId;
            render_view($this->data);
        }
        public function findAppointmentAjax($listingId, $employeeId, $day) {
            $listing     = Listing()->find($listingId);
            $appointment = Appointment()->where(["listing_id" => $listingId, "employee_id" => $employeeId, "day" => $day]);
            # ->
            [$start, $end] = explode('-', $listing->working_hour);
            $period = $listing->working_period;
            # ->
            $data  = $appointment->pluck("hour")->toArray();
            $today = now()->format("d-m-Y") === $day;
            # ->
            foreach (date_get_hours_interval($start, $end, $period, $today) as $value) {
                if ($value["disabled"] && !in_array($value["hour"], $data)) {
                    $data[] = $value["hour"];
                }
            }
            # ->
            return responseOk([
                "message" => trans("app.İşlem Başarılı"),
                "data"    => $data,
            ]);
        }
    }
