<!DOCTYPE html>
<html lang="km">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Controller — CINÉ MARQUEE</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --void: #faf8f2;
      --surface: #ffffff;
      --surface-raised: #f3efe4;
      --surface-line: #e5ded0;
      --marquee: #c9932e;
      --marquee-dim: #a3812f;
      --velvet: #b3242e;
      --velvet-bright: #d93244;
      --ok: #2f9d63;
      --ink: #221c28;
      --ink-muted: #726a80;
      --font-display: 'Bebas Neue', 'Noto Sans Khmer', sans-serif;
      --font-body: 'Inter', 'Noto Sans Khmer', sans-serif;
      --font-mono: 'JetBrains Mono', monospace;
      --sidebar-w: 250px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background: var(--void);
      color: var(--ink);
      font-family: var(--font-body);
      display: flex;
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    button {
      font-family: inherit;
      cursor: pointer;
    }

    /* ---------- sidebar ---------- */
    .sidebar {
      width: var(--sidebar-w);
      background: var(--surface);
      border-right: 1px solid var(--surface-line);
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      display: flex;
      flex-direction: column;
      z-index: 40;
    }

    .brand {
      padding: 26px 24px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: var(--font-display);
      font-size: 22px;
      letter-spacing: 1px;
      color: var(--marquee);
      border-bottom: 1px solid var(--surface-line);
    }

    .brand .bulb {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--marquee);
      box-shadow: 0 0 8px 2px var(--marquee);
      animation: blink 1.6s infinite ease-in-out;
    }

    @keyframes blink {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: .35;
      }
    }

    .brand span {
      color: var(--ink);
      font-size: 14px;
      align-self: flex-end;
      margin-left: 2px;
    }

    .nav-group {
      padding: 18px 14px;
    }

    .nav-label {
      font-size: 10.5px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--ink-muted);
      padding: 8px 12px 6px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 12px;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 500;
      color: var(--ink-muted);
      margin-bottom: 2px;
      transition: .15s;
      border-left: 2px solid transparent;
    }

    .nav-item svg {
      width: 17px;
      height: 17px;
      stroke: currentColor;
      flex-shrink: 0;
    }

    .nav-item:hover {
      background: var(--surface-raised);
      color: var(--ink);
    }

    .nav-item.active {
      background: var(--surface-raised);
      color: var(--marquee);
      border-left-color: var(--marquee);
    }

    .sidebar-footer {
      margin-top: auto;
      padding: 18px;
      border-top: 1px solid var(--surface-line);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--velvet), var(--marquee));
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 13px;
    }

    .sidebar-footer .who {
      font-size: 13px;
      font-weight: 600;
    }

    .sidebar-footer .role {
      font-size: 11px;
      color: var(--ink-muted);
    }

    .logout-btn {
      margin-left: auto;
      background: none;
      border: none;
      color: var(--ink-muted);
      font-size: 16px;
    }

    .logout-btn:hover {
      color: var(--velvet-bright);
    }

    /* ---------- main ---------- */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      min-width: 0;
    }

    .topbar {
      position: sticky;
      top: 0;
      z-index: 30;
      background: rgba(250, 248, 242, .92);
      backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--surface-line);
      padding: 20px 34px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .topbar h1 {
      font-family: var(--font-display);
      font-size: 26px;
      letter-spacing: .5px;
    }

    .topbar .sub {
      font-size: 12.5px;
      color: var(--ink-muted);
      margin-top: 2px;
    }

    .filmstrip-thin {
      height: 6px;
      background: repeating-linear-gradient(90deg, var(--void) 0 8px, transparent 8px 18px), var(--surface-line);
      background-size: 18px 100%, 100% 100%;
    }

    .content {
      padding: 30px 34px 60px;
    }

    .view {
      display: none;
    }

    .view.active {
      display: block;
    }

    /* stat cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 18px;
      margin-bottom: 34px;
    }

    .stat-card {
      background: var(--surface);
      border: 1px solid var(--surface-line);
      border-radius: 8px;
      padding: 22px;
      position: relative;
      overflow: hidden;
    }

    .stat-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: var(--accent, var(--marquee));
    }

    .stat-card .label {
      font-size: 12px;
      color: var(--ink-muted);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 10px;
    }

    .stat-card .value {
      font-family: var(--font-display);
      font-size: 38px;
      letter-spacing: .5px;
    }

    .stat-card .delta {
      font-size: 12px;
      color: var(--ok);
      margin-top: 6px;
      font-family: var(--font-mono);
    }

    .panel {
      background: var(--surface);
      border: 1px solid var(--surface-line);
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 26px;
    }

    .panel-head {
      padding: 18px 22px;
      border-bottom: 1px solid var(--surface-line);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .panel-head h3 {
      font-size: 16px;
      font-weight: 700;
    }

    .panel-head .hint {
      font-size: 12px;
      color: var(--ink-muted);
    }

    /* recent bookings + chart split */
    .dash-split {
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 22px;
      margin-bottom: 8px;
    }

    .bars {
      display: flex;
      align-items: flex-end;
      gap: 10px;
      height: 160px;
      padding: 22px;
    }

    .bar-col {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      height: 100%;
      justify-content: flex-end;
    }

    .bar {
      width: 100%;
      border-radius: 4px 4px 0 0;
      background: linear-gradient(180deg, var(--marquee), var(--marquee-dim));
    }

    .bar-col .lbl {
      font-size: 10.5px;
      color: var(--ink-muted);
      font-family: var(--font-mono);
    }

    /* tables */
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px;
    }

    th {
      text-align: left;
      padding: 12px 22px;
      color: var(--ink-muted);
      font-weight: 600;
      text-transform: uppercase;
      font-size: 10.5px;
      letter-spacing: 1px;
      border-bottom: 1px solid var(--surface-line);
    }

    td {
      padding: 13px 22px;
      border-bottom: 1px solid var(--surface-line);
      vertical-align: middle;
    }

    tr:last-child td {
      border-bottom: none;
    }

    .row-thumb {
      width: 34px;
      height: 46px;
      border-radius: 4px;
      background-size: cover;
      background-position: center;
      display: inline-block;
      vertical-align: middle;
      margin-right: 10px;
    }

    .cell-movie {
      display: flex;
      align-items: center;
    }

    .badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
    }

    .badge-action {
      background: rgba(232, 177, 77, .15);
      color: var(--marquee);
    }

    .badge-horror {
      background: rgba(179, 36, 46, .18);
      color: var(--velvet-bright);
    }

    .badge-comedy {
      background: rgba(76, 175, 125, .15);
      color: var(--ok);
    }

    .badge-romance {
      background: rgba(224, 56, 74, .14);
      color: #c23a4e;
    }

    .badge-animation {
      background: rgba(163, 129, 47, .2);
      color: #8f6f26;
    }

    .status-confirmed {
      background: rgba(76, 175, 125, .15);
      color: var(--ok);
      padding: 3px 10px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
    }

    .row-actions {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
    }

    .icon-btn {
      width: 30px;
      height: 30px;
      border-radius: 6px;
      border: 1px solid var(--surface-line);
      background: var(--surface-raised);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--ink-muted);
    }

    .icon-btn:hover {
      color: var(--marquee);
      border-color: var(--marquee-dim);
    }

    .icon-btn.danger:hover {
      color: var(--velvet-bright);
      border-color: var(--velvet);
    }

    .icon-btn svg {
      width: 14px;
      height: 14px;
      stroke: currentColor;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 18px;
      border-radius: 6px;
      font-weight: 700;
      font-size: 13px;
      border: 1px solid transparent;
    }

    .btn-gold {
      background: var(--marquee);
      color: #1a1408;
    }

    .btn-gold:hover {
      box-shadow: 0 4px 18px -6px var(--marquee);
    }

    .btn-outline {
      border-color: var(--surface-line);
      background: transparent;
      color: var(--ink);
    }

    .btn-outline:hover {
      border-color: var(--marquee-dim);
    }

    .toolbar {
      display: flex;
      gap: 12px;
      padding: 16px 22px;
      border-bottom: 1px solid var(--surface-line);
    }

    .toolbar input,
    .toolbar select {
      background: var(--surface-raised);
      border: 1px solid var(--surface-line);
      color: var(--ink);
      padding: 9px 12px;
      border-radius: 6px;
      font-size: 13px;
      font-family: inherit;
    }

    .toolbar input {
      flex: 1;
    }

    /* modal (add/edit) */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(8, 6, 10, .75);
      backdrop-filter: blur(3px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 100;
      padding: 20px;
    }

    .modal-overlay.show {
      display: flex;
    }

    .modal {
      background: var(--surface-raised);
      border: 1px solid var(--surface-line);
      border-radius: 10px;
      width: 100%;
      max-width: 520px;
      box-shadow: 0 30px 80px rgba(34, 28, 40, .25);
    }

    .modal-head {
      padding: 20px 24px;
      border-bottom: 1px solid var(--surface-line);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-head h3 {
      font-family: var(--font-display);
      font-size: 22px;
      letter-spacing: .5px;
    }

    .modal-close {
      background: none;
      border: none;
      color: var(--ink-muted);
      font-size: 18px;
    }

    .modal-body {
      padding: 22px 24px;
      display: grid;
      gap: 16px;
    }

    .field label {
      display: block;
      font-size: 12px;
      color: var(--ink-muted);
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .field input,
    .field select,
    .field textarea {
      width: 100%;
      background: var(--surface);
      border: 1px solid var(--surface-line);
      color: var(--ink);
      padding: 11px 13px;
      border-radius: 6px;
      font-size: 14px;
      font-family: inherit;
    }

    .field-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .upload-box {
      border: 1.5px dashed var(--surface-line);
      border-radius: 8px;
      padding: 24px;
      text-align: center;
      color: var(--ink-muted);
      font-size: 13px;
      cursor: pointer;
    }

    .upload-box:hover {
      border-color: var(--marquee-dim);
      color: var(--marquee);
    }

    .modal-footer {
      padding: 18px 24px;
      border-top: 1px solid var(--surface-line);
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    @media (max-width:1000px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .main {
        margin-left: 0;
      }

      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .dash-split {
        grid-template-columns: 1fr;
      }

      .field-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

  <aside class="sidebar">
    <div class="brand"><span class="bulb"></span>CINÉ<span>ADMIN</span></div>
    <div class="nav-group">
      <div class="nav-label">Overview</div>
      <div class="nav-item active" data-view="dashboard" onclick="showView('dashboard', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <rect x="3" y="3" width="7" height="9" rx="1" />
          <rect x="14" y="3" width="7" height="5" rx="1" />
          <rect x="14" y="12" width="7" height="9" rx="1" />
          <rect x="3" y="16" width="7" height="5" rx="1" />
        </svg>
        Dashboard
      </div>
    </div>
    <div class="nav-group">
      <div class="nav-label">Content</div>
      <div class="nav-item" data-view="movies" onclick="showView('movies', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <rect x="2" y="4" width="20" height="16" rx="2" />
          <path d="M7 4v16M17 4v16M2 9h5M17 9h5M2 15h5M17 15h5" />
        </svg>
        Movies
      </div>
      <div class="nav-item" data-view="categories" onclick="showView('categories', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <path d="M20.6 12.7L12.7 20.6a2 2 0 0 1-2.8 0L2 12.7V4a2 2 0 0 1 2-2h8.7l7.9 7.9a2 2 0 0 1 0 2.8z" />
          <circle cx="7" cy="7" r="1" />
        </svg>
        Categories
      </div>
      <div class="nav-item" data-view="rooms" onclick="showView('rooms', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <rect x="3" y="3" width="18" height="18" rx="2" />
          <path d="M3 9h18M9 21V9" />
        </svg>
        Cinema Rooms
      </div>
      <div class="nav-item" data-view="showtimes" onclick="showView('showtimes', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <circle cx="12" cy="12" r="9" />
          <path d="M12 7v5l3 3" />
        </svg>
        Showtimes
      </div>
    </div>
    <div class="nav-group">
      <div class="nav-label">Reports</div>
      <div class="nav-item" data-view="bookings" onclick="showView('bookings', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
          <path d="M9 2h6l1 4H8l1-4z" />
          <path d="M4 6h16l-1.5 14a2 2 0 0 1-2 2H7.5a2 2 0 0 1-2-2L4 6z" />
          <path d="M9 11h6M9 15h6" />
        </svg>
        Booking History
      </div>
    </div>
    <div class="sidebar-footer">
      <div class="avatar">SA</div>
      <div>
        <div class="who">Sok Admin</div>
        <div class="role">Administrator</div>
      </div>
      <button class="logout-btn" title="Logout">⏻</button>
    </div>
  </aside>

  <div class="main">

    <!-- ===================== DASHBOARD ===================== -->
    <div class="view active" id="view-dashboard">
      <div class="topbar">
        <div>
          <h1>Dashboard</h1>
          <div class="sub">ព័ត៌មានសង្ខេបប្រព័ន្ធកក់សំបុត្រកុន</div>
        </div>
        <button class="btn btn-gold">+ New Showtime</button>
      </div>
      <div class="filmstrip-thin"></div>
      <div class="content">
        <div class="stats-grid">
          <div class="stat-card" style="--accent:var(--marquee)">
            <div class="label">Movies</div>
            <div class="value">24</div>
            <div class="delta">▲ 3 this month</div>
          </div>
          <div class="stat-card" style="--accent:var(--velvet-bright)">
            <div class="label">Users</div>
            <div class="value">1,208</div>
            <div class="delta">▲ 86 this month</div>
          </div>
          <div class="stat-card" style="--accent:var(--ok)">
            <div class="label">Bookings</div>
            <div class="value">3,412</div>
            <div class="delta">▲ 214 this week</div>
          </div>
          <div class="stat-card" style="--accent:#8f7bd6">
            <div class="label">Cinema Rooms</div>
            <div class="value">6</div>
            <div class="delta">2 VIP rooms</div>
          </div>
        </div>

        <div class="dash-split">
          <div class="panel">
            <div class="panel-head">
              <h3>Recent Bookings</h3><span class="hint">Last 24 hours</span>
            </div>
            <table>
              <thead>
                <tr>
                  <th>User</th>
                  <th>Movie</th>
                  <th>Showtime</th>
                  <th>Seats</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="recentBookingsBody"></tbody>
            </table>
          </div>
          <div class="panel">
            <div class="panel-head">
              <h3>Bookings by Day</h3><span class="hint">This week</span>
            </div>
            <div class="bars" id="barsChart"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- ===================== MOVIES ===================== -->
    <div class="view" id="view-movies">
      <div class="topbar">
        <div>
          <h1>Movies</h1>
          <div class="sub">គ្រប់គ្រងព័ត៌មានភាពយន្ត</div>
        </div>
        <button class="btn btn-gold" onclick="openModal('movieModal')">+ Add Movie</button>
      </div>
      <div class="filmstrip-thin"></div>
      <div class="content">
        <div class="panel">
          <div class="toolbar">
            <input type="text" placeholder="Search movies...">
            <select>
              <option>All Categories</option>
              <option>Action</option>
              <option>Horror</option>
              <option>Comedy</option>
              <option>Romance</option>
              <option>Animation</option>
            </select>
          </div>
          <table>
            <thead>
              <tr>
                <th>Movie</th>
                <th>Category</th>
                <th>Duration</th>
                <th>Release Date</th>
                <th style="text-align:right">Actions</th>
              </tr>
            </thead>
            <tbody id="moviesBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ===================== CATEGORIES ===================== -->
    <div class="view" id="view-categories">
      <div class="topbar">
        <div>
          <h1>Categories</h1>
          <div class="sub">ប្រភេទភាពយន្ត</div>
        </div>
        <button class="btn btn-gold" onclick="openModal('categoryModal')">+ Add Category</button>
      </div>
      <div class="filmstrip-thin"></div>
      <div class="content">
        <div class="panel">
          <table>
            <thead>
              <tr>
                <th>Category</th>
                <th>Movies</th>
                <th style="text-align:right">Actions</th>
              </tr>
            </thead>
            <tbody id="categoriesBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ===================== ROOMS ===================== -->
    <div class="view" id="view-rooms">
      <div class="topbar">
        <div>
          <h1>Cinema Rooms</h1>
          <div class="sub">គ្រប់គ្រងបន្ទប់កុន</div>
        </div>
        <button class="btn btn-gold" onclick="openModal('roomModal')">+ Add Room</button>
      </div>
      <div class="filmstrip-thin"></div>
      <div class="content">
        <div class="panel">
          <table>
            <thead>
              <tr>
                <th>Room Name</th>
                <th>Capacity</th>
                <th>Active Showtimes</th>
                <th style="text-align:right">Actions</th>
              </tr>
            </thead>
            <tbody id="roomsBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ===================== SHOWTIMES ===================== -->
    <div class="view" id="view-showtimes">
      <div class="topbar">
        <div>
          <h1>Showtimes</h1>
          <div class="sub">កំណត់ម៉ោងបញ្ចាំង</div>
        </div>
        <button class="btn btn-gold" onclick="openModal('showtimeModal')">+ Add Showtime</button>
      </div>
      <div class="filmstrip-thin"></div>
      <div class="content">
        <div class="panel">
          <table>
            <thead>
              <tr>
                <th>Movie</th>
                <th>Room</th>
                <th>Date</th>
                <th>Time</th>
                <th style="text-align:right">Actions</th>
              </tr>
            </thead>
            <tbody id="showtimesBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ===================== BOOKINGS ===================== -->
    <div class="view" id="view-bookings">
      <div class="topbar">
        <div>
          <h1>Booking History</h1>
          <div class="sub">ប្រវត្តិការកក់សំបុត្រទាំងអស់</div>
        </div>
      </div>
      <div class="filmstrip-thin"></div>
      <div class="content">
        <div class="panel">
          <div class="toolbar">
            <input type="text" placeholder="Search by user or movie...">
            <select>
              <option>All Status</option>
              <option>Confirmed</option>
              <option>Cancelled</option>
            </select>
          </div>
          <table>
            <thead>
              <tr>
                <th>Booking #</th>
                <th>User</th>
                <th>Movie</th>
                <th>Showtime</th>
                <th>Seats</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="allBookingsBody"></tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <!-- ===================== MODALS ===================== -->
  <div class="modal-overlay" id="movieModal">
    <div class="modal">
      <div class="modal-head">
        <h3>Add Movie</h3><button class="modal-close" onclick="closeModal('movieModal')">✕</button>
      </div>
      <div class="modal-body">
        <div class="field"><label>Title</label><input type="text" placeholder="e.g. Superman"></div>
        <div class="field"><label>Description</label><textarea rows="3" placeholder="Short synopsis..."></textarea></div>
        <div class="field-row">
          <div class="field"><label>Category</label><select>
              <option>Action</option>
              <option>Horror</option>
              <option>Comedy</option>
              <option>Romance</option>
              <option>Animation</option>
            </select></div>
          <div class="field"><label>Duration (min)</label><input type="number" placeholder="128"></div>
        </div>
        <div class="field"><label>Release Date</label><input type="date"></div>
        <div class="field"><label>Poster</label>
          <div class="upload-box">Click or drag a poster image to upload<br><span style="font-size:11px">stored in /public/uploads · PNG/JPG</span></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('movieModal')">Cancel</button>
        <button class="btn btn-gold" onclick="closeModal('movieModal')">Save Movie</button>
      </div>
    </div>
  </div>

  <div class="modal-overlay" id="categoryModal">
    <div class="modal">
      <div class="modal-head">
        <h3>Add Category</h3><button class="modal-close" onclick="closeModal('categoryModal')">✕</button>
      </div>
      <div class="modal-body">
        <div class="field"><label>Category Name</label><input type="text" placeholder="e.g. Sci-Fi"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('categoryModal')">Cancel</button>
        <button class="btn btn-gold" onclick="closeModal('categoryModal')">Save Category</button>
      </div>
    </div>
  </div>

  <div class="modal-overlay" id="roomModal">
    <div class="modal">
      <div class="modal-head">
        <h3>Add Cinema Room</h3><button class="modal-close" onclick="closeModal('roomModal')">✕</button>
      </div>
      <div class="modal-body">
        <div class="field"><label>Room Name</label><input type="text" placeholder="e.g. Room C"></div>
        <div class="field"><label>Capacity</label><input type="number" placeholder="60"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('roomModal')">Cancel</button>
        <button class="btn btn-gold" onclick="closeModal('roomModal')">Save Room</button>
      </div>
    </div>
  </div>

  <div class="modal-overlay" id="showtimeModal">
    <div class="modal">
      <div class="modal-head">
        <h3>Add Showtime</h3><button class="modal-close" onclick="closeModal('showtimeModal')">✕</button>
      </div>
      <div class="modal-body">
        <div class="field"><label>Movie</label><select>
            <option>Superman</option>
            <option>Spider-Verse</option>
            <option>The Grudge Returns</option>
          </select></div>
        <div class="field-row">
          <div class="field"><label>Room</label><select>
              <option>Room A</option>
              <option>Room B</option>
              <option>VIP Room</option>
            </select></div>
          <div class="field"><label>Date</label><input type="date"></div>
        </div>
        <div class="field"><label>Time</label><input type="time"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('showtimeModal')">Cancel</button>
        <button class="btn btn-gold" onclick="closeModal('showtimeModal')">Save Showtime</button>
      </div>
    </div>
  </div>

  <script>
    // ---------- view switching ----------
    function showView(name, el) {
      document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
      document.getElementById('view-' + name).classList.add('active');
      document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
      el.classList.add('active');
    }

    function openModal(id) {
      document.getElementById(id).classList.add('show');
    }

    function closeModal(id) {
      document.getElementById(id).classList.remove('show');
    }

    // ---------- mock data (replace with API calls to Laravel backend) ----------
    const editIcon = `<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>`;
    const trashIcon = `<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>`;
    const badgeClass = {
      Action: 'badge-action',
      Horror: 'badge-horror',
      Comedy: 'badge-comedy',
      Romance: 'badge-romance',
      Animation: 'badge-animation'
    };

    const movies = [{
        title: "Superman",
        cat: "Action",
        duration: "128 min",
        release: "25/07/2026",
        poster: "https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=100&q=60"
      },
      {
        title: "Spider-Verse",
        cat: "Animation",
        duration: "140 min",
        release: "18/07/2026",
        poster: "https://images.unsplash.com/photo-1531259683007-016a7b628fc3?w=100&q=60"
      },
      {
        title: "The Grudge Returns",
        cat: "Horror",
        duration: "102 min",
        release: "12/07/2026",
        poster: "https://images.unsplash.com/photo-1509281373149-e957c6296406?w=100&q=60"
      },
      {
        title: "Only You",
        cat: "Romance",
        duration: "110 min",
        release: "02/07/2026",
        poster: "https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=100&q=60"
      },
      {
        title: "Laugh Track",
        cat: "Comedy",
        duration: "95 min",
        release: "29/06/2026",
        poster: "https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=100&q=60"
      },
    ];
    document.getElementById('moviesBody').innerHTML = movies.map(m => `
    <tr>
      <td><div class="cell-movie"><span class="row-thumb" style="background-image:url('${m.poster}')"></span>${m.title}</div></td>
      <td><span class="badge ${badgeClass[m.cat]}">${m.cat}</span></td>
      <td>${m.duration}</td>
      <td>${m.release}</td>
      <td><div class="row-actions">
        <button class="icon-btn" onclick="openModal('movieModal')">${editIcon}</button>
        <button class="icon-btn danger">${trashIcon}</button>
      </div></td>
    </tr>`).join('');

    const categories = [{
      name: "Action",
      count: 8
    }, {
      name: "Horror",
      count: 4
    }, {
      name: "Comedy",
      count: 5
    }, {
      name: "Romance",
      count: 3
    }, {
      name: "Animation",
      count: 4
    }];
    document.getElementById('categoriesBody').innerHTML = categories.map(c => `
    <tr>
      <td><span class="badge ${badgeClass[c.name]}">${c.name}</span></td>
      <td>${c.count} movies</td>
      <td><div class="row-actions">
        <button class="icon-btn" onclick="openModal('categoryModal')">${editIcon}</button>
        <button class="icon-btn danger">${trashIcon}</button>
      </div></td>
    </tr>`).join('');

    const rooms = [{
      name: "Room A",
      cap: 80,
      active: 6
    }, {
      name: "Room B",
      cap: 60,
      active: 4
    }, {
      name: "VIP Room",
      cap: 24,
      active: 3
    }];
    document.getElementById('roomsBody').innerHTML = rooms.map(r => `
    <tr>
      <td>${r.name}</td>
      <td>${r.cap} seats</td>
      <td>${r.active} showtimes</td>
      <td><div class="row-actions">
        <button class="icon-btn" onclick="openModal('roomModal')">${editIcon}</button>
        <button class="icon-btn danger">${trashIcon}</button>
      </div></td>
    </tr>`).join('');

    const showtimes = [{
        movie: "Superman",
        room: "Room A",
        date: "25/07/2026",
        time: "7:30 PM"
      },
      {
        movie: "Spider-Verse",
        room: "Room B",
        date: "25/07/2026",
        time: "4:15 PM"
      },
      {
        movie: "The Grudge Returns",
        room: "VIP Room",
        date: "25/07/2026",
        time: "10:00 PM"
      },
      {
        movie: "Only You",
        room: "Room A",
        date: "26/07/2026",
        time: "1:00 PM"
      },
    ];
    document.getElementById('showtimesBody').innerHTML = showtimes.map(s => `
    <tr>
      <td>${s.movie}</td><td>${s.room}</td><td>${s.date}</td><td class="lbl" style="font-family:var(--font-mono)">${s.time}</td>
      <td><div class="row-actions">
        <button class="icon-btn" onclick="openModal('showtimeModal')">${editIcon}</button>
        <button class="icon-btn danger">${trashIcon}</button>
      </div></td>
    </tr>`).join('');

    const bookings = [{
        id: "#BK1042",
        user: "Dara K.",
        movie: "Superman",
        showtime: "25/07 · 7:30 PM",
        seats: "C4, C5"
      },
      {
        id: "#BK1041",
        user: "Sreymom P.",
        movie: "Spider-Verse",
        showtime: "25/07 · 4:15 PM",
        seats: "A2"
      },
      {
        id: "#BK1040",
        user: "Vichet L.",
        movie: "The Grudge Returns",
        showtime: "24/07 · 10:00 PM",
        seats: "F2, F3"
      },
      {
        id: "#BK1039",
        user: "Chenda R.",
        movie: "Only You",
        showtime: "24/07 · 1:00 PM",
        seats: "D6"
      },
      {
        id: "#BK1038",
        user: "Pisach T.",
        movie: "Laugh Track",
        showtime: "23/07 · 6:00 PM",
        seats: "B8, B9"
      },
    ];
    document.getElementById('recentBookingsBody').innerHTML = bookings.slice(0, 4).map(b => `
    <tr><td>${b.user}</td><td>${b.movie}</td><td style="font-family:var(--font-mono); font-size:12px;">${b.showtime}</td><td>${b.seats}</td><td><span class="status-confirmed">Confirmed</span></td></tr>
  `).join('');
    document.getElementById('allBookingsBody').innerHTML = bookings.map(b => `
    <tr><td style="font-family:var(--font-mono)">${b.id}</td><td>${b.user}</td><td>${b.movie}</td><td>${b.showtime}</td><td>${b.seats}</td><td><span class="status-confirmed">Confirmed</span></td></tr>
  `).join('');

    // bar chart (bookings by day) — pure CSS bars driven by data
    const weekData = [{
      d: 'Mon',
      v: 38
    }, {
      d: 'Tue',
      v: 52
    }, {
      d: 'Wed',
      v: 44
    }, {
      d: 'Thu',
      v: 60
    }, {
      d: 'Fri',
      v: 81
    }, {
      d: 'Sat',
      v: 96
    }, {
      d: 'Sun',
      v: 70
    }];
    const max = Math.max(...weekData.map(w => w.v));
    document.getElementById('barsChart').innerHTML = weekData.map(w => `
    <div class="bar-col"><div class="bar" style="height:${(w.v/max*100)}%"></div><span class="lbl">${w.d}</span></div>
  `).join('');
  </script>
</body>

</html>