<?php

namespace App\Exports;

use App\Helper\Mycurl;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PgwOrdersExport implements FromCollection, WithMapping, WithHeadings,ShouldAutoSize,WithStyles
{
    public function __construct(array $orders)
    {
        $this->orders = $orders;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $orders = $this->orders;
        return collect($orders);
    }
    /**
     * Returns headers for report
     * @return array
     */
    public function headings(): array {
        return [
            'ID',
            'Mã Hoá Đơn',
            'Order Client Id',
            'Mã đối tác',
            'Tên khách hàng',
            'Số điện thoại',
            'Email',
            'Landing Page',
            'Đơn Vị Thanh Toán',
            'Tổng Tiền(VND)',
            'Giảm Giá',
            'Mã khuyến mại',
            'Số lượng',
            'Transsion_Id',
            'Trạng thái',
            'Ngày tạo',
            'Ngày cập nhật'

        ];
    }

    public function map($orders): array {
//        dd($orders);
        return [
            $orders['id'],
            $orders['code'],
            $orders['order_client_id'],
            $orders['partner_code'],
            $orders['contact']['full_name'] ?? null,
            $orders['contact']['phone'] ?? null,
            $orders['contact']['email'] ?? null,
            $orders['landing_page']['domain_name'] ?? null,
            $orders['banking_code'] ?? $orders['merchant_code'],
            intval($orders['amount']),
            intval($orders['discount']),
            $orders['coupon_code'],
            $orders['quantity'],
            $orders['payment_request']['transsion_id'] ?? null,
            $orders['status'],
            Carbon::parse($orders['created_at'])->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
            Carbon::parse($orders['updated_at'])->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),

        ];

    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
            1 => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'C4BB34'
                    ]
                ]
            ]
        ];
    }
}
