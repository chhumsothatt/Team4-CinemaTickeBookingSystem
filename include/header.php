
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
<script src="../jquery/jquery-3.7.1.min.js"> </script>

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
  .btn-primary{
    background-color: #C9932E !important;
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
    position:relative; min-height:82vh; display:flex; align-items:flex-end;
    background:
      linear-gradient(180deg, rgba(34,28,40,.2) 0%, rgba(250,248,242,.98) 90%),
      radial-gradient(ellipse at 30% 20%, rgba(179,36,46,.35), transparent 55%),
      url('../upload/background.png') center/cover;
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
