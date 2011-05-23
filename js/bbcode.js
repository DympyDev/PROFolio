function bbcode_ins(fieldId, tag) {
    var field = document.getElementById(fieldId);
    if(tag == 'b' || tag == 'i' || tag == 'u') {
        if (document.selection) {
            field.focus();
            var selected = document.selection.createRange().text;
            var ins = '<' + tag + '>' + selected + '</' + tag +'>';
            var selected2 = document.selection.createRange();
            var sel = document.selection.createRange();
            selected2.moveStart ('character', -field.value.length);
            sel.text = ins;
            sel.moveStart('character', selected2.text.length + ins.length - selected.length);
        } else if (field.selectionStart || field.selectionStart == 0) {
            var startPos = field.selectionStart;
            var endPos = field.selectionEnd;
            var selected = field.value.substring(startPos, endPos);
            var ins = '<' + tag + '>' + selected + '</' + tag +'>';
            field.focus();
            field.value = field.value.substring(0, startPos) + ins + field.value.substring(endPos, field.value.length);
            field.setSelectionRange(endPos+ins.length, endPos+ins.length-selected.length);
        }
    } else if(tag == 'url') {
        var url = prompt('Voer de URL in');
        var linkText = prompt('Voer de text in voor de link');
        if(!url || !linkText) {
            return;
        }
        if (document.selection) {
            field.focus();
            var selected = document.selection.createRange().text;
            var ins = '[' + tag + '='+url+']' + linkText + '[/' + tag+']';
            var selected2 = document.selection.createRange();
            var sel = document.selection.createRange();
            sel.text = '[' + tag + '='+url+']' + linkText + '[/' + tag+']';
            selected2.moveStart ('character', -field.value.length);
            sel.moveStart('character', selected2.text.length + ins.length - selected.length);
        } else if (field.selectionStart || field.selectionStart == 0) {
            var startPos = field.selectionStart;
            var endPos = field.selectionEnd;
            var ins = '[' + tag + '='+url+']' + linkText + '[/' + tag+']';
            field.focus();
            field.value = field.value.substring(0, startPos)
            + ins
            + field.value.substring(endPos, field.value.length);
            field.setSelectionRange(endPos+ins.length, endPos+ins.length-selected.length);
        }
    }
}