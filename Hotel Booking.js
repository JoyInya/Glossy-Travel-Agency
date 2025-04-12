document.addEventListener("DOMContentLoaded", function () {
   
    const params = new URLSearchParams(window.location.search);

   
    document.getElementById("hotel-name").value = params.get("hotel") || "";
    document.getElementById("location").value = params.get("country") || "";
    document.getElementById("price").value = params.get("price") || "";

    
    const roomsInput = document.getElementById("rooms");
    const roomTypeSelect = document.getElementById("room-type");
    const totalPriceDisplay = document.getElementById("total-price");
    const totalPriceInput = document.getElementById("total-price-input");

  
    function updatePrice() {
        let basePrice = parseFloat(params.get("price")) || 100;
        let rooms = parseInt(roomsInput.value) || 1;
        let roomType = roomTypeSelect.value;

        
        let roomMultiplier = roomType === "double" ? 1.5 : roomType === "suite" ? 2.1 : 1;
        let totalPrice = basePrice * rooms * roomMultiplier;

      
        totalPriceDisplay.textContent = `$${totalPrice.toFixed(2)}`;
        totalPriceInput.value = totalPrice.toFixed(2);
    }

   
    updatePrice();

 
    roomsInput.addEventListener("input", updatePrice);
    roomTypeSelect.addEventListener("change", updatePrice);
});
