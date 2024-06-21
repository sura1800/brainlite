$(document).ready(function () {
    

    $(".add_more").on("click", function () {
        let copy = $(".copy_box:last").clone();
        // console.log( copy.find("input").val(""));
        // copy.find("input").val("").end();

        // copy.wrap("<form>").closest("form").get(0).reset();
        copy.find("input[type='text']").val("").end();
        copy.find("input[type='color']").val("#ededed");
        // copy.unwrap();
        if ($(".more_box .copy_box").length == 0) {
            copy.children("div").append(
                "<div class='col-md-1'><button type='button' class='remove_more btn btn-danger'>X</button></div>"                
            );
        }
        copy.css("margin-top", "10px");
        $(".more_box").append(copy);
    });

    $(document).on("click", ".remove_more", function (e) {
        $(this).parent().parent().parent().remove();
    });
})