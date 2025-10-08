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
                  <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                </div>
                <input type="text" name="email" id="mobile-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full pl-10 p-2.5" placeholder="Search">
              </div>
            </form>
          </li>
          <li>
            <a href="{{ route('dashboard.campaign_tracking.index') }}"
              class="@if(request()->routeIs('dashboard.campaign_tracking.index')) bg-gray-100 text-primary-600 @else text-gray-900 @endif font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group">
              <svg class="w-6 h-6 @if(request()->routeIs('dashboard.campaign_tracking.index')) text-primary-600 @else text-gray-500 @endif group-hover:text-gray-900 transition duration-75"
                  fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
              </svg>
              <span class="ml-3">Theo dõi chiến dịch</span>
            </a>
          </li>
          <li>
            <a href="{{ route('dashboard.audience_config.index') }}"
              class="@if(request()->is('dashboard/audience_config*')) bg-gray-100 text-primary-600 @else text-gray-900 @endif font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group">
                <svg class="w-6 h-6 @if(request()->is('dashboard/audience_config*')) text-primary-600 @else text-gray-500 @endif flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="ml-3 flex-1 whitespace-nowrap">Đối tượng mục tiêu</span>
            </a>
          </li>
          <li>
            <a href="{{ route('dashboard.market_analysis.index') }}"
              class="@if(request()->is('dashboard/market_analysis*')) bg-gray-100 text-primary-600 @else text-gray-900 @endif font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group">
                <svg class="w-6 h-6 @if(request()->is('dashboard/market_analysis*')) text-primary-600 @else text-gray-500 @endif flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                  fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
                <span class="ml-3 flex-1 whitespace-nowrap">Nghiên cứu thị trường</span>
            </a>
          </li>
          <li>
            <a href="{{ route('dashboard.content_creator.index') }}"
              class="@if(request()->is('dashboard/content_creator*')) bg-gray-100 text-primary-600 @else text-gray-900 @endif font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group">
                <svg class="w-6 h-6 @if(request()->is('dashboard/content_creator*')) text-primary-600 @else text-gray-500 @endif flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17A3 3 0 015 5zm9 11a1 1 0 102 0 1 1 0 00-2 0zm-9 0a1 1 0 102 0 1 1 0 00-2 0z"
                          clip-rule="evenodd"></path>
                </svg>
                <span class="ml-3 flex-1 whitespace-nowrap">Khởi tạo Content</span>
            </a>
          </li>
          <li>
            <a href="{{ route('dashboard.auto_publisher.index') }}"
              class="@if(request()->is('dashboard/auto_publisher*')) bg-gray-100 text-primary-600 @else text-gray-900 @endif font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group">
                <svg class="w-6 h-6 @if(request()->is('dashboard/auto_publisher*')) text-primary-600 @else text-gray-500 @endif flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L11.414 15H14a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"></path>
                </svg>
                <span class="ml-3 flex-1 whitespace-nowrap">Trung tâm đăng bài</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</aside>

<div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>