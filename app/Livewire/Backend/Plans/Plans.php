<?php

namespace App\Livewire\Backend\Plans;

use App\Models\Feature;
use App\Models\Plan;
use App\Models\User;
use Livewire\Component;
use Stripe\Price;
use Stripe\Product;

class Plans extends Component
{
    public $package_name;
    public $package_marketing;
    public $package_price;
    public $package_discount;
    public $new_feature;
    public $selected_features = [];
    public $edit_feature_id;
    public $edit_feature_name;
    public $plans;
    public $draftPlans;
    public $features;

    public $current_package;

    public function mount()
    {
        $this->plans = Plan::where('status', 'published')->get();
        $this->draftPlans = Plan::where('status', 'draft')->get();
        $this->features = Feature::all();
    }

    public function active_package(  $id ){

        $package = Plan::where('id', $id)->first();        
        if( ! $package ){
            $this->resetToDefualt();
            return  $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الباقة!');
        }

        $this->current_package = $package;

        $this->package_name = $package->name;
        $this->package_marketing = $package->description;
        $this->package_price = $package->monthly_price;
        $this->package_discount = $package->annual_discount;

        $this->selected_features = $package->features()->pluck('features.id')->toArray();

    }

    public function resetToDefualt()
    {
        $this->reset(['current_package','package_name', 'package_marketing', 'package_price', 'package_discount', 'selected_features']);
    }
    // دالة لإضافة ميزة جديدة
    public function addFeature()
    {
        $this->validate([
            'new_feature' => 'required|string|max:255',
        ]);

        // إنشاء الميزة الجديدة
        $feature = Feature::create([
            'name' => $this->new_feature,
        ]);

        // تحديث قائمة الميزات وإعادة تعيين حقل الإدخال
        $this->features = Feature::all();
        $this->new_feature = '';
    }

    // دالة لحذف ميزة
    public function deleteFeature($id)
    {
        Feature::destroy($id);
        $this->features = Feature::all();  // إعادة تحميل الميزات بعد الحذف
    }

    // دالة لتعديل ميزة
    public function editFeature($id)
    {
        $feature = Feature::find($id);
        if ($feature) {
            $this->edit_feature_id = $feature->id;
            $this->edit_feature_name = $feature->name;
        }
    }

    // حفظ الميزة بعد التعديل
    public function saveUpdatedFeature()
    {
        $feature = Feature::find($this->edit_feature_id);
        if ($feature) {
            $feature->name = $this->edit_feature_name;
            $feature->save();
            $this->features = Feature::all();  // تحديث قائمة الميزات
        }

        // إعادة تعيين المتغيرات بعد الحفظ
        $this->edit_feature_id = null;
        $this->edit_feature_name = null;
    }

    // دالة لحفظ الحزمة
    public function savePackage()
    {

        $this->validate([
            'package_name' => 'required|string|min:5|max:255',
            'package_marketing' => 'required|string|min:5|max:255',
            'package_price' => 'required|numeric|min:0',
            'package_discount' => 'required|numeric|min:0|max:100',
            'selected_features' => 'required|array',
        ]);

        // إنشاء الحزمة
        $plan = Plan::create([
            'name' => $this->package_name,
            'description' => $this->package_marketing,
            'monthly_price' => $this->package_price,
            'annual_discount' => $this->package_discount,
            'status' => 'published',
        ]);

        // ربط الميزات بالحزمة
        $plan->features()->sync($this->selected_features);
        // تحديث قائمة الحزم
        $this->mount();

        // إعادة تعيين الحقول بعد حفظ الحزمة
        $this->resetToDefualt();
        $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم إنشاء الباقة بنجاح!');
    }
    public function saveUpdatePackage()
    {
        if( ! $this->current_package || $this->current_package === null ){
            $this->resetToDefualt();
            return  $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الخطة!');
        }

        $this->validate([
            'package_name' => 'required|string|min:5|max:255',
            'package_marketing' => 'required|string|min:5|max:255',
            'package_price' => 'required|numeric|min:0',
            'package_discount' => 'required|numeric|min:0|max:100',
            'selected_features' => 'required|array',
        ]);

        // إنشاء الحزمة
        $this->current_package->update([
            'name' => $this->package_name,
            'description' => $this->package_marketing,
            'monthly_price' => $this->package_price,
            'annual_discount' => $this->package_discount,
        ]);

        // ربط الميزات بالحزمة
        $this->current_package->features()->sync($this->selected_features);

        // تحديث قائمة الحزم
        $this->mount();

        // إعادة تعيين الحقول بعد حفظ الحزمة
        $this->resetToDefualt();
        $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حفظ الباقة بنجاح!');

    }

    // دالة لحفظ الحزمة كمسودة
    public function saveAsDraft()
    {
        $this->validate([
            'package_name' => 'required|string|min:5|max:255',
            'package_marketing' => 'required|string|min:5|max:255',
            'package_price' => 'required|numeric|min:0',
            'package_discount' => 'required|numeric|min:0|max:100',
            'selected_features' => 'required|array',
        ]);

        // إنشاء الحزمة كمسودة
        $plan = Plan::create([
            'name' => $this->package_name,
            'description' => $this->package_marketing,
            'monthly_price' => $this->package_price,
            'annual_discount' => $this->package_discount,
        ]);

        // ربط الميزات بالحزمة
        $plan->features()->sync($this->selected_features);

        // تحديث قائمة الحزم
        $this->mount();

        // إعادة تعيين الحقول بعد حفظ المسودة
        $this->resetToDefualt();
        $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم إنشاء الباقة بنجاح!');
    }

    public function deletePackage( $id )
    {
        $this->active_package(  $id );

        if( $this->current_package === null || $this->current_package->id !== $id ){
            $this->resetToDefualt();
            return  $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الخطة المطلوب حذفها!');
        }

        $this->dispatch('deletePackageConfirm', type: 'question', msg: 'هل أنت متأكد من رغبتك في حذف: '.$this->current_package->name);
    }

    public function updatePackage( $id )
    {
        $this->active_package(  $id );

        if( $this->current_package === null || $this->current_package->id !== $id ){
            $this->resetToDefualt();
            return  $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الخطة المطلوب حذفها!');
        }

        $this->dispatch('updatePackageConfirm', type: '', msg: '');
    }

    public function confirmDeletePackage()
    {
        if( ! $this->current_package || $this->current_package === null ){
            $this->resetToDefualt();
            return  $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الخطة المطلوب حذفها!');
        }

        $this->current_package->delete();
        $this->resetToDefualt();

        $this->mount();
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حذف الباقة بنجاح!');

    }

    public function draftPackage( $id )
    {
        $this->active_package(  $id );

        if( $this->current_package === null || $this->current_package->id !== $id ){
            $this->resetToDefualt();
            return  $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الخطة!');
        }

        $text = $this->current_package->status == 'draft' ? 'هل ترغب في نشر الباقة' : 'هل ترغب في نقل الباقة للمسودة';
        $this->dispatch('draftPackageConfirm', type: 'question', msg: $text . '?');
    }

    public function confirmDraftPackage()
    {
        if( ! $this->current_package || $this->current_package === null ){
            $this->resetToDefualt();
            return  $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الخطة!');
        }

        $this->current_package->update([
            'status' => $this->current_package->status == 'draft' ? 'published' : 'draft'
        ]);
        $this->resetToDefualt();

        $this->mount();
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حفظ التغييرات بنجاح!');

    }

    public function toggleFeatured($id)
    {
        
        $this->active_package(  $id );

        if( $this->current_package === null || $this->current_package->id !== $id ){
            $this->resetToDefualt();
            return  $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الخطة!');
        }

        $this->current_package->update([
            'is_featured' => $this->current_package->is_featured == true ? false : true
        ]);

        $this->resetToDefualt();

        $this->mount();
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حفظ التغييرات بنجاح!');

    }

    public function render()
    {
        return view('livewire.backend.plans.plans', [
            'plans' => $this->plans,
            'features' => $this->features,
        ]);
    }
}
