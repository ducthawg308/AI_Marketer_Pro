<x-app-dashboard title="Chỉnh sửa AI Prompt">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('admin.prompts.index') }}" class="text-primary-600 hover:text-primary-700 flex items-center gap-2 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Quay lại danh sách
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900">Cập nhật Prompt: {{ $prompt->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Slug hệ thống: <span class="font-mono text-primary-600 bg-primary-50 px-2 py-0.5 rounded">{{ $prompt->slug }}</span></p>
                    </div>

                    <form action="{{ route('admin.prompts.update', $prompt->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên hiển thị</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $prompt->name) }}" 
                                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('name') border-red-500 @enderror"
                                    required>
                                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- AI Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Vai trò AI (System Role)</label>
                                <input type="text" name="role" id="role" value="{{ old('role', $prompt->role) }}" 
                                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                    placeholder="Ví dụ: Chuyên gia Marketing, Trợ lý ảo...">
                            </div>

                            <!-- Content -->
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <label for="content" class="block text-sm font-medium text-gray-700">Nội dung Prompt</label>
                                    <span class="text-xs text-gray-400">Hỗ trợ biến số dạng {variable_name}</span>
                                </div>
                                <textarea name="content" id="content" rows="15" 
                                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 font-mono text-sm leading-relaxed @error('content') border-red-500 @enderror"
                                    required>{{ old('content', $prompt->content) }}</textarea>
                                @error('content') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Ghi chú hướng dẫn</label>
                                <textarea name="notes" id="notes" rows="3" 
                                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">{{ old('notes', $prompt->notes) }}</textarea>
                            </div>

                            <div class="pt-4 flex justify-end gap-3">
                                <a href="{{ route('admin.prompts.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    Hủy bỏ
                                </a>
                                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 shadow-sm transition-colors">
                                    Lưu thay đổi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-dashboard>
