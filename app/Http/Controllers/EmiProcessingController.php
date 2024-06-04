<?php

namespace App\Http\Controllers;

use App\Models\LoanDetail;
use App\Models\EmiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EmiProcessingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /*
    |           ____
    |          |  _ \
    |          | |_) |
    |          |  _ <
    |          | |_) |
    |          |____/
    |
    |    Browse Emi Data: (B)READ
    */

    /*
    *    Display a listing of the resource
    *   return view  with data if table exist in data base.
    *  @author: Naman Mehta
    */

    public function index()
    {
        $emiDetails = collect();

        // Check if the emi_details table exists
        if (Schema::hasTable('emi_details')) {
            $emiDetails = DB::table('emi_details')->get();
        }

        return view('emi-processing.index',['emiDetails' => $emiDetails]);
    }

     /*
    |              /\
    |             /  \
    |            / /\ \
    |           / ____ \
    |          /_/    \_\
    |
    |    Add Emi Data: BRE(A)D
    */

    /*
    *   Generate Emi data from loan details table
    *   when user click on process data button first deelte the table from data base then regenerate the data.
    *  return redirect to listing endpoint.
    *   @author: Naman Mehta
    */
    
    public function processData()
    {
        // Drop the emi_details table if it exists
        DB::statement('DROP TABLE IF EXISTS emi_details');

        // Get Loan table data
        $loanDetails = DB::table('loan_details')->get();
        // get Min  and max date
        $minDate = $loanDetails->min('first_payment_date');
        $maxDate = $loanDetails->max('last_payment_date');
       
        // Create the emi_details table with dynamic columns
        $columns = '`client_id` INT';

        $columnNames = [];
        // call protected function to get period (array of db column name)
        $period = $this->createMonthArray($minDate, $maxDate);
        
        foreach ($period as $date) {
            $columnName = $date;
            $columnNames[] = $columnName;
            $columns .= ", `$columnName` DECIMAL(10, 2) DEFAULT 0.00";
        }
        // Create data base 
        DB::statement("CREATE TABLE emi_details ($columns)");
       
        // Process the loan_details data and insert into emi_details
        foreach ($loanDetails as $detail) {
            $emiAmount = round($detail->loan_amount / $detail->num_of_payments,2);
            // call function to get spefic client_id loan months 
            $period = $this->createMonthArray($detail->first_payment_date, $detail->last_payment_date);
            $emiData = ['`client_id`' => $detail->client_id];
    
            $paymentCount = 1;
            $totalAmount = 0;
            foreach ($period as $date) {
                $columnName = $date;
                if ($paymentCount < $detail->num_of_payments ) {
                    $emiData["`$columnName`"] = $emiAmount;
                    $totalAmount += $emiAmount;
                    $paymentCount++;
                }else if($paymentCount == $detail->num_of_payments){
                    $emiAmount = round($detail->loan_amount - $totalAmount,2);
                    $emiData["`$columnName`"] = $emiAmount;
                } else {
                    $emiData["`$columnName`"] = 0.00;
                }
            }
            
            $columnsPart = implode(', ', array_keys($emiData));
            $valuesPart = implode(', ', array_values($emiData));
            DB::statement("INSERT INTO emi_details ($columnsPart) VALUES ($valuesPart)");
    
        }
            
        return redirect()->route('emi-processing.index');
    }

    protected function createMonthArray($startDate, $endDate) {
        // Create DateTime objects for the start and end dates
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
    
        // Adjust the end date to include the final month
        $end->modify('first day of next month');
    
        // Initialize the array to hold the months
        $months = [];
    
        // Loop through each month between the start and end dates
        while ($start < $end) {
            // Format the month and year as desired
            $formattedMonth = $start->format('Y_F');
            
            // Add the formatted month to the array
            $months[] = $formattedMonth;
    
            // Move to the next month
            $start->modify('first day of next month');
        }
    
        return $months;
    }


}
