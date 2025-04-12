function bookActivity(activityName, country) {
    
    document.getElementById('activity-name').value = activityName;
    document.getElementById('country').value = country;

   
    document.getElementById('activity-details').innerText = 'You have selected: ' + activityName + ' in ' + country;

   
    window.location.href = `ActivitiesBookingPage.php?activity=${encodeURIComponent(activityName)}&country=${encodeURIComponent(country)}`;
}
