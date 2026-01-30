/**
 * Refactored App.js - Uses new OOP API with Tailwind CSS and Pagination
 * This is the new version that works with api/index.php
 */
$(document).ready(function() {
    let currentPage = 1;
    const productsPerPage = 12;
    
    // Mobile menu toggle
    $("#mobileMenuBtn").click(function() {
        $("#mobileMenu").slideToggle(300);
    });

    function loadProducts(category = "", page = 1) {
        $("#loader").removeClass("hidden").show();
        $("#products").html('');

        API.call('product', 'fetch', {
            category: category,
            page: page,
            limit: productsPerPage
        })
            .then(function(response) {
                // Handle backward compatibility - check if response has products array
                const products = response.products || response;
                const pagination = response.pagination || null;
                
                let html = '';
                
                if (products.length === 0) {
                    html = `
                        <div class="col-span-full text-center py-12">
                            <i class="fas fa-box-open text-gray-300 text-4xl mb-3"></i>
                            <p class="text-lg text-gray-500">No products found</p>
                            <p class="text-gray-400 text-sm mt-2">Try selecting a different category</p>
                        </div>
                    `;
                } else {
                    products.forEach(function(product, index) {
                        const categoryIcons = {
                            '1': 'fa-bread-slice',
                            '2': 'fa-leaf',
                            '3': 'fa-drumstick-bite'
                        };
                        const categoryColors = {
                            '1': 'green',
                            '2': 'emerald',
                            '3': 'teal'
                        };
                        
                        // Food category specific images from Unsplash
                        const categoryImages = {
                            '1': [ // Bakery & Desserts
                                'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1517433670267-08bbd4be890f?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1486427944299-d1955d23e34d?w=400&h=250&fit=crop'
                            ],
                            '2': [ // Vegetarian Meals
                                'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1511690743698-d9d85f2fbf38?w=400&h=250&fit=crop'
                            ],
                            '3': [ // Non-Veg Meals
                                'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1606755962773-d324e0a13086?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=400&h=250&fit=crop',
                                'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=400&h=250&fit=crop'
                            ]
                        };
                        
                        const icon = categoryIcons[product.category_id] || 'fa-box';
                        const color = categoryColors[product.category_id] || 'gray';
                        const delay = (index % 8) * 0.1;
                        
                        // Get food image based on category
                        const categoryImgArray = categoryImages[product.category_id] || categoryImages['1'];
                        const imageUrl = categoryImgArray[product.id % categoryImgArray.length];
                        
                        html += `
                            <div class="food-card bg-white rounded-xl shadow-md overflow-hidden animate-fadeIn hover:shadow-lg transition-shadow duration-300" style="animation-delay: ${delay}s;">
                                <div class="relative h-48 overflow-hidden bg-gray-100">
                                    <img src="${imageUrl}" alt="${product.name}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" loading="lazy">
                                    <span class="absolute top-2 right-2 bg-white text-${color}-600 px-2 py-1 rounded-full text-xs font-semibold shadow-md">
                                        <i class="fas ${icon} mr-1"></i>${product.category_name}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-base font-bold text-gray-800 mb-2 truncate" title="${product.name}">${product.name}</h3>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xl font-bold text-${color}-600">₹${parseFloat(product.price).toFixed(2)}</span>
                                        <div class="text-yellow-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    <button class="buy-food w-full bg-${color}-600 hover:bg-${color}-700 text-white px-3 py-2 rounded-lg font-medium text-sm transition duration-300 flex items-center justify-center space-x-1" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}">
                                        <i class="fas fa-shopping-bag text-xs"></i>
                                        <span>Buy Now</span>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                }
                
                $("#products").html(html);
                $("#loader").hide();
                
                // Render pagination if available
                if (pagination) {
                    renderPagination(pagination, category);
                }
                
                // Add scroll animation observer
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fadeIn');
                        }
                    });
                }, {threshold: 0.1});
                
                document.querySelectorAll('.product-card').forEach(card => {
                    observer.observe(card);
                });
            })
            .catch(function(error) {
                $("#products").html(`
                    <div class="col-span-full text-center py-20">
                        <i class="fas fa-exclamation-circle text-red-500 text-6xl mb-4"></i>
                        <p class="text-2xl text-red-500 font-bold">Oops! Something went wrong</p>
                        <p class="text-gray-600 mt-2">${error}</p>
                        <button onclick="location.reload()" class="mt-6 bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                            <i class="fas fa-redo mr-2"></i>Try Again
                        </button>
                    </div>
                `);
                $("#loader").hide();
            });
    }
    
    function renderPagination(pagination, category) {
        const paginationHtml = `
            <div class="col-span-full mt-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-white rounded-xl shadow-lg p-6">
                    <!-- Page Info -->
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2 text-green-600"></i>
                        Showing page <span class="font-bold text-green-600">${pagination.current_page}</span> 
                        of <span class="font-bold">${pagination.total_pages}</span>
                        <span class="hidden sm:inline">(${pagination.total_products} total products)</span>
                    </div>
                    
                    <!-- Pagination Buttons -->
                    <div class="flex items-center space-x-2">
                        ${pagination.has_prev ? `
                            <button class="pagination-btn px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 font-medium text-sm flex items-center" data-page="1" data-category="${category}">
                                <i class="fas fa-angle-double-left mr-2"></i>First
                            </button>
                            <button class="pagination-btn px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 font-medium text-sm flex items-center" data-page="${pagination.current_page - 1}" data-category="${category}">
                                <i class="fas fa-angle-left mr-2"></i>Prev
                            </button>
                        ` : `
                            <button class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium text-sm flex items-center" disabled>
                                <i class="fas fa-angle-double-left mr-2"></i>First
                            </button>
                            <button class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium text-sm flex items-center" disabled>
                                <i class="fas fa-angle-left mr-2"></i>Prev
                            </button>
                        `}
                        
                        <!-- Page Numbers -->
                        <div class="flex items-center space-x-1">
                            ${generatePageNumbers(pagination.current_page, pagination.total_pages, category)}
                        </div>
                        
                        ${pagination.has_next ? `
                            <button class="pagination-btn px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 font-medium text-sm flex items-center" data-page="${pagination.current_page + 1}" data-category="${category}">
                                Next<i class="fas fa-angle-right ml-2"></i>
                            </button>
                            <button class="pagination-btn px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 font-medium text-sm flex items-center" data-page="${pagination.total_pages}" data-category="${category}">
                                Last<i class="fas fa-angle-double-right ml-2"></i>
                            </button>
                        ` : `
                            <button class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium text-sm flex items-center" disabled>
                                Next<i class="fas fa-angle-right ml-2"></i>
                            </button>
                            <button class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-medium text-sm flex items-center" disabled>
                                Last<i class="fas fa-angle-double-right ml-2"></i>
                            </button>
                        `}
                    </div>
                </div>
            </div>
        `;
        
        $("#products").append(paginationHtml);
    }
    
    function generatePageNumbers(currentPage, totalPages, category) {
        let html = '';
        const maxVisible = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);
        
        // Adjust start if we're near the end
        if (endPage - startPage < maxVisible - 1) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }
        
        // Add first page and ellipsis if needed
        if (startPage > 1) {
            html += `
                <button class="pagination-btn w-10 h-10 rounded-lg border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition duration-300 font-medium text-sm" data-page="1" data-category="${category}">
                    1
                </button>
            `;
            if (startPage > 2) {
                html += '<span class="px-2 text-gray-500">...</span>';
            }
        }
        
        // Add page numbers
        for (let i = startPage; i <= endPage; i++) {
            if (i === currentPage) {
                html += `
                    <button class="w-10 h-10 rounded-lg bg-green-600 text-white font-bold text-sm shadow-lg" disabled>
                        ${i}
                    </button>
                `;
            } else {
                html += `
                    <button class="pagination-btn w-10 h-10 rounded-lg border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition duration-300 font-medium text-sm" data-page="${i}" data-category="${category}">
                        ${i}
                    </button>
                `;
            }
        }
        
        // Add last page and ellipsis if needed
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += '<span class="px-2 text-gray-500">...</span>';
            }
            html += `
                <button class="pagination-btn w-10 h-10 rounded-lg border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition duration-300 font-medium text-sm" data-page="${totalPages}" data-category="${category}">
                    ${totalPages}
                </button>
            `;
        }
        
        return html;
    }

    // Initial load
    loadProducts("", currentPage);

    $("#category").change(function() {
        currentPage = 1; // Reset to first page when category changes
        loadProducts($(this).val(), currentPage);
    });
    
    // Handle pagination button clicks
    $(document).on("click", ".pagination-btn", function() {
        const page = parseInt($(this).data("page"));
        const category = $(this).data("category");
        currentPage = page;
        loadProducts(category, page);
        
        // Smooth scroll to products section
        $('html, body').animate({
            scrollTop: $("#products-section").offset().top - 100
        }, 500);
    });

    // Handle Buy Now button clicks
    $(document).on("click", ".buy-food", function() {
        const productId = $(this).data("id");
        const productName = $(this).data("name");
        const productPrice = $(this).data("price");
        
        // Show loading state
        const btn = $(this);
        const originalContent = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
        
        // Simulate purchase process
        setTimeout(() => {
            // Show success notification
            const notification = $(`
                <div class="fixed top-24 right-4 bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slideIn">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <div>
                        <div class="font-semibold">Food Rescued Successfully! 🎉</div>
                        <div class="text-sm opacity-90">${productName} - ₹${parseFloat(productPrice).toFixed(2)}</div>
                    </div>
                </div>
            `);
            $('body').append(notification);
            setTimeout(() => notification.fadeOut(() => notification.remove()), 4000);
            
            // Reset button
            btn.html(originalContent).prop('disabled', false);
        }, 1000);
    });
    
    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if(target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 1000);
        }
    });
});
