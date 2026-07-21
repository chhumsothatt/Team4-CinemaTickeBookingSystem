<!DOCTYPE html>
<html lang="km">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CINÉ MARQUEE — កក់សំបុត្រកុន</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
  :root{
    --void:#faf8f2;
    --surface-line:#e5ded0;
    --marquee:#c9932e;
    --marquee-dim:#a3812f;
    --velvet:#b3242e;
    --velvet-bright:#d93244;
    --ink:#221c28;
    --ink-muted:#726a80;
    --font-display:'Bebas Neue','Noto Sans Khmer',sans-serif;
    --font-mono:'JetBrains Mono', monospace;
  }
  body{background:var(--void); color:var(--ink); font-family:'Inter','Noto Sans Khmer',sans-serif;}
  .font-display{font-family:var(--font-display); letter-spacing:.5px;}
  .font-mono{font-family:var(--font-mono);}
  .text-marquee{color:var(--marquee) !important;}
  .text-velvet{color:var(--velvet) !important;}
  .btn-marquee{background:var(--marquee); border-color:var(--marquee); color:#1a1408; font-weight:700;}
  .btn-marquee:hover{background:var(--marquee-dim); border-color:var(--marquee-dim); color:#1a1408;}
  .btn-velvet{background:var(--velvet); border-color:var(--velvet); color:#fff; font-weight:700;}
  .btn-velvet:hover{background:var(--velvet-bright); border-color:var(--velvet-bright); color:#fff;}
  .btn-outline-cinema{border-color:var(--surface-line); color:var(--ink); font-weight:600;}
  .btn-outline-cinema:hover{border-color:var(--marquee-dim); background:transparent; color:var(--marquee-dim);}

  /* film-strip divider — recurring cinema motif */
  .filmstrip{
    height:20px;
    background:
      repeating-linear-gradient(90deg, var(--void) 0 10px, transparent 10px 22px),
      var(--surface-line);
    background-size: 22px 100%, 100% 100%;
    border-top:1px solid var(--surface-line);
    border-bottom:1px solid var(--surface-line);
  }

  .navbar-brand .bulb{width:7px;height:7px;border-radius:50%;background:var(--marquee); box-shadow:0 0 8px 2px var(--marquee); display:inline-block; animation:blink 1.6s infinite ease-in-out;}
  @keyframes blink{0%,100%{opacity:1;}50%{opacity:.3;}}

  /* hero */
  .hero{
    position:relative; min-height:70vh; display:flex; align-items:flex-end;
    background:
      linear-gradient(180deg, rgba(34,28,40,.2) 0%, rgba(250,248,242,.98) 90%),
      radial-gradient(ellipse at 30% 20%, rgba(179,36,46,.35), transparent 55%),
      url('https://images.unsplash.com/photo-1489599162946-9f6f0b3f6b2f?w=1400&q=60') center/cover;
  }
  .hero .ribbon{
    position:absolute; top:32px; right:-58px; background:var(--velvet); color:#fff;
    font-family:var(--font-display); font-size:13px; letter-spacing:3px;
    padding:7px 70px; transform:rotate(38deg); box-shadow:0 4px 14px rgba(0,0,0,.25);
  }
  .hero h1{font-size:clamp(48px,8vw,96px); line-height:.95; text-shadow:0 6px 24px rgba(0,0,0,.3);}
  .badge-tag{border:1px solid var(--marquee-dim); color:var(--marquee); font-weight:700; font-size:11px; letter-spacing:.5px; background:transparent;}

  /* movie cards */
  .movie-card{overflow:hidden; border-color:var(--surface-line); cursor:pointer; transition:transform .2s ease, box-shadow .2s ease;}
  .movie-card:hover{transform:translateY(-4px); box-shadow:0 10px 30px -12px rgba(34,28,40,.25); border-color:var(--marquee-dim);}
  .poster-wrap{aspect-ratio:2/3; background-size:cover; background-position:center; position:relative;}
  .poster-wrap .cat-badge{position:absolute; bottom:10px; left:10px;}

  /* seats */
  .screen-arc{width:70%; height:6px; margin:0 auto 8px; border-radius:50%; background:radial-gradient(ellipse at center, rgba(201,147,46,.5), transparent 75%);}
  .seat-map{display:grid; grid-template-columns:repeat(10,1fr); gap:8px; max-width:520px; margin:0 auto;}
  .seat{
    aspect-ratio:1; border-radius:5px 5px 8px 8px; background:#e9e3d6; border:1px solid var(--surface-line);
    display:flex; align-items:center; justify-content:center; font-size:10px; font-family:var(--font-mono);
    color:var(--ink-muted); cursor:pointer; transition:.15s;
  }
  .seat:hover{border-color:var(--marquee-dim);}
  .seat.taken{background:#f0cdd0; color:#9c4750; cursor:not-allowed; opacity:.7;}
  .seat.selected{background:var(--marquee); color:#1a1408; font-weight:700; border-color:var(--marquee);}
  .legend-swatch{width:12px; height:12px; border-radius:3px; display:inline-block;}

  /* ticket stub in modal */
  .ticket-stub{
    width:96px; background:repeating-linear-gradient(180deg, var(--void) 0 8px, transparent 8px 16px), var(--marquee);
    background-size:100% 16px, 100% 100%; display:flex; align-items:center; justify-content:center;
  }
  .ticket-stub span{writing-mode:vertical-rl; font-family:var(--font-display); font-size:16px; letter-spacing:3px; color:#1a1408;}
  .dashed-row{border-bottom:1px dashed var(--surface-line);}

  .navbar{background:rgba(250,248,242,.92) !important; backdrop-filter:blur(8px); border-bottom:1px solid var(--surface-line);}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top py-3">
  <div class="container">
    <a class="navbar-brand font-display fs-3 d-flex align-items-center gap-2" href="#top">
      <span class="bulb"></span><span class="text-marquee">CINÉ</span><span class="fs-6 fw-normal ms-1">MARQUEE</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav mx-auto gap-lg-4 fw-semibold text-center">
        <li class="nav-item"><a class="nav-link text-marquee" href="#movies">ភាពយន្ត</a></li>
        <li class="nav-item"><a class="nav-link" href="#booking">កក់សំបុត្រ</a></li>
        <li class="nav-item"><a class="nav-link" href="#history">ប្រវត្តិកក់</a></li>
      </ul>
      <div class="d-flex gap-2 mt-3 mt-lg-0">
        <a href="../login.php" class="btn btn-outline-cinema px-3">ចូល / Login</a>
        <a href="../register.php" class="btn btn-marquee px-3">ចុះឈ្មោះ</a>
      </div>
    </div>
  </div>
</nav>
<div class="filmstrip"></div>

<!-- HERO -->
<section class="hero" id="top" style=" height: 50vh; margin-top: -200px;">
  <span class="ribbon">NOW SHOWING</span>
  <div class="container pb-5 pt-5">
    <div class="text-marquee fw-bold small text-uppercase mb-2" style="letter-spacing:2px;">
      <i class="bi bi-circle-fill" style="font-size:8px;"></i> Room A · 7:30 PM Tonight
    </div>
    <h1 class="font-display mb-3">SUPERMAN</h1>
    <div class="d-flex flex-wrap gap-3 align-items-center mb-4 text-muted">
      <span class="badge badge-tag rounded-pill px-3 py-2">Action</span>
      <span><strong class="text-dark">128</strong> នាទី</span>
      <span>Release <strong class="text-dark">25/07/2026</strong></span>
    </div>
    <div class="d-flex gap-2">
      <a href="#booking" class="btn btn-velvet btn-lg px-4">កក់សំបុត្រឥឡូវនេះ</a>
      <button class="btn btn-outline-cinema btn-lg px-4">មើល Trailer</button>
    </div>
  </div>
</section>

<main class="container">
  <!-- SEARCH & FILTER -->
  <div class="row g-3 py-5" id="movies">
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
        <input type="text" id="movieSearch" class="form-control border-start-0" placeholder="ស្វែងរកភាពយន្ត... ឧ. Spi" oninput="liveSearch()">
      </div>
    </div>
    <div class="col-md-3">
      <select id="catFilter" class="form-select" onchange="liveSearch()">
        <option value="">គ្រប់ប្រភេទ</option>
        <option>Action</option><option>Horror</option><option>Comedy</option><option>Romance</option><option>Animation</option>
      </select>
    </div>
    <div class="col-md-3">
      <select id="roomFilter" class="form-select" onchange="liveSearch()">
        <option value="">គ្រប់បន្ទប់</option>
        <option>Room A</option><option>Room B</option><option>VIP Room</option>
      </select>
    </div>
    <div class="col-12"><small class="text-muted" id="search-status"></small></div>
  </div>

  <!-- MOVIE GRID -->
  <div class="d-flex justify-content-between align-items-baseline mb-4">
    <h2 class="font-display fs-1 mb-0">កំពុងបញ្ចាំង</h2>
    <span class="text-muted font-mono small" id="resultCount">6 movies</span>
  </div>
  <div class="row g-4 pb-5" id="movieGrid">
    <div class="col-3">
      <div class="card" >
        <img src="../upload/image.png" class="card-img-top" alt="...">
        <div class="card-body">
          <p class="card-text">Some quick example t</p>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card" >
        <img src="../upload/image.png" class="card-img-top" alt="...">
        <div class="card-body">
          <p class="card-text">Some quick example t</p>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card" >
        <img src="../upload/image.png" class="card-img-top" alt="...">
        <div class="card-body">
          <p class="card-text">Some quick example t</p>
        </div>
      </div>
    </div>
  <div class="col-3">
    <div class="card" >
      <img src="../upload/image.png" class="card-img-top" alt="...">
      <div class="card-body">
        <p class="card-text">Some quick example t</p>
      </div>
    </div>
  </div>

  <div class="filmstrip my-2"></div>

  <!-- BOOKING PANEL -->
  <section class="py-5" id="booking">
    <h2 class="font-display fs-1 mb-4">ជ្រើសរើសកៅអី</h2>
    <div class="card border shadow-sm p-3 p-md-4" style="border-color:var(--surface-line);">
      <div class="row g-4 mb-4">
        <div class="col-auto">
          <div class="poster-wrap rounded" style="width:150px; background-image:url('https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=400&q=60')"></div>
        </div>
        <div class="col">
          <h3 class="font-display fs-1">Superman</h3>
          <p class="text-muted mb-3" style="max-width:600px;">សុភវីរបុរសមកពី Krypton ត្រូវប្រយុទ្ធដើម្បីការពារពិភពលោក ខណៈគាត់ស្វែងរកអត្តសញ្ញាណពិតរបស់ខ្លួន។</p>
          <div class="d-flex gap-2 flex-wrap mb-3">
            <span class="badge badge-tag rounded-pill px-3 py-2">Action</span>
            <span class="badge badge-tag rounded-pill px-3 py-2">Room A</span>
            <span class="badge badge-tag rounded-pill px-3 py-2">25/07/2026</span>
          </div>
          <div class="btn-group flex-wrap" role="group">
            <input type="radio" class="btn-check" name="showtime" id="st1" checked>
            <label class="btn btn-outline-cinema font-mono" for="st1">1:00 PM</label>
            <input type="radio" class="btn-check" name="showtime" id="st2">
            <label class="btn btn-outline-cinema font-mono" for="st2">4:15 PM</label>
            <input type="radio" class="btn-check" name="showtime" id="st3">
            <label class="btn btn-outline-cinema font-mono" for="st3">7:30 PM</label>
            <input type="radio" class="btn-check" name="showtime" id="st4">
            <label class="btn btn-outline-cinema font-mono" for="st4">10:00 PM</label>
          </div>
        </div>
      </div>

      <div class="screen-arc"></div>
      <p class="text-center small text-muted mb-4" style="letter-spacing:4px;">SCREEN</p>
      <div class="seat-map mb-4" id="seatMap"></div>
      <div class="d-flex justify-content-center gap-4 small text-muted mb-4">
        <span><i class="legend-swatch" style="background:#e9e3d6"></i> ទំនេរ</span>
        <span><i class="legend-swatch" style="background:var(--marquee)"></i> បានជ្រើសរើស</span>
        <span><i class="legend-swatch" style="background:#f0cdd0"></i> បានកក់រួច</span>
      </div>

      <div class="d-flex flex-wrap justify-content-between align-items-center border-top pt-4" style="border-color:var(--surface-line) !important;">
        <div class="text-muted">
          សរុប (<span id="seatCount">0</span> កៅអី)
          <div class="font-mono fs-3 text-marquee fw-bold" id="totalPrice">$0.00</div>
        </div>
        <button class="btn btn-velvet btn-lg px-4" data-bs-toggle="modal" data-bs-target="#ticketModal" onclick="confirmBooking()">បញ្ជាក់ការកក់</button>
      </div>
    </div>
  </section>

  <div class="filmstrip my-2"></div>

  <!-- HISTORY -->
  <section class="py-5" id="history">
    <h2 class="font-display fs-1 mb-4">ប្រវត្តិការកក់</h2>
    <div class="card border shadow-sm" style="border-color:var(--surface-line);">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr class="text-muted small text-uppercase">
              <th>ភាពយន្ត</th><th>ថ្ងៃ</th><th>ម៉ោង</th><th>កៅអី</th><th>ស្ថានភាព</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Spider-Verse</td><td>18/07/2026</td><td>7:30 PM</td><td class="font-mono">C4, C5</td><td><span class="badge rounded-pill" style="background:rgba(47,157,99,.15); color:#2f9d63;">Confirmed</span></td></tr>
            <tr><td>The Grudge Returns</td><td>12/07/2026</td><td>10:00 PM</td><td class="font-mono">F2</td><td><span class="badge rounded-pill" style="background:rgba(47,157,99,.15); color:#2f9d63;">Confirmed</span></td></tr>
            <tr><td>Only You</td><td>02/07/2026</td><td>4:15 PM</td><td class="font-mono">D6, D7</td><td><span class="badge rounded-pill" style="background:rgba(47,157,99,.15); color:#2f9d63;">Confirmed</span></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</main>

<footer class="text-center text-muted small py-5 border-top" style="border-color:var(--surface-line) !important;">
  © 2026 CINÉ MARQUEE — Cinema Ticket Booking System · Team 4
</footer>

<!-- TICKET MODAL -->
<div class="modal fade" id="ticketModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius:12px;">
      <div class="d-flex">
        <div class="flex-grow-1 p-4 position-relative">
          <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
          <div class="text-marquee fw-bold small mb-2" style="letter-spacing:2px;">BOOKING CONFIRMED</div>
          <h3 class="font-display fs-1 mb-3">Superman</h3>
          <div class="dashed-row d-flex justify-content-between py-2 small"><span class="text-muted">Room</span><span class="font-mono fw-semibold">Room A</span></div>
          <div class="dashed-row d-flex justify-content-between py-2 small"><span class="text-muted">Date</span><span class="font-mono fw-semibold">25/07/2026</span></div>
          <div class="dashed-row d-flex justify-content-between py-2 small"><span class="text-muted">Time</span><span class="font-mono fw-semibold" id="tTime">7:30 PM</span></div>
          <div class="d-flex justify-content-between py-2 small"><span class="text-muted">Seats</span><span class="font-mono fw-semibold" id="tSeats">—</span></div>
          <div class="d-flex justify-content-between py-2 small"><span class="text-muted">Total</span><span class="font-mono fw-bold text-marquee" id="tTotal">$0.00</span></div>
        </div>
        <div class="ticket-stub"><span>ADMIT ONE</span></div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>