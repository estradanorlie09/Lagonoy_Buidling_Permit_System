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

    // Button click handler for both status and date filters
    $(".filter-btn").on("click", function () {
        const type = $(this).data("type");
        const value = $(this).data("value");

        if (type === "status") {
            // Toggle filter selection
            selectedStatus = selectedStatus === value ? "all" : value;

            // Reset all status buttons to their base styles
            $(".status-btn").each(function () {
                const val = $(this).data("value");
                let baseClasses =
                    "filter-btn status-btn p-2 rounded-xl font-medium ";
                switch (val) {
                    case "all":
                        baseClasses += "bg-gray-200 text-gray-800";
                        break;
                    case "scheduled":
                        baseClasses += "bg-blue-100 text-blue-800";
                        break;
                    case "completed":
                        baseClasses += "bg-green-100 text-green-800";
                        break;
                    case "absent":
                        baseClasses += "bg-red-100 text-red-800";
                        break;
                    case "cancelled":
                        baseClasses += "bg-yellow-100 text-yellow-800";
                        break;
                    default:
                        baseClasses += "bg-gray-200 text-gray-800";
                        break;
                }
                $(this).attr("class", baseClasses);
            });

            // Highlight active status button with dark bg
            if (selectedStatus !== "all") {
                let activeBtn = $(".status-btn").filter(
                    `[data-value='${selectedStatus}']`
                );
                let activeClasses =
                    "filter-btn status-btn p-2 rounded-xl font-medium text-white ";
                switch (selectedStatus) {
                    case "scheduled":
                        activeClasses += "bg-blue-800";
                        break;
                    case "completed":
                        activeClasses += "bg-green-800";
                        break;
                    case "absent":
                        activeClasses += "bg-red-800";
                        break;
                    case "cancelled":
                        activeClasses += "bg-yellow-800";
                        break;
                    default:
                        activeClasses += "bg-gray-800";
                        break;
                }
                activeBtn.attr("class", activeClasses);
            }
        }

        if (type === "date") {
            selectedDate = selectedDate === value ? "all" : value;

            $(".date-btn").each(function () {
                const val = $(this).data("value");
                let baseClasses =
                    "filter-btn date-btn p-2 rounded-xl font-medium ";
                switch (val) {
                    case "all":
                        baseClasses += "bg-gray-200 text-gray-800";
                        break;
                    case "today":
                        baseClasses += "bg-blue-100 text-blue-800";
                        break;
                    case "last_week":
                        baseClasses += "bg-green-100 text-green-800";
                        break;
                    case "last_month":
                        baseClasses += "bg-yellow-100 text-yellow-800";
                        break;
                    default:
                        baseClasses += "bg-gray-200 text-gray-800";
                        break;
                }
                $(this).attr("class", baseClasses);
            });

            if (selectedDate !== "all") {
                let activeBtn = $(".date-btn").filter(
                    `[data-value='${selectedDate}']`
                );
                let activeClasses =
                    "filter-btn date-btn px-4 py-2 rounded-xl font-medium text-white ";
                switch (selectedDate) {
                    case "today":
                        activeClasses += "bg-blue-800";
                        break;
                    case "last_week":
                        activeClasses += "bg-green-800";
                        break;
                    case "last_month":
                        activeClasses += "bg-yellow-800";
                        break;
                    default:
                        activeClasses += "bg-gray-800";
                        break;
                }
                activeBtn.attr("class", activeClasses);
            }
        }

        table.draw();
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        let statusCell = data[4];
        let dateStr = data[2];

        let statusText = statusCell.trim().toLowerCase().replace(/\s+/g, "_");

        console.log(statusText);
        // Status filter check
        let statusPass =
            selectedStatus === "all" || statusText === selectedStatus;

        // Date filter check
        let datePass = true;
        if (selectedDate !== "all") {
            let recordDate = moment(dateStr, "MMM DD, YYYY");
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
        }

        return statusPass && datePass;
    });
});
