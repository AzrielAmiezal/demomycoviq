$(document).ready(function () {
  countryfun();
})


function countryfun() {
  $.ajax({

    url: 'country.php',
    method: 'GET',
    //dataType: "JSON",
    success: function (data) {
      $('#country_tbl').html(data);
    }
  })
}