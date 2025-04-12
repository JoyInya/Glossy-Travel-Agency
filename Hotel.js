function bookHotel(hotelName, country, price) {
    window.location.href = "HotelBooking.php?hotel=" + encodeURIComponent(hotelName) +
                           "&country=" + encodeURIComponent(country) +
                           "&price=" + encodeURIComponent(price);
}
