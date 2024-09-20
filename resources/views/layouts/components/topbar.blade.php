<nav class="navbar bg-base-100 shadow lg:px-16 sticky top-0 z-50">
    <div class="navbar-start w-full justify-center md:w-1/2 md:justify-start">
        <div class="dropdown absolute left-6">
            <div tabindex="0" role="button" class="btn btn-square md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="white" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>

            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="bi-house me-1"></i>
                        Home
                    </a>
                </li>

                @foreach ($routes as $route)
                    @if (array_key_exists('children', $route))
                        <li>
                            <details>
                                <summary>
                                    <i class="bi-{{ $route['icon'] }} me-1"></i>
                                    {{ $route['title'] }}
                                </summary>
                                <ul class="p-2">
                                    @foreach ($route['children'] as $child)
                                        <li>
                                            <a href="{{ route($child['name']) }}">
                                                {{ $child['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        </li>
                    @else
                        <li>
                            <a
                                href="{{ route($route['name']) . (array_key_exists('hash', $route) ? $route['hash'] : '') }}">
                                @if (array_key_exists('icon', $route))
                                    <i class="bi-{{ $route['icon'] }} mr-1"></i>
                                @endif

                                {{ $route['title'] }}
                            </a>
                        </li>
                    @endif
                @endforeach

                <div class="divider my-1"></div>

                <li>
                    <x-blade-logout>
                        <i class="bi-box-arrow-left me-2"></i>
                        Logout
                    </x-blade-logout>
                </li>
            </ul>
        </div>

        <div class="flex items-center">
            @include('layouts.components.binus-ribbon', [
                'class' => 'relative hidden md:block',
                'style' => 'top: -0.5rem',
            ])

            <a class="ms-3" href="{{ route('home') }}">
                <img src="{{ url('img/logo/logo-sm.png') }}" alt="Logo Basic Binus" class="h-16" />
            </a>
        </div>
    </div>
    <div class="navbar-center hidden md:flex">
        <ul class="menu menu-horizontal px-1">
            @foreach ($routes as $route)
                @if (array_key_exists('children', $route))
                    <li>
                        <details>
                            <summary>
                                <i class="bi-{{ $route['icon'] }}"></i>
                                {{ $route['title'] }}
                            </summary>
                            <ul class="p-2">
                                @foreach ($route['children'] as $child)
                                    <li>
                                        <a href="{{ route($child['name']) }}">
                                            {{ $child['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </details>
                    </li>
                @else
                    <li>
                        <a
                            href="{{ route($route['name']) . (array_key_exists('hash', $route) ? $route['hash'] : '') }}">
                            @if (array_key_exists('icon', $route))
                                <i class="bi-{{ $route['icon'] }} mr-1"></i>
                            @endif

                            {{ $route['title'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="navbar-end hidden md:inline-flex">
        @guest
            <div>
                <a class="btn btn-primary shadow mr-1" href="{{ route('login') }}">{{ __('Login') }}</a>
                <a class="btn" href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
        @else
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="flex gap-x-3 items-center">
                    <div class="flex flex-col text-right">
                        <span class="font-semibold">
                            {{ $user->name }}
                        </span>
                        @if ($user->hasCurrentRole())
                            <span class="text-sm">
                                {{ ucfirst($user->currentRole->title) }}
                            </span>
                        @endif
                    </div>
                    <div class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img alt="Profile" src="{{ asset('img/profile.png') }}" />
                        </div>
                    </div>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <a href="{{ route($profileRoute) }}">
                            <i class="bi-person-circle me-1"></i>
                            Profile
                        </a>
                    </li>
                    @if ($user->hasMultipleRoles())
                        <li>
                            <a href="{{ route($roleRoute) }}">
                                <i class="bi-people-fill me-1"></i>
                                Change Role
                            </a>
                        </li>
                    @endif

                    <div class="divider my-1"></div>

                    <li>
                        <x-blade-logout>
                            <i class="bi-box-arrow-left me-2"></i>
                            Logout
                        </x-blade-logout>
                    </li>
                </ul>
            </div>
        @endguest
    </div>
</nav>
