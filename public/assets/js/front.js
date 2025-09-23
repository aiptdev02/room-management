$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

var host = window.location.host;

if (host === "127.0.0.1:8000") {
    var sitelink = "http://127.0.0.1:8000/";
} else {
    var sitelink = window.location.origin + "/";
}

$("#logout").click(function (e) {
    if (confirm("Are you sure want to logout?")) {
        $.ajax({
            type: "POST",
            url: sitelink + "logout",
            success: function (response) {
                window.location.replace(sitelink + "login");
            },
        });
    }
});

(function (window, $) {
    "use strict";

    var defaultConfig = {
        type: "",
        autoDismiss: false,
        container: "#toasts",
        autoDismissDelay: 4000,
        transitionDuration: 500,
    };

    $.toast = function (config) {
        var size = arguments.length;
        var isString = typeof config === "string";

        if (isString && size === 1) {
            config = {
                message: config,
            };
        }

        if (isString && size === 2) {
            config = {
                message: arguments[1],
                type: arguments[0],
            };
        }

        return new toast(config);
    };

    var toast = function (config) {
        config = $.extend({}, defaultConfig, config);
        // show "x" or not
        var close = config.autoDismiss ? "" : "&times;";

        // toast template
        var toast = $(
            [
                '<div class="toast ' + config.type + '">',
                "<p>" + config.message + "</p>",
                '<div class="close">' + close + "</div>",
                "</div>",
            ].join("")
        );

        // handle dismiss
        toast.find(".close").on("click", function () {
            var toast = $(this).parent();

            toast.addClass("hide");

            setTimeout(function () {
                toast.remove();
            }, config.transitionDuration);
        });

        // append toast to toasts container
        $(config.container).append(toast);

        // transition in
        setTimeout(function () {
            toast.addClass("show");
        }, config.transitionDuration);

        // if auto-dismiss, start counting
        if (config.autoDismiss) {
            setTimeout(function () {
                toast.find(".close").click();
            }, config.autoDismissDelay);
        }

        return this;
    };
})(window, jQuery);

$(document).ready(function () {
    $(".form-submit").on('submit',  function (e) {
        e.preventDefault();
        var id = $(this).attr("id");
        const button = $(this).find("button[type='submit']");

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
                    toastrSucc(response);

                    setTimeout(() => {
                        $(".toast").addClass("hide");
                    }, 5000);
                    setTimeout(() => {
                        if (response.type) {
                            window.location.replace(response.url);
                        } else {
                            if (response.url == "reload") {
                                window.location.reload();
                            } else {
                                window.location.replace(
                                    sitelink + response.url
                                );
                            }
                        }
                    }, 3000);
                } else {
                    button.attr("disabled", false).html(btn_html);
                    toastrErr(response);
                    regenCaptcha();
                    setTimeout(() => {
                        $(".toast").addClass("hide");
                    }, 5000);
                }
            },
            error: function (error) {
                button.attr("disabled", false).html(btn_html);

                toastrErr(error.responseJSON);
                regenCaptcha();
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
        var url = sitelink + "delete-account";

        if (confirm(confirm_msg)) {
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
                                window.location.replace(
                                    sitelink + response.url
                                );
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

    $(document).on("click", ".delete-form", function (e) {
        e.preventDefault();

        var id = $(this).attr("id");
        var url = $(this).attr("action");
        var data = new FormData(this);
        if (confirm("Are you sure wanted to delete this data?")) {
            $.ajax({
                type: "post",
                url: url,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === true) {
                        // $.toast("success", response.message);
                        toastrSucc(response);
                        setTimeout(() => {
                            $(".toast").addClass("hide");
                        }, 5000);
                    } else {
                        button.attr("disabled", false).html(btn_html);
                        toastrErr(response);
                        regenCaptcha();
                        setTimeout(() => {
                            $(".toast").addClass("hide");
                        }, 5000);
                    }
                },
                error: function (error) {
                    button.attr("disabled", false).html(btn_html);

                    toastrErr(error);
                    regenCaptcha();
                    setTimeout(() => {
                        $(".toast").addClass("hide");
                    }, 5000);
                },
            });
        }
    });

    $(document).on("change", ".change-data", function (e) {
        e.preventDefault();
        var idatt = $(this).attr("id");
        var id = $(this).data("id");
        var url = $(this).data("url");
        var status = $(this).val();
        var statutext = "";
        if (status == 1) {
            status = 0;
            statutext = "Inactive";
        } else {
            status = 1;
            statutext = "Active";
        }
        $.ajax({
            type: "POST",
            url: url,
            data: {
                id: id,
                status: status,
            },
            success: function (response) {
                if (response.status === true) {
                    toastrSucc(response);
                    regenCaptcha();
                    setTimeout(() => {
                        $(".toast").addClass("hide");
                    }, 5000);
                    $("#" + idatt).val(status);
                    $("#form-check-label" + id).html(statutext);
                } else {
                    toastrErr(response);
                    regenCaptcha();
                    setTimeout(() => {
                        $(".toast").addClass("hide");
                    }, 5000);
                }
            },
            error: function (error) {
                toastrErr(error);
                regenCaptcha();
                setTimeout(() => {
                    $(".toast").addClass("hide");
                }, 5000);
            },
        });
    });

    $(document).on("click", ".delete-data", function (e) {
        e.preventDefault();
        var id = $(this).attr("id");
        var url = $(this).data("url");
        var table = $(this).closest("tr").attr("class");

        if (confirm("Are you sure wanted to delete this data?")) {
            $.ajax({
                type: "DELETE",
                url: url,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === true) {
                        toastrSucc(response);
                        regenCaptcha();
                        setTimeout(() => {
                            $(".toast").addClass("hide");
                        }, 5000);

                        if (response.url == "reload") {
                            window.location.reload();
                        } else {
                            $("." + table)
                                .closest("tr")
                                .remove();
                        }
                    } else {
                        toastrErr(response);
                        regenCaptcha();
                        setTimeout(() => {
                            $(".toast").addClass("hide");
                        }, 5000);
                    }
                },
                error: function (error) {
                    toastrErr(error);
                    regenCaptcha();
                    setTimeout(() => {
                        $(".toast").addClass("hide");
                    }, 5000);
                },
            });
        }
    });

    $(".nav-arrow").click(function (e) {
        e.preventDefault();
        $(this).closest(".has-sub").toggleClass("active-sub");
    });

    // Function to format the date in 'd-M-Y' format
    function formatDate(date) {
        const monthNames = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ];

        const day = ("0" + date.getDate()).slice(-2); // Get day and pad with leading zero
        const month = monthNames[date.getMonth()]; // Get month name from array
        const year = date.getFullYear(); // Get full year

        return `${day}-${month}-${year}`;
    }

    $("#newcaptcha").on("click", function () {
        regenCaptcha();
    });
    function regenCaptcha() {
        $.ajax({
            type: "GET",
            url: "/reload-captcha",
            success: function (data) {
                $("#captchadiv").html(data);
            },
        });
    }
    function toastrSucc(data) {
        toastr.success(data.message, "Message", {
            positionClass: "toast-bottom-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1,
        });
    }

    function toastrErr(data) {
        toastr.error(data.message, "Message", {
            positionClass: "toast-bottom-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1,
        });
    }
});
$("#copyButton").on("click", function () {
    // Get the text from the span
    const textToCopy = $("#copyText").text();

    // Create a temporary input element to copy the text
    const tempInput = $("<textarea>");
    $("body").append(tempInput);
    tempInput.val(textToCopy).select();

    // Copy the text to the clipboard
    document.execCommand("copy");

    // Remove the temporary input element
    tempInput.remove();

    // Provide user feedback
    alert("Copied to clipboard: " + textToCopy);
});
