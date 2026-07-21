<!DOCTYPE html>
<html lang="km">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ចុះឈ្មោះ / Register — CINÉ MARQUEE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&family=Bebas+Neue&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --cream: #F5EFE3;
      --cream-dark: #EDE4D0;
      --ink: #221C16;
      --gold: #C99A3A;
      --gold-light: #E4B85C;
      --maroon: #8E2A2A;
      --maroon-dark: #701F1F;
      --line: #DCCFB0;
    }
    body {
      background:
        radial-gradient(circle at 15% -10%, rgba(201,154,58,0.18), transparent 45%),
        radial-gradient(circle at 100% 10%, rgba(142,42,42,0.10), transparent 50%),
        var(--cream);
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      color: var(--ink);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .brand-eyebrow {
      letter-spacing: .35em;
      font-size: .7rem;
      color: var(--gold);
      font-weight: 600;
    }
    .brand-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.6rem;
      letter-spacing: .04em;
      line-height: 1;
      color: var(--ink);
    }
    .brand-title span { color: var(--gold); }
    .film-strip {
      height: 10px;
      background-repeat: repeat-x;
      background-size: 22px 10px;
      background-image: linear-gradient(90deg, var(--ink) 0 12px, transparent 12px 22px);
      opacity: .85;
      border-radius: 2px;
    }
    .auth-card {
      width: 100%;
      max-width: 440px;
      background: #FFFDF8;
      border: 1px solid var(--line);
      border-radius: 18px;
      box-shadow: 0 30px 60px -20px rgba(34,28,22,0.25);
      overflow: hidden;
    }
    .auth-card .card-body { padding: 2.5rem 2.25rem; }
    .khmer { font-family: 'Battambang', sans-serif; }
    .form-label {
      font-weight: 600;
      font-size: .85rem;
      color: var(--ink);
    }
    .form-control {
      background: var(--cream-dark);
      border: 1px solid var(--line);
      border-radius: 10px;
      padding: .65rem .9rem;
    }
    .form-control:focus {
      border-color: var(--gold);
      box-shadow: 0 0 0 .2rem rgba(201,154,58,.25);
      background: #fff;
    }
    .btn-ticket {
      background: var(--maroon);
      border: none;
      color: #fff;
      font-weight: 700;
      letter-spacing: .03em;
      padding: .75rem 1rem;
      border-radius: 10px;
      transition: background .15s ease, transform .15s ease;
    }
    .btn-ticket:hover {
      background: var(--maroon-dark);
      color: #fff;
      transform: translateY(-1px);
    }
    .divider {
      display: flex;
      align-items: center;
      text-align: center;
      color: #9C8F76;
      font-size: .8rem;
      margin: 1.4rem 0;
    }
    .divider::before, .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid var(--line);
    }
    .divider:not(:empty)::before { margin-right: .75em; }
    .divider:not(:empty)::after { margin-left: .75em; }
    .link-gold {
      color: var(--maroon);
      text-decoration: none;
      font-weight: 600;
    }
    .link-gold:hover { color: var(--maroon-dark); text-decoration: underline; }
    .form-check-input:checked {
      background-color: var(--gold);
      border-color: var(--gold);
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="auth-card">
  <div class="film-strip"></div>
  <div class="card-body">

    <div class="text-center mb-4">
      <div class="brand-eyebrow mb-1">CINÉ MARQUEE</div>
    </div>

    <!-- Alert container -->
    <div id="alertBox" class="mb-3"></div>

    <form id="registerForm" method="POST" novalidate>
      <div class="mb-3">
        <label for="username" class="form-label khmer">User Name</label>
        <input type="text" class="form-control" name="name" id="username" placeholder="Username" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label khmer">អ៊ីមែល / Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" required>
      </div>

      <div class="mb-2">
        <label for="password" class="form-label khmer">ពាក្យសម្ងាត់ / Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="••••••••" required>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember">
          <label class="form-check-label khmer" for="remember" style="font-size:.85rem;">
            ចងចាំខ្ញុំ
          </label>
        </div>
        <a href="#" class="link-gold khmer" style="font-size:.85rem;">ភ្លេចពាក្យសម្ងាត់?</a>
      </div>

      <button type="submit" class="btn btn-ticket w-100 khmer">បង្កើតគណនី / Register</button>
    </form>

    <p class="text-center mt-4 mb-0 khmer" style="font-size:.85rem;">
      មានគណនី? <a href="login.php" class="link-gold">ចូល</a>
    </p>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$('#registerForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: 'api/auth_handler.php',
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'register',
            name: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val()
        },
        success: function (res) {
            if (res.success) {
                $('#alertBox').html('<div class="alert alert-success">' + res.message + '</div>');
                setTimeout(function () {
                    window.location.href = 'login.php';
                }, 800);
            } else {
                $('#alertBox').html('<div class="alert alert-danger">' + res.message + '</div>');
            }
        },
        error: function () {
            $('#alertBox').html('<div class="alert alert-danger">An unexpected error occurred. Please try again.</div>');
        }
    });
});
</script>
</body>
</html>