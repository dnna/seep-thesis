{* Smarty template *}

<script type="text/javascript" src="templates/jquery.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.js"></script>
<script type="text/javascript" src="templates/jquery.tablesorter.dayparser.js"></script>
<script type="text/javascript">
var availableIDS = new Array();
{section name=curLesson loop=$availableLessons}
    availableIDS[{$smarty.section.curLesson.index}] = "{$availableLessons[curLesson]}"
{/section}

{literal}
addLoadEvent(function(){
        var note = document.getElementById('selectionNote');
		if(note != null) {
			note.style.display = '';
		}
	$("#prefTable").tablesorter({sortList: [[0,0]],headers:{2:{sorter:'days'},6:{sorter:false}}});
});

function getElementsByRegExpId(p_regexp, p_element, p_tagName) {
	p_element = p_element === undefined ? document : p_element;
	p_tagName = p_tagName === undefined ? '*' : p_tagName;
	var v_return = [];
	var v_inc = 0;
	for(var v_i = 0, v_il = p_element.getElementsByTagName(p_tagName).length; v_i < v_il; v_i++) {
		if(p_element.getElementsByTagName(p_tagName).item(v_i).id && p_element.getElementsByTagName(p_tagName).item(v_i).id.match(p_regexp)) {
			v_return[v_inc] = p_element.getElementsByTagName(p_tagName).item(v_i);
			v_inc++;
		}
	}
	return v_return;
}

function compareSelects(a,b) {
	//return a.selectedIndex;
return a.options[a.selectedIndex].value - b.options[b.selectedIndex].value;
}

function unique(arrayName)
	{
	var newArray=new Array();
	label:for(var i=0; i<arrayName.length;i++ ) {
		for(var j=0; j<newArray.length;j++ ) {
			if(newArray[j]==arrayName[i])
				continue label;
		}
		newArray[newArray.length] = arrayName[i];
	}
	return newArray;
}

function chooseNextPrio(select) {
	if(select.options[select.selectedIndex].value == 'none') {
		var id = select.id; var k = 0; var i; var sortedSelect = new Array();
		var IDS = id.match('(?=_).+(?=_)').join().substr(1);
		var re = new RegExp('pref_'+IDS+'_*','g') // What to look for
		var prefTable = document.getElementById("prefTable");
		var selectsByRegexp = getElementsByRegExpId('pref_'+IDS+'_*', prefTable, "select");
		for(i = 0; i < selectsByRegexp.length; i++) {
			sortedSelect[k] = selectsByRegexp[i];
			if(sortedSelect[k] != null && sortedSelect[k].options[sortedSelect[k].selectedIndex].value != 'none') {
				k++;
			} else {
				delete sortedSelect[k];
			}
		}
		if(sortedSelect.length > 1) {
		sortedSelect.sort(compareSelects);
			for(i = 0; i < k; i++) {
				if(sortedSelect[i].options[sortedSelect[i].selectedIndex].value != i + 1) {
				select.selectedIndex = i + 1;
				updateValidity();
				return;
				}
			}
			select.selectedIndex = k + 1;
			updateValidity();
			return;
		} else {
			select.selectedIndex = 1;
			updateValidity();
			return;
		}
	}
}

function runChecks(IDS) {
	var i; var j; var k; var select; var total; var nc;
	var samePrioLabs = false; var wrongOrderLabs = false;
	var noChoices = new Array(); select = new Array(); totalSelect = new Array(); 
	k = 0; nc = 0; total = 0; samePrioLabs = false;
	var re = new RegExp('pref_'+IDS+'_*','g') // What to look for
	var prefTable = document.getElementById("prefTable");
	var selectsByRegexp = getElementsByRegExpId('pref_'+IDS+'_*', prefTable, "select");
	for(i = 0; i < selectsByRegexp.length; i++) {
		select[k] = selectsByRegexp[i];
		if(select[k] != null && select[k].options[select[k].selectedIndex].value != 'none') {
			select[k].validity = 'valid';
			totalSelect[total] = select[k];
			k++;
			total++;
		} else {
			// Προσθήκη στον πίνακα noChoices αν η επιλογή είναι 'none'
			if(select[k] != null) {
				noChoices[nc] = select[k];
				noChoices[nc].validity = 'valid';
				totalSelect[total] = noChoices[nc];
				nc++;
				total++;
			}
			delete select[k];
		}
	}
	
	// -- Έλεγχος 1: Δεν έχει γίνει καμία επιλογή --
	if(nc >= total && total > 0) {
		for(i = 0; i < nc; i++) {
			noChoices[i].validity = 'warning';
		}
		return {result : 'noChoices', totalSelect : totalSelect};
	}
	// -- Τέλος Ελέγχου 1 --
	
	// -- Έλεγχος 2: Αν υπάρχουν περισσότερα από ένα εργαστηριακά τμήματα με ίδια προτεραιότητα --
	for(i = 0; i < k; i++) {
		for(j = 0; j < k; j++) {
			if(i == j) continue; // Δεν έχει νόημα να συγκρίνουμε με τον εαυτό του
			if(select[i].options[select[i].selectedIndex].value == select[j].options[select[j].selectedIndex].value) {
				select[i].validity = 'invalid';
				select[j].validity = 'invalid';
				samePrioLabs = true;
			}
		}
	}
	// Αφού υπάρχουν άκυρα εργαστήρια βάζουμε warning στα υπόλοιπα
	if(samePrioLabs == true) {
		for(i = 0; i < k ; i++) {
			if(select[i].validity == 'valid') {
				select[i].validity = 'warning';
			}
		}
		for(i = 0; i < nc; i++) {
			noChoices[i].validity = 'warning';
		}
		return {result : 'sameLab', totalSelect : totalSelect};
	}
	// -- Τέλος Ελέγχου 2 --
	
	// -- Έλεγχος 3: Εργαστήρια με λανθασμένη σειρά προτεραιοτήτων --
	var sortedSelect = select;
	sortedSelect.sort(compareSelects);
	for(i = 0; i < k; i++) {
		if(sortedSelect[i].options[sortedSelect[i].selectedIndex].value != i + 1) {
			sortedSelect[i].validity = 'invalid';
			wrongOrderLabs = true;
		}
	}
	if(wrongOrderLabs == true) {
		return {result : 'wrongOrder', totalSelect : totalSelect};
	}
	// -- Τέλος Ελέγχου 3 --
	return {result : 'success', totalSelect : totalSelect};
}

function updateValidity() {
	// Για κάθε εργαστηριακό μάθημα
	var result; var l; var noChoicesWarning = false; var sameLabError = false; var wrongOrderError = false;
	// Javascript warning disable
	javascriptOffTop = document.getElementById('javascriptOffDivTop'); if(javascriptOffTop != null) { javascriptOffTop.style.display = 'none'; }
	// Valid state
	validStateTop = document.getElementById('validStateDivTop'); if(validStateTop != null) { validStateTop.style.display = 'none'; }
	// Error Types
	noChoicesTop = document.getElementById('noChoicesDivTop'); if(noChoicesTop != null) { noChoicesTop.style.display = 'none'; }
	sameLabTop = document.getElementById('sameLabDivTop'); if(sameLabTop != null) { sameLabTop.style.display = 'none'; }
	wrongOrderTop = document.getElementById('wrongOrderDivTop'); if(wrongOrderTop != null) { wrongOrderTop.style.display = 'none'; }
	
	for(l = 0; l <= availableIDS.length; l++) {
		result = runChecks(availableIDS[l]);
		if(result.result == 'noChoices') noChoicesWarning = true;
		if(result.result == 'sameLab') sameLabError = true;
		if(result.result == 'wrongOrder') wrongOrderError = true;
		for(i = 0; i < result.totalSelect.length; i++) {
			// Επιστρέφουμε σε warning state αυτά στα οποία η επιλογή είναι στο 'none'
			if(result.totalSelect[i].validity == 'valid' && result.totalSelect[i].options[result.totalSelect[i].selectedIndex].value == 'none') {
				result.totalSelect[i].validity = 'warning'; // Potential TODO: Αλλαγή σε διαφορετικό χρώμα από το κλασσικό warning
			}
			//document.write('div_'+result.totalSelect[i].id.substr(5));
			div = document.getElementById('div_'+result.totalSelect[i].id.substr(5));
			result.totalSelect[i].className = result.totalSelect[i].validity;
			div.className = result.totalSelect[i].validity+"Background";
		}
	}
	if(noChoicesWarning == true && noChoicesTop != null) {
		noChoicesTop.style.display = 'block';
	}
	if(sameLabError == true && sameLabTop != null) {
		sameLabTop.style.display = 'block';
	}
	if(wrongOrderError == true && wrongOrderTop != null) {
		wrongOrderTop.style.display = 'block';
	}
	if(wrongOrderError != true && sameLabError != true && noChoicesWarning != true && validStateTop != null) {
		validStateTop.style.display = 'block';
		return true;
	} else if(wrongOrderError != true && sameLabError != true && noChoicesWarning == true) {
		return true;
	} else {
		return false;
	}
}

function confirm() {
	if(!updateValidity()) {
		alert('Υπάρχουν σφάλματα στην δήλωση σας. Παρακαλώ διορθώστε τα και ξαναπροσπαθήστε.');
		return false;
	} else {
		return true;
	}
}

function resetUpdate(e) {
	var form = document.getElementById("statementForm");
	// Βρίσκουμε το κουμπί που πατήθηκε
	var keynum = 0;
	if(window.event) { // IE
		keynum = e.keyCode;
	} else if(e != null && e.which) { // Netscape/Firefox/Opera
		keynum = e.which;
	} else if(e != null && e.keyCode) {
		keynum = e.keyCode;
	}
	if(keynum == 0 || keynum == 32 || keynum == 13) { // Onclick (undefined, 0), Space (32), Enter (13)
		form.reset();
		updateValidity();
	}
	return true;
}
addLoadEvent(updateValidity);
</script>
{/literal}