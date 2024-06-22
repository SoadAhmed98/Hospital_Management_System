<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\Finance\ReceiptAPIRepositoryInterface;
use Illuminate\Http\Request;

class APIReceiptController extends Controller
{
    private $receiptRepository;

    public function __construct(ReceiptAPIRepositoryInterface $receiptRepository)
    {
        $this->receiptRepository = $receiptRepository;
    }

    public function index()
    {
        return $this->receiptRepository->index();
    }

    public function store(Request $request)
    {
        return $this->receiptRepository->store($request);
    }

    public function show($id)
    {
        return $this->receiptRepository->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->receiptRepository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->receiptRepository->destroy($id);
    }
}
