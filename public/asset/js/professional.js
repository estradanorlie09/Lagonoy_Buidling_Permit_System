let counter = 1;

function mergeOldProfessionals() {
    const length = Math.max(
        oldProfTypes.length,
        oldProfNames.length,
        oldPrcNos.length,
        oldPtrNos.length,
        oldBirthdays.length,
        oldEmails.length,
        oldPhoneNumbers.length,
        oldProfAddresses.length
    );
    const professionals = [];
    for (let i = 0; i < length; i++) {
        professionals.push({
            prof_type: oldProfTypes[i] || "",
            prof_name: oldProfNames[i] || "",
            prc_no: oldPrcNos[i] || "",
            ptr_no: oldPtrNos[i] || "",
            birthday: oldBirthdays[i] || "",
            email: oldEmails[i] || "",
            phone_number: oldPhoneNumbers[i] || "",
            prof_address: oldProfAddresses[i] || "",
        });
    }
    return professionals;
}

document.addEventListener("DOMContentLoaded", () => {
    const oldProfessionals = mergeOldProfessionals();

    const section = document.getElementById("professional-section");
    section.innerHTML = "";

    if (oldProfessionals.length > 0) {
        counter = oldProfessionals.length + 1;
        oldProfessionals.forEach((p, index) => addProfessional(p, index === 0));
    } else {
        const saved = sessionStorage.getItem("professionals");
        if (saved) {
            const professionals = JSON.parse(saved);
            counter = professionals.length + 1;
            professionals.forEach((p, index) =>
                addProfessional(p, index === 0)
            );
        } else {
            addProfessional(null, true);
        }
    }
});

document.addEventListener("input", () => saveProfessionalsToSession());

function addProfessional(data = null, isDefault = false) {
    const index = counter++;
    const section = document.getElementById("professional-section");
    const newProf = document.createElement("div");
    newProf.classList.add(
        "professional-entry",
        "border",
        "border-gray-300",
        "rounded-lg",
        "p-4",
        "relative",
        "mt-3",
        "bg-gray-50"
    );

    const removeBtn = isDefault
        ? ""
        : `<button type="button" onclick="removeProfessional(this)" class="absolute top-2 right-2 text-red-500 font-bold">✖</button>`;

    newProf.innerHTML = `
            ${removeBtn}
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">Professional Type <span class="text-red-500">*</span></label>
                <select name="prof_type[]" class="prof-type w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" id="prof_type_${index}">
                    <option value="">-- Select --</option>
                    <option>Architect</option>
                    <option>Civil/Structural Engineer</option>
                    <option>Sanitary Engineer</option>
                    <option>Electrical Engineer</option>
                    <option>Mechanical Engineer</option>
                    <option>Geodetic Engineer</option>
                </select>
                

            </div>

            <div class="flex gap-5 mt-2">
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="prof_name[]" placeholder="Full Name" class="prof-name w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" id="prof_name_${index}">
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700">PRC Number <span class="text-red-500">*</span></label>
                    <input type="text" name="prc_no[]" placeholder="PRC Number" class="prof-prc w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" id="prc_no_${index}">
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700">PTR Number <span class="text-red-500">*</span></label>
                    <input type="text" name="ptr_no[]" placeholder="PTR Number" class="prof-ptr w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" id="ptr_no_${index}">
                </div>
            </div>

            <div class="flex gap-5 mt-2">
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700">Birthday <span class="text-red-500">*</span></label>
                    <input type="date" name="birthday[]" class="prof-birthday w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" id="birthday_${index}">
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email[]" placeholder="Email" class="prof-email w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" id="email_${index}">
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone_number[]" placeholder="Phone Number" class="prof-phone w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" id="phone_number_${index}">
                </div>
            </div>

            <div class="w-full mt-2">
                <label class="block text-sm font-medium text-gray-700">Address <span class="text-red-500">*</span></label>
                <input type="text" name="prof_address[]" placeholder="Address" class="prof-address w-full border border-gray-300 rounded p-2 mt-1 focus:outline-none focus:ring-1 focus:ring-red-500" id="prof_address_${index}">
            </div>
        `;

    section.appendChild(newProf);

    // Fill from passed data (old input/session)
    if (data) {
        newProf.querySelector(".prof-type").value = data.prof_type || "";
        newProf.querySelector(".prof-name").value = data.prof_name || "";
        newProf.querySelector(".prof-prc").value = data.prc_no || "";
        newProf.querySelector(".prof-ptr").value = data.ptr_no || "";
        newProf.querySelector(".prof-birthday").value = data.birthday || "";
        newProf.querySelector(".prof-email").value = data.email || "";
        newProf.querySelector(".prof-phone").value = data.phone_number || "";
        newProf.querySelector(".prof-address").value = data.prof_address || "";
    }

    saveProfessionalsToSession();
}

function removeProfessional(button) {
    button.closest(".professional-entry").remove();
    saveProfessionalsToSession();
}

function saveProfessionalsToSession() {
    const entries = document.querySelectorAll(".professional-entry");
    const professionals = [];
    entries.forEach((entry) => {
        professionals.push({
            prof_type: entry.querySelector(".prof-type").value,
            prof_name: entry.querySelector(".prof-name").value,
            prc_no: entry.querySelector(".prof-prc").value,
            ptr_no: entry.querySelector(".prof-ptr").value,
            birthday: entry.querySelector(".prof-birthday").value,
            email: entry.querySelector(".prof-email").value,
            phone_number: entry.querySelector(".prof-phone").value,
            prof_address: entry.querySelector(".prof-address").value,
        });
    });
    sessionStorage.setItem("professionals", JSON.stringify(professionals));
}
