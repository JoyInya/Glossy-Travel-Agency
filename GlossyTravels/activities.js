function bookActivity(activity, country) {
    window.location.href = `Activities%20Booking.html?activity=${encodeURIComponent(activity)}&country=${encodeURIComponent(country)}`;
}


function filterActivities() {
    let selectedCountry = document.getElementById('country-filter').value;
    let activities = document.querySelectorAll('.activity-card');
    
    activities.forEach(activity => {
        if (selectedCountry === 'all' || activity.dataset.country === selectedCountry) {
            activity.style.display = 'block';
        } else {
            activity.style.display = 'none';
        }
    });
}
