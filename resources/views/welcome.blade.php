@php
    $loginRoute = route('login');
    $navLinks = [
        ['href' => '#home', 'label' => 'الرئيسية'],
        ['href' => '#about', 'label' => 'عن الجامعة'],
        ['href' => '#colleges', 'label' => 'الكليات'],
        ['href' => '#specializations', 'label' => 'التخصصات'],
        ['href' => '#services', 'label' => 'شؤون الطلاب'],
        ['href' => '#features', 'label' => 'مميزات المنصة'],
        ['href' => '#developers', 'label' => 'المطورون'],
        ['href' => '#contact', 'label' => 'اتصل بنا'],
    ];
    $mobileExtraLinks = [
        ['href' => '#login-options', 'label' => 'خيارات الدخول'],
        ['href' => '#statistics', 'label' => 'إحصائيات'],
    ];
    $loginOptions = [
        [
            'icon' => 'fas fa-user-graduate',
            'title' => 'بوابة الطلاب',
            'description' => 'للوصول إلى المواد الدراسية، الواجبات، الدرجات، والتواصل المباشر مع المحاضرين.',
            'cta' => 'دخول الطلاب',
        ],
        [
            'icon' => 'fas fa-chalkboard-teacher',
            'title' => 'بوابة المحاضرين',
            'description' => 'لإدارة المقررات الدراسية، رفع المحتوى التعليمي، وتقييم أداء الطلاب.',
            'cta' => 'دخول المحاضرين',
        ],
        [
            'icon' => 'fas fa-user-tie',
            'title' => 'بوابة الإدارة',
            'description' => 'للوصول إلى لوحة التحكم الشاملة لإدارة النظام، المستخدمين، والتقارير الإحصائية.',
            'cta' => 'دخول الإدارة',
        ],
    ];
    $infoItems = [
        ['icon' => '🎯', 'title' => 'رؤية الجامعة', 'description' => 'أن نكون منارة علمية رائدة تساهم في بناء مجتمع المعرفة والتنمية المستدامة.'],
        ['icon' => '📚', 'title' => 'رسالة الجامعة', 'description' => 'إعداد كوادر مؤهلة ومبدعة، وإجراء بحوث علمية تطبيقية تخدم المجتمع والتنمية.'],
        ['icon' => '⭐', 'title' => 'قيم الجامعة', 'description' => 'الجودة، الإبداع، النزاهة، الشفافية، والمسؤولية المجتمعية.'],
        ['icon' => '🏆', 'title' => 'أهداف الجامعة', 'description' => 'تطوير البرامج الأكاديمية، تعزيز البحث العلمي، وخدمة المجتمع بتميز.'],
    ];
    $stats = [
        ['value' => '5', 'label' => 'كليات'],
        ['value' => '16', 'label' => 'برنامج أكاديمي'],
        ['value' => '172', 'label' => 'عضو هيئة تدريس'],
        ['value' => '610', 'label' => 'خريج متميز'],
        ['value' => '12', 'label' => 'عاماً من العطاء'],
        ['value' => '1000+', 'label' => 'طالب حالي'],
    ];
    $colleges = [
        ['icon' => '🏛', 'title' => 'كلية العلوم الإنسانية', 'description' => 'تضم أقسام اللغة العربية، الإنجليزية، التاريخ، والجغرافيا، لإعداد كوادر متخصصة.'],
        ['icon' => '💼', 'title' => 'كلية التجارة والاقتصاد', 'description' => 'تشمل أقسام إدارة الأعمال، المحاسبة، والاقتصاد، لتأهيل خريجين لسوق العمل.'],
        ['icon' => '⚙', 'title' => 'كلية الهندسة', 'description' => 'تضم تخصصات الهندسة المدنية، الكهربائية، والمعمارية لتلبية احتياجات التنمية.'],
        ['icon' => '🏥', 'title' => 'كلية العلوم الطبية', 'description' => 'تشمل الطب العام، طب الأسنان، والصيدلة لإعداد كوادر طبية متميزة.'],
        ['icon' => '👨‍⚕', 'title' => 'كلية الطب البشري', 'description' => 'تقدم برنامج الطب البشري وفق أحدث المناهج العالمية لتخريج أطباء مؤهلين.'],
    ];
    $specializations = [
        [
            'title' => 'كلية الهندسة وعلوم الحاسوب',
            'programs' => [
                ['name' => 'هندسة الحاسوب', 'duration' => '4 سنوات', 'fees' => '500,000 ريال', 'seats' => '50 مقعد'],
                ['name' => 'هندسة البرمجيات', 'duration' => '4 سنوات', 'fees' => '450,000 ريال', 'seats' => '40 مقعد'],
                ['name' => 'هندسة الشبكات', 'duration' => '4 سنوات', 'fees' => '400,000 ريال', 'seats' => '30 مقعد'],
            ],
        ],
        [
            'title' => 'كلية إدارة الأعمال',
            'programs' => [
                ['name' => 'إدارة الأعمال', 'duration' => '4 سنوات', 'fees' => '300,000 ريال', 'seats' => '60 مقعد'],
                ['name' => 'المحاسبة', 'duration' => '4 سنوات', 'fees' => '280,000 ريال', 'seats' => '50 مقعد'],
                ['name' => 'التسويق', 'duration' => '4 سنوات', 'fees' => '250,000 ريال', 'seats' => '40 مقعد'],
            ],
        ],
    ];
    $services = [
        ['icon' => '👤', 'title' => 'دليل الطالب', 'description' => 'دليل شامل للخدمات والإجراءات الأكاديمية.'],
        ['icon' => '📚', 'title' => 'دليل التسجيل والقبول', 'description' => 'معلومات مفصلة عن إجراءات التسجيل والمتطلبات.'],
        ['icon' => '📅', 'title' => 'التقويم الأكاديمي', 'description' => 'جدول زمني شامل للمواعيد والأنشطة الجامعية.'],
        ['icon' => '📋', 'title' => 'إجراءات القبول', 'description' => 'خطوات مفصلة للتقديم في مختلف الكليات.'],
        ['icon' => '📖', 'title' => 'الخطط الدراسية', 'description' => 'المناهج المحدثة لجميع التخصصات والبرامج.'],
        ['icon' => '💻', 'title' => 'التنسيق الإلكتروني', 'description' => 'نظام إلكتروني متطور لجميع خدمات الطلاب.'],
        ['icon' => '🎓', 'title' => 'خدمات الخريجين', 'description' => 'برامج متابعة، فرص عمل، وتطوير مهني.'],
        ['icon' => '🌐', 'title' => 'بوابة الطالب', 'description' => 'منصة إلكترونية شاملة لجميع الخدمات الطلابية.'],
    ];
    $buildings = [
        ['icon' => '🏢', 'title' => 'المركز الرئيسي', 'description' => 'يقع في أمانة العاصمة صنعاء، مديرية السبعين، مدينة حدة. ويضم جميع الكليات والمرافق الأكاديمية والإدارية.'],
        ['icon' => '🏥', 'title' => 'مستشفى جامعة الحضارة', 'description' => 'يقع في مدينة حدة، ويقدم خدمات طبية متكاملة ويعتبر مركزاً للتدريب العملي لطلاب الكليات الطبية.'],
    ];
    $features = [
        ['icon' => 'fas fa-laptop', 'title' => 'واجهة سهلة الاستخدام', 'description' => 'تصميم عصري وبديهي يجعل التنقل في المنصة سهلاً ومريحاً.'],
        ['icon' => 'fas fa-book-open', 'title' => 'إدارة المقررات', 'description' => 'نظام شامل لإدارة المقررات الدراسية والمواد التعليمية والواجبات.'],
        ['icon' => 'fas fa-video', 'title' => 'الفصول الافتراضية', 'description' => 'إمكانية عقد محاضرات مباشرة عبر الإنترنت بأدوات تفاعلية متقدمة.'],
        ['icon' => 'fas fa-chart-line', 'title' => 'تتبع الأداء', 'description' => 'تقارير مفصلة عن أداء الطلاب والحضور لتحسين العملية التعليمية.'],
        ['icon' => 'fas fa-mobile-alt', 'title' => 'متوافق مع الجوال', 'description' => 'تصميم متجاوب يعمل بكفاءة على جميع الأجهزة الذكية والأجهزة اللوحية.'],
        ['icon' => 'fas fa-shield-alt', 'title' => 'الأمان والخصوصية', 'description' => 'نظام أمان متقدم يحمي بيانات المستخدمين مع تشفير عالي المستوى.'],
    ];
    $developers = [
        [
            'name' => 'م/ وائل عبدالباسط اليوسفي',
            'role' => 'Full Stack Web Developer',
            'image' => 'https://i.ibb.co/L5k6zFx/wael.jpg',
            'contacts' => [
                ['icon' => 'fas fa-phone-alt', 'text' => '772231038'],
                ['icon' => 'fas fa-briefcase', 'text' => 'مطور نظم ومبرمج'],
                ['icon' => 'fas fa-building', 'text' => 'قسم تقنية المعلومات'],
                ['icon' => 'fas fa-map-marker-alt', 'text' => 'صنعاء، اليمن'],
            ],
            'socials' => [
                ['icon' => 'fab fa-linkedin', 'url' => '#', 'title' => 'LinkedIn'],
                ['icon' => 'fab fa-github', 'url' => '#', 'title' => 'GitHub'],
                ['icon' => 'fas fa-envelope', 'url' => 'mailto:wael@example.com', 'title' => 'Email'],
            ],
        ],
        [
            'name' => 'م/ أكرم عبدالكريم اليوسفي',
            'role' => 'Backend Developer & Data Analyst',
            'image' => 'https://i.ibb.co/yY1k5wB/akram.jpg',
            'contacts' => [
                ['icon' => 'fas fa-phone-alt', 'text' => '775315121'],
                ['icon' => 'fas fa-briefcase', 'text' => 'مطور ويب ومحلل بيانات'],
                ['icon' => 'fas fa-building', 'text' => 'قسم تقنية المعلومات'],
                ['icon' => 'fas fa-map-marker-alt', 'text' => 'صنعاء، اليمن'],
            ],
            'socials' => [
                ['icon' => 'fab fa-linkedin', 'url' => '#', 'title' => 'LinkedIn'],
                ['icon' => 'fab fa-github', 'url' => '#', 'title' => 'GitHub'],
                ['icon' => 'fas fa-envelope', 'url' => 'mailto:akram@example.com', 'title' => 'Email'],
            ],
        ],
    ];
    $contactInfo = [
        ['icon' => 'fas fa-map-marker-alt', 'title' => 'العنوان', 'description' => 'اليمن، صنعاء، حدة، جولة المدينة'],
        ['icon' => 'fas fa-phone-alt', 'title' => 'الهاتف', 'description' => '01/414808 - 01/418294'],
        ['icon' => 'fas fa-mobile-alt', 'title' => 'الجوال', 'description' => '780199211 - 774707977'],
        ['icon' => 'fas fa-envelope', 'title' => 'البريد الإلكتروني', 'description' => 'info@civilizationuniv.edu.ye'],
        ['icon' => 'fas fa-clock', 'title' => 'أوقات الدوام', 'description' => 'السبت - الخميس: 8ص - 4م'],
    ];
    $socialLinks = [
        ['icon' => 'fab fa-facebook-f', 'title' => 'Facebook', 'url' => '#'],
        ['icon' => 'fab fa-twitter', 'title' => 'Twitter', 'url' => '#'],
        ['icon' => 'fab fa-instagram', 'title' => 'Instagram', 'url' => '#'],
        ['icon' => 'fab fa-linkedin-in', 'title' => 'LinkedIn', 'url' => '#'],
        ['icon' => 'fab fa-youtube', 'title' => 'YouTube', 'url' => '#'],
    ];

    $dashboardRoute = '#';
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            $dashboardRoute = route('admin.dashboard');
        } elseif ($user->isDoctor()) {
            $dashboardRoute = route('doctor.dashboard');
        } elseif ($user->isStudent()) {
            $dashboardRoute = route('student.dashboard');
        }
    }
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جامعة الحضارة | صرحك نحو المستقبل</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#3498db">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="المنصة الجامعية">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}">

    <!-- Google Fonts -->
    <!-- تم استبدال الخطوط بخطوط محلية (Questv1 و NeoSansArabic) -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    @vite(['resources/css/app.css', 'resources/css/welcome.css', 'resources/css/animations.css', 'resources/js/welcome.js', 'resources/js/animations.js'])
    @livewireStyles
</head>
<body>

    <!-- الشريط العلوي -->
    <header class="header" id="header">
        <div class="nav-container container">
            <a href="#home" class="logo">
                <lottie-player src="{{ asset('animations/abihe.json') }}" background="transparent" speed="1" style="width: 50px; height: 50px;" loop autoplay></lottie-player>
                جامعة الحضارة
            </a>
            <nav>
                <ul class="nav-menu" aria-label="القائمة الرئيسية">
                    @foreach($navLinks as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
            <div class="nav-actions">
                @auth
                    <a href="{{ $dashboardRoute }}" class="login-btn">
                        <i class="fas fa-th-large"></i>
                        <span>لوحة التحكم</span>
                    </a>
                @else
                    <a href="{{ $loginRoute }}" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>دخول</span>
                    </a>
                @endauth
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="فتح القائمة">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <main>
        <!-- القسم الرئيسي -->
        <section class="hero" id="home">
            <div class="container hero-grid">
                <div class="hero-content anim-slide-right">
                    <div class="university-name anim-zoom"><span>جامعة</span>الحضارة</div>
                    <h1 class="anim-slide-up">صرحك نحو مستقبلٍ واعد</h1>
                    <p class="hero-description anim-slide-up" style="transition-delay: 0.2s;">نصنع القادة والمبتكرين في بيئة أكاديمية تجمع بين الأصالة والتميز. تأسست الجامعة عام 2012م بإيمان راسخ بأهمية التعليم العالي في بناء الحضارات ورقي الشعوب.</p>
                    <a href="#login-options" class="cta-button anim-zoom floating-delayed">اكتشف رحلتك الأكاديمية <i class="fas fa-arrow-left"></i></a>
                </div>
                <div class="hero-animation anim-slide-left">
                    <lottie-player src="{{ asset('animations/Welcome.json') }}" background="transparent" speed="1" style="width: 100%; height: auto; max-width: 600px;" loop autoplay></lottie-player>
                </div>
            </div>
        </section>

        <!-- قسم خيارات الدخول -->
        <section id="login-options" class="section" style="background-color: var(--bg-soft);">
            <div class="container">
                <x-section-title title="بوابتك الرقمية" subtitle="اختر دورك للوصول إلى الخدمات المخصصة لك في المنصة الجامعية المتكاملة." />
                <div class="default-grid">
                    @foreach($loginOptions as $loop_index => $option)
                        <x-card 
                            :icon="$option['icon']" 
                            :title="$option['title']" 
                            :description="$option['description']" 
                            :cta="$option['cta']" 
                            :ctaLink="$loginRoute"
                            :delay="$loop_index * 100"
                        />
                    @endforeach
                </div>
            </div>
        </section>

        <!-- فاصل جمالي -->
        <div class="section-divider">
            <lottie-player src="{{ asset('animations/Demo.json') }}" background="transparent" speed="1" style="width: 100%; height: 200px;" loop autoplay></lottie-player>
        </div>

        <!-- قسم عن الجامعة والمنصة -->
        <section id="about" class="section">
            <div class="container">
                <x-section-title title="عن الجامعة والمنصة" subtitle="نلتزم بتقديم تعليم عالي الجودة ونظام رقمي متطور يخدم المجتمع." />
                <div class="info-grid">
                    @foreach($infoItems as $item)
                        <x-info-item :icon="$item['icon']" :title="$item['title']" :description="$item['description']" />
                    @endforeach
                </div>
            </div>
        </section>

        <!-- الإحصائيات -->
        <section id="statistics" class="section" style="background-color: var(--bg-soft);">
            <div class="container stats-container-flex">
                <div class="stats-content">
                    <x-section-title title="جامعة الحضارة بالأرقام" subtitle="نفخر بإنجازاتنا التي تعكس مسيرتنا الحافلة بالعطاء والتميز." />
                    <div class="stats-grid">
                        @foreach($stats as $stat)
                            <div class="stat-card anim-zoom" style="transition-delay: {{ $loop->index * 100 }}ms">
                                <div class="stat-number">{{ $stat['value'] }}</div>
                                <div class="stat-label">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="stats-animation anim-slide-left">
                    <lottie-player src="{{ asset('animations/data analysis.json') }}" background="transparent" speed="1" style="width: 100%; height: auto; max-width: 500px;" loop autoplay></lottie-player>
                </div>
            </div>
        </section>

        <!-- الكليات -->
        <section id="colleges" class="section">
            <div class="container">
                <x-section-title title="كليات الجامعة" subtitle="نقدم برامج أكاديمية متنوعة في كليات متخصصة تلبي طموحاتكم." />
                <div class="default-grid">
                    @foreach($colleges as $college)
                        <x-card 
                            :icon="$college['icon']" 
                            :title="$college['title']" 
                            :description="$college['description']" 
                            animation="anim-slide-left"
                        />
                    @endforeach
                </div>
            </div>
        </section>

        <!-- قسم التخصصات -->
        <section id="specializations" class="section" style="background-color: var(--bg-soft);">
            <div class="container">
                <x-section-title title="برامجنا الأكاديمية" subtitle="اكتشف مجموعة متنوعة من التخصصات التي تلبي طموحاتك وتواكب متطلبات سوق العمل." />
                @foreach($specializations as $faculty)
                    <div class="faculty-card anim-slide-right">
                        <h3 class="faculty-title">{{ $faculty['title'] }}</h3>
                        <table class="specializations-table">
                            <thead>
                                <tr>
                                    <th>التخصص</th>
                                    <th>مدة الدراسة</th>
                                    <th>الرسوم السنوية</th>
                                    <th>عدد المقاعد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($faculty['programs'] as $program)
                                    <tr>
                                        <td>{{ $program['name'] }}</td>
                                        <td>{{ $program['duration'] }}</td>
                                        <td>{{ $program['fees'] }}</td>
                                        <td>{{ $program['seats'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- خدمات الطلاب -->
        <section id="services" class="section">
            <div class="container">
                <x-section-title title="خدمات شؤون الطلاب" subtitle="نوفر كل ما يحتاجه الطالب لتجربة جامعية سلسة ومثمرة." />
                <div class="services-grid">
                    @foreach($services as $loop_index => $service)
                        <x-card 
                            :icon="$service['icon']" 
                            :title="$service['title']" 
                            :description="$service['description']" 
                            :delay="$loop_index * 100"
                        />
                    @endforeach
                </div>
            </div>
        </section>

        <!-- مباني الجامعة -->
        <section id="buildings" class="section" style="background-color: var(--bg-soft);">
            <div class="container">
                <x-section-title title="مرافق الجامعة" subtitle="بيئة تعليمية متكاملة ومجهزة بأحدث الوسائل لدعم مسيرتك الأكاديمية." />
                <div class="info-grid">
                    @foreach($buildings as $building)
                        <x-info-item :icon="$building['icon']" :title="$building['title']" :description="$building['description']" />
                    @endforeach
                </div>
            </div>
        </section>

        <!-- قسم المميزات -->
        <section id="features" class="section">
            <div class="container">
                <div class="features-top-layout" style="text-align: center; margin-bottom: 40px;">
                    <div class="features-animation" style="display: flex; justify-content: center; margin-bottom: 20px;">
                        <lottie-player src="{{ asset('animations/robot-analytics.json') }}" background="transparent" speed="1" style="width: 100%; height: auto; max-width: 400px;" loop autoplay></lottie-player>
                    </div>
                    <x-section-title title="مميزات منصتنا التعليمية" subtitle="نقدم تجربة تعليمية رقمية متكاملة ومصممة لتلبية احتياجاتك." />
                </div>
                
                <div class="default-grid">
                    @foreach($features as $loop_index => $feature)
                        <x-card 
                            :icon="$feature['icon']" 
                            :title="$feature['title']" 
                            :description="$feature['description']" 
                            :delay="$loop_index * 100"
                        />
                    @endforeach
                </div>
            </div>
        </section>

        <!-- قسم الاقتباس -->
        <section class="quote-section anim-zoom">
            <div class="container">
                <div class="quote-card">
                    <i class="fas fa-quote-right quote-start"></i>
                    <h3>حكمة يمنية خالدة</h3>
                    <p>"بالعلم تُبنى الأوطان وتُرفع الأعلام"</p>
                    <i class="fas fa-quote-left quote-end"></i>
                </div>
            </div>
        </section>

        <!-- قسم المطورين -->
        <section id="developers" class="developers-section section">
            <div class="container">
                <x-section-title title="فريق تطوير المنصة" subtitle="العقول المبدعة التي عملت بشغف لتقديم هذه التجربة الرقمية المتميزة." />
                <div class="developers-grid">
                    @foreach($developers as $developer)
                        <x-developer-card
                            style="transition-delay: {{ $loop->index * 200 }}ms"
                            :name="$developer['name']"
                            :role="$developer['role']"
                            :image="$developer['image']"
                            :contacts="$developer['contacts']"
                            :socials="$developer['socials']"
                        />
                    @endforeach
                </div>
            </div>
        </section>

        <!-- قسم الاتصال -->
        <section id="contact" class="section">
            <div class="container">
                <x-section-title title="تواصل معنا" subtitle="نحن هنا لمساعدتك! لا تتردد في التواصل معنا لأي استفسار." />
                <div class="contact-grid-layout">
                    <div class="form-card anim-slide-up">
                        <h3>أرسل لنا رسالة</h3>
                        @livewire('contact-form')
                    </div>
                    <div class="contact-info-card anim-slide-up">
                        <h3>معلومات الاتصال</h3>
                        <div style="margin-top: 2rem;">
                            @foreach($contactInfo as $item)
                                <div class="contact-info-item">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <div>
                                        <h4>{{ $item['title'] }}</h4>
                                        <p>{{ $item['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
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
                @foreach($socialLinks as $link)
                    <a href="{{ $link['url'] }}" title="{{ $link['title'] }}" target="_blank" rel="noopener">
                        <i class="{{ $link['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
            <p class="copyright">© 2024 جامعة الحضارة. جميع الحقوق محفوظة.</p>
        </div>
    </footer>


    <div class="mobile-menu" id="mobileMenu">
        <ul>
            @foreach($navLinks as $link)
                <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
            @endforeach
            @foreach($mobileExtraLinks as $link)
                <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
            @endforeach
            @auth
                <li><a href="{{ $dashboardRoute }}" class="login-btn">لوحة التحكم</a></li>
            @else
                <li><a href="{{ $loginRoute }}" class="login-btn">دخول</a></li>
            @endauth
        </ul>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>

    @livewire('guest-ai-chat')
    @livewireScripts
</body>
</html>