<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";
if ($_REQUEST['appointdate'] != '' && $_REQUEST['appointslottype'] != '' && $_REQUEST['zipcodeid'] != '') {
	$slot_array = $slot->slot_display($db->tbl_pre . "slot_tbl", array(), "WHERE slot_type='" . $_REQUEST['appointslottype'] . "'");
	echo '<select name="appointment_slot_id" id="appointment_slot_id" class="form-control select2" data-validation-engine="validate[required]">';
	for ($sa = 0; $sa < count($slot_array); $sa++) {
		$appointment_array = $appointment->appointment_display($db->tbl_pre . "appointment_tbl", array(), "WHERE appointment_date='" . $_REQUEST['appointdate'] . "' and appointment_slot_id='" . $slot_array[$sa]['slot_id'] . "' and zip_code_id='" . $_REQUEST['zipcodeid'] . "'");
		if (count($appointment_array) == 0) {
			echo '<option value="' . $slot_array[$sa]['slot_id'] . '">' . $slot_array[$sa]['slot_start_hour'] . '.' . $slot_array[$sa]['slot_start_minute'] . ' - ' . $slot_array[$sa]['slot_end_hour'] . '.' . $slot_array[$sa]['slot_end_minute'] . '</option>';
		}
	}
	echo '</select>';
}
if ($_REQUEST['customer_address_type'] != '') {
	$pricing_array = $pricing->pricing_display($db->tbl_pre . "pricing_tbl", array(), "WHERE pricing_type='" . $_REQUEST['customer_address_type'] . "'");
	echo '<select name="pricing_id" id="pricing_id" class="form-control select2" data-validation-engine="validate[required]">';
	for ($pa = 0; $pa < count($pricing_array); $pa++) {
		if ($pricing_array[$pa]['pricing_square_footage'] != 0) {
			$prisqufot = 'Square Footage up to ' . $pricing_array[$pa]['pricing_square_footage'] . ' - ';
		} else {
			$prisqufot = '';
		}
		echo '<option value="' . $pricing_array[$pa]['pricing_id'] . '">' . $pricing_array[$pa]['pricing_unit'] . ' (' . $prisqufot . '$' . $pricing_array[$pa]['pricing_amount'] . ')</option>';
	}
	echo '</select>';
}
?>