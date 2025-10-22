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

    $(".filter-btn").on("click", function () {
        let type = $(this).data("type");
        let value = $(this).data("value");

        if (type === "status") {
            if (selectedStatus === value) {
                selectedStatus = "all";
            } else {
                selectedStatus = value;
            }

            // Reset all status buttons to their original bg/text color
            $(".status-btn").each(function () {
                let val = $(this).data("value");
                switch (val) {
                    case "all":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-gray-200 text-gray-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "under_review":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "approved":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "disapproved":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-red-100 text-red-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "resubmit":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                }
            });

            // Add dark background for active
            if (selectedStatus !== "all") {
                $(this)
                    .removeClass()
                    .addClass(
                        "filter-btn status-btn bg-gray-800 text-white px-4 py-2 rounded-full font-medium"
                    );
                switch (selectedStatus) {
                    case "under_review":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-blue-800 text-white px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "approved":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-green-800 text-white px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "disapproved":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-red-800 text-white px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "resubmit":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn status-btn bg-yellow-800 text-white px-4 py-2 rounded-full font-medium"
                            );
                        break;
                }
            }
        }

        if (type === "date") {
            if (selectedDate === value) {
                selectedDate = "all";
            } else {
                selectedDate = value;
            }

            // Reset all date buttons to original colors
            $(".date-btn").each(function () {
                let val = $(this).data("value");
                switch (val) {
                    case "all":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn date-btn bg-gray-200 text-gray-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "today":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn date-btn bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "last_week":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn date-btn bg-green-100 text-green-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "last_month":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn date-btn bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-medium"
                            );
                        break;
                }
            });

            // Add dark background for active
            if (selectedDate !== "all") {
                switch (selectedDate) {
                    case "today":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn date-btn bg-blue-800 text-white px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "last_week":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn date-btn bg-green-800 text-white px-4 py-2 rounded-full font-medium"
                            );
                        break;
                    case "last_month":
                        $(this)
                            .removeClass()
                            .addClass(
                                "filter-btn date-btn bg-yellow-800 text-white px-4 py-2 rounded-full font-medium"
                            );
                        break;
                }
            }
        }

        table.draw();
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        let statusCell = data[3];
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
