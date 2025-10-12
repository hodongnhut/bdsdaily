

<!-- NEW: HORIZONTAL VIDEO CAROUSEL SECTION -->
<section id="horizontal-video-feed" class="py-6 bg-white shadow-sm border-b border-gray-200">
    <div class="container mx-auto px-4 md:px-0">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Video Hướng Dẫn Sử Dụng</h3>
        
        <!-- Wrapper for Carousel and Controls -->
        <div class="relative">
            <!-- Navigation Buttons (Now always visible) -->
            
            <!-- Scroll Back Button -->
            <!-- Loại bỏ 'hidden md:block' để hiển thị trên di động -->
            <button id="scroll-back" class="absolute top-1/2 left-0 transform -translate-y-1/2 z-10 p-2 bg-white rounded-r-xl shadow-xl border border-gray-300 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 opacity-80 md:opacity-100" onclick="scrollBack()">
                <!-- Chevron Left Icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            
            <!-- Scroll Next Button -->
            <!-- Loại bỏ 'hidden md:block' để hiển thị trên di động -->
            <button id="scroll-next" class="absolute top-1/2 right-0 transform -translate-y-1/2 z-10 p-2 bg-white rounded-l-xl shadow-xl border border-gray-300 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 opacity-80 md:opacity-100" onclick="scrollNext()">
                <!-- Chevron Right Icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Horizontal Scroll Container - Đã thêm padding (pl-10 pr-10) để nhường chỗ cho nút -->
            <div id="horizontal-carousel" class="flex space-x-4 overflow-x-auto pb-4 scroll-smooth pl-10 pr-10" style="
                /* Custom Scrollbar Styling (Webkit/Firefox) */
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* IE and Edge */
            ">
                <!-- Custom CSS for Scrollbar Hiding -->
                <style>
                    #horizontal-carousel::-webkit-scrollbar {
                        display: none; /* Chrome, Safari, Opera */
                    }
                </style>
                
                <!-- Video Carousel Items will be rendered here -->
                <div id="carousel-items-container" class="flex space-x-4">
                    <div class="text-center text-gray-500 p-8">Đang tải video nổi bật...</div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    // Hàm mô phỏng việc định dạng số lượt xem (ví dụ: 177395 -> 177K)
    function formatViews(num) {
        if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
        if (num >= 1000) return (num / 1000).toFixed(0) + 'K';
        return num.toString();
    }

    // Dữ liệu mẫu (Mock Data) đã được thay thế bằng kết quả tìm kiếm YouTube về "Hướng dẫn dùng"
    const videoFeedData = [
        {
            id: 1, author: "BDSDaily", time: "8 tháng trước", 
            title: "Email marketing tools gửi 1000 email daily", views: "177K", duration: "28:39",
            thumbnail: "https://bdsdaily.com/img/email-marketing.webp", 
            avatar: "GH", link: "https://youtu.be/W70xiAUZ3h0?si=ykE7XiFclApnpEDF"
        },
        {
            id: 2, author: "BDSDaily", time: "1 năm trước", 
            title: "Lên mẫu Email gửi mời khách hành - BDSDaily", views: "207K", duration: "05:50",
            thumbnail: "https://bdsdaily.com/img/Email-template.webp", 
            avatar: "MV", link: "http://www.youtube.com/watch?v=H0_cP4a_rzs"
        },
        {
            id: 3, author: "BDSDaily", time: "4 tháng trước", 
            title: "Gửi hàng 1000 Email qua hệ thống - BDSDaily", views: "6K", duration: "00:55",
            thumbnail: "https://bdsdaily.com/img/1000-email.webp", 
            avatar: "EB", link: "https://youtu.be/_bHFN-Zv478?si=EUvFQJ2euqkzH9uD"
        },
        {
            id: 4, author: "BDSDaily", time: "10 tháng trước", 
            title: "App Nhà Phố - Phần mềm nhà phố", views: "20K", duration: "00:49",
            thumbnail: "https://bdsdaily.com/img/slider1.webp", 
            avatar: "ST", link: "https://youtu.be/jfA5Mj7WlNI?si=Q3MtvdVl7YiYfFPf"
        },
        {
            id: 5, author: "BDSDaily", time: "8 tháng trước", 
            title: "Hướng dẫn dùng Check bảng đồ Quy Hoạch", views: "32K", duration: "00:56",
            thumbnail: "https://bdsdaily.com/img/slider2.webp", 
            avatar: "RQ", link: "https://youtu.be/WXqaFdcm0Y0?si=nPe3xOLJmmKaqtEM"
        },
        {
            id: 6, author: "Review by Quyên aaa", time: "8 tháng trước", 
            title: "Hướng dẫn dùng App mobile BDSDaily", views: "32K", duration: "00:56",
            thumbnail: "https://bdsdaily.com/img/slider3.webp", 
            avatar: "RQ", link: "https://youtu.be/pGw7yK4UF6Q?si=zLIl0sYD5A1ezGiC"
        },
        {
            id: 7, author: "Review by Quyên aaa", time: "8 tháng trước", 
            title: "Đồng Bộ Zalo Group cập nhật mới", views: "32K", duration: "00:56",
            thumbnail: "https://bdsdaily.com/img/slider4.webp", 
            avatar: "RQ", link: "https://youtube.com/shorts/qMeJY8nJ4Z8?si=dwppQAl1Jp5rZ1yG"
        },
    ];

    /**
     * Generates the HTML structure for a single vertical video post.
     * @param {Object} post - The video post data.
     * @returns {string} HTML string for the vertical post card.
     */
    function createVerticalVideoPostHtml(post) {
        // Simple color mapping based on avatar initials for consistency
        let avatarBgColor = '#5B55E2'; 
        if (post.avatar === 'MV') avatarBgColor = '#10B981';
        else if (post.avatar === 'EB') avatarBgColor = '#FBBF24';
        else if (post.avatar === 'ST') avatarBgColor = '#EF4444';
        else if (post.avatar === 'RQ') avatarBgColor = '#3B82F6';

        return `
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <a href="${post.link}" target="_blank" onclick="showCustomModal('Đang mở video YouTube: ${post.title}')" class="relative block bg-black group">
                    <img src="${post.thumbnail}" alt="Thumbnail for ${post.title}" onerror="this.onerror=null;this.src='https://placehold.co/600x338/6B7280/ffffff?text=Video';" class="w-full object-cover rounded-t-xl transition duration-500 group-hover:opacity-80 aspect-video">
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition duration-300">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs font-semibold px-2 py-1 rounded-md">${post.duration}</span>
                </a>

                <div class="p-4">
                    <div class="flex items-start space-x-3 mb-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md" style="background-color: ${avatarBgColor};">
                            ${post.avatar}
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-base font-bold text-gray-900 line-clamp-2">${post.title}</h4>
                            <p class="text-sm text-gray-600 hover:text-indigo-600 cursor-pointer transition duration-150">${post.author}</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center text-xs text-gray-500 border-t pt-3">
                        <span>${post.views} lượt xem • ${post.time}</span>
                        <button class="text-gray-500 hover:text-indigo-600 transition duration-150" onclick="showCustomModal('Chia sẻ bài đăng: ${post.id}')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.035 3.018A4.473 4.473 0 0018 20a4.473 4.473 0 00-3.281-1.342l-6.035-3.018zm0-2.684L11.964 8.018A4.473 4.473 0 0018 4a4.473 4.473 0 00-3.281 1.342l-6.035 3.018z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Generates the HTML structure for a single horizontal video card (compact).
     * @param {Object} post - The video post data.
     * @returns {string} HTML string for the horizontal card.
     */
    function createHorizontalVideoCardHtml(post) {
        return `
            <div class="flex-shrink-0 w-48 sm:w-60 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition duration-300 transform hover:scale-[1.01]">
                <a href="${post.link}" target="_blank" onclick="showCustomModal('Đang mở video YouTube: ${post.title}')" class="relative block bg-black group">
                    <img src="${post.thumbnail}" alt="Thumbnail for ${post.title}" onerror="this.onerror=null;this.src='https://placehold.co/600x338/6B7280/ffffff?text=Video';" class="w-full object-cover transition duration-500 group-hover:opacity-80 aspect-[16/9]">
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="absolute bottom-1 right-1 bg-black bg-opacity-70 text-white text-xs font-semibold px-1 rounded-md">${post.duration}</span>
                </a>
                <div class="p-3">
                    <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 leading-tight">${post.title}</h4>
                    <p class="text-xs text-gray-500 mt-1">${post.author} • ${post.views} lượt xem</p>
                </div>
            </div>
        `;
    }

    // Function to render the horizontal carousel posts
    function renderHorizontalFeed() {
        const container = document.getElementById('carousel-items-container');
        if (container) {
            container.innerHTML = '';
            // Hiển thị TẤT CẢ video cho phần "Video Hướng Dẫn Sử Dụng" (Băng chuyền ngang)
            const allPosts = videoFeedData; 
            const carouselHtml = allPosts.map(createHorizontalVideoCardHtml).join('');
            container.innerHTML = carouselHtml;
        }
    }


    // Scroll distance calculation: w-60 (240px) + space-x-4 (16px) = 256px.
    // Dùng 260px cho an toàn
    const SCROLL_DISTANCE = 260; 

    /**
     * Scrolls the horizontal carousel backward by one card width.
     */
    function scrollBack() {
        const carousel = document.getElementById('horizontal-carousel');
        if (carousel) {
            carousel.scrollBy({
                left: -SCROLL_DISTANCE,
                behavior: 'smooth'
            });
        }
    }

    /**
     * Scrolls the horizontal carousel forward by one card width.
     */
    function scrollNext() {
        const carousel = document.getElementById('horizontal-carousel');
        if (carousel) {
            carousel.scrollBy({
                left: SCROLL_DISTANCE,
                behavior: 'smooth'
            });
        }
    }


    // Function to render the horizontal carousel posts
    function renderHorizontalFeed() {
        const container = document.getElementById('carousel-items-container');
        if (container) {
            container.innerHTML = '';
            // Hiển thị TẤT CẢ video cho phần "Video Hướng Dẫn Sử Dụng" (Băng chuyền ngang)
            const allPosts = videoFeedData; 
            const carouselHtml = allPosts.map(createHorizontalVideoCardHtml).join('');
            container.innerHTML = carouselHtml;
        }
    }

    // Function to render the vertical feed posts
    function renderVerticalFeed() {
        const container = document.getElementById('video-feed-container');
        if (container) {
            container.innerHTML = '';
            const feedHtml = videoFeedData.map(createVerticalVideoPostHtml).join('');
            container.innerHTML = feedHtml;
        }
    }


    // Execute the rendering when the document is ready
    document.addEventListener('DOMContentLoaded', () => {
        renderHorizontalFeed();
    });
</script>
