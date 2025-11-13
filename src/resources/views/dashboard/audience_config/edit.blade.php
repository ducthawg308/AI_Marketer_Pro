<x-app-dashboard>
    <div class="min-h-screen bg-primary-50 p-6">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Chỉnh sửa đối tượng mục tiêu</h2>
                    <a href="{{ route('dashboard.audience_config.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Quay lại
                    </a>
                </div>
                <form action="{{ route('dashboard.audience_config.update', [$item->id]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <!-- Tên sản phẩm/dịch vụ -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm/dịch vụ</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" required>
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
                                <option value="Thời trang & Phụ kiện" {{ old('industry', $item->industry) === 'Thời trang & Phụ kiện' ? 'selected' : '' }}>Thời trang & Phụ kiện</option>
                                <option value="Làm đẹp & Mỹ phẩm" {{ old('industry', $item->industry) === 'Làm đẹp & Mỹ phẩm' ? 'selected' : '' }}>Làm đẹp & Mỹ phẩm</option>
                                <option value="Đồ điện tử & Công nghệ" {{ old('industry', $item->industry) === 'Đồ điện tử & Công nghệ' ? 'selected' : '' }}>Đồ điện tử & Công nghệ</option>
                                <option value="Đồ gia dụng & Nội thất" {{ old('industry', $item->industry) === 'Đồ gia dụng & Nội thất' ? 'selected' : '' }}>Đồ gia dụng & Nội thất</option>
                                <option value="Thực phẩm & Đồ uống" {{ old('industry', $item->industry) === 'Thực phẩm & Đồ uống' ? 'selected' : '' }}>Thực phẩm & Đồ uống</option>
                                <option value="Thể thao & Sức khỏe" {{ old('industry', $item->industry) === 'Thể thao & Sức khỏe' ? 'selected' : '' }}>Thể thao & Sức khỏe</option>
                                <option value="Du lịch & Giải trí" {{ old('industry', $item->industry) === 'Du lịch & Giải trí' ? 'selected' : '' }}>Du lịch & Giải trí</option>
                                <option value="Mẹ & Bé" {{ old('industry', $item->industry) === 'Mẹ & Bé' ? 'selected' : '' }}>Mẹ & Bé</option>
                            </optgroup>

                            <!-- Nhóm B2B -->
                            <optgroup label="B2B - Dịch vụ & Giải pháp Doanh nghiệp">
                                <option value="Phần mềm & Ứng dụng (SaaS)" {{ old('industry', $item->industry) === 'Phần mềm & Ứng dụng (SaaS)' ? 'selected' : '' }}>Phần mềm & Ứng dụng (SaaS)</option>
                                <option value="Marketing & Quảng cáo" {{ old('industry', $item->industry) === 'Marketing & Quảng cáo' ? 'selected' : '' }}>Marketing & Quảng cáo</option>
                                <option value="Đào tạo & Giáo dục" {{ old('industry', $item->industry) === 'Đào tạo & Giáo dục' ? 'selected' : '' }}>Đào tạo & Giáo dục</option>
                                <option value="Tài chính & Ngân hàng" {{ old('industry', $item->industry) === 'Tài chính & Ngân hàng' ? 'selected' : '' }}>Tài chính & Ngân hàng</option>
                                <option value="Bất động sản" {{ old('industry', $item->industry) === 'Bất động sản' ? 'selected' : '' }}>Bất động sản</option>
                                <option value="Logistics & Vận tải" {{ old('industry', $item->industry) === 'Logistics & Vận tải' ? 'selected' : '' }}>Logistics & Vận tải</option>
                                <option value="Tư vấn & Dịch vụ doanh nghiệp" {{ old('industry', $item->industry) === 'Tư vấn & Dịch vụ doanh nghiệp' ? 'selected' : '' }}>Tư vấn & Dịch vụ doanh nghiệp</option>
                                <option value="Nhân sự & Tuyển dụng" {{ old('industry', $item->industry) === 'Nhân sự & Tuyển dụng' ? 'selected' : '' }}>Nhân sự & Tuyển dụng</option>
                            </optgroup>

                            <!-- Nhóm Công nghệ & Sáng tạo -->
                            <optgroup label="Công nghệ & Sáng tạo số">
                                <option value="Công nghệ thông tin / AI / IoT" {{ old('industry', $item->industry) === 'Công nghệ thông tin / AI / IoT' ? 'selected' : '' }}>Công nghệ thông tin / AI / IoT</option>
                                <option value="Thiết kế đồ họa & Sản xuất nội dung" {{ old('industry', $item->industry) === 'Thiết kế đồ họa & Sản xuất nội dung' ? 'selected' : '' }}>Thiết kế đồ họa & Sản xuất nội dung</option>
                                <option value="Game / eSports" {{ old('industry', $item->industry) === 'Game / eSports' ? 'selected' : '' }}>Game / eSports</option>
                                <option value="Thương mại điện tử" {{ old('industry', $item->industry) === 'Thương mại điện tử' ? 'selected' : '' }}>Thương mại điện tử</option>
                                <option value="Truyền thông / Streaming" {{ old('industry', $item->industry) === 'Truyền thông / Streaming' ? 'selected' : '' }}>Truyền thông / Streaming</option>
                            </optgroup>

                            <!-- Khác -->
                            <optgroup label="Khác">
                                <option value="Y tế & Dược phẩm" {{ old('industry', $item->industry) === 'Y tế & Dược phẩm' ? 'selected' : '' }}>Y tế & Dược phẩm</option>
                                <option value="Nông nghiệp & Thực phẩm sạch" {{ old('industry', $item->industry) === 'Nông nghiệp & Thực phẩm sạch' ? 'selected' : '' }}>Nông nghiệp & Thực phẩm sạch</option>
                                <option value="Ô tô & Phương tiện di chuyển" {{ old('industry', $item->industry) === 'Ô tô & Phương tiện di chuyển' ? 'selected' : '' }}>Ô tô & Phương tiện di chuyển</option>
                                <option value="Phi lợi nhuận / Cộng đồng" {{ old('industry', $item->industry) === 'Phi lợi nhuận / Cộng đồng' ? 'selected' : '' }}>Phi lợi nhuận / Cộng đồng</option>
                                <option value="Khác" {{ old('industry', $item->industry) === 'Khác' ? 'selected' : '' }}>Khác</option>
                            </optgroup>
                        </select>

                        @error('industry')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Mô tả ngắn gọn -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả ngắn gọn</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">{{ old('description', $item->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Đặc điểm khách hàng mục tiêu -->
                    <div>
                        <h3 class="text-lg font-semibold text-primary-600 mb-2">Khách hàng mục tiêu</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="target_customer_age_range" class="block text-sm font-medium text-gray-700">Độ tuổi</label>
                                <input type="text" id="target_customer_age_range" name="target_customer_age_range" value="{{ old('target_customer_age_range', $item->target_customer_age_range) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: 18-25">
                                @error('target_customer_age_range') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="target_customer_income_level" class="block text-sm font-medium text-gray-700">Mức thu nhập</label>
                                <input type="text" id="target_customer_income_level" name="target_customer_income_level" value="{{ old('target_customer_income_level', $item->target_customer_income_level) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Trung bình">
                                @error('target_customer_income_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="target_customer_interests" class="block text-sm font-medium text-gray-700">Sở thích</label>
                                <input type="text" id="target_customer_interests" name="target_customer_interests" value="{{ old('target_customer_interests', $item->target_customer_interests) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Thể thao, Công nghệ">
                                @error('target_customer_interests') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Đối thủ cạnh tranh -->
                    <div>
                        <h3 class="text-lg font-semibold text-primary-600 mb-2">Đối thủ cạnh tranh (Tùy chọn)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="competitor_name" class="block text-sm font-medium text-gray-700">Tên đối thủ</label>
                                <input type="text" id="competitor_name" name="competitor_name" value="{{ old('competitor_name', $item->competitor_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">
                                @error('competitor_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="competitor_url" class="block text-sm font-medium text-gray-700">URL đối thủ</label>
                                <input type="url" id="competitor_url" name="competitor_url" value="{{ old('competitor_url', $item->competitor_url) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="https://">
                                @error('competitor_url') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="competitor_description" class="block text-sm font-medium text-gray-700">Mô tả đối thủ</label>
                                <textarea id="competitor_description" name="competitor_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">{{ old('competitor_description', $item->competitor_description) }}</textarea>
                                @error('competitor_description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Nút gửi -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Cập nhật Thông Tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-dashboard>