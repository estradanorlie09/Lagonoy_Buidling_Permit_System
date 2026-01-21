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
                    "filter-btn status-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all border ";
                switch (val) {
                    case "all":
                        baseClasses +=
                            "bg-gray-100 text-gray-700 border-gray-200 hover:bg-gray-200";
                        break;
                    case "scheduled":
                        baseClasses +=
                            "bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100";
                        break;
                    case "rescheduled":
                        baseClasses +=
                            "bg-cyan-50 text-cyan-700 border-cyan-200 hover:bg-cyan-100";
                        break;
                    case "completed":
                        baseClasses +=
                            "bg-green-50 text-green-700 border-green-200 hover:bg-green-100";
                        break;
                    case "absent":
                        baseClasses +=
                            "bg-red-50 text-red-700 border-red-200 hover:bg-red-100";
                        break;
                    case "cancelled":
                        baseClasses +=
                            "bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100";
                        break;
                    default:
                        baseClasses +=
                            "bg-gray-100 text-gray-700 border-gray-200 hover:bg-gray-200";
                        break;
                }
                $(this).attr("class", baseClasses);
            });

            // Highlight active status button with solid color
            if (selectedStatus !== "all") {
                let activeBtn = $(".status-btn").filter(
                    `[data-value='${selectedStatus}']`,
                );
                let activeClasses =
                    "filter-btn status-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all border text-white ";
                switch (selectedStatus) {
                    case "scheduled":
                        activeClasses +=
                            "bg-blue-600 border-blue-600 hover:bg-blue-700";
                        break;
                    case "rescheduled":
                        activeClasses +=
                            "bg-cyan-600 border-cyan-600 hover:bg-cyan-700";
                        break;
                    case "completed":
                        activeClasses +=
                            "bg-green-600 border-green-600 hover:bg-green-700";
                        break;
                    case "absent":
                        activeClasses +=
                            "bg-red-600 border-red-600 hover:bg-red-700";
                        break;
                    case "cancelled":
                        activeClasses +=
                            "bg-gray-600 border-gray-600 hover:bg-gray-700";
                        break;
                    default:
                        activeClasses +=
                            "bg-gray-600 border-gray-600 hover:bg-gray-700";
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
                    "filter-btn date-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all border ";
                switch (val) {
                    case "all":
                        baseClasses +=
                            "bg-gray-100 text-gray-700 border-gray-200 hover:bg-gray-200";
                        break;
                    case "today":
                        baseClasses +=
                            "bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100";
                        break;
                    case "last_week":
                        baseClasses +=
                            "bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100";
                        break;
                    case "last_month":
                        baseClasses +=
                            "bg-cyan-50 text-cyan-700 border-cyan-200 hover:bg-cyan-100";
                        break;
                    default:
                        baseClasses +=
                            "bg-gray-100 text-gray-700 border-gray-200 hover:bg-gray-200";
                        break;
                }
                $(this).attr("class", baseClasses);
            });

            if (selectedDate !== "all") {
                let activeBtn = $(".date-btn").filter(
                    `[data-value='${selectedDate}']`,
                );
                let activeClasses =
                    "filter-btn date-btn px-3 py-1.5 rounded-full font-medium text-xs transition-all border text-white ";
                switch (selectedDate) {
                    case "today":
                        activeClasses +=
                            "bg-blue-600 border-blue-600 hover:bg-blue-700";
                        break;
                    case "last_week":
                        activeClasses +=
                            "bg-indigo-600 border-indigo-600 hover:bg-indigo-700";
                        break;
                    case "last_month":
                        activeClasses +=
                            "bg-cyan-600 border-cyan-600 hover:bg-cyan-700";
                        break;
                    default:
                        activeClasses +=
                            "bg-gray-600 border-gray-600 hover:bg-gray-700";
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
                    "[]",
                );
            } else if (selectedDate === "last_month") {
                datePass = recordDate.isSame(
                    today.clone().subtract(1, "month"),
                    "month",
                );
            }
        }

        return statusPass && datePass;
    });
});
