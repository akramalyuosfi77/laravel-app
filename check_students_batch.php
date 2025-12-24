<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;

echo "=== فحص الطلاب والدفعات ===\n\n";

// عدد الطلاب الكلي
$totalStudents = Student::count();
echo "إجمالي الطلاب: $totalStudents\n\n";

// الطلاب حسب الدفعة
$studentsByBatch = Student::selectRaw('batch_id, COUNT(*) as count')
    ->groupBy('batch_id')
    ->get();

echo "توزيع الطلاب حسب الدفعة:\n";
foreach ($studentsByBatch as $batch) {
    $batchId = $batch->batch_id ?? 'NULL';
    echo "  Batch ID: $batchId => {$batch->count} طالب\n";
}

echo "\n=== عينة من الطلاب ===\n";
$sampleStudents = Student::with('batch')->take(5)->get();
foreach ($sampleStudents as $student) {
    $batchName = $student->batch->name ?? 'لا يوجد';
    echo "ID: {$student->id} | الاسم: {$student->name} | Batch ID: " . ($student->batch_id ?? 'NULL') . " | الدفعة: $batchName\n";
}

echo "\n✅ تم الفحص بنجاح!\n";
