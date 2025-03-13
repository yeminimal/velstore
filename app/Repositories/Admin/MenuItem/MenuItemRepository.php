<?php

namespace App\Repositories\Admin\MenuItem;

use App\Models\MenuItem;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuItemRepository implements MenuItemRepositoryInterface
{
    public function getAll()
    {
        return MenuItem::all();
    }

    public function getMenuItemsByMenuId($menuId)
    {
        return MenuItem::with('menuItemTranslations')
            ->where('menu_id', $menuId)
            ->get();
    }

    public function createMenuItem(Request $request, $menuId)
    {
        $languages = Language::all();
        $slug = Str::slug($request->input('title_' . $languages->first()->code));

        $menuItem = MenuItem::create([
            'menu_id' => $menuId,
            'order_number' => $request->input('order_number'),
            'parent_id' => $request->input('parent_id'),
            'slug' => $slug,
        ]);

        foreach ($languages as $language) {
            $menuItem->translations()->create([
                'language_code' => $language->code,
                'title' => $request->input('title_' . $language->code),
            ]);
        }

        return $menuItem;
    }

    public function updateMenuItem(Request $request, $menuId, $menuItemId)
    {
        $menuItem = MenuItem::findOrFail($menuItemId);
        $languages = Language::all();
        $slug = Str::slug($request->input('title_' . $languages->first()->code));

        $menuItem->update([
            'menu_id' => $menuId,
            'order_number' => $request->input('order_number'),
            'parent_id' => $request->input('parent_id'),
            'slug' => $slug,
        ]);

        foreach ($languages as $language) {
            $translation = $menuItem->translations()->where('language_code', $language->code)->first();
            if ($translation) {
                $translation->update(['title' => $request->input('title_' . $language->code)]);
            } else {
                $menuItem->translations()->create([
                    'language_code' => $language->code,
                    'title' => $request->input('title_' . $language->code),
                ]);
            }
        }

        return $menuItem;
    }

    public function deleteMenuItem($menuItemId)
    {
        $menuItem = MenuItem::findOrFail($menuItemId);
        return $menuItem->delete();
    }
}
