/**
 * Refactored App.js - Uses new OOP API with Tailwind CSS
 * This is the new version that works with api/index.php
 */
$(document).ready(function() {
    // Mobile menu toggle
    $("#mobileMenuBtn").click(function() {
        $("#mobileMenu").slideToggle(300);
    });

    function loadProducts(category = "") {
        $("#loader").removeClass("hidden").show();
        $("#products").html('');

        API.call('product', 'fetch', {category: category})
            .then(function(products) {
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
                            '1': 'fa-mobile-alt',
                            '2': 'fa-book',
                            '3': 'fa-tshirt'
                        };
                        const categoryColors = {
                            '1': 'purple',
                            '2': 'blue',
                            '3': 'pink'
                        };
                        
                        const icon = categoryIcons[product.category_id] || 'fa-box';
                        const color = categoryColors[product.category_id] || 'gray';
                        const delay = (index % 8) * 0.1;
                        
                        html += `
                            <div class="product-card bg-white rounded-xl shadow-md overflow-hidden animate-fadeIn hover:shadow-lg transition-shadow duration-300" style="animation-delay: ${delay}s;">
                                <div class="bg-gradient-to-br from-${color}-100 to-${color}-50 p-6 flex items-center justify-center h-32 relative">
                                    <i class="fas ${icon} text-${color}-600 text-4xl"></i>
                                    <span class="absolute top-2 right-2 bg-white text-${color}-600 px-2 py-0.5 rounded-full text-xs font-semibold shadow-sm">
                                        ${product.category_name}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-base font-bold text-gray-800 mb-2 truncate" title="${product.name}">${product.name}</h3>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xl font-bold text-${color}-600">$${product.price}</span>
                                        <div class="text-yellow-400 text-xs">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    ${product.is_logged_in ? `
                                        <div class="flex space-x-2">
                                            <button class="edit-product flex-1 bg-${color}-600 hover:bg-${color}-700 text-white px-3 py-2 rounded-lg font-medium text-sm transition duration-300 flex items-center justify-center space-x-1" data-id="${product.id}">
                                                <i class="fas fa-edit text-xs"></i>
                                                <span>Edit</span>
                                            </button>
                                            <button class="delete-product flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg font-medium text-sm transition duration-300 flex items-center justify-center space-x-1" data-id="${product.id}">
                                                <i class="fas fa-trash text-xs"></i>
                                                <span>Delete</span>
                                            </button>
                                        </div>
                                    ` : `
                                        <button class="w-full bg-${color}-600 hover:bg-${color}-700 text-white px-3 py-2 rounded-lg font-medium text-sm transition duration-300 flex items-center justify-center space-x-1">
                                            <i class="fas fa-shopping-cart text-xs"></i>
                                            <span>Add to Cart</span>
                                        </button>
                                    `}
                                </div>
                            </div>
                        `;
                    });
                }
                
                $("#products").html(html);
                $("#loader").hide();
                
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

    loadProducts();

    $("#category").change(function() {
        loadProducts($(this).val());
    });

    $(document).on("click", ".edit-product", function() {
        const productId = $(this).data("id");
        window.location.href = "edit.php?id=" + productId;
    });

    $(document).on("click", ".delete-product", function() {
        const productId = $(this).data("id");
        const category = $("#category").val();
        
        // Create custom confirmation modal
        const confirmed = confirm("🗑️ Are you sure you want to delete this product?\n\nThis action cannot be undone!");
        
        if(!confirmed) {
            return;
        }
        
        // Show loading state
        const btn = $(this);
        const originalContent = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
        
        API.call('product', 'delete', {product_id: productId})
            .then(function(result) {
                // Show success notification
                const notification = $(`
                    <div class="fixed top-24 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slideIn">
                        <i class="fas fa-check-circle text-2xl"></i>
                        <span class="font-semibold">${result.message}</span>
                    </div>
                `);
                $('body').append(notification);
                setTimeout(() => notification.fadeOut(() => notification.remove()), 3000);
                
                loadProducts(category);
            })
            .catch(function(error) {
                btn.html(originalContent).prop('disabled', false);
                
                if (error.includes('logged in')) {
                    const notification = $(`
                        <div class="fixed top-24 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slideIn">
                            <i class="fas fa-lock text-2xl"></i>
                            <span class="font-semibold">Please login to delete products!</span>
                        </div>
                    `);
                    $('body').append(notification);
                    setTimeout(() => {
                        notification.fadeOut(() => notification.remove());
                        window.location.href = "login.php";
                    }, 2000);
                } else {
                    const notification = $(`
                        <div class="fixed top-24 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slideIn">
                            <i class="fas fa-exclamation-circle text-2xl"></i>
                            <span class="font-semibold">Error: ${error}</span>
                        </div>
                    `);
                    $('body').append(notification);
                    setTimeout(() => notification.fadeOut(() => notification.remove()), 3000);
                }
            });
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
