<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Requests\StoreSingleServiceRequest;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SingleServiceController extends Controller
{
    private $SingleService;

    public function __construct(SingleServiceRepositoryInterface $SingleService)
    {
        $this->SingleService = $SingleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->SingleService->index();

    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSingleServiceRequest $request)
    {
        return $this->SingleService->store($request);
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSingleServiceRequest $request)
    {
       return $this->SingleService->update($request);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->SingleService->destroy($request);
    }
}
