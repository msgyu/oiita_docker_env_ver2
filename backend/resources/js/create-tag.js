$(function() {
    function new_tag(text) {
        var $tag_li = `<li class="tag-content">
                    <span class="tag-label">
                      ${text}
                      <a class="text-icon">
                        ×
                      </a>
                    </span>
                    <input class="tag-hidden-field" name="tags[]" value="${text}" type="hidden">
                  </li>`;
        return $tag_li;
    }

    function ul_width() {
        var ul_width = 0;
        $(".tag-content").each(function() {
            ul_width += $(this).outerWidth(true);
        });
        $("#tag-input").css({
            width: `calc(100% - ${ul_width}px - 14px)`
        });
    }

    $tags = [];
    ul_width();

    $("#tag-input").on("keydown", function(e) {
        //add tag
        $ul = $(".tags").find(".tags-wrapper");
        if (e.keyCode == 13) {
            var $text = this.value;
            if ($text.length > 0 && $tags.indexOf($text) == -1) {
                $(".tags-wrapper").append(new_tag($text));
                $tags.push($text);
                this.value = "";
                ul_width();
            }

            return false;
        }

        //Delete tag
        if (e.keyCode == 8) {
            var $text = this.value;
            if ($text.length == 0) {
                var $tag = $(".tag-content:last");
                var tag_value = $tag.find(".tag-hidden-field").val();
                var index = $tags.indexOf(tag_value);
                if (index > -1) {
                    $tags.splice(index, 1);
                }
                $tag.remove();
                ul_width();
            }
        }
    });

    //Delete tag
    $(".tags-wrapper").on("click", ".text-icon", function() {
        var $tag = $(this).parents(".tag-content");
        var tag_value = $tag.find(".tag-hidden-field").val();
        var index = $tags.indexOf(tag_value);
        if (index > -1) {
            $tags.splice(index, 1);
        }
        $tag.remove();
        ul_width();
    });
});
