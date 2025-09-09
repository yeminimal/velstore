<?php

namespace App\Repositories\Admin\Attribute;

use App\Models\Attribute;
use App\Models\AttributeValueTranslation;

class AttributeRepository implements AttributeRepositoryInterface
{
    public function getAll()
    {
        return Attribute::with('values.translations')->latest()->paginate(10);
    }

    public function getById($id)
    {
        return Attribute::with('values.translations')->findOrFail($id);
    }

    public function store(array $data)
    {
        $attribute = Attribute::create(['name' => $data['name']]);

        foreach ($data['values'] as $value) {
            $attributeValue = $attribute->values()->create(['value' => $value]);

            if (isset($data['translations'])) {
                foreach ($data['translations'] as $languageCode => $translatedValue) {
                    if (! empty($translatedValue)) {
                        AttributeValueTranslation::create([
                            'attribute_value_id' => $attributeValue->id,
                            'language_code' => $languageCode,
                            'translated_value' => $translatedValue,
                        ]);
                    }
                }
            }
        }

        return $attribute;
    }

    public function update(Attribute $attribute, array $data)
    {
        $attribute->update(['name' => $data['name']]);

        $existingValues = $attribute->values->keyBy('id');

        $processedIds = [];

        foreach ($data['values'] as $valueId => $value) {
            if (is_numeric($valueId) && isset($existingValues[$valueId])) {
                $existingValues[$valueId]->update(['value' => $value]);
                $processedIds[] = $valueId;

                $attributeValue = $existingValues[$valueId];
            } else {
                $attributeValue = $attribute->values()->create(['value' => $value]);
                $processedIds[] = $attributeValue->id;
            }

            if (isset($data['translations'])) {
                foreach ($data['translations'] as $languageCode => $translatedValue) {
                    if (! empty($translatedValue)) {
                        \App\Models\AttributeValueTranslation::updateOrCreate(
                            [
                                'attribute_value_id' => $attributeValue->id,
                                'language_code' => $languageCode,
                            ],
                            ['translated_value' => $translatedValue]
                        );
                    }
                }
            }
        }

        $valuesToDelete = $existingValues->keys()->diff($processedIds);
        if ($valuesToDelete->isNotEmpty()) {
            $attribute->values()->whereIn('id', $valuesToDelete)->delete();
        }

        return $attribute;
    }

    public function delete($id)
    {
        $attribute = Attribute::findOrFail($id);

        return $attribute->delete();
    }
}
