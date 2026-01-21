<?php
// generate_hash.php
$password = 'password123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "<h1>Password Hash Generator</h1>";
echo "<p>Password: <strong>$password</strong></p>";
echo "<p>Generated Hash: <br><textarea cols='100' rows='2'>$hash</textarea></p>";
echo "<p><strong>INSTRUCTIONS:</strong><br>Copy the hash above and paste it into the 'password_hash' column for the Director user in your database (phpMyAdmin).</p>";
?>
