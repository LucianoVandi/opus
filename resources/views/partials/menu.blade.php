<nav class="navbar navbar-default navbar-fixed-top main-menu" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li class="with-img">
					<a href="{{ route('dashboard', [ Auth::user()->getTeam()->slug ]) }}" style="font-size: 13px;">
						@if($team->team_logo)
                            <img src="/img/avatars/{{ $team->team_logo }}" alt="" width="155" height="155" class="media-object" style="border-radius: 3px;">
                        @else
                            <img src="/img/no-image.png" alt="" width="155" height="155" class="media-object" style="border-radius: 3px;">
                        @endif
                        {{ $team->name }}
					</a>
				</li>
				<form class="navbar-form navbar-left" role="search">
					<div class="aa-input-container" id="aa-input-container">
						<input type="search" id="aa-search-input" class="form-control aa-input-search" placeholder="{{_i('Search...')}}" name="search" autocomplete="off" />
						<svg class="aa-input-icon" viewBox="654 -372 1664 1664">
							<path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
						</svg>
					</div>
				</form>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				<!-- <form class="navbar-form navbar-left dropdown" role="search">
					<div class="form-group with-icon dropdown-toggle" data-toggle="dropdown" >
						<input type="text" class="form-control overall-search-input" placeholder="{{_i('Search...')}}">
						<i class="fa fa-search icon"></i>
					</div>
					<ul class="dropdown-menu dropdown-menu-right" id="overall-search-output" onClick="event.stopPropagation();" style="margin-top: 4px; margin-right: 15px; width: 250px; padding: 4px 5px; max-height: 250px; overflow: auto;">
                   		<li style="font-style: italic; text-align: center; font-size: 13px;">{{_i('Type something.')}}</li>
                    </ul>
				</form> -->
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-right: 9px; padding-left: 9px;"><i class="fa fa-plus fa-fw"></i></a>
					<ul class="dropdown-menu dropdown-menu-right" style="margin-top: -3px; margin-right: -6px; margin-top: -3px; padding: 4px 5px;">
                        <li><a href="{{ route('wikis.create', [ $team->slug ]) }}" style="padding: 5px 6px;">{{_i('Create wiki')}}</a></li>
                        <li><a href="{{ route('spaces.create', [ $team->slug ]) }}" style="padding: 5px 6px;">{{_i('Create space')}}</a></li>
                        <li class="divider" style="margin: 0px;"></li>
                        <li><a href="{{ route('teams.settings.members', [$team->slug,]) }}" style="padding: 5px 6px;">{{_i('Invite user')}}</a></li>
                    </ul>
              	</li>
              	<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-right: 9px; padding-left: 9px; position: relative;">
						<i class="fa fa-bell fa-fw"></i>
						@if($notifications->count() > 0)
							<span class="unread-notification" style="background-color: #03A9F4; height: 11px; width: 11px; display: inline-block; border-radius: 50%; position: absolute; top: 13px; right: 8px; border: 2px solid #fbfbfb;"></span>
						@endif
					</a>
					<div class="dropdown-menu dropdown-menu-right" onClick="event.stopPropagation();" style="margin-top: -3px; margin-right: -6px; width: 420px; padding: 0;">
                        <div class="menu-notifications">
                        	<div class="notification-head" style="padding: 12px 15px;">
                        		<div class="pull-left" style="height: 18px; display: flex; align-items: center;">
                        			<h2 style="font-size: 12px; color: #777;">{{_i('Notifications')}}</h2>
                        		</div>
                        		<div class="pull-right" style="height: 18px; display: flex; align-items: center;">
                        			@if($notifications->count() > 0)
	                        			<a href="{{ route('notifications.readall', [$team->slug, Auth::user()->slug]) }}"><i class="fa fa-eye fa-fw icon" data-toggle="tooltip" data-position="top" title="Mark all as read"></i></a>
	                        		@endif
                        		</div>
                        		<div class="clearfix"></div>
                        	</div>
                        	<div class="notification-body" style="max-height: 260px; overflow: auto; margin-bottom: 15px;">
                        		@if($notifications->count() > 0)
                        			<ul class="list-unstyled notifications-list" style="margin-bottom: 0;">
	                        			@foreach($notifications as $notification)
	                        				<li>
	                        					<a href="{{ $notification->url }}">
			                        				<div class="media">
			                        				    <div class="pull-left event-user-image" href="">
				                        				    <?php $user_image = \App\Models\User::find($notification->from_id)->profile_image; ?>
				                        				    @if($user_image)
										                        <img class="media-object" style="border-radius: 3px;" src="/img/avatars/{{ $user_image }}" width="42" height="42" alt="Image">
										                    @else
										                        <img class="media-object" style="border-radius: 3px;" src="/img/no-image.png" width="44" height="44" alt="Image">
										                    @endif
			                        				    </div>
			                        				    <div class="media-body">
		                    				                <div class="pull-left event-icon" style="margin-right: 7px;">
											                    <?php $notificationCategory = $notification->category->name; ?>
											                    @if($notificationCategory === 'wiki.updated' || $notificationCategory === 'page.updated') 
																	<i class="fa fa-save fa-fw fa-lg icon"></i>
											                    @elseif($notificationCategory === 'wiki.deleted' || $notificationCategory === 'page.deleted')
												                    <i class="fa fa-trash-o fa-fw fa-lg icon"></i>
												                @elseif($notificationCategory === 'page.created')
																	<i class="fa fa-file-text-o fa-fw fa-lg icon"></i>
												                @endif
											                </div>
											                <div class="pull-left" style="position: relative; top: -3px; width: 89%;">
											                    {{ $notification->text }}
											                </div>
											                <div class="clearfix"></div>
			                        				        <p class="text-muted" style="font-size: 13px; color: #b7b7b7;">{{ $notification->created_at->diffForHumans() }}</p>
			                        				    </div>
			                        				</div>
	                        					</a>
	                        				</li>
	                        			@endforeach
                        			</ul>
                        		@else 
	                        		<div style="font-size: 12px; text-align: center; padding: 2px 15px 20px; color: #777;">
	                        			<i class="fa fa-bell-o" style="transform: rotate(24deg); font-size: 14px; margin-right: 4px; position: relative; top: -2px;"></i>
	                        			{{_i('No unread notification.')}}
	                        		</div>
                        		@endif
                        	</div>
                        </div>
                    </div>
                </li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} <i class="fa fa-caret-down fa-fw"></i></a>
					<ul class="dropdown-menu dropdown-menu-right" style="margin-top: -3px; padding: 4px 5px;">
                        <li><a href="{{ route('users.show', [$team->slug, Auth::user()->slug]) }}" style="padding: 5px 6px;">{{_i('Profile')}}</a></li>
                        <li><a href="{{ route('settings.profile', [$team->slug, Auth::user()->slug]) }}" style="padding: 5px 6px;">{{_i('Settings')}}</a></li>
                        <li class="divider" style="margin: 0px; background-color: #eee;"></li>
                        <li><a href="{{ route('logout') }}" style="padding: 5px 6px;">{{_i('Logout')}} </a></li>
                    </ul>
				</li>
			</ul>
		</div>
	</div>
</nav>