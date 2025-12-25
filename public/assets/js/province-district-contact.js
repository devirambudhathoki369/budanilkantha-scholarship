$('#cprovince_id').change(function () {
  let province_id = $(this).val();

  if (province_id != '' && !isNaN(province_id)) {
    $.ajax({
      method: 'POST',
      url: baseURL + 'get-district',
      data: {
        province_id,
        _token: csrf,
      },
      success: function (res) {
        if (res.length > 0) {
          options = set_optons(res);
        } else {
          options =
            "<option value='' disabled selected>Details not found</option>";
        }
        $("#cdistrict_id").html(options);
      },
    })
  }
})

$('#cdistrict_id').change(function () {
  let district_id = $(this).val();

  if (district_id != '' && !isNaN(district_id)) {
    $.ajax({
      method: 'POST',
      url: baseURL + 'get-district-local-level',
      data: {
        district_id,
        _token: csrf,
      },
      success: function (res) {
        if (res.length > 0) {
          options = set_optons(res);
        } else {
          options =
            "<option value='' disabled selected>Details not found</option>";
        }
        $("#clocallevel_id").html(options);
      },
    })
  }
})


$('#clocallevel_id').change(function () {
  let locallevel_id = $(this).val();

  if (locallevel_id != '' && !isNaN(locallevel_id)) {
    $.ajax({
      method: 'POST',
      url: baseURL + 'get-local-level-ward',
      data: {
        locallevel_id,
        _token: csrf,
      },
      success: function (res) {
        if (res) {
          options = set_ward_option(res.number_of_wards);
        } else {
          options = "<option value='' disabled selected>Details not found</option>";
        }
        $("#cward").html(options);
      },
    })
  }
})

function set_ward_option(numberOfWards) {
  let options = "";
  for (let i = 1; i <= numberOfWards; i++) {
    options += `<option value="${i}">वडा नं. ${i}</option>`;
  }
  return options;
}
