
document.addEventListener("DOMContentLoaded", function () {
    const prices = {
        "Paris-Kenya": { economy: 800, business: 1400, first: 2000 },
        "Kenya-Paris": { economy: 800, business: 1400, first: 2000 },
        "Kenya-SouthAfrica": { economy: 600, business: 1100, first: 1800 },
        "SouthAfrica-Kenya": { economy: 600, business: 1100, first: 1800 },
        "SouthAfrica-USA": { economy: 1200, business: 2000, first: 3000 },
        "USA-SouthAfrica": { economy: 1200, business: 2000, first: 3000 },
        "Paris-USA": { economy: 1500, business: 2500, first: 3500 },
        "USA-Paris": { economy: 1500, business: 2500, first: 3500 },
    };

    const departureLocation = document.getElementById("departureLocation");
    const destinationLocation = document.getElementById("destinationLocation");
    const classButtons = document.querySelectorAll(".class-btn");
    const totalPriceElement = document.getElementById("totalPrice");

    let selectedClass = "economy";

    function updatePrice() {
        const departure = departureLocation.value;
        const destination = destinationLocation.value;
        const route = `${departure}-${destination}`;


        if (prices[route]) {
            const price = prices[route][selectedClass];
            totalPriceElement.innerHTML = `$${price}`;

        } else {
            totalPriceElement.innerHTML = "$0";
        }
    }

    departureLocation.addEventListener("change", updatePrice);
    destinationLocation.addEventListener("change", updatePrice);

    classButtons.forEach((btn) => {
        btn.addEventListener("click", function () {
            selectedClass = this.dataset.class; 
            updatePrice();
        });
    });
});