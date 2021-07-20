<aside class="md:min-h-screen md:sticky top-0 sidebar">
    <nav id="sidebar">
        <ul class="list-unstyled components">
            <!-- USERS -->
            @if (true)
                <li class="@if(request()->routeIs('users.*')) {{ 'active' }} @endif">
                    <a href="{{ route('users.index') }}">
                        <svg class="h-5 w-5 inline icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Usuários') }}
                    </a>
                </li>
            @endif

        </ul>
    </nav>
</aside>
