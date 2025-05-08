<h2>All Contact Messages</h2>
<ul>
  <?php foreach ($contact_messages as $message): ?>
    <li>
      <strong><?= htmlspecialchars($message['name']) ?></strong> (<?= htmlspecialchars($message['email']) ?>):  
      <?= htmlspecialchars($message['message']) ?> <br>
      <small>Sent at: <?= $message['sent_at'] ?></small>
    </li>
  <?php endforeach; ?>
</ul>
