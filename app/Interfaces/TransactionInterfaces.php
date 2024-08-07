<?php

namespace App\Interfaces;

use App\Http\Requests\Transaction\TransactionRequest;
use Illuminate\Http\Request;

interface TransactionInterfaces
{
    public function createTransaction(TransactionRequest $request);
    public function getDataHistoryTransaction(Request $request);
    public function getSummaryTransaction();
}
