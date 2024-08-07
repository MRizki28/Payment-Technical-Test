<?php

namespace App\Jobs;

use App\Models\TransactionModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class TransactionProcess implements ShouldQueue
{
    use Queueable;

    protected $transaction;

    /**
     * Create a new job instance.
     */
    public function __construct(TransactionModel $transaction){
        $this->transaction = $transaction;
    }

    public function getTransaction(){
        return $this->transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $randomTransaction = rand(0, 1);
        $proses = $randomTransaction == 1 ? 'completed' : 'failed';
        $this->transaction->status = $proses;
        $this->transaction->save();         
    }
}
