<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Password · ATS</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 128 128'%3E%3Crect rx='24' width='128' height='128' fill='%232563eb'/%3E%3Cpath fill='white' d='M64 28c15 0 27 12 27 27v7h9a6 6 0 0 1 6 6v30a6 6 0 0 1-6 6H28a6 6 0 0 1-6-6V68a6 6 0 0 1 6-6h9v-7c0-15 12-27 27-27Zm0 12c-8 0-15 7-15 15v7h30v-7c0-8-7-15-15-15Z'/%3E%3C/svg%3E" />
  <style>
    :root {
      --bg-start: #0ea5e9;  /* sky-500 */
      --bg-end: #2563eb;    /* indigo-600 */
      --card-bg: rgba(255,255,255,0.9);
      --text: #0f172a;      /* slate-900 */
      --muted: #475569;     /* slate-600 */
      --border: #cbd5e1;    /* slate-300 */
      --brand: #2563eb;
      --brand-700: #1d4ed8;
      --danger: #e11d48;
      --danger-bg: #ffe4e6;
      --success: #16a34a;
      --success-bg: #dcfce7;
      --shadow: 0 20px 45px rgba(2, 6, 23, 0.18);
      --radius: 16px;
    }
    @media (prefers-color-scheme: dark) {
      :root {
        --card-bg: rgba(15, 23, 42, 0.78);
        --text: #e2e8f0;
        --muted: #94a3b8;
        --border: #334155;
        --shadow: 0 20px 50px rgba(2, 6, 23, 0.55);
      }
    }

    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body {
      margin: 0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica Neue, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
      color: var(--text);
      display: grid;
      place-items: center;
      overflow-x: hidden;
    }

    /* Background orbs */
    .orbs {
      position: fixed; inset: -10vmax; pointer-events: none; filter: blur(40px); opacity: .55;
    }
    .orb { position: absolute; border-radius: 50%; mix-blend-mode: screen; animation: float 16s ease-in-out infinite; }
    .orb.o1 { width: 36vmax; height: 36vmax; background: radial-gradient(circle at 30% 30%, #60a5fa, transparent 60%); top: 10%; left: 5%; animation-duration: 18s; }
    .orb.o2 { width: 28vmax; height: 28vmax; background: radial-gradient(circle at 60% 40%, #22d3ee, transparent 60%); bottom: 0; right: 10%; animation-duration: 20s; }
    .orb.o3 { width: 40vmax; height: 40vmax; background: radial-gradient(circle at 50% 50%, #a78bfa, transparent 60%); top: 40%; right: -5%; animation-duration: 24s; }
    @keyframes float { 0%,100%{ transform: translateY(0) } 50%{ transform: translateY(-14px) } }

    .container {
      width: min(92vw, 460px);
      background: var(--card-bg);
      backdrop-filter: blur(12px) saturate(120%);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: clamp(20px, 4vw, 28px);
      transform: translateY(8px);
      animation: rise .6s ease both;
    }
    @keyframes rise { from { opacity: 0; transform: translateY(22px) scale(.98); } to { opacity: 1; transform: translateY(8px) scale(1); } }

    .brand {
      display: grid; grid-template-columns: 56px 1fr; gap: 12px; align-items: center; margin-bottom: 6px;
    }
    .logo {
      width: 56px; height: 56px; border-radius: 14px; display: grid; place-items: center;
      background: conic-gradient(from 210deg at 50% 50%, #1e40af, #4338ca, #2563eb, #0ea5e9, #22d3ee, #1e40af);
      box-shadow: inset 0 1px 3px rgba(255,255,255,.5), 0 8px 18px rgba(30, 64, 175, .35);
    }
    .logo svg { width: 32px; height: 32px; color: white; }
    .brand h1 { margin: 0; font-size: 1.05rem; letter-spacing: .08em; color: var(--muted); font-weight: 600; }
    .title { margin: 8px 0 18px; font-size: clamp(1.4rem, 2.6vw, 1.6rem); font-weight: 700; }
    .subtitle { margin: 0 0 12px; color: var(--muted); font-size: .95rem; }

    .alert { border-radius: 10px; padding: 10px 12px; margin-bottom: 14px; font-size: .95rem; display: flex; gap: 10px; align-items: flex-start; }
    .alert.success { background: var(--success-bg); color: var(--success); border: 1px solid rgba(22,163,74,.35); }
    .alert.error { background: var(--danger-bg); color: var(--danger); border: 1px solid rgba(225,29,72,.35); }
    .alert ul { margin: 6px 0 0 18px; }

    form { display: grid; gap: 14px; }

    .field { display: grid; gap: 8px; }
    .field label { font-weight: 600; font-size: .95rem; color: var(--muted); }

    .input-wrap { position: relative; }
    .input-wrap input {
      width: 100%; padding: 14px 44px 14px 44px; border-radius: 12px; border: 1px solid var(--border);
      background: linear-gradient(180deg, rgba(255,255,255,.95), rgba(248,250,252,.95));
      font-size: 1rem; color: var(--text); outline: none; transition: box-shadow .2s, border-color .2s, transform .08s ease;
    }
    .input-wrap input:focus { border-color: var(--brand); box-shadow: 0 0 0 4px rgba(37,99,235,.15); }
    .input-wrap input[readonly] { background: linear-gradient(180deg, rgba(241,245,249,.9), rgba(226,232,240,.9)); cursor: not-allowed; }

    .icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #64748b; }
    .action { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); display: grid; place-items: center; width: 36px; height: 36px; border-radius: 10px; border: 1px solid var(--border); background: rgba(255,255,255,.7); cursor: pointer; }
    .action:hover { border-color: var(--brand); }
    .action svg { width: 18px; height: 18px; color: #475569; }

    .btn {
      appearance: none; border: 0; padding: 14px 16px; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer;
      background: linear-gradient(180deg, var(--brand), var(--brand-700)); color: #fff; box-shadow: 0 10px 20px rgba(37,99,235,.35);
      transition: transform .05s ease, filter .2s ease, box-shadow .2s ease; letter-spacing: .02em;
    }
    .btn:hover { filter: brightness(1.02); box-shadow: 0 14px 28px rgba(37,99,235,.45); }
    .btn:active { transform: translateY(1px); }

    .footer { display: flex; justify-content: space-between; align-items: center; margin-top: 6px; font-size: .9rem; color: var(--muted); }
    .footer a { color: var(--brand); text-decoration: none; font-weight: 600; }

    .divider { height: 1px; background: linear-gradient(90deg, transparent, var(--border), transparent); margin: 4px 0 10px; }

    @media (max-width: 420px) {
      .container { padding: 18px; border-radius: 14px; }
      .brand { grid-template-columns: 48px 1fr; }
      .logo { width: 48px; height: 48px; border-radius: 12px; }
    }

    @media (prefers-reduced-motion: reduce) {
      .orb, .container { animation: none !important; }
    }
  </style>
</head>
<body>
  <!-- Ambient background orbs -->
  <div class="orbs" aria-hidden="true">
    <div class="orb o1"></div>
    <div class="orb o2"></div>
    <div class="orb o3"></div>
  </div>

  <main class="container" role="main" aria-labelledby="title">
    <header class="brand">
      <div class="logo" aria-hidden="true">
        <!-- ATS Monogram -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none">
          <path d="M7 33l8.5-22h5L29 33h-5l-2-5H14l-2 5H7Zm9.5-10h4.9L19.9 16l-3.4 7Z" fill="currentColor" opacity=".95"/>
          <path d="M31 11h5v4h-5v22h-5V15c0-2.2 1.8-4 4-4h1Z" fill="currentColor" opacity=".95"/>
          <rect x="6" y="38" width="36" height="3" rx="1.5" fill="currentColor" opacity=".35"/>
        </svg>
      </div>
      <div>
        <h1>EMSATS</h1>
        <div class="subtitle">Secure Password Reset</div>
      </div>
    </header>

    <h2 id="title" class="title">Reset your password</h2>
    <p class="subtitle">Please choose a strong password you don't use elsewhere.</p>

    <!-- Status / Errors -->
    @if (session('status'))
      <div class="alert success" role="status">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
        <div>{{ session('status') }}</div>
      </div>
    @endif

    @php
      $errors = $errors ?? session('errors', app('view')->shared('errors', new \Illuminate\Support\ViewErrorBag));
      $emailFromUrl = request()->query('email', old('email', $email ?? ''));
    @endphp

    @if ($errors && $errors->any())
      <div class="alert error" role="alert">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v5"/><path d="M12 16h.01"/></svg>
        <div>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" autocomplete="off" novalidate>
      @csrf
      <input type="hidden" name="token" value="{{ $token ?? request()->route('token') }}" />

      <div class="field">
        <label for="email">Email address</label>
        <div class="input-wrap">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16v16H4z" opacity=".15"/><path d="m22 6-10 7L2 6"/></svg>
          <input id="email" type="email" name="email" value="{{ $emailFromUrl }}" readonly inputmode="email" aria-readonly="true" />
        </div>
      </div>

      <div class="field">
        <label for="password">New password</label>
        <div class="input-wrap">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V8a5 5 0 0 1 10 0v3"/></svg>
          <input id="password" type="password" name="password" required autocomplete="new-password" minlength="8" aria-describedby="pw-help" />
          <button type="button" class="action" aria-label="Toggle password visibility" data-toggle="password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        <small id="pw-help" class="subtitle">Use at least 8 characters. Mix letters, numbers & symbols.</small>
      </div>

      <div class="field">
        <label for="password-confirm">Confirm new password</label>
        <div class="input-wrap">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V8a5 5 0 0 1 10 0v3"/></svg>
          <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" />
          <button type="button" class="action" aria-label="Toggle confirm password visibility" data-toggle="password-confirm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <button class="btn" type="submit">Reset Password</button>

      <div class="divider"></div>
      <div class="footer">
        <span>Remembered it?</span>
        <a href="{{ route('login') }}">Back to Login</a>
      </div>
    </form>
  </main>

  <script>
    // Password show/hide toggles
    const toggles = document.querySelectorAll('[data-toggle]');
    toggles.forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-toggle');
        const input = document.getElementById(id);
        const icon = btn.querySelector('svg');
        if (!input) return;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        // Simple icon swap: eye to eye-off
        icon.innerHTML = type === 'password'
          ? "<path d='M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z'/><circle cx='12' cy='12' r='3'/>"
          : "<path d='M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.8 21.8 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 7 11 7a21.73 21.73 0 0 1-4.35 5.41M1 1l22 22M9.88 9.88A3 3 0 0 0 12 15a3 3 0 0 0 2.12-.88' />";
      });
    });

    // Subtle entrance animation for form controls
    document.querySelectorAll('.field').forEach((el, i) => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(10px)';
      el.style.transition = 'opacity .5s ease, transform .5s ease';
      setTimeout(() => { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; }, 120 + i * 80);
    });
  </script>
</body>
</html>