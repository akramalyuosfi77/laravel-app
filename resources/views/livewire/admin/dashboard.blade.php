<div wire:poll.30s="loadAllData">
    <div class="p-4 sm:p-6 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto">

            <!-- عنوان الصفحة -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-sky-800">لوحة التحكم الرئيسية</h1>
                <p class="text-lg text-gray-600">نظرة عامة وشاملة على كل أركان المنصة.</p>
            </div>

            <!-- المرحلة الأولى: بطاقات الإحصائيات الشاملة -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                <!-- بطاقة إجمالي المستخدمين -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 rtl:space-x-reverse transition-transform transform hover:scale-105">
                    <div class="bg-blue-100 p-3 rounded-full"><i class="bi bi-people-fill text-2xl text-blue-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">إجمالي المستخدمين</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    </div>
                </div>
                <!-- بطاقة الطلاب النشطين -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 rtl:space-x-reverse transition-transform transform hover:scale-105">
                    <div class="bg-green-100 p-3 rounded-full"><i class="bi bi-person-check-fill text-2xl text-green-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">الطلاب النشطين</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $activeStudents }}</p>
                    </div>
                </div>
                <!-- بطاقة إجمالي الدكاترة -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 rtl:space-x-reverse transition-transform transform hover:scale-105">
                    <div class="bg-purple-100 p-3 rounded-full"><i class="bi bi-person-video3 text-2xl text-purple-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">إجمالي الدكاترة</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalDoctors }}</p>
                    </div>
                </div>
                <!-- بطاقة المشاريع المكتملة -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 rtl:space-x-reverse transition-transform transform hover:scale-105">
                    <div class="bg-yellow-100 p-3 rounded-full"><i class="bi bi-award-fill text-2xl text-yellow-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">المشاريع المكتملة</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $completedProjects }}</p>
                    </div>
                </div>
                <!-- 💡 بطاقة الأقسام الجديدة -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 rtl:space-x-reverse transition-transform transform hover:scale-105">
                    <div class="bg-red-100 p-3 rounded-full"><i class="bi bi-building-fill text-2xl text-red-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">الأقسام الأكاديمية</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalDepartments }}</p>
                    </div>
                </div>
                <!-- 💡 بطاقة التخصصات الجديدة -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 rtl:space-x-reverse transition-transform transform hover:scale-105">
                    <div class="bg-indigo-100 p-3 rounded-full"><i class="bi bi-mortarboard-fill text-2xl text-indigo-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">التخصصات الدراسية</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalSpecializations }}</p>
                    </div>
                </div>
                <!-- 💡 بطاقة الدفعات الجديدة -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 rtl:space-x-reverse transition-transform transform hover:scale-105">
                    <div class="bg-pink-100 p-3 rounded-full"><i class="bi bi-collection-fill text-2xl text-pink-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">الدفعات الطلابية</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalBatches }}</p>
                    </div>
                </div>
                <!-- 💡 بطاقة المواد الجديدة -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 rtl:space-x-reverse transition-transform transform hover:scale-105">
                    <div class="bg-teal-100 p-3 rounded-full"><i class="bi bi-book-half text-2xl text-teal-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">المقررات الدراسية</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalCourses }}</p>
                    </div>
                </div>
            </div>

            <!-- ... باقي الأقسام (الأنشطة، الرسوم البيانية، قوائم المراجعة) تبقى كما هي ... -->
            <!-- المرحلتان الثانية والثالثة: الأنشطة والرسوم البيانية -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- العمود الأيمن: أحدث الأنشطة -->
                <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">أحدث الأنشطة</h3>
                    <ul role="list" class="space-y-4">
                        @forelse($recentNotifications as $notification)
                            <li class="flex items-start space-x-3 rtl:space-x-reverse">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="bi {{ $notification->data['icon'] ?? 'bi-bell-fill' }} text-gray-500 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-700">{{ $notification->data['message'] }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="text-center text-gray-500 py-4">لا توجد أنشطة لعرضها حالياً.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- العمود الأيسر: الرسوم البيانية -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">الطلاب الجدد (آخر 7 أيام)</h3>
                        <div class="h-64"><canvas id="newStudentsChart"></canvas></div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">توزيع المستخدمين حسب الدور</h3>
                        <div class="h-64"><canvas id="userRolesChart"></canvas></div>
                    </div>
                </div>
            </div>

            <!-- المرحلة الرابعة: قوائم المراجعة السريعة -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">طلاب بانتظار التفعيل</h3>
                    <ul class="divide-y divide-gray-200">
                        @forelse($pendingStudents as $student)
                            <li class="py-3 flex items-center justify-between">
                                <p class="text-gray-700">{{ $student->name }} <span class="text-sm text-gray-500">({{ $student->student_id_number }})</span></p>
                                <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:underline">مراجعة</a>
                            </li>
                        @empty
                            <li class="py-3 text-center text-gray-500">لا يوجد طلاب بانتظار التفعيل.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">مشاريع بانتظار الموافقة</h3>
                    <ul class="divide-y divide-gray-200">
                        @forelse($pendingProjects as $project)
                            <li class="py-3 flex items-center justify-between">
                                <p class="text-gray-700">{{ $project->title }} <span class="text-sm text-gray-500">(بواسطة {{ $project->creatorStudent->name }})</span></p>
                                <a href="{{ route('admin.projects') }}" class="text-sm text-blue-600 hover:underline">مراجعة</a>
                            </li>
                        @empty
                            <li class="py-3 text-center text-gray-500">لا توجد مشاريع بانتظار الموافقة.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ... (كود الجافاسكريبت للرسوم البيانية يبقى كما هو بدون تغيير )
        let userRolesChartInstance = null;
        let newStudentsChartInstance = null;

        function updateUserRolesChart(data) {
            const ctx = document.getElementById('userRolesChart').getContext('2d');
            if (userRolesChartInstance) {
                userRolesChartInstance.data.labels = data.labels;
                userRolesChartInstance.data.datasets[0].data = data.data;
                userRolesChartInstance.update();
            } else {
                userRolesChartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.data,
                            backgroundColor: ['#3B82F6', '#10B981', '#A855F7'],
                            hoverOffset: 4
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }
        }

        function updateNewStudentsChart(data) {
            const ctx = document.getElementById('newStudentsChart').getContext('2d');
            if (newStudentsChartInstance) {
                newStudentsChartInstance.data.labels = data.labels;
                newStudentsChartInstance.data.datasets[0].data = data.data;
                newStudentsChartInstance.update();
            } else {
                newStudentsChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'عدد الطلاب المسجلين',
                            data: data.data,
                            fill: true,
                            borderColor: 'rgba(59, 130, 246, 1)',
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                    }
                });
            }
        }

        document.addEventListener('livewire:init', () => {
            updateUserRolesChart(@json($userRolesChartData));
            updateNewStudentsChart(@json($newStudentsChartData));

            Livewire.on('update-charts', (event) => {
                updateUserRolesChart(event.userRolesChartData);
                updateNewStudentsChart(event.newStudentsChartData);
            });
        });
    </script>
    @endpush
</div>
