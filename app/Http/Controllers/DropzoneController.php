<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropzoneController extends Controller
{
    public function store(Request $request)
    {
        // التحقق من وجود ملف مرفق
        if ($request->hasFile('file')) {
            // الحصول على الملف المرفوع
            $image = $request->file('file');
    
            // الحصول على الاسم الأصلي للملف بدون الامتداد
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
    
            // إنشاء اسم جديد للملف باستخدام الاسم الأصلي و الوقت الحالي وامتداد الملف
            $imageName = $originalName . '_' . time() . '.' . $image->extension();
    
            // الحصول على السنة والشهر الحاليين
            $year = date('Y');
            $month = date('m');
    
            // التحقق إذا كان هناك Tenant مسجل
            if (tenant('id')) {
                // استخدام tenant id لإنشاء مجلد خاص بالـ tenant
                $tenantId = tenant('id');
                $directory = 'tenants/' . $tenantId . '/' . $year . '/' . $month;
            } else {
                // رفع الملفات في مجلد 'master' إذا لم يكن هناك tenant
                $directory = 'master/' . $year . '/' . $month;
            }
    
            // التأكد من وجود المجلد، وإذا لم يكن موجودًا يتم إنشاؤه مع المجلدات الفرعية للسنة والشهر
            if (!file_exists(public_path($directory))) {
                mkdir(public_path($directory), 0777, true);
            }
    
            // نقل الملف إلى المسار المحدد بناءً على حالة tenant
            $image->move(public_path($directory), $imageName);
    
            // إنشاء رابط الصورة المرفوعة
            $imageUrl = asset($directory . '/' . $imageName);
    
            // إرجاع استجابة JSON تحتوي على رابط الصورة وحالة النجاح
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'image_url' => $imageUrl,
            ]);
        }
    
        // في حالة عدم وجود ملف مرفق، إرجاع استجابة خطأ
        return response()->json([
            'success' => false,
            'message' => 'No file uploaded.',
        ], 400);
    }
}
