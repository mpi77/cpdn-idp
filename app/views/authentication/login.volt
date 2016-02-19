{{ content() }}

{% if showLoginForm == true %}
<form class="form-signin" role="form" method="post">
	<h2 class="form-signin-heading">Please log in</h2>
	<p style="font-size:20px">To login use your global identity.</p>
    <label for="email" class="sr-only">Email</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
    <p>&nbsp;</p>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
    <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}"/>
</form>
{% endif %}