// Copyright pixy (c) 2002 e-mail: pixy@pixy.cz
// This program is not for public use
// If you want to use it, contact the author

window.onload = Init;

var ctrlEvents = false;

var colorInline = 'lightgreen';
var colorBlock = 'yellow';
var colorNSBox = 'black';
var bgcolorNSBox = '#fffff0';

var nodeStack = new Array();
var nsCnt = 0;
var NSBox;

var buttonStyle = 'font:12px/1 sans-serif;font-weight:bold;vertical-align:middle';
var selectStyle = 'font:12px/1 sans-serif;vertical-align:middle';
var iframeStyle = 'width:auto;margin:0;height:250px;';


function Init() {
	if (!thepage) alert('page missing! Editor won\'t work.')
	if (!thestyle) alert('style missing! Editor won\'t work.')
	else {
		var e = document.body;
		initNodes(e);
		createNSBox();
		ctrlEvents = true;
		}
	}

function initNodes(e) {
	if (e.nodeType==1) {
		initNode(e);
		if (e.childNodes) {
			var ch = e.childNodes;
			for (var i=0; i<ch.length; i++) initNodes(ch[i]);
			}
		}
	}

function initNode(e) {
	if (e.nodeType==1) {
		e.onmouseover = nodeHiliteSelf;
		e.onmouseout = nodeUnHiliteSelf;
		e.onclick = nodeActionSelf;
		e.style.cursor = "pointer";
		var n = e.nodeName.toLowerCase();
		if (n=='strong' || n=='a') e.WEnodeType = 'inline'
		else if (n=='body') e.WEnodeType = 'body'
		else e.WEnodeType = 'block';
		var ee = e;
		var ttl = '';
		while (ee && ee!=document) {
			if (ttl) ttl = ee.nodeName.toLowerCase() + ' > ' + ttl;
			else ttl = ee.nodeName.toLowerCase();
			ee = ee.parentNode;
			}
		e.title = 'This element(s): ' + ttl + ' (click to edit)';
		}
	}

function nodeHiliteSelf() {
	if (ctrlEvents) {
		nodeHilite(this);
		return false
		}
	else return true
	}
function nodeUnHiliteSelf() {
	if (ctrlEvents) {
		nodeUnHilite(this);
		return false
		}
	else return true
	}
function nodeActionSelf() {
	if (ctrlEvents) {
		nodeAction(this);
		return false
		}
	else return true
	}

function compBkgr(e) {
	if (document.defaultView && document.defaultView.getComputedStyle)
		return document.defaultView.getComputedStyle(e, '').getPropertyValue("background-color");
	else if (e.currentStyle)
		return e.currentStyle.backgroundColor;
	else return e.style.backgroundColor;
	}
function nodeHilite(e) {
	if (e.WEnodeType!='body') {
		e.WEoldBkgr = compBkgr(e);
		if (e.WEnodeType=='inline') e.style.backgroundColor = colorInline;
		else e.style.backgroundColor = colorBlock;
		}
	}

function nodeUnHilite(e) {
	if (e.WEnodeType!='body')
		e.style.backgroundColor = (e.WEoldBkgr) ? e.WEoldBkgr : "transparent";
	}

function nodeAction(e) {
	ctrlEvents = false;
	buildNSBox(e);
	}

function buildNodeStack(e) {
	var ee = e;
	nsCnt = 0;
	while (ee && ee!=document) {
		nodeStack[nsCnt] = ee;
		nsCnt++;
		ee = ee.parentNode;
		}
	}

function buildNSBox(e) {
	var i,e,en, buff = '<h3>Select element to be styled</strong></h3><p>';
	buildNodeStack(e);
	for (i=0; i<nsCnt; i++) {
		e = nodeStack[i];
		nodeUnHilite(e);
		en = e.nodeName.toLowerCase();
		if (e.id) en += ' id="'+e.id+'"';
		if (e.className) en += ' class="'+e.className+'"';
		buff += '<button style="'+buttonStyle+'" onclick="showTagChoice('+i+')"> &lt;'+en+'&gt; </button><br>';
		if (i<nsCnt-1) buff += '|<br>';
		}
	buff += '</p><hr /><p><button style="'+buttonStyle+'" onclick="closeNSBox(true)"> close </button></p>';
	showNSBox(buff);
	}

function showNSBox(html) {
	NSBox.innerHTML = html;
	NSBox.style.left = '30%';
	NSBox.style.width = '40%';
	NSBox.style.display = 'block';
	}

function closeNSBox(startEvents) {
	nsCnt = 0;
	NSBox.style.display = 'none';
	NSBox.innerHTML = '';
	ctrlEvents = startEvents;
	}

function createNSBox() {
	NSBox = document.createElement('div');
	NSBox.innerHTML = '';
	NSBox.style.position = 'fixed';
	NSBox.style.zIndex = '99999';
	NSBox.style.top = '20px';
	NSBox.style.left = '0';
	NSBox.style.width = '0';
	NSBox.style.padding = '1em';
	NSBox.style.border = '1px solid black';
	NSBox.style.borderRightWidth = '2px';
	NSBox.style.borderBottomWidth = '2px';
	NSBox.style.textAlign = 'center';
	NSBox.style.verticalAlign = 'middle';
	NSBox.style.color = colorNSBox;
	NSBox.style.backgroundColor = bgcolorNSBox;
	NSBox.style.font = '12px/1 sans-serif';
	NSBox.style.display = 'none';
	document.body.appendChild(NSBox);
	}

function showTagChoice(n) {
	var buff = '<h3>This element: ';
	var e = nodeStack[n];
	buildNodeStack(e);
	e = nodeStack[0];
	var en = e.nodeName.toLowerCase();
	var id = (e.id) ? ' id="'+e.id+'"' : '';
	var cl = (e.className) ? ' class="'+e.className+'"' : '';
	buff += '&lt;'+en+id+cl+'&gt;</h3>';
	
	buff += '<hr /><h3>Set style for element:</h3>';

	for (var i=0; i<nsCnt; i++) {
		if (i>0) {
			buff += '<div style="text-align:left">Context '+i+': <input type="checkbox" id="treecheck'+i+'" onclick="checkTreeContext('+i+')" /> ';
			buff += '<select style="'+selectStyle+'" onchange="checkTreeSelects()" id="treeop'+i+'">';
			buff += '<option value="0" selected="selected">anywhere inside</option>';
			buff += '<option value="1">directly inside</option>';
			buff += '</select> ';
			}
		else buff += '<div>';
		buff += '<select style="'+selectStyle+'" onchange="checkTreeSelects()" id="tree'+i+'">';
		en = nodeStack[i].nodeName.toLowerCase();
		buff += '<option value="tag" selected="selected">Any &lt;'+en+'&gt;</option>';
		if (nodeStack[i].id) {
			id = nodeStack[i].id;
			buff += '<option value="id">Exactly id="'+id+'"</option>';
			}
		if (nodeStack[i].className) {
			cl = nodeStack[i].className;
			buff += '<option value="tag.class">Any &lt;'+en+' class="'+cl+'"&gt;</option>';
			buff += '<option value="class">Any element with class="'+cl+'"</option>';
			}
		buff += '</select> ';
		
		buff += '<select style="'+selectStyle+'" onchange="checkTreeSelects()" id="treestate'+i+'">';
		buff += '<option value="any" selected="selected">- any state -</option>';
		if (en=='a') {
			buff += '<option value="link">not visited (:link)</option>';
			buff += '<option value="visited">visited (:visited)</option>';
			}
		buff += '<option value="hover">on mouseover (:hover)</option>';
		buff += '<option value="focus">when focused (:focus)</option>';
		buff += '<option value="active">when activated (:active)</option>';
		buff += '<option value="firstchild">when beeing first child</option>';
		buff += '<option value="firstline">first line of it only</option>';
		buff += '<option value="firstletter">first letter of it only</option>';
		buff += '</select></div>';
		}

	buff += '<hr /><p id="selectorpreview"></p>';
	buff += '<p><button style="'+buttonStyle+'" onclick="editNode('+n+')"> edit style </button></p>';

	buff += '<hr /><p><button style="'+buttonStyle+'" onclick="closeNSBox(true)"> close </button></p>';

	NSBox.innerHTML = buff;

	for (var i=1; i<nsCnt; i++) checkTreeContext(i);

	NSBox.style.left = '10%';
	NSBox.style.width = '80%';
	NSBox.style.display = 'block';
	}

function checkTreeContext(n) {
	var ch = objGet('treecheck'+n);
	objGet('tree'+n).style.visibility = (ch.checked) ? 'visible' : 'hidden';
	objGet('treeop'+n).style.visibility = (ch.checked) ? 'visible' : 'hidden';
	objGet('treestate'+n).style.visibility = (ch.checked) ? 'visible' : 'hidden';
	showSelector();
	}

function checkTreeSelects() {
	showSelector();
	}
function showSelector() {
	var sel = buildSelector();
	sel = sel.replace(/>/,'&gt;');
	objGet('selectorpreview').innerHTML = 'Selector: <strong>'+sel+'</strong>';
	}
	
function buildSelector() {
	var e,sel,op,st, useOp, buff = '';
	for (var i=nsCnt-1; i>=0; i--) {
		e = nodeStack[i];
		sel = objGet('tree'+i).value;
		st = objGet('treestate'+i).value;
		if (i>0) {
			op = objGet('treeop'+i).value;
			useOp = objGet('treecheck'+i).checked;
			}
		else useOp = false;
		if (i==0 || useOp) {
			if (sel=="tag") buff += e.nodeName.toLowerCase();
			else if (sel=="id") buff += '#'+e.id;
			else if (sel=="tag.class") buff += e.nodeName.toLowerCase()+'.'+e.className;
			else if (sel=="class") buff += '.'+e.className;
			if (st=="hover") buff += ':hover';
			else if (st=="focus") buff += ':focus';
			else if (st=="active") buff += ':active';
			else if (st=="link") buff += ':link';
			else if (st=="visited") buff += ':visited';
			else if (st=="firstchild") buff += ':first-child';
			else if (st=="firstline") buff += ':first-line';
			else if (st=="firstletter") buff += ':first-letter';
			}
		if (useOp) {
			if (op=="0") buff += ' ';
			else if (op=="1") buff += ' > ';
			}
		}
	return buff;
	}

function editNode(n) {
	var sel = buildSelector();
	var seltxt = sel.replace('>','&gt;');
	closeNSBox(false);
	document.location.href = 'csseditor.php?thepage='+thepage+'&thestyle='+thestyle+'&sel='+escape(sel);
	}