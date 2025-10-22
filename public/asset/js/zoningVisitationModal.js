function markStatus(id, status) {
    Swal.fire({
        title: "Are you sure?",
        text: "This visitation will be marked as " + status + ".",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, confirm!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/zoning_visitations/${id}/status`, {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    status: status,
                }),
            })
                .then(async (response) => {
                    const contentType = response.headers.get("content-type");

                    if (!response.ok) {
                        if (
                            contentType &&
                            contentType.includes("application/json")
                        ) {
                            const error = await response.json();
                            throw new Error(error.message || "Server error");
                        } else {
                            const text = await response.text();
                            throw new Error(
                                "Unexpected response from server: " +
                                    text.slice(0, 100)
                            );
                        }
                    }

                    return response.json();
                })
                .then((data) => {
                    Swal.fire("Updated!", data.message, "success").then(() =>
                        location.reload()
                    );
                })
                .catch((error) => {
                    Swal.fire("Error!", error.message, "error");
                });
        }
    });
}
