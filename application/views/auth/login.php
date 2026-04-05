<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #1a0533; }
  .wrap {
    display: flex; width: 100vw; height: 100vh; max-width: 100%;
    border-radius: 0; overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
  }

  /* LEFT PANEL */
  .left {
    width: 38%; background: #fff;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 2.5rem 2rem;
  }
  
  .avatar { width: 64px; height: 64px; border-radius: 50%; background: #f5f3ff; border: 2px solid #ddd6fe; display: flex; align-items: center; justify-content: center; margin-bottom: 1.6rem; }
  .field-wrap { width: 100%; margin-bottom: 12px; position: relative; }
  .field-wrap input { width: 100%; padding: 10px 14px 10px 36px; border: 1.5px solid #e0d9ff; border-radius: 8px; background: #fafafa; font-size: 13px; color: #1e1b4b; outline: none; transition: border-color 0.2s; }
  .field-wrap input:focus { border-color: #7c3aed; background: #fff; }
  .field-wrap input::placeholder { color: #9ca3af; }
  .field-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #a78bfa; }
  .btn-login { width: 100%; padding: 10px; background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%); color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; margin: 4px 0 12px; letter-spacing: 1px; text-transform: uppercase; }
  .btn-login:hover { background: linear-gradient(135deg, #6d28d9 0%, #4338ca 100%); }
  .bottom-links { display: flex; justify-content: space-between; width: 100%; margin-top: 4px; }
  .bottom-links span, .bottom-links a { font-size: 11px; color: #9ca3af; text-decoration: none; }
  .bottom-links a { color: #7c3aed; }
  .dots { display: flex; gap: 6px; margin-top: 2rem; }
  .dot { width: 7px; height: 7px; border-radius: 50%; background: #ddd6fe; }
  .dot.active { background: #7c3aed; }

  /* RIGHT PANEL */
  .right { width: 62%; position: relative; overflow: hidden; background: #1e0b3d; }
  .mesh {
    position: absolute; inset: 0;
    background-color: #1e0b3d;
    background-image:
      radial-gradient(ellipse at 20% 20%, #7c3aed 0%, transparent 50%),
      radial-gradient(ellipse at 80% 10%, #4f46e5 0%, transparent 40%),
      radial-gradient(ellipse at 60% 80%, #06b6d4 0%, transparent 50%),
      radial-gradient(ellipse at 10% 80%, #0e0626 0%, transparent 50%),
      radial-gradient(ellipse at 90% 60%, #2563eb 0%, transparent 45%);
  }
  .mesh-blur {
    position: absolute; inset: 0;
    background:
      radial-gradient(ellipse 60% 50% at 35% 40%, rgba(139,92,246,0.75) 0%, transparent 60%),
      radial-gradient(ellipse 50% 55% at 70% 60%, rgba(6,182,212,0.65) 0%, transparent 55%),
      radial-gradient(ellipse 40% 40% at 55% 25%, rgba(99,102,241,0.5) 0%, transparent 50%);
    filter: blur(32px);
  }
  .right-nav { position: relative; z-index: 2; display: flex; align-items: center; justify-content: flex-end; padding: 1.2rem 1.5rem; gap: 1.5rem; }
  .right-nav a { font-size: 11px; color: rgba(255,255,255,0.75); text-decoration: none; letter-spacing: 0.3px; }
  .nav-btn { background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 5px 16px; border-radius: 6px; font-size: 11px; cursor: pointer; }
  .right-content { position: relative; z-index: 2; padding: 3rem 2.5rem; display: flex; flex-direction: column; justify-content: flex-end; height: calc(100% - 60px); }
  .welcome-text { font-size: 52px; font-weight: 800; color: white; line-height: 1; margin-bottom: 1rem; letter-spacing: -1px; }
  .welcome-sub { font-size: 12px; color: rgba(255,255,255,0.65); max-width: 240px; line-height: 1.6; }
  .signup-link { margin-top: 1.5rem; }
  .signup-link a { font-size: 12px; color: rgba(255,255,255,0.75); text-decoration: underline; text-underline-offset: 3px; }
</style>

<div class="wrap">
  <!-- LEFT -->
  <div class="left">
   

    <div class="avatar">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="#7c3aed"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
    </div>

    <?= $this->session->flashdata('message'); ?>

    <form method="post" action="<?= base_url('Auth'); ?>" autocomplete="off" style="width:100%;">

      <!-- TRICK AUTOFILL -->
      <input type="text" name="fake_user" style="display:none">
      <input type="password" name="fake_pass" style="display:none">

      <div class="field-wrap">
        <span class="field-icon">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
        </span>
        <input type="text" id="email" name="user_email" placeholder="Email Address" value="" autocomplete="off">
        <?= form_error('user_email', '<small style="color:#dc2626;font-size:11px;padding-left:4px;">', '</small>'); ?>
      </div>

      <div class="field-wrap">
        <span class="field-icon">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.8-2.2-5-5-5S7 3.2 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.7 1.4-3.1 3.1-3.1 1.7 0 3.1 1.4 3.1 3.1v2z"/></svg>
        </span>
        <input type="password" id="password" name="user_password" placeholder="Password" autocomplete="new-password">
        <?= form_error('user_password', '<small style="color:#dc2626;font-size:11px;padding-left:4px;">', '</small>'); ?>
      </div>

      <button type="submit" class="btn-login">Sign In</button>
    </form>

    <div class="bottom-links">
     
      <a href="forgot-password.html">Forgot password?</a>
    </div>


  </div>

  <!-- RIGHT -->
  <div class="right">
    <div class="mesh"></div>
    <div class="mesh-blur"></div>
    <div class="right-nav"></div>
    <div class="right-content">
      <div class="welcome-text">Welcome Back.</div>
      <div class="welcome-sub">Sistem pengajuan proposal mahasiswa — kelola dan pantau proposalmu dengan mudah.</div>
      <div class="signup-link">
        <a href="<?= base_url('Auth/registration'); ?>">Don't have an account? Sign up now</a>
      </div>
    </div>
  </div>
</div>