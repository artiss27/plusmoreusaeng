
// set choosen select
$('select[name="member_id"]').chosen();

if (window.location.href.indexOf('/admin/myvault/') !== -1) {
  $('#myModal').on('shown.bs.modal', function () {
    $('select[name="memberid"]').chosen();
  });
}
