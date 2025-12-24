# 📱 دليل استخدام APIs التطبيق - نظام تسجيل الطلاب

## 🎯 التدفق الكامل للتسجيل عبر Google OAuth + Barcode

### 1️⃣ **مسح الباركود (Scan QR Code)**
**Endpoint:** `GET /api/v1/mobile/batch/{batch_id}`

**مثال:**
```
GET http://localhost:8000/api/v1/mobile/batch/1
```

**الاستجابة (Response):**
```json
{
  "status": true,
  "data": {
    "id": 1,
    "name": "دفعة 2024",
    "specialization": "علوم الحاسوب",
    "department": "تقنية المعلومات",
    "current_year": 1,
    "current_semester": 1
  }
}
```

---

### 2️⃣ **التسجيل عبر Google OAuth + Barcode**
**Endpoint:** `POST /api/v1/mobile/register-google`

**البيانات المطلوبة (Request Body):**
```json
{
  "batch_id": 1,
  "google_id": "108769xxxxxx",
  "google_name": "أحمد محمد",
  "google_email": "ahmed@gmail.com",
  "student_id_number": "2024001",
  "password": "password123"
}
```

**الاستجابة (Response):**
```json
{
  "status": true,
  "message": "🎉 مرحباً بك! تم التسجيل والدخول بنجاح",
  "data": {
    "user": {
      "id": 15,
      "name": "أحمد محمد",
      "email": "ahmed@gmail.com",
      "role": "student",
      "is_active": true
    },
    "student": {
      "id": 12,
      "name": "أحمد محمد",
      "email": "ahmed@gmail.com",
      "student_id_number": "2024001",
      "batch_id": 1,
      "status": "نشط"
    },
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "batch": {
      "id": 1,
      "name": "دفعة 2024",
      "specialization": "علوم الحاسوب",
      "department": "تقنية المعلومات"
    }
  }
}
```

⚠️ **ملاحظات مهمة:**
- البيانات (`google_id`, `google_name`, `google_email`) تأتي من Google OAuth
- الطالب يدخل فقط: `student_id_number` + `password`
- `batch_id` يأتي من مسح الباركود
- التسجيل والدخول يتمان في خطوة واحدة!
- يتم إرجاع `token` للاستخدام المباشر في التطبيق

---

### 3️⃣ **تسجيل الدخول (للطلاب المسجلين مسبقاً)**
**Endpoint:** `POST /api/v1/mobile/login`

**البيانات المطلوبة:**
```json
{
  "email": "ahmed@gmail.com",
  "password": "password123"
}
```

**الاستجابة:**
```json
{
  "status": true,
  "message": "تم تسجيل الدخول بنجاح",
  "data": {
    "token": "2|xxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "user": { ... },
    "student": { ... }
  }
}
```

---

### 4️⃣ **جلب بيانات الطالب الحالي**
**Endpoint:** `GET /api/v1/mobile/me`

**Headers:**
```
Authorization: Bearer {token}
```

**الاستجابة:**
```json
{
  "status": true,
  "data": {
    "user": { ... },
    "student": { ... },
    "batch": { ... }
  }
}
```

---

## 📋 خطوات التنفيذ في Flutter:

1. **مسح QR Code** → احصل على `batch_id`
2. **تسجيل دخول Google OAuth** → احصل على `google_id`, `google_name`, `google_email`
3. **عرض حقول الإدخال** → الطالب يدخل `student_id_number` + `password`
4. **إرسال الطلب** → `POST /api/v1/mobile/register-google`
5. **حفظ Token** → استخدامه في كل الطلبات المستقبلية
6. **الانتقال للصفحة الرئيسية** → عرض "مرحباً بك في لوحة التحكم"

---

## ✅ تم التنفيذ

- ✅ API لجلب معلومات الدفعة (لعرضها بعد المسح)
- ✅ API للتسجيل عبر Google + Barcode
- ✅ API لتسجيل الدخول العادي  
- ✅ API لجلب بيانات الطالب المسجل
- ✅ الحسابات تُفعّل تلقائياً
- ✅ رسائل تأكيد بالعربية
- ✅ معالجة الأخطاء (البريد مكرر، رقم أكاديمي مكرر، إلخ...)

---

## 🎨 للصفحة الرئيسية في التطبيق:

بعد تسجيل الدخول، يمكنك عرض صفحة بسيطة:

```dart
class StudentDashboard extends StatelessWidget {
  final String studentName;
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Text(
          'مرحباً بك $studentName\nفي لوحة التحكم الخاصة بك',
          textAlign: TextAlign.center,
          style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
        ),
      ),
    );
  }
}
```
