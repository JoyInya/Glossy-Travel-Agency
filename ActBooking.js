document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const activityName = urlParams.get("activity");
    const country = urlParams.get("country");

    if (activityName && country) {
        document.getElementById("activity-name").value = activityName;
        document.getElementById("country").value = country;
        document.getElementById("activity-details").innerHTML =
            `<strong>Activity:</strong> ${activityName} <br> <strong>Country:</strong> ${country}`;
    } else {
        document.getElementById("activity-details").innerText = "Activity details not found.";
    }
});
