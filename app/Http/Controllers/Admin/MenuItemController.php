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
use Yajra\DataTables\DataTables;

class MenuItemController extends Controller
{   
    protected $menuItemService;

    public function __construct(MenuItemService $menuItemService)
    {
        $this->menuItemService = $menuItemService;
    }

    public function index($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $menuItems = $this->menuItemService->getMenuItemsByMenuId($menuId);

        return view('admin.menu_items.index', compact('menu', 'menuItems'));
    }   

    public function getData(Request $request, $menuId)
    {
        $menuItems = MenuItem::where('menu_id', $menuId)
        ->select('id', 'slug', 'order_number', 'menu_id') // Ensure 'slug' is included
        ->with('menuItemtranslations') // Load translations
        ->get();

    return DataTables::of($menuItems)
        ->addColumn('title', function ($menuItem) {
            return optional($menuItem->menuItemtranslations->first())->title ?? 'No title';
        })
        ->addColumn('action', function ($menuItem) {
            return view('admin.menu_items.partials.actions', compact('menuItem'))->render();
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create($menuId)
    {
       
        $menus = Menu::all(); // Fetch all menus
        $languages = Language::where('active', 1)->get(); // Fetch active languages
    
        return view('admin.menu_items.create', compact('menus', 'languages'));
    }
/*
    public function store(Request $request, $menuId)
    {
        $validatedData = $request->validate([
            'order_number' => 'required|integer',
            'menu' => 'required|string',
        ]);

        $languages = Language::all();
        $validationRules = [];

        foreach ($languages as $language) {
            $validationRules['title_' . $language->code] = 'required|string';
        }

        $request->validate($validationRules);

        $this->menuItemService->createMenuItem($request, $menuId);

        return redirect()->route('admin.menus.items.index', $menuId)->with('success', __('cms.menu_items.created'));
    }
*/
public function store(Request $request, $menuId)
{
          
    $validatedData = $request->validate([
        'order_number' => 'required|integer',
        'menu' => 'required|string',
    ]);
dd($validateData);
    $languages = Language::all();
    
    if ($languages->isEmpty()) {
        return back()->with('error', 'No languages found.');
    }

    $validationRules = [];
    foreach ($languages as $language) {
        $validationRules['title_' . $language->code] = 'required|string';
    }
    $request->validate($validationRules);

    // Generate slug safely
    $firstLanguage = $languages->first();
    $slug = $firstLanguage ? Str::slug($request->input('title_' . $firstLanguage->code, 'default-slug')) : 'default-slug';

    // Create menu item
    $menuItem = MenuItem::create([
        'menu_id' => $menuId,
        'order_number' => $request->input('order_number'),
        'parent_id' => $request->input('parent_id'),
        'slug' => $slug,
    ]);

    // Save translations
    foreach ($languages as $language) {
        $menuItem->translations()->create([
            'language_code' => $language->code,
            'title' => $request->input('title_' . $language->code),
        ]);
    }

    return redirect()->route('admin.menus.items.index', $menuId)->with('success', __('cms.menu_items.created'));
}

/*
    public function edit($menuId, $menuItemId)
    {
        $menu = Menu::findOrFail($menuId);  
        $menuItem = MenuItem::findOrFail($menuItemId);  
        $languages = Language::all(); 
        $menus = Menu::all();  
    
        return view('admin.menu_items.edit', compact('menu', 'menuItem', 'languages', 'menus'));
    } */

    public function update(Request $request, $menuId, $menuItemId)
    {
        $validatedData = $request->validate([
            'order_number' => 'required|integer',
            'menu' => 'required|string',
        ]);

        $languages = Language::all();
        $validationRules = [];

        foreach ($languages as $language) {
            $validationRules['title_' . $language->code] = 'required|string';
        }

        $request->validate($validationRules);

        $this->menuItemService->updateMenuItem($request, $menuId, $menuItemId);

        return redirect()->route('admin.menus.items.index', $menuId)->with('success',  __('cms.menu_items.updated'));
    }

    public function destroy($menuId, $menuItemId)
    {
       
        try {
            $this->menuItemService->deleteMenuItem($menuItemId);
    
            return response()->json([
                'success' => true,
                'message' =>  __('cms.menu_items.deleted'),
            ]);
        } catch (\Exception $e) {
            Log::error("Error deleting menu item: " . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the menu item.'
            ]);
        }
    }  

}