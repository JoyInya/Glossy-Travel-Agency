<script>
    document.addEventListener("DOMContentLoaded", function() { }
    const params = new URLSearchParams(window.location.search);
    const hotelName = params.get("hotel");
    const location = params.get("location");

    if (hotelName) {document.getElementById("hotel-name").value = hotelName};
        }
    if (location) {document.getElementById("hotel-location").textContent = location};
        }
    });
</script>;
