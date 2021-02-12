/**
 * Created by vasia on 12/09/14.
 */
$(function(){
	var $send_date = $('input[name="send_date"]');
	console.log($send_date.get(0));
	$send_date.datepicker({ dateFormat: "dd.mm.yy" });
});