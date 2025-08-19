<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lên lịch đăng bài tự động</title>
    <!-- Thêm CDN Tailwind và Flowbite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.4.3/dist/flowbite.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <header class="text-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Lên lịch đăng bài tự động</h1>
            <p class="text-lg text-gray-500">Lên lịch đăng bài theo chiến dịch hoặc tự chọn thời gian</p>
        </header>

        <!-- Tabs for Choosing Scheduling Option -->
        <div class="flex justify-center space-x-4 mb-6">
            <button id="campaignTab" class="tab-button px-4 py-2 bg-blue-600 text-white rounded-lg">Lên lịch theo chiến dịch</button>
            <button id="manualTab" class="tab-button px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Lên lịch tự chọn</button>
        </div>

        <!-- Scheduling Option Forms -->
        <div id="campaignForm" class="hidden space-y-4">
            <div>
                <label for="campaign" class="block text-gray-700 font-medium">Chọn chiến dịch</label>
                <select id="campaign" class="w-full mt-2 px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option>Chiến dịch Mùa Hè Sale</option>
                    <option>Chiến dịch Khuyến Mãi Tết</option>
                    <option>Chiến dịch Mua 1 Tặng 1</option>
                </select>
            </div>
            <button class="mt-4 px-6 py-2 bg-green-600 text-white rounded-md">Chọn chiến dịch</button>
        </div>

        <div id="manualForm" class="hidden space-y-4">
            <div>
                <label for="postTitle" class="block text-gray-700 font-medium">Tiêu đề bài viết</label>
                <input id="postTitle" type="text" placeholder="Tiêu đề bài viết" class="w-full mt-2 px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="postType" class="block text-gray-700 font-medium">Chọn loại bài viết</label>
                <select id="postType" class="w-full mt-2 px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option>AI Content</option>
                    <option>Link</option>
                    <option>Manual</option>
                </select>
            </div>

            <div>
                <label for="scheduleDate" class="block text-gray-700 font-medium">Chọn ngày và giờ</label>
                <input id="scheduleDate" type="datetime-local" class="w-full mt-2 px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md">Lên lịch đăng</button>
        </div>

        <!-- Scheduled Post List -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách bài viết đã lên lịch</h2>
            <table class="min-w-full table-auto bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700">Tiêu đề bài viết</th>
                        <th class="px-4 py-2 text-left text-gray-700">Loại bài viết</th>
                        <th class="px-4 py-2 text-left text-gray-700">Ngày giờ đăng</th>
                        <th class="px-4 py-2 text-left text-gray-700">Chiến dịch</th>
                        <th class="px-4 py-2 text-left text-gray-700">Trạng thái</th>
                        <th class="px-4 py-2 text-left text-gray-700">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu giả cho bài viết đã lên lịch -->
                    <tr>
                        <td class="px-4 py-2">Màn hình ASUS TUF Gaming VG27AQA3A</td>
                        <td class="px-4 py-2">AI Content</td>
                        <td class="px-4 py-2">19/08/2025 02:04</td>
                        <td class="px-4 py-2">Chiến dịch Mùa Hè Sale</td>
                        <td class="px-4 py-2 text-green-600">Đang hoạt động</td>
                        <td class="px-4 py-2">
                            <button class="text-blue-600 hover:underline">Chỉnh sửa</button> |
                            <button class="text-red-600 hover:underline">Xóa</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Smartphone Samsung Galaxy A54</td>
                        <td class="px-4 py-2">Link</td>
                        <td class="px-4 py-2">20/08/2025 10:00</td>
                        <td class="px-4 py-2">Chiến dịch Khuyến Mãi Tết</td>
                        <td class="px-4 py-2 text-yellow-600">Chưa đăng</td>
                        <td class="px-4 py-2">
                            <button class="text-blue-600 hover:underline">Chỉnh sửa</button> |
                            <button class="text-red-600 hover:underline">Xóa</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Laptop Dell Inspiron 15</td>
                        <td class="px-4 py-2">Manual</td>
                        <td class="px-4 py-2">21/08/2025 15:30</td>
                        <td class="px-4 py-2">Chiến dịch Mua 1 Tặng 1</td>
                        <td class="px-4 py-2 text-blue-600">Đã hoàn thành</td>
                        <td class="px-4 py-2">
                            <button class="text-blue-600 hover:underline">Chỉnh sửa</button> |
                            <button class="text-red-600 hover:underline">Xóa</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.4.3/dist/flowbite.bundle.min.js"></script>

    <script>
        // Switch between the tabs
        document.getElementById('campaignTab').addEventListener('click', () => {
            document.getElementById('campaignForm').classList.remove('hidden');
            document.getElementById('manualForm').classList.add('hidden');
            document.getElementById('campaignTab').classList.add('bg-blue-600', 'text-white');
            document.getElementById('manualTab').classList.remove('bg-blue-600', 'text-white');
        });

        document.getElementById('manualTab').addEventListener('click', () => {
            document.getElementById('manualForm').classList.remove('hidden');
            document.getElementById('campaignForm').classList.add('hidden');
            document.getElementById('manualTab').classList.add('bg-blue-600', 'text-white');
            document.getElementById('campaignTab').classList.remove('bg-blue-600', 'text-white');
        });
    </script>
</body>

</html>
