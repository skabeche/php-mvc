<div class="lg:w-1/2 mx-auto my-10 p-12 bg-white shadow rounded">
  <h1 class="">
    Register
  </h1>
  <div class="">
    <form id="form-login" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <div class="mb-6">
        <label for="name" class="required">Name</label>
        <input type="text" id="name" name="name" value="<?php echo $data['post']['name'] ?? ''; ?>" required>
      </div>
      <div class="mb-6">
        <label for="email" class="required">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $data['post']['email'] ?? ''; ?>" required>
      </div>
      <div class="mb-6">
        <label for="password" class="required">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="mb-6">
        <label for="password2" class="required">Repeat password</label>
        <input type="password" id="password2" name="password2" required>
      </div>
      <input type="submit" class="btn-primary" name="register" value="Register">
    </form>
  </div>
</div>