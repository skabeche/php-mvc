<h1>User <?php echo $data['user']['name']; ?></h1>

<section>
  <ul>
    <li><strong>ID:</strong> <?php echo $data['user']['id'] ?></li>
    <li><strong>Name:</strong> <?php echo $data['user']['name'] ?></li>
    <li><strong>Email:</strong> <a href="mailto:<?php echo $data['user']['email'] ?>"><?php echo $data['user']['email'] ?></a></li>
  </ul>
</section>