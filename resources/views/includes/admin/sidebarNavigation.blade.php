<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">User</li>

                    <li class="nav-item">
                        <a href="{{ route('userDashboard') }}" class="nav-link {{ Route::currentRouteName() == 'userDashboard' ? 'active' : '' }}">
                            <i class="icon icon-speedometer"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="{{ route('userPosts') }}" class="nav-link {{ Route::currentRouteName() == 'authorPosts' ? 'active' : '' }}"">
                            <i class="icon icon-paper-clip"></i> Posts
                        </a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="{{ route('userReplies') }}" class="nav-link {{ Route::currentRouteName() == 'userComments' ? 'active' : '' }}"">
                            <i class="icon icon-book-open"></i> Replies
                        </a>
                    </li>

                    @if(Auth::user()->admin == true)
                    <li class="nav-title">Admin</li>

                    <li class="nav-item nav-dropdown">
                        <a href="{{ route('adminDashboard') }}" class="nav-link {{ Route::currentRouteName() == 'adminDashboard' ? 'active' : '' }}"">
                            <i class="icon icon-speedometer"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="{{ route('adminChannels') }}" class="nav-link {{ Route::currentRouteName() == 'adminChannels' ? 'active' : '' }}"">
                            <i class="icon icon-paper-clip"></i> Channels
                        </a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="{{ route('adminPosts') }}" class="nav-link {{ Route::currentRouteName() == 'adminPosts' ? 'active' : '' }}"">
                            <i class="icon icon-paper-clip"></i> Posts
                        </a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a href="{{ route('adminUsers') }}" class="nav-link {{ Route::currentRouteName() == 'adminUsers' ? 'active' : '' }}"">
                            <i class="icon icon-user"></i> Users
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>