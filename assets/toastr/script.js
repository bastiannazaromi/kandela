var sukses = $('.notif-sukses').data('flashdata');
var error = $('.notif-error').data('flashdata');

if (sukses) {
    toastr.success(sukses);
}

if (error) {
    toastr.error(error);
}