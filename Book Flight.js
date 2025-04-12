document.addEventListener("DOMContentLoaded", function () {
    const classButtons = document.querySelectorAll(".class-btn");
    const calculateBtn = document.getElementById("calculatePrice");
    const totalPriceDisplay = document.getElementById("totalPrice");
    const fromLocation = document.getElementById("fromLocation");
    const toLocation = document.getElementById("toLocation");
    const travelersInput = document.getElementById("travelers");
    const totalPriceInput = document.getElementById("totalPriceInput");
    const travelClassInput = document.createElement("input");

    travelClassInput.type = "hidden";
    travelClassInput.name = "travelClass";
    travelClassInput.id = "travelClassInput";
    document.getElementById("flightBookingForm").appendChild(travelClassInput);

    const basePrices = {
        "Paris-Kenya": 10000, "Kenya-Paris": 9000,
        "Kenya-South Africa": 8000, "South Africa-Kenya": 9000,
        "South Africa-USA": 12000, "USA-South Africa": 13000,
        "USA-Paris": 15000, "Paris-USA": 16000,
        "Kenya-USA": 13000, "USA-Kenya": 14000,
        "Paris-South Africa": 11000, "South Africa-Paris": 10000
    };

    const classMultipliers = {
        "Economy": 1, "Business": 1.5
    };

    let selectedClass = "Economy"; 

    classButtons.forEach(button => {
        button.addEventListener("click", function () {
            classButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");
            selectedClass = this.getAttribute("data-class");
            travelClassInput.value = selectedClass;
        });
    });

    calculateBtn.addEventListener("click", function () {
        const from = fromLocation.value;
        const to = toLocation.value;
        const travelers = parseInt(travelersInput.value) || 1;
        const routeKey = `${from}-${to}`;

        if (!from || !to) {
            totalPriceDisplay.innerText = "Select both locations!";
            totalPriceInput.value = "";
            return;
        }

        if (from === to) {
            totalPriceDisplay.innerText = "Invalid Route!";
            totalPriceInput.value = "";
            return;
        }

        if (basePrices[routeKey]) {
            const basePrice = basePrices[routeKey];
            const classMultiplier = classMultipliers[selectedClass];
            const totalPrice = (basePrice * classMultiplier) * travelers;

            totalPriceDisplay.innerText = `Total: $${totalPrice.toLocaleString()}`;
            totalPriceInput.value = totalPrice;
        } else {
            totalPriceDisplay.innerText = "Route Not Available";
            totalPriceInput.value = "";
        }
    });
});
