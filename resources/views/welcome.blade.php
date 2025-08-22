<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جامعة الحضارة | صرحك نحو المستقبل</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* === [1] النظام التصميمي الجديد: فخامة وحداثة === */
        :root {
            --brand-primary: #c0392b; /* أحمر الحضارة */
            --brand-secondary: #e74c3c;
            --text-dark: #212529;
            --text-secondary: #6c757d;
            --bg-main: #f8f9fa;
            --bg-soft: #fdf6f5; /* لون خلفية ناعم متناسق */
            --bg-card: #ffffff;
            --border-color: #dee2e6;
            --border-soft: rgba(0, 0, 0, 0.05);
            --success: #28a745;
            --blue: #007bff;

            --font-headings: 'Cairo', sans-serif;
            --font-body: 'Tajawal', sans-serif;

            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-brand: 0 8px 25px rgba(192, 57, 43, 0.2);

            --gradient-brand: linear-gradient(135deg, var(--brand-secondary) 0%, var(--brand-primary) 100%);

            --transition-smooth: all 0.3s ease-in-out;
        }

        /* === [2] إعدادات عامة === */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font-body);
            color: var(--text-secondary);
            background-color: var(--bg-main);
            line-height: 1.8;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-headings); font-weight: 700; color: var(--text-dark); line-height: 1.4; }
        section { padding: 100px 0; overflow: hidden; position: relative; }

        /* === [3] حركة ظهور العناصر عند التمرير === */
        .reveal {
            opacity: 0;
            transform: translateY(30px) scale(0.98);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .reveal.visible { opacity: 1; transform: translateY(0) scale(1); }
        .reveal.visible:nth-child(2) { transition-delay: 0.1s; }
        .reveal.visible:nth-child(3) { transition-delay: 0.2s; }
        .reveal.visible:nth-child(4) { transition-delay: 0.3s; }
        .reveal.visible:nth-child(5) { transition-delay: 0.4s; }
        .reveal.visible:nth-child(6) { transition-delay: 0.5s; }
        .reveal.visible:nth-child(7) { transition-delay: 0.6s; }
        .reveal.visible:nth-child(8) { transition-delay: 0.7s; }

        /* === [4] شريط التصفح العلوي (Header) === */
        .header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: var(--transition-smooth);
            border-bottom: 1px solid var(--border-soft);
        }
        .header.scrolled { background: rgba(255, 255, 255, 0.98); box-shadow: var(--shadow-md); }
        .nav-container { display: flex; justify-content: space-between; align-items: center; height: 80px; }
        .logo { display: flex; align-items: center; gap: 12px; font-size: 1.4rem; font-weight: 700; color: var(--brand-primary); text-decoration: none; transition: var(--transition-smooth); }
        .logo:hover { transform: scale(1.03); color: var(--brand-dark); }
        .logo img { height: 45px; border-radius: 8px; }
        .nav-menu { display: flex; list-style: none; gap: 10px; }
        .nav-menu a { text-decoration: none; color: var(--text-secondary); font-weight: 500; padding: 8px 16px; border-radius: 20px; transition: var(--transition-smooth); }
        .nav-menu a:hover { color: var(--brand-primary); background-color: rgba(192, 57, 43, 0.07); }
        .login-btn { background: var(--gradient-brand); color: white; padding: 10px 25px; border-radius: 50px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: var(--shadow-brand); transition: var(--transition-smooth); border: none; cursor: pointer; }
        .login-btn:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 12px 30px rgba(192, 57, 43, 0.3); }
        .mobile-menu-btn, .mobile-menu { display: none; }

        /* === [5] القسم الرئيسي (Hero Section) === */
        .hero { padding-top: 160px; padding-bottom: 80px; min-height: 90vh; display: flex; align-items: center; justify-content: center; text-align: center; background: linear-gradient(180deg, rgba(255,255,255,0) 0%, var(--bg-main) 100%); }
        .hero-content { max-width: 900px; }
        .university-name { font-family: var(--font-headings); font-weight: 800; font-size: 4.5rem; color: var(--brand-primary); margin-bottom: 10px; }
        .university-name span { display: block; font-size: 2rem; font-weight: 500; color: var(--text-dark); margin-bottom: 10px; }
        .hero h1 { font-size: 2.5rem; color: var(--text-dark); margin-bottom: 25px; }
        .hero-description { font-size: 1.2rem; max-width: 750px; margin: 0 auto 40px auto; }
        .cta-button { background: var(--gradient-brand); color: #fff; padding: 18px 45px; text-decoration: none; font-size: 1.2rem; font-weight: 600; border-radius: 50px; transition: var(--transition-smooth); box-shadow: var(--shadow-brand); display: inline-flex; align-items: center; gap: 12px; }
        .cta-button:hover { transform: translateY(-5px) scale(1.05); box-shadow: 0 15px 35px rgba(192, 57, 43, 0.35); }
        .cta-button i { transition: transform 0.3s ease; }
        .cta-button:hover i { transform: rotate(90deg); }

        /* === [6] التنسيقات العامة للأقسام والبطاقات === */
        .section-title { text-align: center; margin-bottom: 60px; }
        .section-title h2 { font-size: 2.8rem; color: var(--text-dark); margin-bottom: 15px; position: relative; display: inline-block; padding-bottom: 10px; }
        .section-title h2::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 70px; height: 4px; background: var(--gradient-brand); border-radius: 2px; }
        .section-title p { font-size: 1.1rem; color: var(--text-secondary); max-width: 600px; margin: 15px auto 0; }
        .default-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        .card-base { background: var(--bg-card); border-radius: 16px; padding: 40px; text-align: center; box-shadow: var(--shadow-md); transition: var(--transition-smooth); border: 1px solid var(--border-soft); }
        .card-base:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }
        .card-icon { width: 70px; height: 70px; background: var(--gradient-brand); color: white; border-radius: 50%; margin: 0 auto 25px; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 5px 15px rgba(192, 57, 43, 0.25); }
        .card-base h3 { font-size: 1.5rem; color: var(--text-dark); margin-bottom: 15px; }
        .card-base p { line-height: 1.7; margin-bottom: 25px; }
        .btn-primary { background: var(--gradient-brand); color: white; padding: 12px 30px; border-radius: 25px; font-weight: 600; text-decoration: none; display: inline-block; box-shadow: var(--shadow-brand); transition: var(--transition-smooth); border: none; cursor: pointer; }
        .btn-primary:hover { transform: translateY(-3px) scale(1.03); box-shadow: 0 10px 25px rgba(192, 57, 43, 0.3); }

        /* === [7] أقسام متخصصة === */
        .quote-section { background-color: var(--bg-soft); }
        .quote-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px); border-radius: 20px; padding: 50px; text-align: center; box-shadow: var(--shadow-lg); position: relative; max-width: 800px; margin: 0 auto; border: 1px solid rgba(192, 57, 43, 0.2); }
        .quote-card h3 { color: var(--brand-primary); font-size: 1.6rem; margin-bottom: 15px; }
        .quote-card p { font-size: 1.5rem; font-family: var(--font-headings); font-weight: 500; color: var(--text-dark); }
        .quote-card .fas { font-size: 2.5rem; color: var(--brand-primary); opacity: 0.2; position: absolute; }
        .quote-start { top: 20px; right: 25px; }
        .quote-end { bottom: 20px; left: 25px; }

        .faculty-card { background: var(--bg-card); border-radius: 16px; padding: 30px; margin-bottom: 30px; box-shadow: var(--shadow-md); border: 1px solid var(--border-soft); }
        .faculty-title { color: var(--brand-primary); font-size: 2rem; margin-bottom: 25px; text-align: center; }
        .specializations-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 1rem; }
        .specializations-table th, .specializations-table td { padding: 16px; text-align: center; border-bottom: 1px solid var(--border-color); }
        .specializations-table thead { background: var(--gradient-brand); color: white; }
        .specializations-table tbody tr:hover { background-color: rgba(192, 57, 43, 0.04); }

        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; }
        .info-item { display: flex; align-items: center; gap: 20px; padding: 20px; background: var(--bg-card); border-radius: 12px; border: 1px solid var(--border-soft); transition: var(--transition-smooth); }
        .info-item:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); }
        .info-item .icon { font-size: 2rem; color: var(--brand-primary); }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 25px; }
        .stat-card { background: var(--bg-card); padding: 30px 20px; border-radius: 12px; text-align: center; box-shadow: var(--shadow-sm); border: 1px solid var(--border-soft); }
        .stat-number { font-size: 3rem; font-weight: 800; color: var(--brand-primary); margin-bottom: 5px; }
        .stat-label { font-size: 1.1rem; font-weight: 500; color: var(--text-secondary); }

        .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; }
        .service-card { background: var(--bg-card); border-radius: 12px; padding: 25px; text-align: center; box-shadow: var(--shadow-sm); transition: var(--transition-smooth); border: 1px solid var(--border-soft); }
        .service-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); }
        .service-icon { font-size: 2.5rem; margin-bottom: 15px; color: var(--brand-primary); }
        .service-card h4 { font-size: 1.2rem; color: var(--text-dark); margin-bottom: 10px; }

        /* === [8] قسم المطورين والاتصال === */
        .contact-grid-layout { display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px; align-items: flex-start; }
        .form-card, .contact-info-card { background: var(--bg-card); border-radius: 16px; padding: 40px; box-shadow: var(--shadow-md); border: 1px solid var(--border-soft); height: 100%; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark); }
        .form-control { width: 100%; padding: 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 1rem; background-color: var(--bg-main); transition: var(--transition-smooth); }
        .form-control:focus { outline: none; border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.15); }
        .contact-info-item { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .contact-info-item i { width: 45px; height: 45px; background: var(--gradient-brand); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }

        .developers-section { background-color: #f1f3f5; }
        .developers-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; }
        .developer-card { background: var(--bg-card); border-radius: 16px; box-shadow: var(--shadow-md); transition: var(--transition-smooth); overflow: hidden; border: 1px solid var(--border-soft); display: flex; flex-direction: column; }
        .developer-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-lg); }
        .dev-card-header { padding: 30px; text-align: center; position: relative; }
        .dev-card-header::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 100px; background: var(--gradient-brand); border-radius: 0 0 50% 50% / 0 0 100% 100%; transform: scaleX(1.5); }
        .dev-image { width: 120px; height: 120px; border-radius: 50%; border: 5px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); object-fit: cover; position: relative; z-index: 1; }
        .dev-info { margin-top: 15px; position: relative; z-index: 1; }
        .dev-info h3 { font-size: 1.4rem; } .dev-info p { color: var(--brand-primary); font-weight: 500; }
        .dev-card-body { padding: 0 30px 30px; flex-grow: 1; }
        .dev-contact-list { list-style: none; padding: 0; margin: 0 0 20px 0; text-align: right; }
        .dev-contact-list li { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
        .dev-contact-list li:last-child { border-bottom: none; }
        .dev-contact-list i { color: var(--brand-primary); width: 20px; text-align: center; }
        .dev-socials { text-align: center; margin-top: auto; padding-top: 20px; border-top: 1px solid #f0f0f0; }
        .dev-socials a { color: var(--text-secondary); font-size: 1.3rem; margin: 0 10px; transition: var(--transition-smooth); }
        .dev-socials a:hover { color: var(--brand-primary); transform: scale(1.2); }

        /* === [9] التذييل والتصميم المتجاوب === */
        .footer { background: #2c3e50; color: #bdc3c7; padding: 60px 0 30px; text-align: center; }
        .footer h3 { font-size: 1.8rem; margin-bottom: 15px; color: white; }
        .footer p { max-width: 500px; margin: 0 auto 30px; }
        .social-links a { display: inline-flex; justify-content: center; align-items: center; width: 45px; height: 45px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; color: white; text-decoration: none; margin: 0 8px; transition: var(--transition-smooth); font-size: 1.1rem; }
        .social-links a:hover { background: var(--brand-primary); transform: translateY(-5px); }
        .footer .copyright { margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1); font-size: 0.9rem; }

        @media (max-width: 992px) {
            .nav-menu, .login-btn { display: none; }
            .mobile-menu-btn { display: block; background: none; border: none; font-size: 1.8rem; color: var(--brand-primary); cursor: pointer; }
            .mobile-menu { display: block; position: absolute; top: 80px; left: 0; right: 0; background: var(--bg-card); box-shadow: var(--shadow-lg); max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out; }
            .mobile-menu.active { max-height: 100vh; }
            .mobile-menu ul { list-style: none; padding: 20px; }
            .mobile-menu ul li a { display: block; padding: 15px; color: var(--text-dark); font-weight: 600; border-radius: 8px; transition: var(--transition-smooth); }
            .mobile-menu ul li a:hover { background: rgba(192, 57, 43, 0.07); color: var(--brand-primary); transform: translateX(-10px); }
            .mobile-menu .login-btn { display: flex; width: 100%; justify-content: center; margin-top: 10px; }
            .contact-grid-layout { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            section { padding: 80px 0; }
            .university-name { font-size: 3.5rem; } .hero h1 { font-size: 2rem; }
            .section-title h2 { font-size: 2.2rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .specializations-table { font-size: 0.9rem; }
            .specializations-table th, .specializations-table td { padding: 12px 8px; }
        }
        @media (max-width: 576px) {
            .university-name { font-size: 2.8rem; } .hero h1 { font-size: 1.8rem; }
            .hero-description { font-size: 1rem; }
            .cta-button { padding: 15px 35px; font-size: 1rem; }
            .stats-grid, .default-grid, .developers-grid, .services-grid { grid-template-columns: 1fr; }
        }
    </style>
    @livewireStyles

</head>
<body>

    <!-- الشريط العلوي -->
    <header class="header" id="header">
        <div class="nav-container container">
            <a href="#home" class="logo">
                <img src="https://civilizationuniv.edu.ye/wp-content/uploads/2023/08/logo.png" alt="شعار جامعة الحضارة">
                جامعة الحضارة
            </a>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#home">الرئيسية</a></li>
                    <li><a href="#about">عن الجامعة</a></li>
                    <li><a href="#colleges">الكليات</a></li>
                    <li><a href="#specializations">التخصصات</a></li>
                    <li><a href="#services">شؤون الطلاب</a></li>
                    <li><a href="#features">مميزات المنصة</a></li>
                    <li><a href="#developers">المطورون</a></li>
                    <li><a href="#contact">اتصل بنا</a></li>
                </ul>
            </nav>
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ route('login') }}" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    دخول
                </a>
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <ul>
                <li><a href="#home">الرئيسية</a></li>
                <li><a href="#login-options">خيارات الدخول</a></li>
                <li><a href="#about">عن الجامعة</a></li>
                <li><a href="#colleges">الكليات</a></li>
                <li><a href="#specializations">التخصصات</a></li>
                <li><a href="#services">شؤون الطلاب</a></li>
                <li><a href="#statistics">إحصائيات</a></li>
                <li><a href="#features">مميزات المنصة</a></li>
                <li><a href="#developers">المطورون</a></li>
                <li><a href="#contact">اتصل بنا</a></li>
                <li><a href="{{ route('login') }}" class="login-btn">دخول</a></li>
            </ul>
        </div>
    </header>

    <main>
        <!-- القسم الرئيسي -->
        <section class="hero" id="home">
            <div class="container hero-content reveal">
                <div class="university-name"><span>جامعة</span>الحضارة</div>
                <h1>صرحك نحو مستقبلٍ واعد</h1>
                <p class="hero-description">نصنع القادة والمبتكرين في بيئة أكاديمية تجمع بين الأصالة والتميز. تأسست الجامعة عام 2012م بإيمان راسخ بأهمية التعليم العالي في بناء الحضارات ورقي الشعوب.</p>
                <a href="#login-options" class="cta-button">اكتشف رحلتك الأكاديمية <i class="fas fa-arrow-left"></i></a>
            </div>
        </section>

        <!-- قسم خيارات الدخول -->
        <section id="login-options" class="section" style="background-color: var(--bg-soft);">
            <div class="container">
                <div class="section-title reveal">
                    <h2>بوابتك الرقمية</h2>
                    <p>اختر دورك للوصول إلى الخدمات المخصصة لك في المنصة الجامعية المتكاملة.</p>
                </div>
                <div class="default-grid">
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-user-graduate"></i></div><h3>بوابة الطلاب</h3><p>للوصول إلى المواد الدراسية، الواجبات، الدرجات، والتواصل المباشر مع المحاضرين.</p><a href="{{ route('login') }}" class="btn-primary">دخول الطلاب</a></div>
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div><h3>بوابة المحاضرين</h3><p>لإدارة المقررات الدراسية، رفع المحتوى التعليمي، وتقييم أداء الطلاب.</p><a href="{{ route('login') }}" class="btn-primary">دخول المحاضرين</a></div>
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-user-tie"></i></div><h3>بوابة الإدارة</h3><p>للوصول إلى لوحة التحكم الشاملة لإدارة النظام، المستخدمين، والتقارير الإحصائية.</p><a href="{{ route('login') }}" class="btn-primary">دخول الإدارة</a></div>
                </div>
            </div>
        </section>

        <!-- قسم عن الجامعة والمنصة -->
        <section id="about" class="section">
            <div class="container">
                <div class="section-title reveal">
                    <h2>عن الجامعة والمنصة</h2>
                    <p>نلتزم بتقديم تعليم عالي الجودة ونظام رقمي متطور يخدم المجتمع.</p>
                </div>
                <div class="info-grid">
                    <div class="info-item reveal"><div class="icon">🎯</div><div><h4>رؤية الجامعة</h4><p>أن نكون منارة علمية رائدة تساهم في بناء مجتمع المعرفة والتنمية المستدامة.</p></div></div>
                    <div class="info-item reveal"><div class="icon">📚</div><div><h4>رسالة الجامعة</h4><p>إعداد كوادر مؤهلة ومبدعة، وإجراء بحوث علمية تطبيقية تخدم المجتمع والتنمية.</p></div></div>
                    <div class="info-item reveal"><div class="icon">⭐</div><div><h4>قيم الجامعة</h4><p>الجودة، الإبداع، النزاهة، الشفافية، والمسؤولية المجتمعية.</p></div></div>
                    <div class="info-item reveal"><div class="icon">🏆</div><div><h4>أهداف الجامعة</h4><p>تطوير البرامج الأكاديمية، تعزيز البحث العلمي، وخدمة المجتمع بتميز.</p></div></div>
                </div>
            </div>
        </section>

        <!-- الإحصائيات -->
        <section id="statistics" class="section" style="background-color: var(--bg-soft);">
            <div class="container">
                <div class="section-title reveal">
                    <h2>جامعة الحضارة بالأرقام</h2>
                    <p>نفخر بإنجازاتنا التي تعكس مسيرتنا الحافلة بالعطاء والتميز.</p>
                </div>
                <div class="stats-grid">
                    <div class="stat-card reveal"><div class="stat-number">5</div><div class="stat-label">كليات</div></div>
                    <div class="stat-card reveal"><div class="stat-number">16</div><div class="stat-label">برنامج أكاديمي</div></div>
                    <div class="stat-card reveal"><div class="stat-number">172</div><div class="stat-label">عضو هيئة تدريس</div></div>
                    <div class="stat-card reveal"><div class="stat-number">610</div><div class="stat-label">خريج متميز</div></div>
                    <div class="stat-card reveal"><div class="stat-number">12</div><div class="stat-label">عاماً من العطاء</div></div>
                    <div class="stat-card reveal"><div class="stat-number">1000+</div><div class="stat-label">طالب حالي</div></div>
                </div>
            </div>
        </section>

        <!-- الكليات -->
        <section id="colleges" class="section">
            <div class="container">
                <div class="section-title reveal">
                    <h2>كليات الجامعة</h2>
                    <p>نقدم برامج أكاديمية متنوعة في كليات متخصصة تلبي طموحاتكم.</p>
                </div>
                <div class="default-grid">
                    <div class="card-base reveal"><div class="card-icon">🏛</div><h3>كلية العلوم الإنسانية</h3><p>تضم أقسام اللغة العربية، الإنجليزية، التاريخ، والجغرافيا، لإعداد كوادر متخصصة.</p></div>
                    <div class="card-base reveal"><div class="card-icon">💼</div><h3>كلية التجارة والاقتصاد</h3><p>تشمل أقسام إدارة الأعمال، المحاسبة، والاقتصاد، لتأهيل خريجين لسوق العمل.</p></div>
                    <div class="card-base reveal"><div class="card-icon">⚙</div><h3>كلية الهندسة</h3><p>تضم تخصصات الهندسة المدنية، الكهربائية، والمعمارية لتلبية احتياجات التنمية.</p></div>
                    <div class="card-base reveal"><div class="card-icon">🏥</div><h3>كلية العلوم الطبية</h3><p>تشمل الطب العام، طب الأسنان، والصيدلة لإعداد كوادر طبية متميزة.</p></div>
                    <div class="card-base reveal"><div class="card-icon">👨‍⚕</div><h3>كلية الطب البشري</h3><p>تقدم برنامج الطب البشري وفق أحدث المناهج العالمية لتخريج أطباء مؤهلين.</p></div>
                </div>
            </div>
        </section>

        <!-- قسم التخصصات -->
        <section id="specializations" class="section" style="background-color: var(--bg-soft);">
            <div class="container">
                <div class="section-title reveal">
                    <h2>برامجنا الأكاديمية</h2>
                    <p>اكتشف مجموعة متنوعة من التخصصات التي تلبي طموحاتك وتواكب متطلبات سوق العمل.</p>
                </div>
                <div class="faculty-card reveal"><h3 class="faculty-title">كلية الهندسة وعلوم الحاسوب</h3><table class="specializations-table"><thead><tr><th>التخصص</th><th>مدة الدراسة</th><th>الرسوم السنوية</th><th>عدد المقاعد</th></tr></thead><tbody><tr><td>هندسة الحاسوب</td><td>4 سنوات</td><td>500,000 ريال</td><td>50 مقعد</td></tr><tr><td>هندسة البرمجيات</td><td>4 سنوات</td><td>450,000 ريال</td><td>40 مقعد</td></tr><tr><td>هندسة الشبكات</td><td>4 سنوات</td><td>400,000 ريال</td><td>30 مقعد</td></tr></tbody></table></div>
                <div class="faculty-card reveal"><h3 class="faculty-title">كلية إدارة الأعمال</h3><table class="specializations-table"><thead><tr><th>التخصص</th><th>مدة الدراسة</th><th>الرسوم السنوية</th><th>عدد المقاعد</th></tr></thead><tbody><tr><td>إدارة الأعمال</td><td>4 سنوات</td><td>300,000 ريال</td><td>60 مقعد</td></tr><tr><td>المحاسبة</td><td>4 سنوات</td><td>280,000 ريال</td><td>50 مقعد</td></tr><tr><td>التسويق</td><td>4 سنوات</td><td>250,000 ريال</td><td>40 مقعد</td></tr></tbody></table></div>
            </div>
        </section>

        <!-- خدمات الطلاب -->
        <section id="services" class="section">
            <div class="container">
                <div class="section-title reveal">
                    <h2>خدمات شؤون الطلاب</h2>
                    <p>نوفر كل ما يحتاجه الطالب لتجربة جامعية سلسة ومثمرة.</p>
                </div>
                <div class="services-grid">
                    <div class="service-card reveal"><div class="service-icon">👤</div><h4>دليل الطالب</h4><p>دليل شامل للخدمات والإجراءات الأكاديمية.</p></div>
                    <div class="service-card reveal"><div class="service-icon">📚</div><h4>دليل التسجيل والقبول</h4><p>معلومات مفصلة عن إجراءات التسجيل والمتطلبات.</p></div>
                    <div class="service-card reveal"><div class="service-icon">📅</div><h4>التقويم الأكاديمي</h4><p>جدول زمني شامل للمواعيد والأنشطة الجامعية.</p></div>
                    <div class="service-card reveal"><div class="service-icon">📋</div><h4>إجراءات القبول</h4><p>خطوات مفصلة للتقديم في مختلف الكليات.</p></div>
                    <div class="service-card reveal"><div class="service-icon">📖</div><h4>الخطط الدراسية</h4><p>المناهج المحدثة لجميع التخصصات والبرامج.</p></div>
                    <div class="service-card reveal"><div class="service-icon">💻</div><h4>التنسيق الإلكتروني</h4><p>نظام إلكتروني متطور لجميع خدمات الطلاب.</p></div>
                    <div class="service-card reveal"><div class="service-icon">🎓</div><h4>خدمات الخريجين</h4><p>برامج متابعة، فرص عمل، وتطوير مهني.</p></div>
                    <div class="service-card reveal"><div class="service-icon">🌐</div><h4>بوابة الطالب</h4><p>منصة إلكترونية شاملة لجميع الخدمات الطلابية.</p></div>
                </div>
            </div>
        </section>

        <!-- مباني الجامعة -->
        <section id="buildings" class="section" style="background-color: var(--bg-soft);">
            <div class="container">
                <div class="section-title reveal">
                    <h2>مرافق الجامعة</h2>
                    <p>بيئة تعليمية متكاملة ومجهزة بأحدث الوسائل لدعم مسيرتك الأكاديمية.</p>
                </div>
                <div class="info-grid">
                    <div class="info-item reveal"><div class="icon">🏢</div><div><h4>المركز الرئيسي</h4><p>يقع في أمانة العاصمة صنعاء، مديرية السبعين، مدينة حدة. ويضم جميع الكليات والمرافق الأكاديمية والإدارية.</p></div></div>
                    <div class="info-item reveal"><div class="icon">🏥</div><div><h4>مستشفى جامعة الحضارة</h4><p>يقع في مدينة حدة، ويقدم خدمات طبية متكاملة ويعتبر مركزاً للتدريب العملي لطلاب الكليات الطبية.</p></div></div>
                </div>
            </div>
        </section>

        <!-- قسم المميزات -->
        <section id="features" class="section">
            <div class="container">
                <div class="section-title reveal">
                    <h2>مميزات منصتنا التعليمية</h2>
                    <p>نقدم تجربة تعليمية رقمية متكاملة ومصممة لتلبية احتياجاتك.</p>
                </div>
                <div class="default-grid">
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-laptop"></i></div><h3>واجهة سهلة الاستخدام</h3><p>تصميم عصري وبديهي يجعل التنقل في المنصة سهلاً ومريحاً.</p></div>
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-book-open"></i></div><h3>إدارة المقررات</h3><p>نظام شامل لإدارة المقررات الدراسية والمواد التعليمية والواجبات.</p></div>
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-video"></i></div><h3>الفصول الافتراضية</h3><p>إمكانية عقد محاضرات مباشرة عبر الإنترنت بأدوات تفاعلية متقدمة.</p></div>
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-chart-line"></i></div><h3>تتبع الأداء</h3><p>تقارير مفصلة عن أداء الطلاب والحضور لتحسين العملية التعليمية.</p></div>
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-mobile-alt"></i></div><h3>متوافق مع الجوال</h3><p>تصميم متجاوب يعمل بكفاءة على جميع الأجهزة الذكية والأجهزة اللوحية.</p></div>
                    <div class="card-base reveal"><div class="card-icon"><i class="fas fa-shield-alt"></i></div><h3>الأمان والخصوصية</h3><p>نظام أمان متقدم يحمي بيانات المستخدمين مع تشفير عالي المستوى.</p></div>
                </div>
            </div>
        </section>

        <!-- قسم الاقتباس -->
        <section class="quote-section reveal">
            <div class="container"><div class="quote-card"><i class="fas fa-quote-right quote-start"></i><h3>حكمة يمنية خالدة</h3><p>"بالعلم تُبنى الأوطان وتُرفع الأعلام"</p><i class="fas fa-quote-left quote-end"></i></div></div>
        </section>

        <!-- قسم المطورين -->
        <section id="developers" class="developers-section section">
            <div class="container">
                <div class="section-title reveal"><h2>فريق تطوير المنصة</h2><p>العقول المبدعة التي عملت بشغف لتقديم هذه التجربة الرقمية المتميزة.</p></div>
                <div class="developers-grid">
                    <div class="developer-card reveal"><div class="dev-card-header"><img src="https://i.ibb.co/L5k6zFx/wael.jpg" alt="المهندس وائل اليوسفي" class="dev-image"><div class="dev-info"><h3>م/ وائل عبدالباسط اليوسفي</h3><p>Full Stack Web Developer</p></div></div><div class="dev-card-body"><ul class="dev-contact-list"><li><i class="fas fa-phone-alt"></i> <span>772231038</span></li><li><i class="fas fa-briefcase"></i> <span>مطور نظم ومبرمج</span></li><li><i class="fas fa-building"></i> <span>قسم تقنية المعلومات</span></li><li><i class="fas fa-map-marker-alt"></i> <span>صنعاء، اليمن</span></li></ul><div class="dev-socials"><a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a><a href="#" title="GitHub"><i class="fab fa-github"></i></a><a href="mailto:wael@example.com" title="Email"><i class="fas fa-envelope"></i></a></div></div></div>
                    <div class="developer-card reveal"><div class="dev-card-header"><img src="https://i.ibb.co/yY1k5wB/akram.jpg" alt="المهندس أكرم اليوسفي" class="dev-image"><div class="dev-info"><h3>م/ أكرم عبدالكريم اليوسفي</h3><p>Backend Developer & Data Analyst</p></div></div><div class="dev-card-body"><ul class="dev-contact-list"><li><i class="fas fa-phone-alt"></i> <span>775315121</span></li><li><i class="fas fa-briefcase"></i> <span>مطور ويب ومحلل بيانات</span></li><li><i class="fas fa-building"></i> <span>قسم تقنية المعلومات</span></li><li><i class="fas fa-map-marker-alt"></i> <span>صنعاء، اليمن</span></li></ul><div class="dev-socials"><a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a><a href="#" title="GitHub"><i class="fab fa-github"></i></a><a href="mailto:akram@example.com" title="Email"><i class="fas fa-envelope"></i></a></div></div></div>
                </div>
            </div>
        </section>

        <!-- قسم الاتصال -->
        <section id="contact" class="section">
            <div class="container">
                <div class="section-title reveal"><h2>تواصل معنا</h2><p>نحن هنا لمساعدتك! لا تتردد في التواصل معنا لأي استفسار.</p></div>
                <div class="contact-grid-layout">
                    <div class="form-card reveal"><h3>أرسل لنا رسالة</h3>

                    @livewire('contact-form')

                </div>
                    <div class="contact-info-card reveal"><h3>معلومات الاتصال</h3><div style="margin-top: 2rem;"><div class="contact-info-item"><i class="fas fa-map-marker-alt"></i><div><h4>العنوان</h4><p>اليمن، صنعاء، حدة، جولة المدينة</p></div></div><div class="contact-info-item"><i class="fas fa-phone-alt"></i><div><h4>الهاتف</h4><p>01/414808 - 01/418294</p></div></div><div class="contact-info-item"><i class="fas fa-mobile-alt"></i><div><h4>الجوال</h4><p>780199211 - 774707977</p></div></div><div class="contact-info-item"><i class="fas fa-envelope"></i><div><h4>البريد الإلكتروني</h4><p>info@civilizationuniv.edu.ye</p></div></div><div class="contact-info-item"><i class="fas fa-clock"></i><div><h4>أوقات الدوام</h4><p>السبت - الخميس: 8ص - 4م</p></div></div></div></div>
                </div>
            </div>
        </section>

    </main>

    <!-- التذييل -->
    <footer class="footer">
        <div class="container">
            <h3>جامعة الحضارة</h3>
            <p>ملتزمون بالتميز الأكاديمي وبناء جيل يساهم في نهضة الوطن.</p>
            <div class="social-links">
                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a><a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a><a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
            <p class="copyright">© 2024 جامعة الحضارة. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuIcon = mobileMenuBtn.querySelector('i');

            window.addEventListener('scroll', () => header.classList.toggle('scrolled', window.scrollY > 50));

            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                mobileMenuIcon.className = mobileMenu.classList.contains('active') ? 'fas fa-times' : 'fas fa-bars';
            });

            document.querySelectorAll('.mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    mobileMenuIcon.className = 'fas fa-bars';
                });
            });

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-left: 8px;"></i> جارٍ الإرسال...';
                submitBtn.disabled = true;
                setTimeout(() => {
                    alert('تم استلام رسالتك بنجاح. شكراً لتواصلك معنا!');
                    this.reset();
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 1500);
            });
        });
    </script>
    @livewireScripts

</body>
</html>
