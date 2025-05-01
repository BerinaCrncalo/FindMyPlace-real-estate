<h2>Send a Contact Message</h2>
<form method="post" action="/contact_messages">
  <label>Name: <input type="text" name="name" required></label><br>
  <label>Email: <input type="email" name="email" required></label><br>
  <label>Message:<br>
    <textarea name="message" required></textarea>
  </label><br>
  <label>User ID: <input type="number" name="user_id" required></label><br>
  <input type="submit" value="Send">
</form>
