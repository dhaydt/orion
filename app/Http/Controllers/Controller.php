<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Models\RunningTime;
use App\Models\TransaksiProduk;
use charlieuki\ReceiptPrinter\ReceiptPrinter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function print($id)
    {
        $data = RunningTime::find($id);

        $item = [
            'mulai' => Helpers::dateFormat($data->waktu_mulai),
            'selesai' => Helpers::dateFormat($data->waktu_selesai),
            'penyewa' => $data->nama_penyewa,
            'meja' => $data->nommor_meja,
            'id_user' => $data->id_user,
            'id_member' => $data->id_member,
            'waktu' => $data->waktu_running . ' menit',
            'harga_per_jam' => 'Rp. ' . number_format($data->harga_per_jam),
            'status_pembayaran' => $data->status_pembayaran,
            'produk' => $data->produk,
            'total' => 'Rp. ' . number_format($data->total())
        ];

        // return $item;

        // Set params
        $mid = '123123456';
        $store_name = 'YOURMART';
        $store_address = 'Mart Address';
        $store_phone = '1234567890';
        $store_email = 'yourmart@email.com';
        $store_website = 'yourmart.com';
        $tax_percentage = 10;
        $transaction_id = 'TX123ABC456';
        $currency = 'Rp';
        $image_path = 'logo.png';

        // Set items
        $items = [
            [
                'name' => 'French Fries (tera)',
                'qty' => 2,
                'price' => 65000,
            ],
            [
                'name' => 'Roasted Milk Tea (large)',
                'qty' => 1,
                'price' => 24000,
            ],
            [
                'name' => 'Honey Lime (large)',
                'qty' => 3,
                'price' => 10000,
            ],
            [
                'name' => 'Jasmine Tea (grande)',
                'qty' => 3,
                'price' => 8000,
            ],
        ];

        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Set currency
        $printer->setCurrency($currency);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set logo
        // Uncomment the line below if $image_path is defined
        //$printer->setLogo($image_path);

        // Set QR code
        $printer->setQRcode([
            'tid' => $transaction_id,
        ]);

        // Print receipt
        $printer->printReceipt();
    }

    public function print_order($id)
    {
        $data['id'] = $id;

        return view('pages.print_page', $data);
    }

    public function print_transaksi($id)
    {
        $data['id'] = $id;
        return view('pages.print_transaksi', $data);
    }
}
