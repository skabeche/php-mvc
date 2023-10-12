<?php if (!empty($message)) { ?>
  <div id="message" class="message message-<?php echo $message['type']; ?>" role="alert">
    <div class="flex gap-3">
      <img class="w-6 h-6" src="/theme/images/message-<?php echo $message['type']; ?>.svg" alt="<?php echo $message['type']; ?>">
      <?php echo $message['text']; ?>
    </div>
  </div>
<?php } ?>