{{ content() }}

{% if showAuthorizeForm == true %}
<form class="form-signin" role="form" method="post">
	<h2 class="form-signin-heading">Authorization</h2>
    <p>Do you want authorize access the following app to work with your resources?</p>
    <p><strong>{{ clientId }}</strong> would like to access the following data:</p>
    <ul>
    	{% for r in resources %}
        <li>
            {{ r|e }}
        </li>
    	{% endfor %}
    </ul>
    <p>&nbsp;</p>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Yes, I authorize this request</button>
    {{ link_to('/', '<i class="fa fa-times"></i>&nbsp;&nbsp;Cancel', 'class':'btn btn-lg btn-default btn-block') }}
    <input type="hidden" name="confirm" value="yes"/>
    <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}"/>
</form>
{% endif %}