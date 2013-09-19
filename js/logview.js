var polling_timeout_id;

location.param = function(name) {
    return decodeURI((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
};

$(document).ready(function() {
  $('#logfile-menu li a').click(function(event) {
    var type = $(this).attr('href').substr(1);

    // Set new state
    $('.log-output').removeClass('active-logfile').hide();
    $('#logfile-menu li.active').removeClass('active');

    $(this).parent().addClass('active');
    $('#' + type).addClass('active-logfile').show();

    // And start fetching lines
    fetch_new_lines();
  });

  var new_lines = function(type, last_size) {
    $.getJSON('customer_domains.php', {
        'page': 'log',
        'action': 'newlines',
        'type': type,
        'last_size': last_size,
        's': location.param('s') || ""
    }, function(data) {
      append_lines(type, data.lines);
      $('#' + type).data('last_size', data.size);
    });
  };

  var append_lines = function(type, lines) {
    $.each(lines, function(i, line) {
      $('#' + type).append($('<p>' + line + '</p>'));
    });
    $('#' + type)[0].scrollTop = $('#' + type)[0].scrollHeight;
  };

  var fetch_new_lines = function() {
    var type = $('.active-logfile').attr('id');
    var last_size = $('.active-logfile').data('last_size') || 0;

    new_lines(type, last_size);
    start_or_resume_polling(type);
  };

  var start_or_resume_polling = function(type) {
    stop_polling();
    polling_timeout_id = window.setTimeout(fetch_new_lines, 4000);
  };

  var stop_polling = function() {
    if (polling_timeout_id !== undefined) {
      window.clearTimeout(polling_timeout_id);
      polling_timeout_id = undefined;
    }
  };

  // Start up the thing!
  $('div#error').hide();
  fetch_new_lines();
});
