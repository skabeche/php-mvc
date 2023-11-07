<div class="container flex justify-between items-center py-4">
  <div class="brand">
    <a href="/" class="flex gap-2 items-center text-black font-bold">
      <img src="/images/logo.svg" class="w-12 h-12" alt="Logo">
      PHP MVC
    </a>
  </div>
  <nav class="nav-main text-sm offcanvas md:oncanvas">
    <ul class="flex gap-4 md:items-center">
      <?php if ($settings['access_role'] == 'guest') { ?>
        <li><a href="/register">Register</a></li>
        <li><a href="/login">Log in</a></li>
      <?php } ?>
      <?php if ($settings['access_role'] == 'auth') { ?>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/logout">Log out</a></li>
      <?php } ?>
    </ul>
  </nav>
  <div class="navbar-toggler flex items-center md:hidden mx-4">
    <button class="">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>
  </div>
</div>