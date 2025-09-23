$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

var host = window.location.host;

if (host === "127.0.0.1:8000") {
    var sitelink = "http://127.0.0.1:8000/master/";
} else {
    var sitelink = window.location.origin + "/master/";
}

const popoverTriggerList = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
);
const popoverList = [...popoverTriggerList].map(
    (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
);

$("#logout").click(function (e) {
    if (confirm("Are you sure want to logout?")) {
        $.ajax({
            type: "POST",
            url: "/logout",
            success: function (response) {
                window.location.replace(sitelink + "login");
            },
        });
    }
});

$(".viewpass").click(function (e) {
    e.preventDefault();
    var input = $(this).siblings("input");
    var type = input.attr("type");
    if (type == "password") {
        $(this).children(".eye-off").hide();
        $(this).children(".eye-on").show();
        input.attr("type", "text");
    } else {
        $(this).children(".eye-off").show();
        $(this).children(".eye-on").hide();
        input.attr("type", "password");
    }
});

$(".required-val").keyup(function () {
    $(this).removeClass("border-danger");
});

$(".form-submit").submit(function (e) {
    e.preventDefault();

    var id = $(this).attr("id");
    const button = $(this).find("button[type='submit']");
    console.log(button);

    var btn_html = button.html();
    button.attr("disabled", true).html("Please Wait...");

    var url = $(this).attr("action");
    var data = new FormData(this);

    $.ajax({
        type: "post",
        url: url,
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === true) {
                button.attr("disabled", false).html(btn_html);
                $.toast("success", response.message);
                setTimeout(() => {
                    $(".toast").addClass("hide");
                }, 5000);
                setTimeout(() => {
                    if (response.type) {
                        window.location.replace(response.url);
                    } else {
                        window.location.replace(sitelink + response.url);
                    }
                }, 3000);
            } else {
                button.attr("disabled", false).html(btn_html);
                $.toast("error", response.message);
                setTimeout(() => {
                    $(".toast").addClass("hide");
                }, 5000);
            }
        },
        error: function (error) {
            button.attr("disabled", false).html(btn_html);
            $.toast("error", error.responseJSON.message);
            setTimeout(() => {
                $(".toast").addClass("hide");
            }, 5000);
        },
    });
});
$(".click-form").click(function (e) {
    e.preventDefault();
    var id = $(this).attr("id");
    var val_id = $(this).data("id");
    var val = $(this).data("val");
    var confirm_msg = $(this).data("confirm");

    if (confirm(confirm_msg)) {
        if (id == "update-policy-status") {
            var url = sitelink + "update-policy-status";
            var data = { id: val_id, val: val };
        }

        if (id == "delete-insurance-brand") {
            var url = sitelink + "delete-insurance-brand";
            var data = { id: val_id, val: val };
        }

        $.ajax({
            type: "post",
            url: url,
            data: data,
            success: function (response) {
                if (response.status === true) {
                    alert(response.message);
                    setTimeout(() => {
                        if (response.url == "reload") {
                            window.location.reload();
                        } else {
                            window.location.replace(sitelink + response.url);
                        }
                    }, 1000);
                } else {
                    alert(response.message);
                }
            },
            error: function (error) {
                alert(error.responseJSON.message);
            },
        });
    }
});

$(".menu-bar ").click(function () {
    $(".top-menu").toggleClass("top-menu-active");
});

$(".close-nav  ").click(function () {
    $(".top-menu").removeClass("top-menu-active");
});

$(".prev-input").change(function (e) {
    e.preventDefault();
    var html = "";
    var url = URL.createObjectURL(e.target.files[0]);

    $(this).siblings("img").remove();
    if (
        e.target.files[0].type == "image/png" ||
        e.target.files[0].type == "image/jpg" ||
        e.target.files[0].type == "image/jpeg"
    ) {
        html += '<img src="' + url + '" class="item">';
    } else if (e.target.files[0].type == "application/pdf") {
        html +=
            '<img src="' +
            window.location.origin +
            '/assets/images/pdfs-512.webp" class="item">';
    } else {
        html +=
            '<img src="' +
            window.location.origin +
            '/assets/images/5968517.png" class="item">';
    }
    $(this).parents(".prev-box").append(html);
    $(this).parents(".prev-box").addClass("prev-box-active");
});

$(".prev-box-add").click(function (e) {
    e.preventDefault();
    var html =
        '<div class="prev-box"><input type="file" name="files[]" class="prev-input"></div>';
    $(html).insertBefore(this);
});

$("#copyButton").on("click", function () {
    alert('adsf')
    // Select the text in the input field
    const textToCopy = $("#copyText");
    textToCopy.text();
    textToCopy[0].setSelectionRange(0, 99999); // For mobile devices

    // Copy the text to the clipboard
    document.execCommand("copy");

    // Provide user feedback
    alert("Copied to clipboard: " + textToCopy);
});
