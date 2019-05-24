<?php
namespace AvoRed\Framework\Cms\Controllers;

use AvoRed\Framework\Database\Contracts\MenuModelInterface;
use AvoRed\Framework\Database\Models\Menu;
use AvoRed\Framework\Cms\Requests\MenuRequest;
use AvoRed\Framework\Database\Contracts\CategoryModelInterface;

class MenuController
{
    /**
     * Menu Repository for the Menu Controller
     * @var \AvoRed\Framework\Database\Repository\MenuRepository $menuRepository
     */
    protected $menuRepository;

    /**
     * Menu Controller for the Install Command
     * @var \AvoRed\Framework\Database\Repository\CategoryRepository $categoryRepository
     */
    protected $categoryRepository;
    
    /**
     * Construct for the AvoRed install command
     * @param \AvoRed\Framework\Database\Repository\MenuRepository $menuRepository
     */
    public function __construct(
        MenuModelInterface $menuRepository,
        CategoryModelInterface $categoryRepository
    ) {
        $this->menuRepository = $menuRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->all();
        //$categories = $this->setCategoriesUrl();
        
        return view('avored::cms.menu.create')
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     * @param \AvoRed\Framework\Cms\Requests\MenuRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $this->menuRepository->create($request->all());

        return redirect()->route('admin.menu.index')
            ->with('successNotification', __('avored::system.notification.store', ['attribute' => 'Menu']));
    }

    /**
     * set the categories url for menu
     * @param
     */
    public function setCategoriesUrl($categories)
    {
        
        foreach ($categories as $category) {
            $url = route();
            $category->url = $url;
        }

        return $categories;
    }
}
