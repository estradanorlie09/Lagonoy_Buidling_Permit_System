$(document).ready(function () {
    let table = $("#applicantTable").DataTable({
        dom: "<'hidden'f>rt<'flex flex-col sm:flex-row justify-between items-center mt-4 gap-3'<'w-full sm:w-1/2'i><'w-full sm:w-1/2'p>>",
        language: {
            search: "",
            lengthMenu: "Show _MENU_ entries",
            emptyTable: "🚫 No applications found.",
        },
        columnDefs: [
            {
                targets: 0, // Row number column
                orderable: false,
                searchable: false,
            },
        ],
        order: [[1, "asc"]], // Order by Full Name
    });

    // Search functionality
    $("#customSearch").on("input", function () {
        // alert(2);
        table.search(this.value).draw();
    });

    let selectedStatus = "all";

    // When status dropdown changes
    $("#statusFilter").on("change", function () {
        selectedStatus = $(this).val();
        table.draw();
    });

    // Custom filtering function
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        let statusCell = data[4]; // Status column (index 4)

        // Normalize status text - extract only the status word
        let statusText = statusCell.trim().toLowerCase();
        let statusValue = "";

        if (statusText.includes("approved")) {
            statusValue = "approved";
        } else if (statusText.includes("pending")) {
            statusValue = "pending";
        } else if (statusText.includes("rejected")) {
            statusValue = "rejected";
        }

        // Check if status matches filter
        let filterStatus = selectedStatus.toLowerCase().trim();
        let statusPass = selectedStatus === "" || filterStatus === statusValue;

        return statusPass;
    });
});
