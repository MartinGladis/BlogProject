$("document").ready(() => {
    $(".delete-file-button").on("click" , (event) => {
        if (confirm("Are you sure?")) {
            $.ajax({
                method: "GET",
                url: "/file/delete",
                data: {
                    id: event.target.id,
                },
            }).done(function(response) {
                fileElement = $(event.target).parent().parent();
                fileElement.remove();
                $('label#attachmentLabel').before(response);
            })

        }
    });

    $(".delete-post-button").click(() => {
        if (!confirm("Are you sure")) {
            return false;
        }
    });
    
})