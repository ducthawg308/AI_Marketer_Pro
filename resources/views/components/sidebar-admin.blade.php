<aside id="sidebar" class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75" aria-label="Sidebar">
  <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
      <div class="flex-1 px-3 bg-white divide-y space-y-1">
        <ul class="space-y-2 pb-2">
          <li>
            <form action="#" method="GET" class="lg:hidden">
              <label for="mobile-search" class="sr-only">Search</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                       xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476
                             l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                          clip-rule="evenodd"></path>
                  </svg>
                </div>
                <input type="text" name="email" id="mobile-search"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                              focus:ring-primary-600 focus:border-primary-600 block w-full pl-10 p-2.5"
                       placeholder="Search">
              </div>
            </form>
          </li>
          <li>
            <a href="{{ route('admin.users.index') }}"
               class="@if(request()->is('admin/users*')) bg-gray-100 text-primary-600 @else text-gray-900 @endif
                      font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group">
              <i class="fa-solid fa-users text-gray-500
                        @if(request()->is('admin/users*')) text-primary-600 @endif
                        group-hover:text-gray-900 transition duration-75
                        w-5 h-5 flex-shrink-0 leading-none align-middle"></i>
              <span class="ml-3 flex-1 whitespace-nowrap">Quản lý người dùng</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</aside>

<div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
