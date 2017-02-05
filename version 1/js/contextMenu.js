var mouseX = 0;
var mouseY = 0;
var contextMenuEnabled = false;

if (document.addEventListener) {
    document.addEventListener('contextmenu', function(e) {
        contextMenuFunction();
        e.preventDefault();
    }, false);
} else {
    document.attachEvent('oncontextmenu', function(e) {
        contextMenuFunction();
        e.preventDefault();
    });
}

function contextMenuFunction()
{
    if (!contextMenuEnabled)
    {
        contextMenuEnabled = true;
        document.getElementById("contextMenu").style.display = 'block';
        document.getElementById("contextMenu").style.top = mouseY + "px";
        document.getElementById("contextMenu").style.left = mouseX + "px";
    }
    else
    {
        contextMenuEnabled = false;
        document.getElementById("contextMenu").style.display = 'none';
    }
}

(function() {
    window.onmousemove = handleMouseMove;
    function handleMouseMove(event) {
        event = event || window.event; // IE-ism
        // event.clientX and event.clientY contain the mouse position
        mouseX = event.clientX;
        mouseY = event.clientY;
    }
})();

$(document).click(function(){
    document.getElementById("contextMenu").style.display = 'none';
});

function ViewSource()
{
    window.location = "view-source:" + window.location.href;
}

function Reload()
{
    window.location = window.location.href;
}

function CopyUrl()
{
    
}