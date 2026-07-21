<!DOCTYPE html>
<html lang="km">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Controller — CINÉ MARQUEE</title>

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
    --ok:#2f9d63;
    --ink:#221c28;
    --ink-muted:#726a80;
    --sidebar-w:250px;
    --font-display:'Bebas Neue','Noto Sans Khmer',sans-serif;
    --font-mono:'JetBrains Mono', monospace;
  }
  body{background:var(--void); color:var(--ink); font-family:'Inter','Noto Sans Khmer',sans-serif;}
  .font-display{font-family:var(--font-display); letter-spacing:.5px;}
  .font-mono{font-family:var(--font-mono);}
  .text-marquee{color:var(--marquee) !important;}
  .btn-marquee{background:var(--marquee); border-color:var(--marquee); color:#1a1408; font-weight:700;}
  .btn-marquee:hover{background:var(--marquee-dim); border-color:var(--marquee-dim); color:#1a1408;}
  .btn-outline-cinema{border-color:var(--surface-line); color:var(--ink);}
  .btn-outline-cinema:hover{border-color:var(--marquee-dim); color:var(--marquee-dim);}

  .filmstrip-thin{height:6px; background:repeating-linear-gradient(90deg, var(--void) 0 8px, transparent 8px 18px), var(--surface-line); background-size:18px 100%, 100% 100%;}

  /* ---------- sidebar ---------- */
  .sidebar{
    width:var(--sidebar-w); background:#fff; border-right:1px solid var(--surface-line);
    position:fixed; top:0; left:0; bottom:0; z-index:1030; display:flex; flex-direction:column;
  }
  .brand{padding:22px; border-bottom:1px solid var(--surface-line);}
  .brand .bulb{width:7px;height:7px;border-radius:50%;background:var(--marquee); box-shadow:0 0 8px 2px var(--marquee); display:inline-block; animation:blink 1.6s infinite ease-in-out;}
  @keyframes blink{0%,100%{opacity:1;}50%{opacity:.3;}}

  .sidebar .nav-link{color:var(--ink-muted); font-weight:500; font-size:14px; border-left:2px solid transparent; border-radius:6px; padding:.6rem .75rem; display:flex; align-items:center; gap:10px;}
  .sidebar .nav-link:hover{background:var(--void); color:var(--ink);}
  .sidebar .nav-link.active{background:var(--void); color:var(--marquee); border-left-color:var(--marquee);}
  .nav-section-label{font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:var(--ink-muted); padding:6px 12px;}

  .sidebar-footer{margin-top:auto; padding:16px 18px; border-top:1px solid var(--surface-line); display:flex; align-items:center; gap:10px;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--velvet),var(--marquee)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; color:#fff;}

  .main-content{margin-left:var(--sidebar-w);}
  .topbar{background:rgba(250,248,242,.92); backdrop-filter:blur(8px); border-bottom:1px solid var(--surface-line); position:sticky; top:0; z-index:1020;}

  .view{display:none;}
  .view.active{display:block;}

  .stat-card{border:1px solid var(--surface-line); border-top:3px solid var(--accent, var(--marquee)); border-radius:.5rem;}
  .stat-card .value{font-family:var(--font-display); font-size:36px;}
  .stat-card .delta{font-size:12px; color:var(--ok); font-family:var(--font-mono);}

  .bars{display:flex; align-items:flex-end; gap:10px; height:150px;}
  .bar-col{flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; height:100%; justify-content:flex-end;}
  .bar{width:100%; border-radius:4px 4px 0 0; background:linear-gradient(180deg, var(--marquee), var(--marquee-dim));}

  table thead th{font-size:10.5px; text-transform:uppercase; letter-spacing:1px; color:var(--ink-muted); border-bottom-width:1px !important;}
  .row-thumb{width:32px; height:44px; object-fit:cover; border-radius:4px;}

  .badge-cat{font-weight:700; font-size:11px;}
  .badge-action{background:rgba(201,147,46,.15); color:var(--marquee);}
  .badge-horror{background:rgba(179,36,46,.15); color:var(--velvet);}
  .badge-comedy{background:rgba(47,157,99,.15); color:var(--ok);}
  .badge-romance{background:rgba(224,56,74,.14); color:#c23a4e;}
  .badge-animation{background:rgba(163,129,47,.2); color:#8f6f26;}
  .badge-confirmed{background:rgba(47,157,99,.15); color:var(--ok); font-weight:700;}

  .upload-box{border:1.5px dashed var(--surface-line); border-radius:.5rem; padding:24px; text-align:center; color:var(--ink-muted); font-size:13px; cursor:pointer;}
  .upload-box:hover{border-color:var(--marquee-dim); color:var(--marquee-dim);}

  @media (max-width: 991.98px){
    .sidebar{transform:translateX(-100%); transition:transform .25s ease;}
    .sidebar.show{transform:translateX(0);}
    .main-content{margin-left:0;}
  }
</style>


</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="brand d-flex align-items-center gap-2 font-display fs-3">
    <span class="bulb"></span><span class="text-marquee">CINÉ</span><span class="fs-6 fw-normal">ADMIN</span>
  </div>

  <nav class="nav flex-column p-2 pt-3">
    <div class="nav-section-label">Overview</div>
    <a class="nav-link active" href="../admin/dashboard.php" data-view="dashboard"><i class="bi bi-grid-1x2"></i> Dashboard</a>

    <div class="nav-section-label mt-3"> Movies</div>
    <a class="nav-link" id="movie" href="../admin/movie.php" onclick="isClick()" data-view="movies"><i class="bi bi-film"></i> Movies</a>
    <a class="nav-link" id="category" href="../admin/category.php" onclick="isClick()" data-view="categories"><i class="bi bi-tags"></i> Categories</a>
    <a class="nav-link" id="room" href="../admin/room.php" onclick="isClick()" data-view="rooms"><i class="bi bi-door-open"></i> Cinema Rooms</a>
    <a class="nav-link" id="showtime" href="../admin/showtime.php" onclick="isClick()" data-view="showtimes" ><i class="bi bi-clock-history"></i> Showtimes</a>

    <div class="nav-section-label mt-3">Reports</div>
    <a class="nav-link" href="../admin/book_history.php" data-view="bookings"><i class="bi bi-ticket-perforated"></i> Booking History</a>
  </nav>

  <div class="sidebar-footer">
    <div class="avatar">SA</div>
    <div>
      <div class="fw-semibold small">Sok Admin</div>
      <div class="text-muted" style="font-size:11px;">Administrator</div>
    </div>
    <button class="btn btn-sm btn-outline-cinema ms-auto"><i class="bi bi-box-arrow-right"></i></button>
  </div>

</aside>