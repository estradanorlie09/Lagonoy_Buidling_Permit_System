function goBackAndForceReload() {
    const prevUrl = document.referrer;
    if (prevUrl) {
        const url = new URL(prevUrl);
        url.searchParams.set("forceReload", "1");
        window.location.href = url.toString();
    } else {
        window.location.href = "/obo/building_application_record";
    }
}
