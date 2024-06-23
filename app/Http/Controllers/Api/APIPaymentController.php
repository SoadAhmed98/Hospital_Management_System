<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\Finance\PaymentAPIRepositoryInterface;
use Illuminate\Http\Request;

class APIPaymentController extends Controller
{
    private $paymentRepository;

    public function __construct(PaymentAPIRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function index()
    {
        return $this->paymentRepository->index();
    }

    public function store(Request $request)
    {
        return $this->paymentRepository->store($request);
    }

    public function show($id)
    {
        return $this->paymentRepository->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->paymentRepository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->paymentRepository->destroy($id);
    }
}
