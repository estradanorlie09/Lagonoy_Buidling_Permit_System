$(document).ready(function () {
    let selectedStatus = "all";
    let selectedDate = "all";

    // Custom filter for status and date
    $.fn.dataTable.ext.search.push(function (settings, data) {
        let statusCell = data[4]; // Status column
        let dateCell = data[2]; // Date column

        // Normalize status text
        let statusText = statusCell.toString().toLowerCase().trim();
        let statusValue = "";

        // IMPORTANT: order matters (disapproved must come first)
        if (statusText.includes("disapproved")) {
            statusValue = "disapproved";
        } else if (statusText.includes("approved")) {
            statusValue = "approved";
        } else if (statusText.includes("under review")) {
            statusValue = "under_review";
        } else if (statusText.includes("resubmit")) {
            statusValue = "resubmit";
        } else if (statusText.includes("submitted")) {
            statusValue = "submitted";
        }

        // STATUS FILTER
        if (selectedStatus !== "all" && selectedStatus !== "") {
            if (statusValue !== selectedStatus) {
                return false;
            }
        }

        // DATE FILTER
        if (selectedDate !== "all" && selectedDate !== "") {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const rowDate = new Date(dateCell);
            rowDate.setHours(0, 0, 0, 0);

            const diffTime = today - rowDate;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            switch (selectedDate) {
                case "today":
                    if (diffDays !== 0) return false;
                    break;
                case "last_week":
                    if (diffDays < 0 || diffDays > 7) return false;
                    break;
                case "last_month":
                    if (diffDays < 0 || diffDays > 30) return false;
                    break;
            }
        }

        return true;
    });

    // Initialize DataTable
    let table = $("#applicantTable").DataTable({
        dom:
            "<'hidden'f>rt<'flex flex-col sm:flex-row justify-between items-center mt-4 gap-3'" +
            "<'w-full sm:w-1/2'i><'w-full sm:w-1/2'p>>",

        language: {
            search: "",
            emptyTable: "No applications found.",
            paginate: {
                previous: "← Previous",
                next: "Next →",
            },
            info: "Showing _START_ to _END_ of _TOTAL_ applications",
        },

        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
            },
        ],

        order: [[1, "asc"]],
        pageLength: 10,

        drawCallback: function () {
            let info = this.api().page.info();
            let records = info.recordsDisplay;

            if (records <= 10) {
                $("#applicantTable_info").hide();
                $("#applicantTable_paginate").hide();
            } else {
                $("#applicantTable_info").show();
                $("#applicantTable_paginate").show();
            }
        },
    });

    // Search
    $("#customSearch").on("keyup change clear input", function () {
        table.search(this.value, false, false).draw();
    });

    // Status filter
    $("#statusFilter").on("change", function () {
        selectedStatus = $(this).val();
        table.draw();
    });

    // Date filter
    $("#dateFilter").on("change", function () {
        selectedDate = $(this).val();
        table.draw();
    });

    // Reset filters
    $(document).on("click", "#resetFilters", function () {
        selectedStatus = "all";
        selectedDate = "all";
        $("#statusFilter").val("all");
        $("#dateFilter").val("all");
        $("#customSearch").val("");
        table.search("").draw();
    });
});
