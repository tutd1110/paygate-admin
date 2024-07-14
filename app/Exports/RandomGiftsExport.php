<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class RandomGiftsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use RegistersEventListeners;

    public $randomGifts;

    public function __construct(array $randomGifts)
    {
        $this->randomGifts = $randomGifts;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $randomGifts = $this->randomGifts;
        if (!empty($randomGifts)) {
            return collect($randomGifts);
        } else {
            return false;
        }
    }

    /**
     * Returns headers for report
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Họ tên',
            'Email',
            'Số điện thoại',
            'Mã bill',
            'Giá trị bill',
            'Nhà sách',
            'Đối tác',
            'Loại quà',
            'Mã voucher',
            'Medium',
            'Source',
            'Campaign',
            "Thời gian quay",
        ];
    }

    public function map($randomGifts): array
    {
        return [
            $randomGifts['id'],
            $randomGifts['contact']['full_name'] ?? null,
            $randomGifts['contact']['email'] ?? null,
            $randomGifts['contact']['phone'] ?? null,
            $randomGifts['ticket']['bill_code'] ?? null,
            $randomGifts['ticket']['bill_value'] ?? null,
            $randomGifts['ticket']['store_name'] ?? null,
            $randomGifts['gift']['supplier_code'] ?? null,
            $randomGifts['gift']['name'] ?? null,
            $randomGifts['coupon_code'],
            $randomGifts['contact']['utm_medium'] ?? null,
            $randomGifts['contact']['utm_source'] ?? null,
            $randomGifts['contact']['utm_campaign'] ?? null,
            Carbon::parse($randomGifts['created_at'])->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
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
//    public function columnWidths(): array
//    {
//        return [
//            'A' => 55,
//            'B' => 45,
//        ];
//    }


}
