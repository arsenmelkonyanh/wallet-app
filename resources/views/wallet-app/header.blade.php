<nav x-data="{ open: false }" class="bg-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center header-logo">
                    <a href="{{ route('wallets.index') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 header-container">
                <p class="user-name px-4">Hello, {{ Auth::user()->name }}!</p>

                @if (!Auth::user()->getRecords()->isEmpty())
                    <a class="px-4" href="{{ route('records.index') }}">See records</a>
                @endif

                @if (!Auth::user()->getWallets()->isEmpty())
                    <a class="px-4" href="{{ route('records.create') }}">Create Record</a>
                    <a class="px-4" href="{{ route('wallets.create') }}">Create Wallet</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
</nav>
