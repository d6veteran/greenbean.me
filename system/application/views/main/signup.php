<h2>Sign up</h2>
<?php
echo validation_errors();
echo form_open('main/signup');
?>

Full name: <input type="text" name="name" /> <br />
Username: <input type="text" name="username" /> <br />
Password: <input type="password" name="password" /> <br />
Email: <input type="text" name="email" /> <br />
<input type="submit" value="Create my account" name="create" />

</form>