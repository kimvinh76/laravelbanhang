// Sản phẩm filter functions
class SanPhamFilter {
    constructor() {
        this.searchTimeout = null;
        this.isLoading = false;
        this.init();
    }

    init() {
        this.setupPriceRange();
        this.setupAdvancedToggle();
        this.setupFormSubmission();
        this.setupPriceSlider();
        this.setupAjaxSearch(); // Thêm AJAX search
        this.setupDebouncing(); // Thêm debouncing
        this.setupQuickView(); // Thêm quick view modal
    }

    // Setup quick view modal
    setupQuickView() {
        // Lắng nghe click vào nút quick view
        document.addEventListener('click', (e) => {
            if (e.target.closest('.btn-quick-view')) {
                e.preventDefault();
                const productId = e.target.closest('.btn-quick-view').dataset.productId;
                this.showQuickView(productId);
            }
        });
    }

    // Hiển thị modal xem nhanh
    async showQuickView(productId) {
        try {
            const response = await fetch(`/sanpham/${productId}/quick-view`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.createQuickViewModal(data);
            } else {
                this.showToast('Không thể tải thông tin sản phẩm', 'error');
            }
        } catch (error) {
            console.error('Quick view error:', error);
            this.showToast('Lỗi khi tải thông tin sản phẩm', 'error');
        }
    }

    // Tạo modal xem nhanh
    createQuickViewModal(data) {
        // Xóa modal cũ nếu có
        const existingModal = document.getElementById('quickViewModal');
        if (existingModal) existingModal.remove();

        // Tạo modal mới
        const modalHtml = `
            <div class="modal fade" id="quickViewModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="ri-eye-line me-2"></i>Xem nhanh sản phẩm
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            ${data.html}
                        </div>
                        <div class="modal-footer">
                            <a href="/sanpham/${data.id}" class="btn btn-primary">
                                <i class="ri-external-link-line me-1"></i>Xem chi tiết đầy đủ
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Thêm vào DOM và hiển thị
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
        modal.show();

        // Xóa modal khi đóng
        document.getElementById('quickViewModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    // Setup AJAX search (tùy chọn)
    setupAjaxSearch() {
        const enableAjax = document.querySelector('[data-ajax-search="true"]');
        if (!enableAjax) return;

        const searchInput = document.querySelector('input[name="q"]');
        const loaiSelect = document.querySelector('select[name="loai_san_pham_id"]');
        
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.debouncedSearch();
            });
        }

        if (loaiSelect) {
            loaiSelect.addEventListener('change', (e) => {
                this.performAjaxSearch();
            });
        }
    }

    // Setup debouncing cho search
    setupDebouncing() {
        this.debouncedSearch = this.debounce(() => {
            this.performAjaxSearch();
        }, 500);
    }

    // Debounce function
    debounce(func, wait) {
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(this.searchTimeout);
                func(...args);
            };
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(later, wait);
        }.bind(this);
    }

    // Thực hiện AJAX search
    async performAjaxSearch() {
        if (this.isLoading) return;

        const form = document.getElementById('search-form');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        this.setLoading(true);

        try {
            const response = await fetch(`${form.action}?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateResults(data);
                this.updateURL(params);
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showToast('Lỗi tìm kiếm, vui lòng thử lại', 'error');
        } finally {
            this.setLoading(false);
        }
    }

    // Cập nhật kết quả tìm kiếm
    updateResults(data) {
        // Cập nhật bảng sản phẩm
        const tableContainer = document.querySelector('.table-responsive');
        if (tableContainer && data.html) {
            tableContainer.innerHTML = data.html;
        }

        // Cập nhật thông tin pagination
        const paginationContainer = document.querySelector('.pagination-container');
        if (paginationContainer && data.pagination) {
            paginationContainer.innerHTML = data.pagination;
        }

        // Cập nhật counter
        this.updateCounterInfo(data);
    }

    // Cập nhật thông tin đếm
    updateCounterInfo(data) {
        const counterElement = document.querySelector('.result-counter');
        if (counterElement && data.info) {
            counterElement.innerHTML = data.info;
        }
    }

    // Cập nhật URL không reload trang
    updateURL(params) {
        const newURL = `${window.location.pathname}?${params}`;
        history.pushState(null, '', newURL);
    }

    // Hiển thị loading state
    setLoading(loading) {
        this.isLoading = loading;
        const submitBtn = document.querySelector('button[type="submit"]');
        const tableBody = document.querySelector('tbody');

        if (loading) {
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-line ri-spin me-1"></i>Đang tìm...';
            }
            if (tableBody) {
                tableBody.style.opacity = '0.5';
            }
        } else {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri-search-line me-1"></i>Tìm kiếm';
            }
            if (tableBody) {
                tableBody.style.opacity = '1';
            }
        }
    }

    // Thiết lập toggle cho bộ lọc nâng cao
    setupAdvancedToggle() {
        const toggleBtn = document.getElementById('toggle-advanced-filter');
        const advancedSection = document.getElementById('advanced-filter-section');
        
        if (toggleBtn && advancedSection) {
            toggleBtn.addEventListener('click', () => {
                const isHidden = advancedSection.style.display === 'none' || !advancedSection.style.display;
                advancedSection.style.display = isHidden ? 'block' : 'none';
                
                // Cập nhật icon và text
                const icon = toggleBtn.querySelector('i');
                const text = toggleBtn.querySelector('.toggle-text');
                
                if (isHidden) {
                    icon.className = 'ri-arrow-up-s-line';
                    text.textContent = 'Ẩn bộ lọc nâng cao';
                } else {
                    icon.className = 'ri-arrow-down-s-line';
                    text.textContent = 'Bộ lọc nâng cao';
                }
            });
        }
    }

    // Thiết lập slider cho khoảng giá
    setupPriceSlider() {
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');
        const priceDisplay = document.getElementById('price-range-display');

        if (minPriceInput && maxPriceInput && priceDisplay) {
            const updateDisplay = () => {
                const minPrice = parseInt(minPriceInput.value) || 0;
                const maxPrice = parseInt(maxPriceInput.value) || 10000000;
                priceDisplay.textContent = `${this.formatPrice(minPrice)} - ${this.formatPrice(maxPrice)}`;
            };

            minPriceInput.addEventListener('input', updateDisplay);
            maxPriceInput.addEventListener('input', updateDisplay);
            
            // Cập nhật lần đầu
            updateDisplay();
        }
    }

    // Thiết lập validation cho khoảng giá
    setupPriceRange() {
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');

        if (minPriceInput && maxPriceInput) {
            // Validation khi thay đổi giá trị
            minPriceInput.addEventListener('change', () => {
                const minPrice = parseInt(minPriceInput.value) || 0;
                const maxPrice = parseInt(maxPriceInput.value) || 10000000;
                
                if (minPrice >= maxPrice) {
                    maxPriceInput.value = minPrice + 10000;
                    this.showToast('Giá tối đa phải lớn hơn giá tối thiểu', 'warning');
                }
            });

            maxPriceInput.addEventListener('change', () => {
                const minPrice = parseInt(minPriceInput.value) || 0;
                const maxPrice = parseInt(maxPriceInput.value) || 10000000;
                
                if (maxPrice <= minPrice) {
                    minPriceInput.value = Math.max(0, maxPrice - 10000);
                    this.showToast('Giá tối thiểu phải nhỏ hơn giá tối đa', 'warning');
                }
            });
        }
    }

    // Thiết lập xử lý form submission
    setupFormSubmission() {
        const searchForm = document.getElementById('search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => {
                // Có thể thêm validation trước khi submit
                this.validateForm(e);
            });
        }
    }

    // Validation form
    validateForm(event) {
        const minPrice = parseInt(document.getElementById('min_price')?.value) || 0;
        const maxPrice = parseInt(document.getElementById('max_price')?.value) || 10000000;

        if (minPrice >= maxPrice) {
            event.preventDefault();
            this.showToast('Khoảng giá không hợp lệ!', 'error');
            return false;
        }

        return true;
    }

    // Format giá tiền
    formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price) + ' VNĐ';
    }

    // Hiển thị toast notification
    showToast(message, type = 'info') {
        // Tạo toast element
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            <i class="ri-information-line me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(toast);

        // Tự động xóa sau 3 giây
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 3000);
    }

    // Reset tất cả filter
    resetAllFilters() {
        document.getElementById('search-form').reset();
        
        // Reset URL về trang index
        window.location.href = window.location.pathname;
    }

    // Thay đổi số lượng hiển thị per page
    changePerPage(perPage) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
}

// Khởi tạo khi DOM ready
document.addEventListener('DOMContentLoaded', function() {
    new SanPhamFilter();
});

// Export cho các file khác sử dụng
window.SanPhamFilter = SanPhamFilter;
