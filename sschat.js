var nickname = '';
$(document).ready(function(){
	$("#sschat_lines ul").ajaxError(function() {
  	$(this).html('<li>Sorry there was an error! Please reload the page and re-enter the chatroom.');
	});
 
	$('#sschat_input').focus();
	$('#sschat_input').keyup(function(e) {
		if (e.keyCode == 13) {
			if (nickname == '') {
				if ($('#sschat_input').val() != '') {
					listener();
					nickname = $('#sschat_input').val();
					nickname = nickname.replace(/[^-a-z0-9]/ig,'');
					$('#sschat_input').attr('disabled', 'disabled');
					$.post(sschat_serverurl+'sschat.php', {action: 'join', nickname: nickname, channel: sschat_channel}, function(data){
						$('#sschat_input').val('');
						$('#sschat_input').attr('disabled', '');
						$('#sschat_hint').html('Type a line of chat and press enter to speak:');
					});
				}
			} else {
				var sendline = $('#sschat_input').val();
				if (sendline != '') {
					$('#sschat_input').attr('disabled', 'disabled');
					$('#sschat_input').val('sending...');
					serverSend('<span class="nick">'+nickname+':</span> '+sendline);
				}
			}
		}
	});
	
	$(window).bind("beforeunload", function(){
		if (nickname != '') {
			$.post(sschat_serverurl+'sschat.php', {action: 'part', nickname: nickname, channel: sschat_channel});
		}
	});
});

function serverSend(sendtext) {
	$.post(sschat_serverurl+'sschat.php', {action: 'send', text: sendtext, channel: sschat_channel}, function(data){
		$('#sschat_input').val('');
		$('#sschat_input').attr('disabled', '');
	});
}

function listener() {
	$.post(sschat_serverurl+'sschat.php', {action: 'listen', channel: sschat_channel}, function(data){
		$('#sschat_lines ul').append(linkify(data));
		$('#sschat_lines').scrollTop($('#sschat_lines')[0].scrollHeight);
		listener();
	});
}

function linkify(text){
    if (text) {
        text = text.replace(
            /((https?\:\/\/)|(www\.))(\S+)(\w{2,4})(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/gi,
            function(url){
                var full_url = url;
                if (!full_url.match('^https?:\/\/')) {
                    full_url = 'http://' + full_url;
                }
                return '<a href="' + full_url + '" target="_blank">' + url + '</a>';
            }
        );
    }
    return text;
}

