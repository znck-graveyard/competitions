/**
 * Created by ANJAN on 6/26/2015.
 */

$(document).ready(function(){
    $('#contest_create').click(function(){
        window.location.href = '/contest/create';
    });
});
/*
$(document).ready(function () {
    $(".datepicker").datepicker({
        format: 'dd/mm/yyyy'
    });
});
*/

$(function(){
    $('.time').timepicker({'timeFormat': 'H:i:s','step': 10});
});
$(document).ready(function() {
    $("#datepicker").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());

});