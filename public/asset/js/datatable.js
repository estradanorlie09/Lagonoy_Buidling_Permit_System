$(document).ready(function () {
    let table = $("#example").DataTable({
        dom: "<'hidden'f>rt<'flex flex-col sm:flex-row justify-between items-center mt-4 gap-3'<'w-full sm:w-1/2'i><'w-full sm:w-1/2'p>>",
        language: {
            search: "",
            lengthMenu: "Show _MENU_ entries",
        },
        order: [], // no initial sort
        columnDefs: [
            {
                targets: 0,
                orderable: false, // disable sorting for #
                searchable: false,
            },
        ],
    });

    // 🔥 Auto-generate numbering that doesn’t change with sorting
    table
        .on("order.dt search.dt", function () {
            let i = 1;
            table
                .cells(null, 0, { search: "applied", order: "applied" })
                .every(function (cell) {
                    this.data(i++);
                });
        })
        .draw();
    // custom search box
    $("#customSearch").on("keyup", function () {
        table.search(this.value).draw();
    });
});
