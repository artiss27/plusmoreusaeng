
// set choosen select
$('select[name="member_id"]').chosen();

if (window.location.href.indexOf('/admin/myvault/') !== -1) {
  $('#myModal').on('shown.bs.modal', function () {
    $('select[name="memberid"]').chosen();
  });
}

// Dashboard
$('#date-renge').on('change', '.date-range', function () {
  // var url = window.location.href.split('?')[0];
  // var start = $('#date-renge .date-range[name=start]').val();
  // var end = $('#date-renge .date-range[name=end]').val();
  // var param = '?' + 'start=' + (start || '') + '&end=' + (end || '');
  // window.location.replace(url + param);
  $('#date-renge').submit();
});

