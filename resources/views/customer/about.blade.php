@extends('customer.layout')

@section('title', 'Về chúng tôi')

@push('styles')
<style>
.hero-about {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 100px 0;
}

.feature-card {
    transition: transform 0.3s ease;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.feature-card:hover {
    transform: translateY(-5px);
}

.team-member {
    text-align: center;
    margin-bottom: 30px;
}

.team-member img {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
}

.stats-section {
    background: #f8f9fa;
    padding: 80px 0;
}

.stat-item {
    text-align: center;
    margin-bottom: 30px;
}

.stat-number {
    font-size: 3rem;
    font-weight: bold;
    color: var(--primary-color);
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Về chúng tôi</h1>
                <p class="lead mb-4">
                    Chúng tôi là đơn vị tiên phong trong lĩnh vực bán hàng trực tuyến, 
                    mang đến cho khách hàng những sản phẩm chất lượng với dịch vụ tốt nhất.
                </p>
                <p class="mb-4">
                    Với hơn 10 năm kinh nghiệm trong ngành, chúng tôi tự hào là đối tác 
                    tin cậy của hàng triệu khách hàng trên toàn quốc.
                </p>
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                    <i class="ri-phone-line me-2"></i>Liên hệ ngay
                </a>
            </div>
            <div class="col-lg-6">
                <img src="/images/about-hero.jpg" alt="About Us" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="fw-bold">Sứ mệnh của chúng tôi</h2>
                <p class="lead text-muted">
                    Mang đến trải nghiệm mua sắm tuyệt vời nhất cho khách hàng
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="ri-shield-check-line display-4 text-primary"></i>
                        </div>
                        <h5 class="card-title">Chất lượng đảm bảo</h5>
                        <p class="card-text">
                            Tất cả sản phẩm đều được kiểm tra chất lượng nghiêm ngặt 
                            trước khi đến tay khách hàng.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="ri-truck-line display-4 text-success"></i>
                        </div>
                        <h5 class="card-title">Giao hàng nhanh chóng</h5>
                        <p class="card-text">
                            Hệ thống giao hàng toàn quốc với tốc độ nhanh và 
                            đảm bảo an toàn cho sản phẩm.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="ri-customer-service-2-line display-4 text-warning"></i>
                        </div>
                        <h5 class="card-title">Hỗ trợ 24/7</h5>
                        <p class="card-text">
                            Đội ngũ chăm sóc khách hàng chuyên nghiệp, sẵn sàng 
                            hỗ trợ bạn mọi lúc mọi nơi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">1M+</div>
                    <h5>Khách hàng tin tưởng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <h5>Sản phẩm</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">99%</div>
                    <h5>Khách hàng hài lòng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <h5>Năm kinh nghiệm</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="/images/our-story.jpg" alt="Our Story" class="img-fluid rounded">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Câu chuyện của chúng tôi</h2>
                <p>
                    Bắt đầu từ một cửa hàng nhỏ vào năm 2013, chúng tôi đã không ngừng phát triển 
                    và mở rộng quy mô hoạt động. Với tầm nhìn trở thành nền tảng thương mại điện tử 
                    hàng đầu Việt Nam, chúng tôi đã đầu tư mạnh mẽ vào công nghệ và nguồn nhân lực.
                </p>
                <p>
                    Ngày nay, chúng tôi tự hào phục vụ hàng triệu khách hàng trên khắp cả nước với 
                    hàng chục nghìn sản phẩm đa dạng từ các thương hiệu uy tín trong và ngoài nước.
                </p>
                <div class="row mt-4">
                    <div class="col-6">
                        <h5 class="text-primary">Tầm nhìn</h5>
                        <p class="small">
                            Trở thành nền tảng thương mại điện tử hàng đầu Việt Nam
                        </p>
                    </div>
                    <div class="col-6">
                        <h5 class="text-success">Giá trị cốt lõi</h5>
                        <p class="small">
                            Khách hàng là trung tâm, chất lượng là ưu tiên hàng đầu
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="fw-bold">Đội ngũ lãnh đạo</h2>
                <p class="lead text-muted">
                    Những con người tài năng đứng sau thành công của chúng tôi
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4">
                <div class="team-member">
                    <img src="/images/team-1.jpg" alt="CEO" class="shadow">
                    <h5>Nguyễn Văn A</h5>
                    <p class="text-muted">CEO & Founder</p>
                    <p class="small">
                        Với hơn 15 năm kinh nghiệm trong lĩnh vực thương mại điện tử, 
                        anh A là người đã dẫn dắt công ty từ những ngày đầu khởi nghiệp.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="team-member">
                    <img src="/images/team-2.jpg" alt="CTO" class="shadow">
                    <h5>Trần Thị B</h5>
                    <p class="text-muted">CTO</p>
                    <p class="small">
                        Chuyên gia công nghệ với kinh nghiệm phát triển các hệ thống 
                        quy mô lớn, đảm bảo vận hành ổn định của nền tảng.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="team-member">
                    <img src="/images/team-3.jpg" alt="COO" class="shadow">
                    <h5>Lê Văn C</h5>
                    <p class="text-muted">COO</p>
                    <p class="small">
                        Người điều hành hoạt động kinh doanh, có kinh nghiệm quản lý 
                        chuỗi cung ứng và logistics trong nhiều năm.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="fw-bold mb-4">Sẵn sàng mua sắm cùng chúng tôi?</h2>
                <p class="lead mb-4">
                    Khám phá hàng nghìn sản phẩm chất lượng với giá tốt nhất
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="ri-shopping-bag-line me-2"></i>Mua sắm ngay
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg">
                        <i class="ri-customer-service-line me-2"></i>Liên hệ tư vấn
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
