<?php
session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"/>
<link rel="stylesheet" href="styles.css"/>
<title>Glossy Travel Itinerary Planner</title>
</head>
<body>
    <nav>
        <div class="nav__header">
            <div class="nav__logo">
                <a href="#"class="logo">Glossy Travel Agency</a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links"> 
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="activities.php">Activities</a></li>
            <li><a href="Hotel.php">Hotel</a></li>
            <li><a href="my-itinerary.php">My Bookings</a></li>
            
            <li><a href="logout.php">Logout</a></li>
            <li><a href="#"></a></li>

        </ul>
        <div class="nav__btns">
           

            <a href="Book Flight.php" class="btn book-btn">Book Flight</a>

        </div>
    </nav>
    <header id="home">
        <div class="header__container">
            <div class="header__content">
                <p>Fly with Glossy amd embrace the journey </p>
                <h1>Feel the wonder of flying</h1>
                
            </div>
            <div class="header__image">
                <img src="pictures/TRAVELGLOSSY.jpg" alt="Glossy Travel"/>
            </div>
        </div>
    </header>
<section class="section__container destination__container" id="about">
    <h2 class="section__header">Popular Destination</h2>
    <p class="section__description">
        Plan you trips and explore the world with ease
    </p>

<div class="destination__grid">
    <div class="destination__card">
        <img src="pictures/Paris2.jpg" alt="Pic1">
        <div class="destination__card__details">
            <div>
                <h4>Discover amazing destinations</h4>
                <p>Paris,France</p>
            </div>
            <div class="destination__rating">
                <span><i class="ri-star-fill"></i></span>
                4.6
            </div>
        </div>
    </div>
    

    <div class="destination__card">
        <img src="pictures/Nairobi.jpg" alt="Pic1">
        <div class="destination__card__details">
            <div>
                <h4>Discover amazing destinations</h4>
                <p>Nairobi,Kenya</p>
            </div>
            <div class="destination__rating">
                <span><i class="ri-star-fill"></i></span>
               <span>4.7</span>
            </div>
        </div>
    </div>

            <div class="destination__card">
                <img src="pictures/newyork.jpg" alt="Pic1">
                <div class="destination__card__details">
                    <div>
                        <h4>Discover amazing destinations</h4>
                        <p>New York,USA</p>
                    </div>
                    <div class="destination__rating">
                        <span><i class="ri-star-fill"></i></span>
                        4.6
                    </div>
                </div>
            </div>

                    <div class="destination__card">
                        <img src="pictures/southafrica.webp" alt="Pic1">
                        <div class="destination__card__details">
                            <div>
                                <h4>Discover amazing destinations</h4>
                                <p>South Africa</p>
                            </div>
                            <div class="destination__rating">
                                <span><i class="ri-star-fill"></i></span>
                                4.8
                            </div>
                        </div>
                    </div>

</div>
</div>

</section>


</section>
<section class="section__container showcase__container">
    <div class="showcase__image">
        <img src="pictures/beach.jpg" alt="showcase">
    </div>
    <div class="showcase__container">
        <h4>Effortless bookings, unforgettable journeys</h4>
        <p>Find the best deals on flights, hotels, and activities, all in one place</p>
        <p>Plan your perfect getaway effortlessly with our seamless booking platform, offering a wide range of flights, accommodations, and exciting activities tailored to your preferences</p>
        
    </div>
</section>

<section class="section__container discover__container">
    <h2 class="section__header">Discover the World from above</h2>
    <p class="section__description">
        Explore breathtaking destinations handpicked for unforgettable experiences. From serene beaches to bustling cities, find the perfect spot for your next adventure
    </p>
    <div class="discover__grid">
        <div class="discover__card">
            <span><i class="ri-camera-lens-line"></i></span>
            <h4>Aerial cityscapes</h4>
            <p>Experience breathtaking aerial views of the world's most stunning cities. From towering skylines to vibrant streets, see urban landscapes like never before with stunning panoramic perspectives</p>
        </div>
    
        <div class="discover__card">
            <span><i class="ri-ship-line"></i></i></span>
            <h4>Coastal Wonders</h4>
            <p>Discover the breathtaking beauty of coastal destinations, where golden beaches meet crystal-clear waters and rugged cliffs stand tall against the waves. Whether you're seeking relaxation by the shore, thrilling water adventures, or picturesque seaside towns, our curated coastal experiences offer something for every traveler. Explore hidden coves, vibrant marine life, and scenic coastal trails for an unforgettable getaway</p>
        </div>
        <div class="discover__card">
            <span><i class="ri-landscape-line"></i></i></span>
            <h4>Aerial cityscapes</h4>
            <p>Step back in time and explore the world's most iconic historical landmarks. From ancient ruins and medieval castles to grand palaces and sacred temples, these sites tell the stories of civilizations past. Walk through centuries of history, marvel at architectural wonders, and uncover the cultural significance behind these timeless treasures. Whether you're a history enthusiast or a curious traveler, these landmarks offer a glimpse into the rich heritage of our world</p>
        </div>
    </div>
</section>

<footer id="contact">
    <div class="section__container footer__container">
        <div class="footer__col">
            <div class="footer__logo">
                <a href="#" class="logo">Glossy</a>
            </div>
            <p>Discover and book the best flights, hotels, and experiences all in one place. Our platform ensures a hassle-free journey with personalized recommendations and seamless reservations</p>
            <ul class="footer__socials">
                <li>
                    <a href="https://www.facebook.com/profile.php?id=61574955602872" target="_blank"><i class="ri-facebook-fill"></i></a>
                </li>
                <li>
                    <a href="https:www.instagram.com/_its__joyy"><i class="ri-instagram-fill"></i></a>
                </li>
                <li>
                    <a href="https://wa.me/+254748022518"><i class="ri-whatsapp-line"></i></a>
                </li>
            </ul>
        </div>
        <div class="footer__col">
            <h4>Direct Links</h4>
            <ul class="footer__links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Flights</a></li>
                <li><a href="#">hotels</a></li>
                <li><a href="#">Activities</a></li>
            </ul>
        </div>
        <div class="footer__col">
            <h4>Contact Us</h4>
            <ul class="footer__links">
                <li>
                    <a href="tell:+254748022518">
                    <span><i class="ri-phone-fill"></i></span> +254748022518
                    </a>
                </li>
                <li>
                    <a href="mailto:info@glossyexplore.com">
                    <span><i class="ri-record-mail-line"></i></span> info@glossyexplore
                    </a>
                </li>
                <li>
                    <a href="#">
                    <span><i class="ri-map-pin-2-fill"></i></span> Nairobi, Kenya
                    </a>
                </li>
            </ul>
        </div>
        <div class="footer__col">
            <h4>Subscribe</h4>
            <form action="subscribe.php" method="POST">
                <input required type="email" name="email"  placeholder="Enter Your Email">
                <button class="btn">Subscribe</button>
            </form>
        </div>
    </div>
    <div class="footer__bar">
        Copyright © 2024 Glossy Travels. All Rights Reserved.
    </div>
</footer>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
</body>
</html>