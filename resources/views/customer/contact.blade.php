@extends('customer.layout')

@section('title', 'Liên hệ')

@push('styles')
<style>
.contact-hero {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 80px 0;
}

.contact-card {
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
}

.contact-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.map-container {
    height: 400px;
    border-radius: 10px;
    overflow: hidden;
}

.form-floating > label {
    color: #6c757d;
}

.contact-form {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="contact-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Liên hệ với chúng tôi</h1>
                <p class="lead">
                    Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy liên hệ với chúng tôi bất cứ khi nào bạn cần!
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="card contact-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="contact-icon bg-primary text-white">
                            <i class="ri-map-pin-line fs-3"></i>
                        </div>
                        <h5 class="card-title">Địa chỉ</h5>
                        <p class="card-text">
                            123 Đường ABC, Phường XYZ<br>
                            Quận 1, TP. Hồ Chí Minh<br>
                            Việt Nam
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card contact-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="contact-icon bg-success text-white">
                            <i class="ri-phone-line fs-3"></i>
                        </div>
                        <h5 class="card-title">Hotline</h5>
                        <p class="card-text">
                            <strong>1900 1234</strong><br>
                            (028) 1234 5678<br>
                            Hỗ trợ 24/7
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card contact-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="contact-icon bg-warning text-white">
                            <i class="ri-mail-line fs-3"></i>
                        </div>
                        <h5 class="card-title">Email</h5>
                        <p class="card-text">
                            <strong>info@shop.com</strong><br>
                            support@shop.com<br>
                            sales@shop.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Map -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="contact-form p-4">
                    <h3 class="fw-bold mb-4">Gửi tin nhắn cho chúng tôi</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ri-check-line me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ri-error-warning-line me-2"></i>Vui lòng kiểm tra lại thông tin!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    <label for="name">Họ tên *</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    <label for="email">Email *</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    <label for="phone">Số điện thoại</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('subject') is-invalid @enderror" 
                                            id="subject" name="subject" required>
                                        <option value="">Chọn chủ đề</option>
                                        <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>
                                            Thông tin chung
                                        </option>
                                        <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>
                                            Hỗ trợ kỹ thuật
                                        </option>
                                        <option value="order" {{ old('subject') == 'order' ? 'selected' : '' }}>
                                            Vấn đề đơn hàng
                                        </option>
                                        <option value="product" {{ old('subject') == 'product' ? 'selected' : '' }}>
                                            Sản phẩm
                                        </option>
                                        <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>
                                            Hợp tác kinh doanh
                                        </option>
                                    </select>
                                    <label for="subject">Chủ đề *</label>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" name="message" style="height: 120px" required>{{ old('message') }}</textarea>
                                    <label for="message">Nội dung tin nhắn *</label>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agree" name="agree" 
                                           {{ old('agree') ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="agree">
                                        Tôi đồng ý với <a href="#" class="text-decoration-none">điều khoản sử dụng</a> 
                                        và <a href="#" class="text-decoration-none">chính sách bảo mật</a> *
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="ri-send-plane-line me-2"></i>Gửi tin nhắn
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Map & Additional Info -->
            <div class="col-lg-6">
                <div class="mb-4">
                    <h3 class="fw-bold mb-4">Vị trí của chúng tôi</h3>
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3196214493143!2d106.69971731533458!3d10.783115292317715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4b3aa3a3dd%3A0x4fbb6b6da0c0b3c4!2zQ2jhu6MgQuG6v24gVGjDoG5o!5e0!3m2!1svi!2s!4v1641234567890!5m2!1svi!2s" 
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
                
                <!-- Working Hours -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ri-time-line me-2"></i>Giờ làm việc
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <strong>Thứ 2 - Thứ 6:</strong><br>
                                8:00 AM - 6:00 PM
                            </div>
                            <div class="col-6">
                                <strong>Thứ 7 - Chủ nhật:</strong><br>
                                9:00 AM - 5:00 PM
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="ri-customer-service-2-line me-1"></i>
                                Hotline hỗ trợ 24/7: <strong>1900 1234</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="fw-bold">Câu hỏi thường gặp</h2>
                <p class="lead text-muted">
                    Những câu hỏi được khách hàng quan tâm nhiều nhất
                </p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq1">
                                Làm thế nào để theo dõi đơn hàng của tôi?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn có thể theo dõi đơn hàng bằng cách đăng nhập vào tài khoản và vào mục "Đơn hàng của tôi", 
                                hoặc sử dụng mã đơn hàng được gửi qua email để tra cứu.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq2">
                                Chính sách đổi trả như thế nào?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi chấp nhận đổi trả trong vòng 30 ngày kể từ ngày nhận hàng với điều kiện 
                                sản phẩm còn nguyên vẹn, chưa qua sử dụng và có đầy đủ bao bì, hóa đơn.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq3">
                                Thời gian giao hàng bao lâu?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Thời gian giao hàng từ 1-3 ngày làm việc tại TP.HCM và Hà Nội, 2-5 ngày làm việc 
                                tại các tỉnh thành khác trên toàn quốc.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq4">
                                Các hình thức thanh toán được hỗ trợ?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi hỗ trợ thanh toán qua thẻ tín dụng, chuyển khoản ngân hàng, 
                                ví điện tử (MoMo, ZaloPay) và thanh toán khi nhận hàng (COD).
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
