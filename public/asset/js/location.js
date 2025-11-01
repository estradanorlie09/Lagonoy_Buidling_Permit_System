const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
$(document).ready(function () {
    const oldMunicipality = window.oldMunicipality || "";
    const oldBarangay = window.oldBarangay || "";

    $("#project_province").on("change", function () {
        let province = $(this).val();

        $("#project_municipality").html("<option>Loading...</option>");
        $("#project_barangay").html("<option>Select Barangay</option>");

        $.post(
            "/location/municipalities",
            {
                province: province,
                _token: csrfToken,
            },
            function (data) {
                $("#project_municipality").html(
                    '<option value="">Select Municipality/City</option>'
                );
                $.each(data, function (key, value) {
                    let optionValue =
                        typeof value === "object" ? value.name || key : value;
                    let optionText =
                        typeof value === "object" ? value.name || key : value;

                    $("#project_municipality").append(
                        `<option value="${optionValue}" ${
                            oldMunicipality == optionValue ? "selected" : ""
                        }>${optionText}</option>`
                    );
                });

                if (oldMunicipality) {
                    $("#project_municipality").trigger("change");
                }
            }
        ).fail(function () {
            alert("Failed to load municipalities.");
            $("#project_municipality").html(
                "<option>Select Municipality/City</option>"
            );
        });
    });

    $("#project_municipality").on("change", function () {
        let province = $("#project_province").val();
        let municipality = $(this).val();

        $("#project_barangay").html("<option>Loading...</option>");

        $.post(
            "/location/barangays",
            {
                province: province,
                municipality: municipality,
                _token: csrfToken,
            },
            function (data) {
                $("#project_barangay").html(
                    '<option value="">Select Barangay</option>'
                );
                $.each(data, function (index, barangay) {
                    let optionValue =
                        typeof barangay === "object"
                            ? barangay.name || index
                            : barangay;
                    let optionText =
                        typeof barangay === "object"
                            ? barangay.name || index
                            : barangay;

                    $("#project_barangay").append(
                        `<option value="${optionValue}" ${
                            oldBarangay == optionValue ? "selected" : ""
                        }>${optionText}</option>`
                    );
                });

                if (oldBarangay) {
                    $("#project_barangay").val(oldBarangay);
                }
            }
        ).fail(function () {
            alert("Failed to load barangays.");
            $("#project_barangay").html("<option>Select Barangay</option>");
        });
    });

    if ($("#project_province").val()) {
        $("#project_province").trigger("change");
    }

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
                $("#municipality").html(
                    '<option value="">Select Municipality/City</option>'
                );
                $.each(data, function (key, value) {
                    let optionValue =
                        typeof value === "object" ? value.name || key : value;
                    let optionText =
                        typeof value === "object" ? value.name || key : value;

                    $("#municipality").append(
                        `<option value="${optionValue}" ${
                            oldMunicipality == optionValue ? "selected" : ""
                        }>${optionText}</option>`
                    );
                });

                if (oldMunicipality) {
                    $("#municipality").trigger("change");
                }
            }
        ).fail(function () {
            alert("Failed to load municipalities.");
            $("#municipality").html(
                "<option>Select Municipality/City</option>"
            );
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
                $("#barangay").html(
                    '<option value="">Select Barangay</option>'
                );
                $.each(data, function (index, barangay) {
                    let optionValue =
                        typeof barangay === "object"
                            ? barangay.name || index
                            : barangay;
                    let optionText =
                        typeof barangay === "object"
                            ? barangay.name || index
                            : barangay;

                    $("#barangay").append(
                        `<option value="${optionValue}" ${
                            oldBarangay == optionValue ? "selected" : ""
                        }>${optionText}</option>`
                    );
                });

                if (oldBarangay) {
                    $("#barangay").val(oldBarangay);
                }
            }
        ).fail(function () {
            alert("Failed to load barangays.");
            $("#barangay").html("<option>Select Barangay</option>");
        });
    });

    if ($("#province").val()) {
        $("#province").trigger("change");
    }
});
