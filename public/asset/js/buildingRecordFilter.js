$(document).ready(function () {
    let table = $("#example").DataTable({
        dom: "<'hidden'f>rt<'flex flex-col sm:flex-row justify-between items-center mt-4 gap-3'<'w-full sm:w-1/2'i><'w-full sm:w-1/2'p>>",
        language: {
            search: "",
            lengthMenu: "Show _MENU_ entries",
            emptyTable: "🚫 No applications found.",
        },
    });

    $("#customSearch").on("input", function () {
        table.search(this.value).draw();
    });

    let selectedStatus = "all";
    let selectedDate = "all";

    // When status dropdown changes
    $("#statusFilter").on("change", function () {
        selectedStatus = $(this).val();
        table.draw();
    });

    // When date dropdown changes
    $("#dateFilter").on("change", function () {
        selectedDate = $(this).val();
        table.draw();
    });

    // No color update functions needed anymore

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        let statusCell = data[5];
        let dateStr = data[2];

        // Normalize status text
        let statusText = statusCell.trim().toLowerCase().replace(/\s+/g, "_");

        let filterStatus = selectedStatus.toLowerCase().trim();

        let recordDate = moment(dateStr, "MMM DD, YYYY");

        let statusPass =
            selectedStatus === "all" || statusText === selectedStatus;

        // DATE filter
        let datePass = true;
        let today = moment();
        if (selectedDate === "today") {
            datePass = recordDate.isSame(today, "day");
        } else if (selectedDate === "last_week") {
            datePass = recordDate.isBetween(
                today.clone().subtract(7, "days"),
                today,
                "day",
                "[]"
            );
        } else if (selectedDate === "last_month") {
            datePass = recordDate.isSame(
                today.clone().subtract(1, "month"),
                "month"
            );
        }

        return statusPass && datePass;
    });
});
