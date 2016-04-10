// Navigation Tab Color Script
function colorNavTab(tabId) {
	var cssVal = {
		'background-color' : '#ccc',
		'box-shadow' : 'inset 0 6px 10px -5px #666, inset 2px 4px 10px -5px #666, inset -2px 4px 10px -5px #666',
		'color' : '#666',
		'line-height' : '34px'
		}
	$('a.' + tabId).css(cssVal);
	$('li.' + tabId).css('background-color', '#ccc');
}