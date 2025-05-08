<h2>Edit Contact Message</h2>
<form method="post" action="/contact_messages/<?= $contact_message['id'] ?>?_method=PUT">
  <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($contact_message['name']) ?>" required></label><br>
  <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($contact_message['email']) ?>" required></label><br>
  <label>Message:<br>
    <textarea name="message" required><?= htmlspecialchars($contact_message['message']) ?></textarea>
  </label><br>
  <input type="submit" value="Update Message">
</form>
