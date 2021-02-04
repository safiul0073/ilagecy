<?php

namespace App\Exports;

use App\Models\Lead;
use App\Services\GlobalProductIdService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Lead::select('id', 'order_id', 'customer_id', 'note', 'caller_id', 'product_id', 'updated_at')->with('caller', 'product', 'customer');

        $startDate = date('Y-m-d', strtotime(request()->get('from')));
        $endDate = date('Y-m-d', strtotime(request()->get('to')));
        if (request()->get('from') && request()->get('to')) {
            $query->whereDate('updated_at', '>=', $startDate)
                    ->whereDate('updated_at', '<=', $endDate);
        }


        if (request()->get('confirm')) {
            $query->where('status_caller', Lead::CONFIRMED);
            // It will take only the leads that had been processed by a caller
            $query->whereHas('caller', function ($query) {
                return $query->where('role', 'caller');
            });
        }


        $status = request()->get('status');
        if (request()->get('status')) {
            $query->where('status_caller', $status);
        }

        if (request()->get('phone')) {
            $query->whereHas('customer', function ($customer) {
                $customer->where('phone', 'like', '%' . request()->get('phone') . '%');
            });
        }

        if (request()->get('orderId')) {
            $query->where('order_id', 'like', '%' . request()->get('orderId') . '%');
        }

        if (GlobalProductIdService::get()) {
            $query->where('product_id', GlobalProductIdService::get());
        }



        $query->where('caller_id', '!=', 0);



        $query = $query->get();

        $data = [];

        foreach ($query as $value) {
            $data[]= $value;
        }

        return collect($data);
    }

    public function map($lead): array
    {
        return [
            $lead->customer->name ?? '',
            $lead->customer->phone ?? '',
            $lead->customer->address ?? '',
            $lead->note ?? '',
            $lead->product->name ?? '',
         ];
    }

    public function headings() : array
    {
        return ["Customer Name", "Phone" , "Address" , "Note" , "Product Name"];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
