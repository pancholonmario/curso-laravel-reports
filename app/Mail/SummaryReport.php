<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

//anexar estos namespaces por la funcion sendMail
use App\ExpenseReport;

class SummaryReport extends Mailable
{
    use Queueable, SerializesModels;

    private $expenseReport;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ExpenseReport $expenseReport)
    {
        //almcenar el expense dentro del objeto
        $this->expenseReport = $expenseReport;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.expenseReport',[
            'report' => $this->expenseReport
        ]);
    }
}
