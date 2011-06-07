function bbcode_ins(tag) {
    var field = document.getElementById("contentarea");
    var selected = "";
    var selected2 = "";
    var startpos = "";
    var endpos = "";
    var sel = "";
    var ins = "";

    if (tag == 'b' || tag == 'i' || tag == 'u' || tag == 'h1' || tag == 'h2') {
        if (document.selection) {
            field.focus();
            selected = document.selection.createRange().text;
            ins = '<' + tag + '>' + selected + '</' + tag +'>';
            selected2 = document.selection.createRange();
            sel = document.selection.createRange();
            selected2.moveStart ('character', -field.value.length);
            sel.text = ins;
            sel.moveStart('character', selected2.text.length + ins.length - selected.length);
        } else if (field.selectionStart || field.selectionStart == 0) {
            startpos = field.selectionStart;
            endpos = field.selectionEnd;
            selected = field.value.substring(startpos, endpos);
            ins = '<' + tag + '>' + selected + '</' + tag +'>';
            field.focus();
            field.value = field.value.substring(0, startpos) + ins + field.value.substring(endpos, field.value.length);
            field.setSelectionRange(endpos+ins.length, endpos+ins.length-selected.length);
        }
    } else if (tag == 'br') {
        if (document.selection) {
            field.focus();
            selected = document.selection.createRange().text;
            ins = selected + '<' + tag +'>';
            selected2 = document.selection.createRange();
            sel = document.selection.createRange();
            selected2.moveStart ('character', -field.value.length);
            sel.text = ins;
            sel.moveStart('character', selected2.text.length + ins.length - selected.length);
        } else if (field.selectionStart || field.selectionStart == 0) {
            startpos = field.selectionStart;
            endpos = field.selectionEnd;
            selected = field.value.substring(startpos, endpos);
            ins = selected + '<' + tag +'>';
            field.focus();
            field.value = field.value.substring(0, startpos) + ins + field.value.substring(endpos, field.value.length);
            field.setSelectionRange(endpos+ins.length, endpos+ins.length-selected.length);
        }
    } else if (tag == 'font') {
        var selectedColor = '"' + document.getElementById("fontcolors").value + '"';
        if (document.selection) {
            field.focus();
            selected = document.selection.createRange().text;
            ins = '<' + tag +' color='+ selectedColor +'>' + selected + '</font>';
            selected2 = document.selection.createRange();
            sel = document.selection.createRange();
            selected2.moveStart ('character', -field.value.length);
            sel.text = ins;
            sel.moveStart('character', selected2.text.length + ins.length - selected.length);
        } else if (field.selectionStart || field.selectionStart == 0) {
            startpos = field.selectionStart;
            endpos = field.selectionEnd;
            selected = field.value.substring(startpos, endpos);
            ins = '<' + tag +' color='+ selectedColor +'>' + selected + '</font>';
            field.focus();
            field.value = field.value.substring(0, startpos) + ins + field.value.substring(endpos, field.value.length);
            field.setSelectionRange(endpos+ins.length, endpos+ins.length-selected.length);
        }
    } else if (tag == 'div') {
        var style = prompt('Voer de CSS voo dit object in. Bv: "border:1px black solid;width:10%;"');
        if (document.selection) {
            field.focus();
            selected = document.selection.createRange().text;
            ins = '<div style="'+style+'">' + selected + '</div>';
            selected2 = document.selection.createRange();
            sel = document.selection.createRange();
            sel.text = ins;
            selected2.moveStart ('character', -field.value.length);
            sel.moveStart('character', selected2.text.length + ins.length - selected.length);
        } else if (field.selectionStart || field.selectionStart == 0) {
            startpos = field.selectionStart;
            endpos = field.selectionEnd;
            selected = field.value.substring(startpos, endpos);
            ins = '<div style="'+style+'">' + selected + '</div>';
            field.focus();
            field.value = field.value.substring(0, startpos) + ins + field.value.substring(endpos, field.value.length);
            field.setSelectionRange(endpos+ins.length, endpos+ins.length-selected.length);
        }
    } else if (tag == 'url') {
        var url = prompt('Voer de URL in');
        var linkText = prompt('Voer de text in voor de link');
        if(!url || !linkText) {
            return;
        }
        if (document.selection) {
            field.focus();
            selected = document.selection.createRange().text;
            ins = '<a href="'+url+'">' + linkText + '</a>';
            selected2 = document.selection.createRange();
            sel = document.selection.createRange();
            sel.text = ins;
            selected2.moveStart ('character', -field.value.length);
            sel.moveStart('character', selected2.text.length + ins.length - selected.length);
        } else if (field.selectionStart || field.selectionStart == 0) {
            startpos = field.selectionStart;
            endpos = field.selectionEnd;
            ins = '<a href="'+url+'">' + linkText + '</a>';
            field.focus();
            field.value = field.value.substring(0, startpos) + ins + field.value.substring(endpos, field.value.length);
            field.setSelectionRange(endpos+ins.length, endpos+ins.length-selected.length);
        }
    }
}