// flatpickr(".date-min-max", { minDate: "today", defaultDate: new Date(), maxDate: new Date().fp_incr(14) });
flatpickr(".date-min-max", { minDate: "2000-01-01", defaultDate: new Date(), maxDate: "today" }),
  flatpickr(".datepicker", {});

$(document).ready(function () {
  $(".datatable").DataTable();
  $('.select2').select2({
    width: "100%",
    placeholder: "Choose Option"
  });
  if ($('.nepcal').length) {
    $('.nepcal').nepaliDatePicker({
      dateFormat: "YYYY-MM-DD",
      ndpYear: true,
      ndpMonth: true,
      onChange: function (e) {
        if ($('#dob_in_ad').length) {
          $('#dob_in_ad').val(e.ad)
        }
        if ($('#dob_ad').length) {
          $('#dob_ad').val(e.ad)
        }
      }
    });

    // showing nlev verification form

  }

  $('#sales_to_div').hide();
  $('#collector_type_div').hide();

  $('#category').change(function(){
    var category = $('#category').val();
    
    if (category == '1') {
      $('#sales_to_div').show();
      $('#collector_type_div').hide();
      $('#sales_to_div').attr('required','');
    } else if(category == '2'){
      $('#sales_to_div').hide();
      $('#collector_type_div').show();
      
    } else if(category == '2' || category == '3'){
      $('#sales_to_div').show();
      $('#collector_type_div').show();
      
    }
  });

})

jQuery(function ($) {
  $.mask.definitions['~'] = '[+-]';
  $('.date').mask('9999-99-99');
  $('.dayMask').mask('99');
  $('.time').mask('99:99 aa');
  $('.fy-mask').mask('9999-99');
  $('.mobile').mask('9999999999');
});

function set_optons(responses) {
  let option = `<option value='' disabled selected>Select Details</option>`;
  responses = $.makeArray(responses);

  $.map(responses, function (response, i) {
    option += `<option value="${response.id}">${response.show_name}</option>`;
  });

  return option;
}

$(document).on('select2:open', () => {
  document.querySelector('.select2-search__field').focus();
});






