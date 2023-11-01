<?php if (!empty($message)) { ?>
  <div id="message" class="message message-<?php echo $message['type']; ?> mb-5" role="alert">
    <div class="flex gap-3">
      <?php if ($message['type'] === 'success') { ?>
        <img class="w-6 h-6" src="/images/message-success.svg" alt="Success">
      <?php } elseif ($message['type'] === 'error') {  ?>
        <img class="w-6 h-6" src="/images/message-error.svg" alt="Error">
        <?php } elseif ($message['type'] === 'warning') {  ?>
          <img class="w-6 h-6" src="/images/message-warning.svg" alt="Warning">
      <?php } ?>
      <?php echo $message['text']; ?>
    </div>
  </div>
<?php } ?>