<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <title><?php echo $settings['title'] ?? ''; ?> | PHP MVC</title>
  <link href="/styles.css" rel="stylesheet">
  <link href="/images/favicon.ico" rel="shortcut icon">
</head>

<body class="<?php echo $settings['access_role'] . '-page'; ?> <?php echo $settings['body_classes'] ?? ''; ?>">
  <main id="main-contaner" class="">
    <section id="main-section" class="">
      <header id="region-top" class="bg-white">
        <?php include __DIR__ . '/partials/nav-top.php'; ?>
      </header>

      <section id="main-content" class="container py-12">

        <?php include __DIR__ . '/partials/message.php'; ?>

        <div id="region-content">
          <?php echo $view; ?>
        </div>
      </section>

    </section>
  </main>

  <?php include __DIR__ . '/partials/footer.php'; ?>
  <script type="module" src="/scripts.js"></script>
</body>

</html>