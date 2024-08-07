<?php


namespace App\Repositories;

use App\Http\Requests\Transaction\TransactionRequest;
use App\Interfaces\TransactionInterfaces;
use App\Jobs\TransactionProcess;
use App\Models\TransactionModel;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class TransactionRepositories implements TransactionInterfaces
{
    protected $transactionModel;
    use HttpResponseTrait;

    public function __construct(TransactionModel $transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }

    public function createTransaction(TransactionRequest $request)
    {
        try {
            $user_id = Auth::user()->id;
            $data = new $this->transactionModel;
            $data->user_id = $user_id;
            $data->amount = $request->input('amount');
            $data->status = 'pending';
            $data->save();

            TransactionProcess::dispatch($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaction has been created',
            ], 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function getDataHistoryTransaction(Request $request)
    {
        try {
            $pagination = $request->query('pagination', 10);
            $page = $request->get('page', 1);
            $redisKey = 'transactions_page_' . $page;

            try {
                $data = Redis::get($redisKey);
                if ($data) {
                    $data = json_decode($data, true);
                    return $this->success($data, 'success', 'Success get data from redis');
                } else {
                    $data = $this->transactionModel->paginate($pagination);
                    if ($data->isEmpty()) {
                        return $this->dataNotFound();
                    }
                    Redis::setex($redisKey, 3600, json_encode($data));
                    return $this->success($data, 'success', 'Redis is ready now, fetched data from database');
                }
            } catch (\Throwable $th) {
                $data = $this->transactionModel->paginate($pagination);
                if ($data->isEmpty()) {
                    return $this->dataNotFound();
                }
                return $this->success($data, 'success', 'Redis service is not available, fetched data from database');
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function getSummaryTransaction()
    {
        try {
            $data = $this->transactionModel->with('user')->get();
            if($data->isEmpty()) {
                return $this->dataNotFound();
            }
            $totalTransaction = $data->count();
            $averageAmount = $data->avg('amount');
            $highestTransaction = $data->sortByDesc('amount')->first()->only([
                'id', 'user_id', 'amount', 'status', 'created_at', 'updated_at'
            ]);
            $lowestTransaction = $data->sortBy('amount')->first()->only([
                'id', 'user_id', 'amount', 'status', 'created_at', 'updated_at'
            ]);
            $longestNameTransaction = $data->sortByDesc(function ($transaction) {
                return strlen($transaction->user->name);
            })->first();
            $longestNameTransaction = [
                'id' => $longestNameTransaction->id,
                'user_id' => $longestNameTransaction->user_id,
                'amount' => $longestNameTransaction->amount,
                'status' => $longestNameTransaction->status,
                'created_at' => $longestNameTransaction->created_at,
                'updated_at' => $longestNameTransaction->updated_at,
                'user_name' => $longestNameTransaction->user->name,
            ];
            $statusDistribution = $data->groupBy('status')->map->count();

            $response = [
                'total_transaction' => $totalTransaction,
                'average_amount' => $averageAmount,
                'highest_transaction' => $highestTransaction,
                'lowest_transaction' => $lowestTransaction,
                'longest_name_transaction' => $longestNameTransaction,
                'status_distribution' => $statusDistribution
            ];
            return $this->success($response, 'success', 'Success get summary transaction');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }
}
