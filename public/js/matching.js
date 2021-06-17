function match() {
    $.ajax({
        url: "/match",
        method: "GET",
        success: function (result) {
            console.log(result);
        },
        error: function (e) {
            console.error(e);
        }
    });
}