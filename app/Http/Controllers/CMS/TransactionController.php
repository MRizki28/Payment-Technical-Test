<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransactionRequest;
use App\Repositories\TransactionRepositories;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionRepositories;

    public function __construct(TransactionRepositories $transactionRepositories)
    {
        $this->transactionRepositories = $transactionRepositories;
    }

    public function createTransaction(TransactionRequest $request)
    {
        return $this->transactionRepositories->createTransaction($request);
    }

    public function getDataHistoryTransaction(Request $request)
    {
        return $this->transactionRepositories->getDataHistoryTransaction($request);
    }

    public function getSummaryTransaction()
    {
        return $this->transactionRepositories->getSummaryTransaction();
    }   
}
