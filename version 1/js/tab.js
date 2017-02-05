function activateTab(pageId , tabClicked) {
    var tabCtrl = document.getElementById("tabCtrl");
    for (var i = 0; i < tabCtrl.childNodes.length; i++) {
        var node = tabCtrl.childNodes[i];
        if (node.nodeType == 1) { /* Element */
            node.style.display = 'none';
        }
    }

    var TabButtonContrl = document.getElementById("tabs");
    for (var i = 0; i < TabButtonContrl.childNodes.length; i++){
        var node = TabButtonContrl.childNodes[i];
        if (node.nodeType == 1) { /* Element */
            node.className = 'tabButton';
        }
    }
    
    $('#' + tabClicked).attr('class' , 'tabButtonSelected');
    $('#' + pageId).slideDown(500);
}