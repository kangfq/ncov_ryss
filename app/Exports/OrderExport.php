<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class OrderExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
//        return [
//            [1, 2, 3],
//            [4, 5, 6]
//        ];
    }

    public function headings(): array
    {
        return [
            '订单号',
            '姓名',
            '电话',
            '订单金额',
            '商品数量',
            '支付时间',
            '确认收货',
            '下单时间',
            '商品明细',
            '商超名称'
        ];
    }
}
