<div class="lg:w-1/2 mx-auto my-10 p-12 bg-white shadow rounded">
  <h1 class="">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
      <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
    </svg>
    Login
  </h1>
  <div class="">
    <form id="form-login" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <div class="mb-6">
        <label for="email" class="required">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $data['post']['email'] ?? ''; ?>" required>
      </div>
      <div class="mb-6">
        <label for="password" class="required">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <input type="submit" class="btn-primary" name="login" value="Log in">
    </form>
  </div>
</div>