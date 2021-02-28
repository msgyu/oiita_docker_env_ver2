import marked from "marked";

$(function() {
    marked.setOptions({
        langPrefix: "",
        breaks: true,
        sanitize: true
    });

    function getHtml(html) {
        html = html.replace(/&lt;/g, "<");
        html = html.replace(/&gt;/g, ">");
        html = html.replace(/&amp;/g, "&");
        return html;
    }

    var target = $(".post-body");
    var html = marked(getHtml(target.html()));
    $(".post-body").html(html);
});
