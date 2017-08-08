<?php

namespace App\Jobs\Checkout;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\{File, Sale};
use App\Events\Checkout\SaleCreated;
use App\Notifications\SaleBuyed;

class CreateSale implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;

    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(File $file, $email)
    {
        $this->file = $file;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sale = new Sale;

        $sale->fill([
            'identifier' => uniqid(true),
            'buyer_email' => $this->email,
            'sale_price' => $this->file->price,
            'sale_commission' => $this->file->calculateCommission()
        ]);

        $sale->file()->associate($this->file);
        $sale->user()->associate($this->file->user);

        $sale->save();

        $sale->user->notify(new SaleBuyed($sale));

        event(new SaleCreated($sale));
    }
}
