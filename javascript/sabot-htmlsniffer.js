;
(function ($) {
	$(function () {
		
		var messageLabel = function (msgtype) {
			switch (msgtype) {
				case HTMLCS.ERROR:
					return 'Error';
				break;

				case HTMLCS.WARNING:
					return 'Warning';
				break;

				case HTMLCS.NOTICE:
					return 'Notice';
				break;

				default:
					return 'Unknown';
				break;
			}
		};

		var createResultTable = function (tableElement, messages) {
			var head = '<thead><tr><td>Type</td><td>Message</td><td>SC</td><td>Technique</td></tr></thead>';
			tableElement.append(head);

			var body = $('<tbody>');
			tableElement.append(body);

			if (messages.length > 0) {
				for (var i = 0; i < messages.length; i++) {
					var msg = messages[i];

					var msgParts = msg.code.split('.');
					var principle = msgParts[1];
					var sc = msgParts[3].split('_').slice(0, 3).join('_');
					var techniques = msgParts[4];
					techniques = techniques.split(',');

					var messageType = messageLabel(msg.type);
					
					// Build a message code without the standard name.
					msgParts.shift();
					msgParts.unshift('[Standard]');
					var noStdMsgParts = msgParts.join('.');

					var elemText = $(msg.element).text();
					if (elemText.length) {
						elemText = '<span class="sniff-element-text">' + elemText + '</span>';
					}
					
					var row = '<tr class="sniff-' + messageType.toLowerCase() +'">';
					
					row += '<td>' + messageType + '</td>';
					row += '<td>' + msg.msg + elemText + '</td>';
					row += '<td>' + sc.replace(new RegExp('_', 'g'), '.') + '</td>';

					var content = [];
					for (var j = 0; j < techniques.length; j++) {
						content.push('<a href="http://www.w3.org/TR/WCAG20-TECHS/' + techniques[j] + '" target="_blank">' + techniques[j] + '</a>');
					}


					row += '<td>' + content.join(', ') +'</td>';
					row += '</tr>';
					
					body.append(row);
				}
			} else {
				var row = '<tr><td colspan="4">OK!</td></tr>';
				body.append(row);
			}
		};

		$('div.field.htmleditor').entwine({
			onmatch: function () {
				var standard = 'WCAG2AA';
				var editor = $(this);
				var tableElement = $('<table class="sabot-htmlsniff">');

				var button = $('<button>');
				button.text('WCAG check');
				button.click(function (e) {
					tableElement.empty();
					e.preventDefault();

					if (tableElement.hasClass('active')) {
						tableElement.removeClass('active');
						return;
					}
					tableElement.addClass('active');
					
					var ed = tinymce.get(editor.find('textarea').attr('id'));
					var source = ed.getContent();

					HTMLCS.process(standard, source, function () {
						var msgs = HTMLCS.getMessages();
						createResultTable(tableElement, msgs);
						button.after(tableElement);
					});
					return false;
				});
				$(this).find('label.left').after(button);
			}
		})
	})
})(jQuery);