
function getQueryParams() {
    let params = new URLSearchParams(window.location.search);
    return {
        activity: params.get("activity"),
        country: params.get("country")
    };
}


document.addEventListener("DOMContentLoaded", function () {
    let { activity, country } = getQueryParams();

    
    if (activity && country) {
        document.getElementById("activity-details").textContent = `Booking for: ${activity} in ${country}`;
    }
});
