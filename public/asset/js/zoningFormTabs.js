function formTabs() {
    return {
        currentTab: JSON.parse(localStorage.getItem("currentTab")) || 0, // load from storage or default 0
        tabs: [
            {
                label: "Instructions",
            },
            {
                label: "Property Information",
            },
            {
                label: "Documents",
            },
        ],
        setTab(index) {
            this.currentTab = index;
            this.saveTab();
        },
        nextTab() {
            if (this.currentTab < this.tabs.length - 1) {
                this.currentTab++;
                this.saveTab();
            }
        },
        previousTab() {
            if (this.currentTab > 0) {
                this.currentTab--;
                this.saveTab();
            }
        },
        saveTab() {
            localStorage.setItem("currentTab", JSON.stringify(this.currentTab));
        },
    };
}
