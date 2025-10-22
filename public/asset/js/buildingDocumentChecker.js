const requiredDocs = {
    architecture_plans: "Architectural Plans (signed & sealed)",
    structure_plans: "Structural Plans (signed & sealed)",
    plumbing_plans: "Sanitary / Plumbing Plans (signed & sealed)",
    mechanical_plans: "Mechanical Plans (signed & sealed)",
    electronics_plans: "Electronics / Alarm / CCTV Plans (signed & sealed)",
    estimated_cost: "Bill of Materials & Cost Estimates (signed & sealed)",
    electrical_plans: "Electrical Plans (signed & sealed)",
    dos: "Deed of Sale / Transfer Certificate of Title / Title documents",
    crptx: "Current Real Property Tax Receipt",
    site_plan: "Lot / Site Plan (signed & sealed by Geodetic Engineer)",
    SPA: "Authorization / SPA (if applicant is not registered owner)",
    zoning_clearance: "Zoning Clearance",
    bfp_certificate: "Fire Safety Clearance / FSEC (BFP)",
    Environmental_clearance: "Environmental Clearance / DENR (if applicable)",
    optional: "Other clearances (DOH, DPWH, etc.) as required",
};

let uploadedDocs = {};
window.addEventListener("load", () => {
    const saved = sessionStorage.getItem("uploadedDocs");
    if (saved) {
        uploadedDocs = JSON.parse(saved);
        restoreUploadedDocs();
        checkDocuments();
    }
});

function handleFiles(inputElement, containerId, docType) {
    const fileInfo = document.getElementById(containerId);
    fileInfo.innerHTML = "";

    const files = inputElement.files;
    if (files.length === 0) {
        fileInfo.textContent = "No file selected";
        delete uploadedDocs[docType];
        saveToSession();
        checkDocuments();
        return;
    }

    const file = files[0];
    uploadedDocs[docType] = file.name;

    const fileDiv = document.createElement("div");
    fileDiv.classList.add(
        "flex",
        "items-center",
        "justify-between",
        "w-full",
        "gap-3"
    );

    const fileNameSpan = document.createElement("span");
    fileNameSpan.textContent = file.name;
    fileNameSpan.classList.add("truncate", "max-w-xs");

    const actionDiv = document.createElement("div");
    actionDiv.classList.add("flex", "items-center", "gap-3");

    const previewButton = document.createElement("button");
    previewButton.textContent = "Preview";
    previewButton.className =
        "text-blue-500 underline text-sm hover:text-blue-700 focus:outline-none";
    previewButton.type = "button";
    previewButton.onclick = () => {
        const fileURL = URL.createObjectURL(file);
        window.open(fileURL);
    };

    const removeButton = document.createElement("button");
    removeButton.textContent = "Remove";
    removeButton.className =
        "text-red-500 underline text-sm hover:text-red-700 focus:outline-none";
    removeButton.type = "button";
    removeButton.onclick = () => {
        inputElement.value = "";
        fileInfo.innerHTML = "No file selected";
        delete uploadedDocs[docType];
        saveToSession(); // ✅ update session storage
        checkDocuments();
    };

    actionDiv.appendChild(previewButton);
    actionDiv.appendChild(removeButton);
    fileDiv.appendChild(fileNameSpan);
    fileDiv.appendChild(actionDiv);
    fileInfo.appendChild(fileDiv);

    checkDocuments();
}

function restoreUploadedDocs() {
    for (const [docType, fileName] of Object.entries(uploadedDocs)) {
        const containerId = docType + "_info";
        const fileInfo = document.getElementById(containerId);
        if (!fileInfo) continue;

        const fileDiv = document.createElement("div");
        fileDiv.classList.add(
            "flex",
            "items-center",
            "justify-between",
            "w-full",
            "gap-3"
        );

        const fileNameSpan = document.createElement("span");
        fileNameSpan.textContent = fileName;
        fileNameSpan.classList.add("truncate", "max-w-xs");

        const actionDiv = document.createElement("div");
        actionDiv.classList.add("flex", "items-center", "gap-3");

        const removeButton = document.createElement("button");
        removeButton.textContent = "Remove";
        removeButton.className =
            "text-red-500 underline text-sm hover:text-red-700 focus:outline-none";
        removeButton.type = "button";
        removeButton.onclick = () => {
            delete uploadedDocs[docType];
            saveToSession();
            fileInfo.innerHTML = "No file selected";
            checkDocuments();
        };

        actionDiv.appendChild(removeButton);
        fileDiv.appendChild(fileNameSpan);
        fileDiv.appendChild(actionDiv);
        fileInfo.appendChild(fileDiv);
    }
}

function checkDocuments() {
    const messageBox = document.getElementById("docsMessage");
    const missing = Object.keys(requiredDocs).filter(
        (doc) => !(doc in uploadedDocs)
    );

    if (missing.length > 0) {
        messageBox.textContent =
            "⚠️ Missing documents: " +
            missing.map((m) => requiredDocs[m]).join(", ");
        messageBox.className = "text-red-500 text-sm mt-4";
        return false;
    } else {
        messageBox.textContent = "✅ All required documents are uploaded.";
        messageBox.className = "text-green-600 text-sm mt-4";
        return true;
    }
}
