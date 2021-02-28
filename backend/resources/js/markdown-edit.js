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

    var defolt_preview = marked(getHtml($("#markdown_editor_textarea").val()));
    $("#markdown_preview").html(defolt_preview);

    $("#markdown_editor_textarea").keyup(function() {
        var html = marked(getHtml($(this).val()));
        $("#markdown_preview").html(html);
    });
});
