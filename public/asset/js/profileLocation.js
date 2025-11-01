const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

$("#province").on("change", function () {
    let province = $(this).val();

    $("#municipality").html("<option>Loading...</option>");
    $("#barangay").html("<option>Select Barangay</option>");

    $.post(
        "/location/municipalities",
        {
            province: province,
            _token: csrfToken,
        },
        function (data) {
            console.log("Municipalities data:", data);

            $("#municipality").html(
                '<option value="">Select Municipality/City</option>'
            );
            $.each(data, function (key, value) {
                // Support both object or string arrays
                let optionValue =
                    typeof value === "object" ? value.name || key : value;
                let optionText =
                    typeof value === "object" ? value.name || key : value;

                $("#municipality").append(
                    `<option value="${optionValue}">${optionText}</option>`
                );
            });
        }
    ).fail(function (xhr) {
        alert("Failed to load municipalities.");
        $("#municipality").html("<option>Select Municipality/City</option>");
    });
});

$("#municipality").on("change", function () {
    let province = $("#province").val();
    let municipality = $(this).val();

    $("#barangay").html("<option>Loading...</option>");

    $.post(
        "/location/barangays",
        {
            province: province,
            municipality: municipality,
            _token: csrfToken,
        },
        function (data) {
            console.log("Barangays data:", data);

            $("#barangay").html('<option value="">Select Barangay</option>');
            $.each(data, function (index, barangay) {
                // Support object or string arrays
                let optionValue =
                    typeof barangay === "object"
                        ? barangay.name || index
                        : barangay;
                let optionText =
                    typeof barangay === "object"
                        ? barangay.name || index
                        : barangay;

                $("#barangay").append(
                    `<option value="${optionValue}">${optionText}</option>`
                );
            });
        }
    ).fail(function (xhr) {
        alert("Failed to load barangays.");
        $("#barangay").html("<option>Select Barangay</option>");
    });
});
