<!DOCTYPE html>
<html lang="km">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ព្រះអាទិត្យ Cinema — កក់សំបុត្រកុន</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --void:#faf8f2;
    --surface:#ffffff;
    --surface-raised:#f3efe4;
    --surface-line: #e5ded0;
    --marquee:#c9932e;
    --marquee-dim:#a3812f;
    --velvet:#b3242e;
    --velvet-bright:#d93244;
    --ink:#221c28;
    --ink-muted:#726a80;
    --seat-open:#e9e3d6;
    --seat-taken:#f0cdd0;
    --font-display:'Bebas Neue', 'Noto Sans Khmer', sans-serif;
    --font-body:'Inter','Noto Sans Khmer',sans-serif;
    --font-mono:'JetBrains Mono', monospace;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html{scroll-behavior:smooth;}
  body{
    background:var(--void);
    color:var(--ink);
    font-family:var(--font-body);
    line-height:1.5;
    -webkit-font-smoothing:antialiased;
  }
  a{color:inherit; text-decoration:none;}
  img{max-width:100%; display:block;}
  .wrap{max-width:1180px; margin:0 auto; padding:0 28px;}

  /* film strip perforation divider — reused as the page's structural signature */
  .filmstrip{
    height:22px;
    background:
      repeating-linear-gradient(90deg, var(--void) 0 10px, transparent 10px 22px),
      var(--surface-line);
    background-size: 22px 100%, 100% 100%;
    position:relative;
  }
  .filmstrip::before, .filmstrip::after{
    content:"";
    position:absolute; top:50%; left:0; right:0;
    height:8px; transform:translateY(-50%);
    background: repeating-linear-gradient(90deg, var(--void) 0 8px, transparent 8px 22px);
  }
  .filmstrip::before{ top:3px; }
  .filmstrip::after{ bottom:3px; top:auto; }

  /* header */
  header{
    position:sticky; top:0; z-index:50;
    background:rgba(13,11,16,0.92);
    backdrop-filter:blur(10px);
    border-bottom:1px solid var(--surface-line);
  }
  .nav{
    display:flex; align-items:center; justify-content:space-between;
    padding:18px 0;
  }
  .logo{
    font-family:var(--font-display);
    font-size:28px; letter-spacing:1.5px;
    color:var(--marquee);
    display:flex; align-items:center; gap:10px;
  }
  .logo span{color:var(--ink);}
  .logo .bulb{width:8px;height:8px;border-radius:50%;background:var(--marquee); box-shadow:0 0 8px 2px var(--marquee); animation:blink 1.6s infinite ease-in-out;}
  @keyframes blink{0%,100%{opacity:1;}50%{opacity:.35;}}
  .navlinks{display:flex; align-items:center; gap:32px; font-size:14px; font-weight:600; letter-spacing:.3px;}
  .navlinks a{color:var(--ink-muted); transition:color .2s;}
  .navlinks a:hover, .navlinks a.active{color:var(--marquee);}
  .navcta{display:flex; gap:12px;}
  .btn{
    display:inline-flex; align-items:center; justify-content:center;
    padding:10px 20px; border-radius:3px; font-weight:700; font-size:14px;
    letter-spacing:.3px; cursor:pointer; border:1px solid transparent;
    transition:transform .15s ease, box-shadow .15s ease;
  }
  .btn:active{transform:translateY(1px);}
  .btn-ghost{border-color:var(--surface-line); color:var(--ink);}
  .btn-ghost:hover{border-color:var(--marquee-dim);}
  .btn-primary{background:var(--velvet); color:#fff;}
  .btn-primary:hover{background:var(--velvet-bright); box-shadow:0 4px 20px -6px var(--velvet-bright);}
  .btn-gold{background:var(--marquee); color:#1a1408;}
  .btn-gold:hover{box-shadow:0 4px 20px -6px var(--marquee);}

  /* hero / marquee */
  .hero{
    position:relative;
    min-height:560px;
    display:flex; align-items:flex-end;
    background:
      linear-gradient(180deg, rgba(13,11,16,0.2) 0%, rgba(13,11,16,0.98) 88%),
      radial-gradient(ellipse at 30% 20%, rgba(179,36,46,0.35), transparent 55%),
      linear-gradient(135deg, #241f2c, #14111a);
    overflow:hidden;
  }
  .hero::before{
    content:"NOW SHOWING";
    position:absolute; top:36px; right:-56px;
    background:var(--velvet); color:#fff;
    font-family:var(--font-display); font-size:14px; letter-spacing:3px;
    padding:8px 70px; transform:rotate(38deg);
    box-shadow:0 4px 14px rgba(0,0,0,.4);
  }
  .hero-inner{padding:64px 0 56px; position:relative; z-index:2; width:100%;}
  .eyebrow{
    display:inline-flex; gap:8px; align-items:center;
    color:var(--marquee); font-weight:700; font-size:13px; letter-spacing:2px;
    margin-bottom:14px; text-transform:uppercase;
  }
  .eyebrow::before{content:"●"; font-size:9px;}
  .hero h1{
    font-family:var(--font-display);
    font-size:clamp(48px, 8vw, 96px);
    line-height:.95; letter-spacing:1px;
    max-width:820px; color:var(--ink);
    text-shadow:0 6px 30px rgba(0,0,0,.5);
  }
  .hero-meta{display:flex; gap:22px; margin:22px 0 28px; flex-wrap:wrap; font-size:14px; color:var(--ink-muted);}
  .hero-meta b{color:var(--ink); font-weight:600;}
  .tag{
    display:inline-block; padding:4px 12px; border:1px solid var(--marquee-dim);
    border-radius:999px; color:var(--marquee); font-size:12px; font-weight:700; letter-spacing:.5px;
  }
  .hero-actions{display:flex; gap:14px;}

  /* search + filter */
  .filter-bar{
    padding:36px 0 20px;
    display:flex; gap:16px; flex-wrap:wrap; align-items:center;
  }
  .search-box{
    flex:1; min-width:240px; position:relative;
  }
  .search-box input{
    width:100%; background:var(--surface); border:1px solid var(--surface-line);
    color:var(--ink); padding:13px 16px 13px 42px; border-radius:4px; font-size:14px;
    font-family:var(--font-body);
  }
  .search-box input::placeholder{color:var(--ink-muted);}
  .search-box input:focus{outline:2px solid var(--marquee-dim); outline-offset:1px;}
  .search-box svg{position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; stroke:var(--ink-muted);}
  select.filter-select{
    background:var(--surface); border:1px solid var(--surface-line); color:var(--ink);
    padding:12px 14px; border-radius:4px; font-size:14px; font-family:var(--font-body); cursor:pointer;
  }
  #search-status{font-size:13px; color:var(--ink-muted); padding:6px 0 0; min-height:18px;}

  /* section headers */
  .section{padding:20px 0 64px;}
  .section-head{display:flex; align-items:baseline; justify-content:space-between; margin-bottom:26px;}
  .section-head h2{font-family:var(--font-display); font-size:34px; letter-spacing:.5px;}
  .section-head .count{font-size:13px; color:var(--ink-muted); font-family:var(--font-mono);}

  /* movie grid */
  .grid{display:grid; grid-template-columns:repeat(auto-fill, minmax(210px,1fr)); gap:22px;}
  .card{
    background:var(--surface); border:1px solid var(--surface-line); border-radius:6px;
    overflow:hidden; cursor:pointer; transition:transform .2s ease, border-color .2s ease;
  }
  .card:hover{transform:translateY(-4px); border-color:var(--marquee-dim);}
  .poster{
    aspect-ratio:2/3; background-size:cover; background-position:center;
    position:relative; display:flex; align-items:flex-end; padding:12px;
  }
  .poster::after{
    content:""; position:absolute; inset:0;
    background:linear-gradient(180deg, transparent 40%, rgba(13,11,16,.9) 100%);
  }
  .poster .cat{position:relative; z-index:2; font-size:11px; font-weight:700; letter-spacing:1px; color:var(--marquee); background:rgba(13,11,16,.7); padding:3px 9px; border-radius:999px;}
  .card-body{padding:14px 16px 18px;}
  .card-body h3{font-size:16px; font-weight:700; margin-bottom:4px;}
  .card-body p{font-size:12.5px; color:var(--ink-muted); display:flex; gap:6px; align-items:center;}
  .card-body p::before{content:"⏱"; font-size:11px;}

  /* booking panel (movie detail + seats) */
  .booking-panel{
    background:var(--surface); border:1px solid var(--surface-line); border-radius:8px;
    padding:34px; margin-top:10px;
  }
  .bp-head{display:grid; grid-template-columns:180px 1fr; gap:28px; margin-bottom:30px;}
  .bp-poster{border-radius:6px; overflow:hidden; aspect-ratio:2/3; background-size:cover; background-position:center;}
  .bp-info h2{font-family:var(--font-display); font-size:38px; letter-spacing:.5px; margin-bottom:8px;}
  .bp-info p.desc{color:var(--ink-muted); font-size:14px; max-width:620px; margin-bottom:14px;}
  .chips{display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px;}
  .showtime-row{display:flex; gap:10px; flex-wrap:wrap;}
  .show-btn{
    padding:9px 16px; border-radius:4px; border:1px solid var(--surface-line);
    background:var(--surface-raised); font-family:var(--font-mono); font-size:13px; font-weight:600; cursor:pointer;
  }
  .show-btn.active, .show-btn:hover{border-color:var(--marquee); color:var(--marquee);}

  .screen{
    margin:8px auto 30px; width:70%; height:8px; border-radius:50%;
    background:radial-gradient(ellipse at center, rgba(232,177,77,.5), transparent 75%);
    position:relative;
  }
  .screen::before{content:"SCREEN"; position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:10px; letter-spacing:4px; color:var(--marquee-dim); top:-16px;}

  .seat-map{display:grid; grid-template-columns:repeat(10, 1fr); gap:9px; max-width:520px; margin:0 auto 22px;}
  .seat{
    aspect-ratio:1; border-radius:5px 5px 8px 8px; background:var(--seat-open);
    display:flex; align-items:center; justify-content:center; font-size:10px; font-family:var(--font-mono);
    color:var(--ink-muted); cursor:pointer; border:1px solid transparent; transition:.15s;
  }
  .seat:hover{border-color:var(--marquee-dim);}
  .seat.taken{background:var(--seat-taken); color:#e0b9bc; cursor:not-allowed; opacity:.6;}
  .seat.selected{background:var(--marquee); color:#1a1408; font-weight:700; border-color:var(--marquee);}
  .seat-legend{display:flex; gap:24px; justify-content:center; font-size:12px; color:var(--ink-muted); margin-bottom:28px;}
  .seat-legend span{display:inline-flex; align-items:center; gap:7px;}
  .legend-swatch{width:13px; height:13px; border-radius:3px;}

  .bp-footer{display:flex; align-items:center; justify-content:space-between; border-top:1px solid var(--surface-line); padding-top:22px; flex-wrap:wrap; gap:16px;}
  .price-summary{font-size:14px; color:var(--ink-muted);}
  .price-summary b{color:var(--marquee); font-family:var(--font-mono); font-size:20px; display:block; margin-top:2px;}

  /* ticket stub — signature confirmation element */
  .ticket-overlay{
    position:fixed; inset:0; background:rgba(8,6,10,.82); backdrop-filter:blur(4px);
    display:none; align-items:center; justify-content:center; z-index:100; padding:20px;
  }
  .ticket-overlay.show{display:flex;}
  .ticket{
    display:flex; background:var(--surface-raised); border-radius:10px; overflow:hidden;
    max-width:520px; width:100%; box-shadow:0 30px 80px rgba(0,0,0,.6);
    animation:ticketIn .35s ease;
  }
  @keyframes ticketIn{from{opacity:0; transform:translateY(16px) scale(.97);} to{opacity:1; transform:none;}}
  .ticket-main{flex:1; padding:30px 26px;}
  .ticket-main .tstat{color:var(--marquee); font-size:12px; letter-spacing:2px; font-weight:700; margin-bottom:6px;}
  .ticket-main h3{font-family:var(--font-display); font-size:30px; letter-spacing:.5px; margin-bottom:16px;}
  .ticket-row{display:flex; justify-content:space-between; font-size:13px; padding:8px 0; border-bottom:1px dashed var(--surface-line);}
  .ticket-row span:first-child{color:var(--ink-muted);}
  .ticket-row span:last-child{font-family:var(--font-mono); font-weight:600;}
  .ticket-stub{
    width:110px; background:repeating-linear-gradient(180deg, var(--void) 0 8px, transparent 8px 16px), var(--marquee);
    background-size: 100% 16px, 100% 100%;
    display:flex; align-items:center; justify-content:center; position:relative;
  }
  .ticket-stub span{
    writing-mode:vertical-rl; font-family:var(--font-display); font-size:18px; letter-spacing:3px; color:#1a1408;
  }
  .ticket-close{position:absolute; top:14px; right:16px; background:none; border:none; color:var(--ink-muted); font-size:20px; cursor:pointer;}

  /* history */
  .history-table{width:100%; border-collapse:collapse; font-size:13.5px;}
  .history-table th{text-align:left; padding:12px 14px; color:var(--ink-muted); font-weight:600; border-bottom:1px solid var(--surface-line); text-transform:uppercase; font-size:11px; letter-spacing:1px;}
  .history-table td{padding:14px; border-bottom:1px solid var(--surface-line);}
  .status-pill{padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700;}
  .status-confirmed{background:rgba(232,177,77,.15); color:var(--marquee);}

  footer{border-top:1px solid var(--surface-line); padding:40px 0; text-align:center; color:var(--ink-muted); font-size:13px;}

  @media (max-width:760px){
    .navlinks{display:none;}
    .bp-head{grid-template-columns:1fr;}
    .bp-poster{max-width:160px;}
    .seat-map{grid-template-columns:repeat(8,1fr);}
  }
</style>
</head>
<body>

<header>
  <div class="wrap nav">
    <div class="logo"><span class="bulb"></span>CINÉ<span>MARQUEE</span></div>
    <nav class="navlinks">
      <a href="#movies" class="active">ភាពយន្ត</a>
      <a href="#booking">កក់សំបុត្រ</a>
      <a href="#history">ប្រវត្តិកក់</a>
    </nav>
    <div class="navcta">
      <button class="btn btn-ghost">ចូល / Login</button>
      <button class="btn btn-gold">ចុះឈ្មោះ</button>
    </div>
  </div>
</header>
<div class="filmstrip"></div>

<section class="hero" id="top" style="background-image:linear-gradient(180deg, rgba(13,11,16,0.15) 0%, rgba(13,11,16,0.98) 88%), radial-gradient(ellipse at 30% 20%, rgba(179,36,46,0.35), transparent 55%), url('https://images.unsplash.com/photo-1489599162946-9f6f0b3f6b2f?w=1400&q=60'); background-size:cover; background-position:center;">
  <div class="wrap hero-inner">
    <div class="eyebrow">Room A · 7:30 PM Tonight</div>
    <h1>SUPERMAN</h1>
    <div class="hero-meta">
      <span class="tag">Action</span>
      <span><b>128</b> នាទី</span>
      <span>Release <b>25/07/2026</b></span>
    </div>
    <div class="hero-actions">
      <button class="btn btn-primary" onclick="document.getElementById('booking').scrollIntoView({behavior:'smooth'})">កក់សំបុត្រឥឡូវនេះ</button>
      <button class="btn btn-ghost">មើល Trailer</button>
    </div>
  </div>
</section>

<main class="wrap">

  <!-- search + filter -->
  <div class="filter-bar" id="movies">
    <div class="search-box">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
      <input id="movieSearch" type="text" placeholder="ស្វែងរកភាពយន្ត... ឧ. Spi" oninput="liveSearch()">
    </div>
    <select class="filter-select" id="catFilter" onchange="liveSearch()">
      <option value="">គ្រប់ប្រភេទ</option>
      <option>Action</option><option>Horror</option><option>Comedy</option><option>Romance</option><option>Animation</option>
    </select>
    <select class="filter-select" id="roomFilter" onchange="liveSearch()">
      <option value="">គ្រប់បន្ទប់</option>
      <option>Room A</option><option>Room B</option><option>VIP Room</option>
    </select>
  </div>
  <div class="wrap" style="padding:0"><div id="search-status"></div></div>

  <section class="section">
    <div class="section-head">
      <h2>កំពុងបញ្ចាំង</h2>
      <span class="count" id="resultCount">6 movies</span>
    </div>
    <div class="grid" id="movieGrid"></div>
  </section>

  <div class="filmstrip"></div>

  <!-- booking / seat selection -->
  <section class="section" id="booking">
    <div class="section-head"><h2>ជ្រើសរើសកៅអី</h2></div>
    <div class="booking-panel">
      <div class="bp-head">
        <div class="bp-poster" style="background-image:url('https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=400&q=60')"></div>
        <div class="bp-info">
          <h2>Superman</h2>
          <p class="desc">សុភវីរបុរសមកពី Krypton ត្រូវប្រយុទ្ធដើម្បីការពារពិភពលោក ខណៈគាត់ស្វែងរកអត្តសញ្ញាណពិតរបស់ខ្លួន។</p>
          <div class="chips"><span class="tag">Action</span><span class="tag">Room A</span><span class="tag">25/07/2026</span></div>
          <div class="showtime-row">
            <button class="show-btn active">1:00 PM</button>
            <button class="show-btn">4:15 PM</button>
            <button class="show-btn">7:30 PM</button>
            <button class="show-btn">10:00 PM</button>
          </div>
        </div>
      </div>

      <div class="screen"></div>
      <div class="seat-map" id="seatMap"></div>
      <div class="seat-legend">
        <span><i class="legend-swatch" style="background:var(--seat-open)"></i>ទំនេរ</span>
        <span><i class="legend-swatch" style="background:var(--marquee)"></i>បានជ្រើសរើស</span>
        <span><i class="legend-swatch" style="background:var(--seat-taken)"></i>បានកក់រួច</span>
      </div>

      <div class="bp-footer">
        <div class="price-summary">សរុប (<span id="seatCount">0</span> កៅអី)<b id="totalPrice">$0.00</b></div>
        <button class="btn btn-primary" onclick="confirmBooking()">បញ្ជាក់ការកក់</button>
      </div>
    </div>
  </section>

  <div class="filmstrip"></div>

  <!-- history -->
  <section class="section" id="history">
    <div class="section-head"><h2>ប្រវត្តិការកក់</h2></div>
    <div class="booking-panel" style="padding:8px 8px;">
      <table class="history-table">
        <thead><tr><th>ភាពយន្ត</th><th>ថ្ងៃ</th><th>ម៉ោង</th><th>កៅអី</th><th>ស្ថានភាព</th></tr></thead>
        <tbody>
          <tr><td>Spider-Verse</td><td>18/07/2026</td><td>7:30 PM</td><td>C4, C5</td><td><span class="status-pill status-confirmed">Confirmed</span></td></tr>
          <tr><td>The Grudge Returns</td><td>12/07/2026</td><td>10:00 PM</td><td>F2</td><td><span class="status-pill status-confirmed">Confirmed</span></td></tr>
          <tr><td>Only You</td><td>02/07/2026</td><td>4:15 PM</td><td>D6, D7</td><td><span class="status-pill status-confirmed">Confirmed</span></td></tr>
        </tbody>
      </table>
    </div>
  </section>
</main>

<footer>
  <div class="wrap">© 2026 CINÉ MARQUEE — Cinema Ticket Booking System · Team 4</div>
</footer>

<!-- ticket confirmation overlay -->
<div class="ticket-overlay" id="ticketOverlay">
  <div class="ticket">
    <div class="ticket-main">
      <button class="ticket-close" onclick="closeTicket()">✕</button>
      <div class="tstat">BOOKING CONFIRMED</div>
      <h3>Superman</h3>
      <div class="ticket-row"><span>Room</span><span>Room A</span></div>
      <div class="ticket-row"><span>Date</span><span>25/07/2026</span></div>
      <div class="ticket-row"><span>Time</span><span id="tTime">7:30 PM</span></div>
      <div class="ticket-row"><span>Seats</span><span id="tSeats">—</span></div>
      <div class="ticket-row" style="border-bottom:none;"><span>Total</span><span id="tTotal">$0.00</span></div>
    </div>
    <div class="ticket-stub"><span>ADMIT ONE</span></div>
  </div>
</div>

<script>
  // --- mock data (replace with API / Laravel backend) ---
  const movies = [
    {title:"Superman", cat:"Action", room:"Room A", duration:128, poster:"https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=400&q=60"},
    {title:"Spider-Verse", cat:"Animation", room:"Room B", duration:140, poster:"https://images.unsplash.com/photo-1531259683007-016a7b628fc3?w=400&q=60"},
    {title:"The Grudge Returns", cat:"Horror", room:"VIP Room", duration:102, poster:"https://images.unsplash.com/photo-1509281373149-e957c6296406?w=400&q=60"},
    {title:"Only You", cat:"Romance", room:"Room A", duration:110, poster:"https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=400&q=60"},
    {title:"Laugh Track", cat:"Comedy", room:"Room B", duration:95, poster:"https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=400&q=60"},
    {title:"Spider-Man: Homecoming", cat:"Action", room:"VIP Room", duration:133, poster:"https://images.unsplash.com/photo-1608889825205-eebdb9fc5806?w=400&q=60"},
  ];

  function renderMovies(list){
    const grid = document.getElementById('movieGrid');
    grid.innerHTML = list.map(m => `
      <div class="card" onclick="document.getElementById('booking').scrollIntoView({behavior:'smooth'})">
        <div class="poster" style="background-image:url('${m.poster}')"><span class="cat">${m.cat}</span></div>
        <div class="card-body">
          <h3>${m.title}</h3>
          <p>${m.duration} នាទី · ${m.room}</p>
        </div>
      </div>
    `).join('');
    document.getElementById('resultCount').textContent = list.length + ' movies';
  }
  renderMovies(movies);

  function liveSearch(){
    const q = document.getElementById('movieSearch').value.trim().toLowerCase();
    const cat = document.getElementById('catFilter').value;
    const room = document.getElementById('roomFilter').value;
    const filtered = movies.filter(m =>
      m.title.toLowerCase().includes(q) &&
      (!cat || m.cat === cat) &&
      (!room || m.room === room)
    );
    renderMovies(filtered);
    document.getElementById('search-status').textContent = q ? `លទ្ធផលសម្រាប់ "${q}"` : '';
  }

  // --- seat map ---
  const takenSeats = ['A3','A4','B6','C1','D8','E5','F2','F3'];
  const rows = ['A','B','C','D','E','F'];
  let selected = [];
  const seatMap = document.getElementById('seatMap');
  rows.forEach(r => {
    for(let i=1;i<=10;i++){
      const id = r+i;
      const el = document.createElement('div');
      el.className = 'seat' + (takenSeats.includes(id) ? ' taken' : '');
      el.textContent = id;
      el.onclick = () => toggleSeat(id, el);
      seatMap.appendChild(el);
    }
  });
  function toggleSeat(id, el){
    if(el.classList.contains('taken')) return;
    el.classList.toggle('selected');
    selected = selected.includes(id) ? selected.filter(s=>s!==id) : [...selected, id];
    document.getElementById('seatCount').textContent = selected.length;
    document.getElementById('totalPrice').textContent = '$' + (selected.length * 5).toFixed(2);
  }

  function confirmBooking(){
    if(selected.length === 0){ alert('សូមជ្រើសរើសកៅអីយ៉ាងហោចណាស់មួយ'); return; }
    document.getElementById('tSeats').textContent = selected.join(', ');
    document.getElementById('tTotal').textContent = '$' + (selected.length * 5).toFixed(2);
    document.getElementById('ticketOverlay').classList.add('show');
  }
  function closeTicket(){ document.getElementById('ticketOverlay').classList.remove('show'); }
</script>
</body>
</html>