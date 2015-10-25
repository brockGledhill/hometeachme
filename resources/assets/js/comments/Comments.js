var Comments = (function() {
	var selectors = {
		container: '#viewCommentContainer',
		month: '#viewCommentMonth',
		year: '#viewCommentYear'
	};
	var $$ = {};

	/**
	 * Init
	 */
	function init() {
		$$ = Utility.setupWrappers(selectors);
		attachHandlers();
	}

	function attachHandlers() {
		$$.month.change(function() {
			updateViewComments();
		});
		$$.year.change(function() {
			updateViewComments();
		});
	}

	function updateViewComments() {
		var params = {
			month: $$.month.val(),
			year: $$.year.val()
		};
		$.get(
			'/comments',
			params,
			function(html) {
				$$.container.html(html);
				history.pushState({}, '', '/comments?' + $.param(params));
			},
			'html'
		);
	}

	return {
		init: init
	};
})();