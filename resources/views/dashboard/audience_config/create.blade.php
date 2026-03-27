<x-app-dashboard>
    <div class="min-h-screen bg-primary-50 p-6">
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Thêm đối tượng mục tiêu</h2>
                    <a href="{{ route('dashboard.audience_config.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Quay lại
                    </a>
                </div>
                <form action="{{ route('dashboard.audience_config.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Tên sản phẩm/dịch vụ -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm/dịch vụ</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" required>
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Ngành nghề -->
                    <div>
                        <label for="industry" class="block text-sm font-medium text-gray-700">Ngành nghề</label>
                        <select id="industry" name="industry"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm"
                            required>
                            <option value="">Chọn ngành nghề</option>

                            <!-- Nhóm B2C -->
                            <optgroup label="B2C - Hàng hóa & Tiêu dùng">
                                <option value="Thời trang & Phụ kiện" {{ old('industry', $item->industry ?? '') === 'Thời trang & Phụ kiện' ? 'selected' : '' }}>Thời trang & Phụ kiện</option>
                                <option value="Làm đẹp & Mỹ phẩm" {{ old('industry', $item->industry ?? '') === 'Làm đẹp & Mỹ phẩm' ? 'selected' : '' }}>Làm đẹp & Mỹ phẩm</option>
                                <option value="Đồ điện tử & Công nghệ" {{ old('industry', $item->industry ?? '') === 'Đồ điện tử & Công nghệ' ? 'selected' : '' }}>Đồ điện tử & Công nghệ</option>
                                <option value="Đồ gia dụng & Nội thất" {{ old('industry', $item->industry ?? '') === 'Đồ gia dụng & Nội thất' ? 'selected' : '' }}>Đồ gia dụng & Nội thất</option>
                                <option value="Thực phẩm & Đồ uống" {{ old('industry', $item->industry ?? '') === 'Thực phẩm & Đồ uống' ? 'selected' : '' }}>Thực phẩm & Đồ uống</option>
                                <option value="Thể thao & Sức khỏe" {{ old('industry', $item->industry ?? '') === 'Thể thao & Sức khỏe' ? 'selected' : '' }}>Thể thao & Sức khỏe</option>
                                <option value="Du lịch & Giải trí" {{ old('industry', $item->industry ?? '') === 'Du lịch & Giải trí' ? 'selected' : '' }}>Du lịch & Giải trí</option>
                                <option value="Mẹ & Bé" {{ old('industry', $item->industry ?? '') === 'Mẹ & Bé' ? 'selected' : '' }}>Mẹ & Bé</option>
                            </optgroup>

                            <!-- Nhóm B2B -->
                            <optgroup label="B2B - Dịch vụ & Giải pháp Doanh nghiệp">
                                <option value="Phần mềm & Ứng dụng (SaaS)" {{ old('industry', $item->industry ?? '') === 'Phần mềm & Ứng dụng (SaaS)' ? 'selected' : '' }}>Phần mềm & Ứng dụng (SaaS)</option>
                                <option value="Marketing & Quảng cáo" {{ old('industry', $item->industry ?? '') === 'Marketing & Quảng cáo' ? 'selected' : '' }}>Marketing & Quảng cáo</option>
                                <option value="Đào tạo & Giáo dục" {{ old('industry', $item->industry ?? '') === 'Đào tạo & Giáo dục' ? 'selected' : '' }}>Đào tạo & Giáo dục</option>
                                <option value="Tài chính & Ngân hàng" {{ old('industry', $item->industry ?? '') === 'Tài chính & Ngân hàng' ? 'selected' : '' }}>Tài chính & Ngân hàng</option>
                                <option value="Bất động sản" {{ old('industry', $item->industry ?? '') === 'Bất động sản' ? 'selected' : '' }}>Bất động sản</option>
                                <option value="Logistics & Vận tải" {{ old('industry', $item->industry ?? '') === 'Logistics & Vận tải' ? 'selected' : '' }}>Logistics & Vận tải</option>
                                <option value="Tư vấn & Dịch vụ doanh nghiệp" {{ old('industry', $item->industry ?? '') === 'Tư vấn & Dịch vụ doanh nghiệp' ? 'selected' : '' }}>Tư vấn & Dịch vụ doanh nghiệp</option>
                                <option value="Nhân sự & Tuyển dụng" {{ old('industry', $item->industry ?? '') === 'Nhân sự & Tuyển dụng' ? 'selected' : '' }}>Nhân sự & Tuyển dụng</option>
                            </optgroup>

                            <!-- Nhóm Công nghệ & Sáng tạo -->
                            <optgroup label="Công nghệ & Sáng tạo số">
                                <option value="Công nghệ thông tin / AI / IoT" {{ old('industry', $item->industry ?? '') === 'Công nghệ thông tin / AI / IoT' ? 'selected' : '' }}>Công nghệ thông tin / AI / IoT</option>
                                <option value="Thiết kế đồ họa & Sản xuất nội dung" {{ old('industry', $item->industry ?? '') === 'Thiết kế đồ họa & Sản xuất nội dung' ? 'selected' : '' }}>Thiết kế đồ họa & Sản xuất nội dung</option>
                                <option value="Game / eSports" {{ old('industry', $item->industry ?? '') === 'Game / eSports' ? 'selected' : '' }}>Game / eSports</option>
                                <option value="Thương mại điện tử" {{ old('industry', $item->industry ?? '') === 'Thương mại điện tử' ? 'selected' : '' }}>Thương mại điện tử</option>
                                <option value="Truyền thông / Streaming" {{ old('industry', $item->industry ?? '') === 'Truyền thông / Streaming' ? 'selected' : '' }}>Truyền thông / Streaming</option>
                            </optgroup>

                            <!-- Khác -->
                            <optgroup label="Khác">
                                <option value="Y tế & Dược phẩm" {{ old('industry', $item->industry ?? '') === 'Y tế & Dược phẩm' ? 'selected' : '' }}>Y tế & Dược phẩm</option>
                                <option value="Nông nghiệp & Thực phẩm sạch" {{ old('industry', $item->industry ?? '') === 'Nông nghiệp & Thực phẩm sạch' ? 'selected' : '' }}>Nông nghiệp & Thực phẩm sạch</option>
                                <option value="Ô tô & Phương tiện di chuyển" {{ old('industry', $item->industry ?? '') === 'Ô tô & Phương tiện di chuyển' ? 'selected' : '' }}>Ô tô & Phương tiện di chuyển</option>
                                <option value="Phi lợi nhuận / Cộng đồng" {{ old('industry', $item->industry ?? '') === 'Phi lợi nhuận / Cộng đồng' ? 'selected' : '' }}>Phi lợi nhuận / Cộng đồng</option>
                                <option value="Khác" {{ old('industry', $item->industry ?? '') === 'Khác' ? 'selected' : '' }}>Khác</option>
                            </optgroup>
                        </select>
                        @error('industry')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mô tả ngắn gọn -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả ngắn gọn</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Đặc điểm khách hàng mục tiêu -->
                    <div>
                        <h3 class="text-lg font-semibold text-primary-600 mb-2">Khách hàng mục tiêu</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="target_customer_age_range" class="block text-sm font-medium text-gray-700">Độ tuổi</label>
                                <input type="text" id="target_customer_age_range" name="target_customer_age_range" value="{{ old('target_customer_age_range') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: 18-25">
                                @error('target_customer_age_range') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="target_customer_income_level" class="block text-sm font-medium text-gray-700">Mức thu nhập</label>
                                <input type="text" id="target_customer_income_level" name="target_customer_income_level" value="{{ old('target_customer_income_level') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Trung bình">
                                @error('target_customer_income_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="target_customer_interests" class="block text-sm font-medium text-gray-700">Sở thích</label>
                                <input type="text" id="target_customer_interests" name="target_customer_interests" value="{{ old('target_customer_interests') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Thể thao, Công nghệ">
                                @error('target_customer_interests') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Đối thủ cạnh tranh -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-semibold text-primary-600">Đối thủ cạnh tranh (Tùy chọn)</h3>
                            <button type="button" id="add-competitor-btn" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 focus:outline-none transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Thêm đối thủ
                            </button>
                        </div>
                        
                        <div id="competitors-container" class="space-y-4">
                            <!-- Competitor Item Template -->
                            <div class="competitor-item border border-gray-200 rounded-lg p-4 bg-gray-50 relative">
                                <button type="button" class="remove-competitor-btn absolute top-3 right-3 text-red-500 hover:text-red-700 hidden">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tên đối thủ</label>
                                        <input type="text" name="competitors[0][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Shopee">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">URL đối thủ</label>
                                        <input type="url" name="competitors[0][url]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="https://">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('competitors') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const container = document.getElementById('competitors-container');
                            const addBtn = document.getElementById('add-competitor-btn');
                            let competitorCount = 1;

                            // Update remove buttons visibility
                            function updateRemoveButtons() {
                                const items = container.querySelectorAll('.competitor-item');
                                items.forEach((item, index) => {
                                    const removeBtn = item.querySelector('.remove-competitor-btn');
                                    // Show remove button for all except the first one if it's the only one
                                    if (items.length > 1) {
                                        removeBtn.classList.remove('hidden');
                                    } else {
                                        removeBtn.classList.add('hidden');
                                    }
                                });
                            }

                            // Add new competitor
                            addBtn.addEventListener('click', function() {
                                const template = `
                                    <div class="competitor-item border border-gray-200 rounded-lg p-4 bg-gray-50 relative mt-4">
                                        <button type="button" class="remove-competitor-btn absolute top-3 right-3 text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-6">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Tên đối thủ</label>
                                                <input type="text" name="competitors[${competitorCount}][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">URL đối thủ</label>
                                                <input type="url" name="competitors[${competitorCount}][url]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="https://">
                                            </div>
                                        </div>
                                    </div>
                                `;
                                
                                container.insertAdjacentHTML('beforeend', template);
                                competitorCount++;
                                updateRemoveButtons();
                            });

                            // Remove competitor
                            container.addEventListener('click', function(e) {
                                const removeBtn = e.target.closest('.remove-competitor-btn');
                                if (removeBtn) {
                                    const item = removeBtn.closest('.competitor-item');
                                    item.remove();
                                    updateRemoveButtons();
                                }
                            });
                            
                            updateRemoveButtons();
                        });
                    </script>

                    <!-- Nút gửi -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Lưu Thông Tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-dashboard>