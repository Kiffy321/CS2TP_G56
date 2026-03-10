<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Seraphine Atelier | Luxury Jewellery</title>

<link rel="stylesheet" href="{{ asset('assets/style.css') }}">

<style>

/* ======== Zak Styling ======== */

body {
  margin: 0;
  font-family: "Inter", sans-serif;
  background: #ffffff;
  color: #222222;
  line-height: 1.7;
}

h1,h2,h3 {
  font-family: "Playfair Display", serif;
  margin: 0;
}

.container{
  max-width:1200px;
  margin:auto;
}

.section-title{
  font-size:2.4rem;
  text-align:center;
  margin-bottom:10px;
}

.section-subtitle{
  text-align:center;
  font-size:1rem;
  max-width:600px;
  margin:0 auto 30px;
  color:#555;
}

/* ======== Navbar ======== */

.navbar{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:22px 60px;
  border-bottom:1px solid #eee;
  position:sticky;
  top:0;
  background:#ffffff;
  z-index:1000;
}

.nav-links{
  list-style:none;
  display:flex;
  gap:30px;
}

.nav-links a{
  text-decoration:none;
  color:#333;
  font-weight:500;
  font-size:0.95rem;
}

.nav-links a:hover{
  color:#b89b5e;
}

.logo{
  font-family:'Playfair Display', serif;
  font-size:1.6rem;
  font-weight:700;
}

/* ======== Hero ======== */

.hero{
  text-align:center;
  padding:130px 20px;
  background:#faf9f5;
}

.hero-title{
  font-size:3rem;
  margin-bottom:15px;
}

.hero-subtitle{
  font-size:1.1rem;
  color:#555;
  max-width:600px;
  margin:0 auto 30px;
}

.btn-primary{
  background:#b89b5e;
  color:white;
  padding:14px 34px;
  border-radius:4px;
  text-decoration:none;
}

.btn-outline{
  border:1px solid #b89b5e;
  padding:13px 32px;
  border-radius:4px;
  color:#b89b5e;
  text-decoration:none;
}

/* ======== Products ======== */

.product-list-section{
  padding:60px 60px;
}

.product-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:30px;
  margin-top:40px;
}

.product-card{
  display:block;
  background:white;
  padding:20px;
  border-radius:6px;
  text-align:center;
  border:1px solid #eee;
  text-decoration:none;
  color:#222;
}

.product-card img{
  width:100%;
  border-radius:6px;
  margin-bottom:15px;
}

.product-card h3{
  font-family:'Playfair Display', serif;
  font-size:1.2rem;
}

.product-price{
  color:#b89b5e;
  font-weight:500;
}

/* ======== Story ======== */

.story-section{
  padding:60px;
}

/* ======== Footer ======== */

.footer{
  text-align:center;
  padding:25px;
  font-size:0.9rem;
  color:#666;
  border-top:1px solid #eee;
}

@media(max-width:768px){

.navbar{
  padding:18px 25px;
}

.hero-title{
  font-size:2.2rem;
}

.section-title{
  font-size:1.9rem;
}

}

</style>
</head>

<body>

<header class="navbar">

<div class="logo">Seraphine Atelier</div>

<nav>
<ul class="nav-links">
<li><a href="/">Home</a></li>
<li><a href="/products">Shop</a></li>
<li><a href="/products">Categories</a></li>
<li><a href="/about">About</a></li>
<li><a href="/contact">Contact</a></li>
</ul>
</nav>

</header>

<!-- HERO -->

<section class="hero">

<div class="container">

<h1 class="hero-title">Discover Timeless Elegance</h1>

<p class="hero-subtitle">
Luxury handcrafted jewellery for every occasion.
</p>

<a href="/products" class="btn-primary">Shop Now</a>
<a href="/products" class="btn-outline">Explore Collections</a>

</div>

</section>

<!-- FEATURED PRODUCTS -->

<section class="product-list-section">

<div class="container">

<h2 class="section-title">Featured Products</h2>

<div class="product-grid">

<a href="/product" class="product-card">

<img src="{{ asset('assets/images/elegant-gold-ring.jpg') }}" alt="Elegant Gold Ring">

<h3>Elegant Gold Ring</h3>

<p class="product-price">$249</p>

</a>

<a href="/product" class="product-card">

<img src="{{ asset('assets/images/silver-necklace.jpg') }}" alt="Silver Necklace">

<h3>Silver Necklace</h3>

<p class="product-price">$199</p>

</a>

<a href="/product" class="product-card">

<img src="{{ asset('assets/images/diamond-earrings.jpg') }}" alt="Diamond Earrings">

<h3>Diamond Earrings</h3>

<p class="product-price">$349</p>

</a>

</div>

</div>

</section>

<!-- STORY -->

<section class="story-section">

<div class="container">

<h2 class="section-title">Our Story</h2>

<p class="section-subtitle">
At Seraphine Atelier we craft timeless jewellery that celebrates elegance,
artistry and individuality. Every piece blends classic craftsmanship with
modern inspiration.
</p>

</div>

</section>

<footer class="footer">

<div class="container">

<p>© 2024 Seraphine Atelier • All Rights Reserved</p>

</div>

</footer>

</body>
</html>