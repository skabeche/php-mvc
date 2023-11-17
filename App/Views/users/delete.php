<h1>Are you sure to delete user <?php echo $data['user']['name']; ?>?</h1>

<section>
  <ul class="mb-10">
    <li><strong>ID:</strong> <?php echo $data['user']['id'] ?></li>
    <li><strong>Name:</strong> <?php echo $data['user']['name'] ?></li>
    <li><strong>Email:</strong> <a href="mailto:<?php echo $data['user']['email'] ?>"><?php echo $data['user']['email'] ?></a></li>
  </ul>
  <form action="" method="post" class="flex items-center gap-2">
    <input type="hidden" id="id" name="id" value="<?php echo $data['user']['id'] ?>">
    <a href="/users" class="btn-primary">Cancel</a>
    <input type="submit" class="btn-secondary" id="delete" name="delete" value="Delete user">
  </form>
</section>