<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cửa hàng điện tử')</title>
    <meta name="description" content="@yield('description', 'Cửa hàng bán điện thoại, laptop, phụ kiện và thiết bị gia dụng chính hãng')">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        /* Header Styles */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .search-box {
            max-width: 500px;
        }

        /* Product Card Styles */
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .product-image {
            position: relative;
            overflow: hidden;
            height: 250px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
        }

        .price-original {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .price-sale {
            color: var(--danger-color);
            font-weight: bold;
            font-size: 1.1rem;
        }

        .discount-badge {
            background: linear-gradient(45deg, #ff6b6b, #ee5a6f);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }

        /* Category Cards */
        .category-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            text-decoration: none;
            color: inherit;
        }

        .category-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        /* Filter Sidebar */
        .filter-sidebar {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 50px;
            margin: 0 2px;
            border: none;
            color: var(--primary-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Footer */
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 50px 0 20px;
        }

        .footer h5 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                padding: 50px 0;
            }
            
            .product-image {
                height: 200px;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="{{ route('home') }}">
                <i class="ri-shopping-bag-3-line me-2"></i>TechStore
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Box -->
                <div class="mx-auto search-box d-none d-lg-block">
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Tìm kiếm sản phẩm..." 
                                   value="{{ request('search') }}"
                                   id="search-input">
                            <button class="btn btn-primary" type="submit">
                                <i class="ri-search-line"></i>
                            </button>
                        </div>
                    </form>
                    <div id="search-results" class="position-absolute w-100 bg-white shadow-lg rounded mt-1 d-none"></div>
                </div>

                <!-- Navigation Links -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="ri-home-line me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="ri-store-line me-1"></i>Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="ri-list-check me-1"></i>Danh mục
                        </a>
                        <ul class="dropdown-menu">
                            @php
                                $categories = \App\Models\LoaiSanPham::all();
                            @endphp
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('products.category', $category->id) }}">
                                    {{ $category->ten_loai }}
                                </a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="ri-information-line me-1"></i>Giới thiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="ri-phone-line me-1"></i>Liên hệ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#" id="cart-btn">
                            <i class="ri-shopping-cart-line me-1"></i>Giỏ hàng
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                                0
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="ri-check-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5>TechStore</h5>
                    <p>Cửa hàng bán điện thoại, laptop, phụ kiện và thiết bị gia dụng chính hãng với giá tốt nhất.</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="ri-facebook-line"></i></a>
                        <a href="#" class="me-3"><i class="ri-instagram-line"></i></a>
                        <a href="#" class="me-3"><i class="ri-youtube-line"></i></a>
                        <a href="#"><i class="ri-phone-line"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Danh mục</h5>
                    <ul class="list-unstyled">
                        @foreach($categories ?? [] as $category)
                            <li><a href="{{ route('products.category', $category->id) }}">{{ $category->ten_loai }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Hỗ trợ</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled">
                        <li><i class="ri-map-pin-line me-2"></i>123 Nguyễn Văn A, Q1, TP.HCM</li>
                        <li><i class="ri-phone-line me-2"></i>0123 456 789</li>
                        <li><i class="ri-mail-line me-2"></i>info@techstore.com</li>
                        <li><i class="ri-time-line me-2"></i>8:00 - 22:00 (Thứ 2 - CN)</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 TechStore. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">Developed with <i class="ri-heart-fill text-danger"></i> by Laravel</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Back to Top Button -->
    <button class="btn btn-primary position-fixed bottom-0 end-0 m-4 rounded-circle d-none" id="back-to-top" style="z-index: 999;">
        <i class="ri-arrow-up-line"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <script>
        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Back to top button
            const backToTop = document.getElementById('back-to-top');
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTop.classList.remove('d-none');
                } else {
                    backToTop.classList.add('d-none');
                }
            });

            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Search functionality
            const searchInput = document.getElementById('search-input');
            const searchResults = document.getElementById('search-results');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();
                    
                    if (query.length < 2) {
                        searchResults.classList.add('d-none');
                        return;
                    }

                    searchTimeout = setTimeout(() => {
                        fetch(`/api/products/search?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    let html = '<div class="p-3">';
                                    data.forEach(product => {
                                        html += `
                                            <div class="d-flex align-items-center py-2 border-bottom">
                                                <img src="${product.hinh_anh ? '/' + product.hinh_anh : '/images/no-image.png'}" 
                                                     class="me-3 rounded" width="50" height="50" style="object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">${product.ten}</h6>
                                                    <small class="text-danger fw-bold">${new Intl.NumberFormat('vi-VN').format(product.gia)} VNĐ</small>
                                                </div>
                                            </div>
                                        `;
                                    });
                                    html += '</div>';
                                    searchResults.innerHTML = html;
                                    searchResults.classList.remove('d-none');
                                } else {
                                    searchResults.classList.add('d-none');
                                }
                            })
                            .catch(() => {
                                searchResults.classList.add('d-none');
                            });
                    }, 300);
                });

                // Hide search results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('d-none');
                    }
                });
            }
        });

        // Toast notification function
        function showToast(message, type = 'info') {
            const toastContainer = document.querySelector('.toast-container');
            const toastId = 'toast-' + Date.now();
            
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.id = toastId;
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
    </script>

    @stack('scripts')
</body>
</html>
