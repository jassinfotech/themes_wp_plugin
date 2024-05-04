jQuery(document).ready( function() {
    jQuery('.facebook-share').click(function() {
        newwindow=window.open(shareUrl,'Share on Facebook','height=500,width=320');
        if (window.focus) {newwindow.focus()}
        return false;
    });
});


window.twttr = (function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0],
t = window.twttr || {};
if (d.getElementById(id)) return t;
js = d.createElement(s);
js.id = id;
js.src = "https://platform.twitter.com/widgets.js";
fjs.parentNode.insertBefore(js, fjs);

t._e = [];
t.ready = function(f) {
t._e.push(f);
};

return t;
}(document, "script", "twitter-wjs"));