<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="{{ (Route::currentRouteName() == 'settings.profile' ? 'active' : '') }}">
		<a href="{{ route('settings.profile', [$team->slug, Auth::user()->slug]) }}">{{_i('Profile')}}</a>
	</li>
	<li role="presentation" class="{{ (Route::currentRouteName() == 'settings.account' ? 'active' : '') }}">
		<a href="{{ route('settings.account', [$team->slug, Auth::user()->slug]) }}">{{_i('Account')}}</a>
	</li>
</ul>