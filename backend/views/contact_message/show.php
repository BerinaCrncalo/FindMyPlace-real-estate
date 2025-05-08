<h2>Contact Message from <?= htmlspecialchars($contact_message['name']) ?></h2>
<p><strong>Email:</strong> <?= htmlspecialchars($contact_message['email']) ?></p>
<p><strong>Message:</strong><br><?= nl2br(htmlspecialchars($contact_message['message'])) ?></p>
<p><strong>Sent at:</strong> <?= $contact_message['sent_at'] ?></p>
