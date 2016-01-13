var Message = (function() {
	var status = 'alert-danger';
	var selectors = {
		banner: '#session-message',
		close: '#session-message-close',
		message: '#session-message-message'
	};
	var $$ = {};

	function init() {
		$$ = Utility.setupWrappers(selectors);
		attachHandlers();
	}

	function display(status, message) {
		setStatus(status);
		setMessage(message);
		show();
	}

	function show() {
		$$.banner.slideDown();
	}

	function hide() {
		$$.banner.slideUp(function() {
			$$.banner.removeClass(status);
		});
	}

	function setMessage(message) {
		$$.message.text(message);
	}

	function setStatus(newStatus) {
		$$.banner.removeClass(status).addClass(newStatus);
		status = newStatus;
	}

	function attachHandlers() {
		$$.close.click(function() {
			hide();
		});
	}

	return {
		init: init,
		display: display,
		show: show,
		hide: hide,
		setMessage: setMessage,
		setStatus: setStatus
	};
})();