/**
 * Created by ANJAN on 6/26/2015.
 */

$(document).ready(function(){
    $('#contest_create').click(function(){
        window.location.href = '/contest/create';
    });
});

$(document).ready(function () {
    $(".datepicker").datepicker({
        format: 'dd/mm/yyyy'
    });
});
