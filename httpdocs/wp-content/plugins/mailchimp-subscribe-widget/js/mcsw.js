
(function () {
  if (typeof $ === 'undefined') {
    $ = jQuery;
  }

  $(document).ready(function () {
    $('.mcsw_form').on('submit', function (evt) {
      evt.preventDefault();
      var form = evt.target,
              data = {
                email: form.email.value,
                nonce: form._wpnonce.value,
                widget_id: form.widget_id.value
              };
      $('#' + form.id + ' .loader').toggleClass('hidden');
      $('#' + form.id + ' .submit').toggleClass('hidden');
      $('#' + form.id + ' .message').addClass('hidden').html('');

      $.post('/wp-admin/admin-ajax.php?action=mcsw_subscribe', data, function (data) {

        $('#' + form.id + ' .message')
                .html(data.message)
                .removeClass('hidden success error')
                .addClass(data.success ? 'success' : 'error');

        $('#' + form.id + ' .loader').toggleClass('hidden');
        $('#' + form.id + ' .submit').toggleClass('hidden');
      });
    });
  });

})();