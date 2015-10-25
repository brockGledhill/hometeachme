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
		$.get(
			'/comments',
			{
				month: $$.month.val(),
				year: $$.year.val()
			},
			function(html) {
				$$.container.html(html);
			},
			'html'
		);
	}

	return {
		init: init
	};
})();