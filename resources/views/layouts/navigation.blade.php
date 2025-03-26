<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white border-r border-gray-200">
        <div class="flex items-center ps-2.5 mb-8">
            <x-application-logo class="block h-8 w-auto me-3 fill-current text-gray-800" />
            <span class="self-center text-xl font-semibold whitespace-nowrap">{{ config('app.name', 'Laravel') }}</span>
        </div>

        <div class="space-y-2">
            <div class="pt-4 pb-2 px-2 border-t border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="flex-shrink-0">
                        <img class="w-10 h-10 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                            alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-normal text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <ul class="space-y-1 font-medium border-t border-gray-200 pt-4">
                <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-layout-grid">
                            <rect width="7" height="7" x="3" y="3" rx="1" />
                            <rect width="7" height="7" x="14" y="3" rx="1" />
                            <rect width="7" height="7" x="14" y="14" rx="1" />
                            <rect width="7" height="7" x="3" y="14" rx="1" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Dashboard') }}</span>
                    </x-nav-link>
                </li>



                <!-- Add Report Cards Menu Item -->

                <li>
                    <x-nav-link :href="route('homeroom.create')" :active="request()->routeIs('homeroom.create')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-school">
                            <path d="M14 22v-4a2 2 0 1 0-4 0v4" />
                            <path
                                d="m18 10 3.447 1.724a1 1 0 0 1 .553.894V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7.382a1 1 0 0 1 .553-.894L6 10" />
                            <path d="M18 5v17" />
                            <path d="m4 6 7.106-3.553a2 2 0 0 1 1.788 0L20 6" />
                            <path d="M6 5v17" />
                            <circle cx="12" cy="9" r="2" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Wali Kelas') }}</span>
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('classes.create')" :active="request()->routeIs('classes.create')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-school">
                            <path d="M14 22v-4a2 2 0 1 0-4 0v4" />
                            <path
                                d="m18 10 3.447 1.724a1 1 0 0 1 .553.894V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7.382a1 1 0 0 1 .553-.894L6 10" />
                            <path d="M18 5v17" />
                            <path d="m4 6 7.106-3.553a2 2 0 0 1 1.788 0L20 6" />
                            <path d="M6 5v17" />
                            <circle cx="12" cy="9" r="2" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Kelas') }}</span>
                    </x-nav-link>
                </li>


                <li>
                    <x-nav-link :href="route('semesters.create')" :active="request()->routeIs('semesters.create')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-book-marked">
                            <path d="M10 2v8l3-3 3 3V2" />
                            <path
                                d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Semester') }}</span>
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('reportcard.upload')" :active="request()->routeIs('reportcard.upload')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-import">
                            <path d="M12 3v12" />
                            <path d="m8 11 4 4 4-4" />
                            <path d="M8 5H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-4" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Import Excel') }}</span>
                    </x-nav-link>
                </li>

                <li>
                    <x-nav-link :href="route('predikat.index')" :active="request()->routeIs('predikat.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-hash">
                            <line x1="4" x2="20" y1="9" y2="9" />
                            <line x1="4" x2="20" y1="15" y2="15" />
                            <line x1="10" x2="8" y1="3" y2="21" />
                            <line x1="16" x2="14" y1="3" y2="21" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Setting Predikat') }}</span>
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('report-cards.index')" :active="request()->routeIs('report-cards.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-clipboard-minus">
                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                            <path d="M9 14h6" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Report Cards') }}</span>
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('mapel.index')" :active="request()->routeIs('mapel.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-clipboard-minus">
                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                            <path d="M9 14h6" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Daftar Mapel') }}</span>
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('reportpdf.index')" :active="request()->routeIs('reportpdf.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-import">
                            <path d="M12 3v12" />
                            <path d="m8 11 4 4 4-4" />
                            <path d="M8 5H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-4" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Simpan Pdf') }}</span>
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-users">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Profile') }}</span>
                    </x-nav-link>
                </li>
            </ul>

            <div class="pt-4 mt-4 space-y-2 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            fill="none" viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                        </svg>
                        <span class="ms-3 font-medium">{{ __('Log Out') }}</span>
                    </x-nav-link>
                </form>
            </div>
        </div>
    </div>
</aside>
