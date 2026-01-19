$(document).ready(function () {
    let selectedStatus = "all";

    $.fn.dataTable.ext.search.push(function (settings, data) {
        let statusCell = data[4];
        if (!statusCell) return true;

        let statusText = statusCell.toString().toLowerCase();
        let statusValue = "";

        if (statusText.includes("approved")) statusValue = "approved";
        else if (statusText.includes("pending")) statusValue = "pending";
        else if (statusText.includes("rejected")) statusValue = "rejected";

        if (selectedStatus === "all" || selectedStatus === "") {
            return true;
        }

        return statusValue === selectedStatus.toLowerCase();
    });

    let table = $("#applicantTable").DataTable({
        dom: "<'hidden'f>rt<'flex flex-col sm:flex-row justify-between items-center mt-4 gap-3'<'w-full sm:w-1/2'i><'w-full sm:w-1/2'p>>",

        language: {
            search: "",
            emptyTable: "🚫 No applications found.",
        },

        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
            },
        ],

        order: [[1, "asc"]],

        drawCallback: function () {
            let info = this.api().page.info();
            let records = info.recordsDisplay;

            if (records <=10) {
                $("#applicantTable_info").hide();
                $("#applicantTable_paginate").hide();
            } else {
                $("#applicantTable_info").show();
                $("#applicantTable_paginate").show();
            }
        },
    });

    $("#customSearch").on("keyup change clear input", function () {
        table.search(this.value, false, false).draw();
    });

    $("#statusFilter").on("change", function () {
        selectedStatus = $(this).val();
        table.draw();
    });
});
