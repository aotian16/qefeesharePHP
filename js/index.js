$(document).ready(
    function () {

        // 链接: 鼠标经过显示下划线
        $("a").on({
            "mouseover": function () {
                $("a").css("text-decoration", "underline");
                // console.log("over");
            },
            "mouseout": function () {
                $("a").css("text-decoration", "none");
                // console.log("out");
            }
        });

        // post: 点击事件
        $(".post").on({
            "click": function () {
                console.log("click post");
            }
        });
    }
);