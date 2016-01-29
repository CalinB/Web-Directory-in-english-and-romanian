<nav class="navbar navbar-inverse">
	<div class="container-fluid">							
		<div class="navbar-header">								
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<span class="navbar-brand header-menu">MENU</span>								
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li <?php echo ($current_page == 'home') ? 'class="active"' : '' ?>>
					<a href="{{ URL::route('home') }}" title="{{ trans('general.home') }}">
						<span class="glyphicon glyphicon-home"></span>
					</a>
				</li>
				<li <?php echo ($current_page == 'domain.list') ? 'class="active"' : '' ?>>
					<a href="{{ URL::route('domain.list') }}">{{ trans('directory.domains_all') }}</a>
				</li>
				<li <?php echo ($current_page == 'domain.create') ? 'class="active"' : '' ?>>
					<a href="{{ URL::route('domain.create') }}">{{ trans('directory.add_domain') }}</a>
				</li>
				<li <?php echo ($current_page == 'contact') ? 'class="active"' : '' ?>>
					<a href="{{ URL::route('contact') }}" title="{{ trans('general.contact') }}">
						<span class="glyphicon glyphicon-envelope"></span>
					</a>
				</li>
				@if(Acl::isSuperAdmin())
				<li class="dropdown <?php echo (in_array($current_page, $category_pages)) ? 'active' : '' ?>">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ trans('directory.categories') }} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::route('category.list') }}">{{ trans('directory.categories_all') }} ( {{ Category::where('status', 0)->count() }} )</a></li>
						<li><a href="{{ URL::route('category.create') }}">{{ trans('directory.add_category') }}</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ trans('general.admin') }} <span class="caret"></span></a>
					<ul class="dropdown-menu">							
						<li><a href="{{ URL::route('domains-pending') }}">Domenii ( {{ Domain::where('status', 0)->count() }} )</a></li>
						<li><a href="{{ URL::route('domains-attempts') }}">&#206;ncerc&#259;ri ( {{ Attempt::count() }} )</a></li>
						<li><a href="{{ URL::route('comments-pending') }}">Comentarii ( {{ Comment::where('status', 0)->count() }} )</a></li>
						<li><a href="{{ URL::route('comments-all') }}">Comentarii all ( {{ Comment::count() }} )</a></li>
					</ul>	
				</li>
				@endif
			</ul>	

			<ul class="nav navbar-nav">
				<li>
				{{ Form::open(['route' => 'search', 'method' => 'GET', 'class' => 'navbar-form', 'role' => 'search']) }}
				<div class="input-group">
					<input type="text" class="form-control" placeholder="{{ trans('general.search') }}" 
						   name="search_term" id="serch_term" autocomplete="off" data-route="{{ URL::route('search.post') }}" />
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
				<div id="search-results" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
				{{ Form::close() }}
				</li>	
			</ul>
			<ul class="nav navbar-nav navbar-right">
				@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
				<li>
					<a rel="alternate" class="language_bar_chooser <?php echo (LaravelLocalization::getCurrentLocale() == $localeCode) ? 'active' : 'inactive' ?>" hreflang="{{ $localeCode }}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
						{{{ $properties['native'] }}}
						<img src="{{ URL::asset('assets/img/' . $localeCode . '-flag.png') }}" class="flag" alt="{{ $properties['native'] }}" />
					</a>
				</li>
				@endforeach

				@if(Auth::check())
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"> 
						{{ trans('general.hi') }}
						@if( ! empty(Auth::user()->firstname))
						{{ Auth::user()->firstname }} 
						@endif	
						@if( ! empty(Auth::user()->lastname))	
						{{ Auth::user()->lastname }}
						@endif	
						@if(empty(Auth::user()->firstname) && empty(Auth::user()->lastname))
						{{ Auth::user()->email }}
						@endif
						<span class="glyphicon glyphicon-cog"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::route('user.account') }}">{{ trans('user.my_account') }}</a></li>
						<li><a href="{{ URL::route('domain.user') }}">{{ trans('user.my_websites') }}</a></li>
					</ul>								
				</li>
				<li>
					{{ HTML::decode(HTML::link('users/logout', '&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span> ' . trans('general.logout'), ['class' => 'btn btn-info btn-small white'])) }}
				</li>					
				@else
				<li>{{ HTML::decode(HTML::link('users/register', '<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;' . trans('auth.sign_up'))) }}</li>
				<li>{{ HTML::decode(HTML::link('users/login', '<span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;' . trans('auth.login'), ['class' => 'btn btn-info btn-small'])) }}</li>
				@endif
			</ul>
		</div>
	</div>
</nav>