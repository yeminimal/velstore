<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuItemTranslation;
use App\Models\Language;
use App\Services\Admin\MenuItemService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MenuItemController extends Controller
{   
    public function index($menuId)
    {
        $menu = Menu::with('menuItems.translations')->findOrFail($menuId);
        $menuItems = MenuItem::where('menu_id', $menuId)->with(['translations', 'parent.translations'])->orderBy('order_number')->get();

        return view('admin.menu_items.index', compact('menu', 'menuItems'));
    }

    public function create($menuId)
    {
            
        $menu = Menu::findOrFail($menuId);
        $menus = Menu::all(); // Fetch all menus for dropdown
        $languages = Language::where('active', 1)->get();

        return view('admin.menu_items.create', compact('menu', 'menus', 'languages'));
    }


    public function store(Request $request, $menuId)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'order_number' => 'required|integer',
            'parent_id' => 'nullable|exists:menu_items,id',
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $defaultLang = array_key_first($request->title);
            $defaultTitle = $request->title[$defaultLang] ?? 'menu-item';

            $slug = Str::slug($defaultTitle);
            $slugCount = MenuItem::where('slug', 'like', "{$slug}%")->count();
            if ($slugCount > 0) {
                $slug .= '-' . ($slugCount + 1);
            }

            $menuItem = MenuItem::create([
                'menu_id' => $request->menu_id,
                'slug' => $slug,
                'order_number' => $request->order_number,
                'parent_id' => $request->parent_id ?? null,
            ]);

            foreach ($request->title as $lang => $title) {
                MenuItemTranslation::create([
                    'menu_item_id' => $menuItem->id,
                    'language_code' => $lang,
                    'title' => $title,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.menus.items.create', ['menu' => $menuId])
                            ->with('success', __('cms.menu_items.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('cms.menu_items.creation_failed'));
        }

    } 


    public function edit($id)
    {
        $menuItem = MenuItem::with(['menu', 'translations'])->findOrFail($id);
        $menus = Menu::with('menuItems.translations')->get();
        $languages = Language::where('active', 1)->get();
        return view('admin.menu_items.edit', compact('menuItem', 'menus', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::with('translations')->findOrFail($id);
        
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order_number' => 'required|integer',
            'title' => 'required|array',
            'title.*' => 'required|string|max:255'
        ]);
        
        $menuItem->menu_id = $request->menu_id;
        $menuItem->parent_id = $request->parent_id;
        $menuItem->order_number = $request->order_number;
        $menuItem->save();
        
        foreach ($request->title as $languageCode => $title) {
            $translation = $menuItem->translations()->where('language_code', $languageCode)->first();
            
            if ($translation) {
                if ($translation->title !== $title) {
                    $translation->update(['title' => $title]);
                }
            } else {
                $menuItem->translations()->create([
                    'language_code' => $languageCode,
                    'title' => $title,
                ]);
            }
        }
        
        $menuItem->translations()->whereNotIn('language_code', array_keys($request->title))->delete();
        
        /*return redirect()->route('admin.items.index')->with('success', __('cms.menu_items.updated_successfully'));*/
        return redirect()->route('admin.dashboard')->with('success', __('cms.menu_items.updated_successfully'));
    }

}