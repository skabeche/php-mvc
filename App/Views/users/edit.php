<h1>Edit user <?php echo $data['user']['name']; ?></h1>

<section>
  <form action="" method="post">
    <div class="mb-6">
      <label for="name" class="required">Name</label>
      <input type="text" id="name" name="name" value="<?php echo $data['user']['name'] ?>" required>
    </div>
    <div class="mb-6">
      <label for="email" class="required">Email</label>
      <input type="email" id="email" name="email" value="<?php echo $data['user']['email'] ?>" required>
    </div>
    <input type="submit" class="btn-primary" name="edit" value="Save">
    <input type="submit" class="btn-secondary" id="delete" name="delete" value="Delete">
  </form>
</section>