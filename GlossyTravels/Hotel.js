function bookHotel(hotel, country) {
    window.location.href = `Hotel%20Booking.html?hotel=${encodeURIComponent(hotel)}&country=${encodeURIComponent(country)}`;
}

function filterHotels() {
    let selectedCountry = document.getElementById('country-filter').value;
    let hotels = document.querySelectorAll('.hotel-card');
    
    hotels.forEach(hotel => {
        if (selectedCountry === 'all' || hotel.dataset.country === selectedCountry) {
            hotel.style.display = 'block';
        } else {
            hotel.style.display = 'none';
        }
    });
}