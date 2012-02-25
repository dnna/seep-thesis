// add parser through the tablesorter addParser method
$.tablesorter.addParser({
	// set a unique id
	id: 'days',
	is: function(s) {
		// return false so this parser is not auto detected
		return false;
	},
	format: function(s) {
		// format your data for normalization
                //document.write(s.toLowerCase().replace(/κυριακή/,6).replace(/σάββατο/,5).replace(/παρασκευή/,4).replace(/πέμπτη/,3).replace(/τετάρτη/,2).replace(/τρίτη/,1).replace(/δευτέρα/,0));
		return s.toLowerCase().replace(/κυριακή/,6).replace(/σάββατο/,5).replace(/παρασκευή/,4).replace(/πέμπτη/,3).replace(/τετάρτη/,2).replace(/τρίτη/,1).replace(/δευτέρα/,0);
	},
	// set type, either numeric or text
	type: 'numeric'
});