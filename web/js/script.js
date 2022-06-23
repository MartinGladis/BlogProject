$(".delete-file-button").on("click" , function(event) {
    if (confirm("Are you sure?")) {
        $.ajax({
            method: "GET",
            url: "/file/delete",
            data: {
                id: event.target.id,
            },
        }).done(function() {
            $(event.target).parent().parent().remove();
        })
    }
});

$(".delete-post-button").on("click", () => {
    confirm("Are you sure")
});