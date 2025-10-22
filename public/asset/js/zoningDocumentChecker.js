const requiredDocs = {
    vicinity_map: "Vicinity Map",
    lot_plan: "Lot Plan",
    proof_of_ownership: "Proof of Ownership / Tax Declaration",
    CTC: "Community Tax Certificate (CTC)",
};

let uploadedDocs = {};

function handleFiles(inputElement, containerId, docType) {
    const fileInfo = document.getElementById(containerId);
    fileInfo.innerHTML = ""; // reset display

    const files = inputElement.files;
    if (files.length === 0) {
        fileInfo.textContent = "No file selected";
        delete uploadedDocs[docType];
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
        checkDocuments();
    };

    actionDiv.appendChild(previewButton);
    actionDiv.appendChild(removeButton);
    fileDiv.appendChild(fileNameSpan);
    fileDiv.appendChild(actionDiv);
    fileInfo.appendChild(fileDiv);

    checkDocuments();
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
