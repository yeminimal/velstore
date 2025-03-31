<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeValueTranslation;
use App\Models\Language;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('values.translations')->latest()->paginate(10);
        return view('admin.attributes.index', compact('attributes'));
    }

   
    public function create()
    {
       
        $languages = Language::active()->get();
        return view('admin.attributes.create', compact('languages'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'required|array',
            'values.*' => 'string|max:255',
            'translations' => 'array',
        ]);

        $attribute = Attribute::create(['name' => $request->name]);

        foreach ($request->values as $value) {
            $attributeValue = $attribute->values()->create(['value' => $value]);

            if ($request->has('translations')) {
                foreach ($request->translations as $languageCode => $translatedValue) {
                    if (!empty($translatedValue)) {
                        AttributeValueTranslation::create([
                            'attribute_value_id' => $attributeValue->id,
                            'language_code' => $languageCode,
                            'translated_value' => $translatedValue,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully!');   
    }

   
    public function edit(Attribute $attribute)
    {
       
        $attribute->load('values.translations'); 
        $languages = Language::active()->get();
        
        return view('admin.attributes.edit', compact('attribute', 'languages'));
    }

   
    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'required|array',
            'values.*' => 'string|max:255',
            'translations' => 'array',
        ]);
    
        $attribute->update(['name' => $request->name]);
    
        $existingValues = $attribute->values->keyBy('id'); 
    
        foreach ($request->values as $valueId => $value) {
            if (is_numeric($valueId) && isset($existingValues[$valueId])) {
                $existingValues[$valueId]->update(['value' => $value]);
            } else {
                $attributeValue = $attribute->values()->create(['value' => $value]);
            }
    
            if ($request->has('translations')) {
                foreach ($request->translations as $languageCode => $translatedValue) {
                    if (!empty($translatedValue)) {
                        AttributeValueTranslation::updateOrCreate(
                            [
                                'attribute_value_id' => $attributeValue->id ?? $valueId,
                                'language_code' => $languageCode,
                            ],
                            ['translated_value' => $translatedValue]
                        );
                    }
                }
            }
        }
    
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated successfully!');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted successfully.');
    }
}