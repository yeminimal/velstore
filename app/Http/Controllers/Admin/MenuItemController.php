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
        $menuItems = $this->menuItemService->getMenuItemsByMenuId($menuId);

        return DataTables::of($menuItems)
            ->addColumn('title', function ($menuItem) {
                return optional($menuItem->menuItemtranslations->first())->title ?? 'No title';
            })
            ->addColumn('action', function ($menuItem) use ($menuId) {
                return '<a href="' . route('admin.menu.items.edit', [$menuId, $menuItem->id]) . '" class="btn btn-sm btn-primary">Edit</a>
                        <a href="' . route('admin.menu.items.destroy', [$menuId, $menuItem->id]) . '" class="btn btn-sm btn-danger" 
                        onclick="event.preventDefault(); document.getElementById(\'delete-form-' . $menuItem->id . '\').submit();">Delete</a>
                        <form id="delete-form-' . $menuItem->id . '" action="' . route('admin.menu.items.destroy', [$menuId, $menuItem->id]) . '" method="POST" style="display: none;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $languages = Language::all();

        return view('admin.menu_items.create', compact('menu', 'languages'));
    }

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

        return redirect()->route('admin.menu.items.index', $menuId)->with('success', __('cms.menu_items.created'));
    }

    public function edit($menuId, $menuItemId)
    {
        $menu = Menu::findOrFail($menuId);  
        $menuItem = MenuItem::findOrFail($menuItemId);  
        $languages = Language::all(); 
        $menus = Menu::all();  
    
        return view('admin.menu_items.edit', compact('menu', 'menuItem', 'languages', 'menus'));
    }

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

        return redirect()->route('admin.menu.items.index', $menuId)->with('success',  __('cms.menu_items.updated'));
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