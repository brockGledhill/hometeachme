var Utility = {
	setupWrappers: function(selectors) {
		var wrappers = {};
		Object.keys(selectors).map(function(value) {
			wrappers[value] = $(selectors[value]);
		});
		return wrappers;
	}
};