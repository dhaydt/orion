<div>
    <div class="container">
        <div class="row py-3">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">No. Order</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content">#{{ $order['id'] }}</div>
                    </div>
                </div>
            </div>
            {{-- customer --}}
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">Nama Pelanggan</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content" style="text-transform: capitalize">{{ $order['penyewa'] }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">Waktu Mulai</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content">{{ $order['mulai'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">Waktu Selesai</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content">{{ $order['selesai'] ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">Lama Bermain</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content">{{ $waktu_running }} Menit
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">Harga /jam</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content">Rp. {{ number_format($harga_per_jam) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">Meja</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content">{{ $nomor_meja ?? 'Invalid Table' }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">Status Pembayaran</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content">
                            @if ($order['status_pembayaran'] == 1)
                                <span class="badge bg-success text-uppercase payment-status">Dibayar</span>
                            @else
                                <span class="badge bg-danger text-uppercase payment-status">Belum Dibayar</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($items->count() > 0)
            <div class="border-line dashed"></div>

            <div class="row py-3">
                <div class="font-title">Tambahan</div>
                @foreach ($items as $g)
                    <div class="item-cart pb-2" style="border-bottom: unset;">
                        <div class="main-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="font-description">
                                    {{ $g['produk']['nama'] ?? 'Invalid Produk' }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="qty-count font-description cart-font">
                                    {{ $g['jumlah'] }} x Rp. {{ number_format($g['harga']) }}
                                </div>
                                <div class="qty-total font-description cart-font">
                                    Rp. {{ number_format($g['harga'] * $g['jumlah']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="border-line dashed"></div>

        <div class="cart-counter mt-2">
            <div class="d-flex justify-content-between baris-harga">
                <div class="font-description me-3">
                    Meja
                </div>
                <div class="price">
                    Rp. {{ number_format(($running->waktu_running * $running->harga_per_jam) / 60) }}
                </div>
            </div>
            <div class="d-flex justify-content-between baris-harga">
                <div class="font-title me-3">
                    Total
                </div>
                <div class="price font-title">
                    Rp. {{ number_format($running->total()) }}
                </div>
            </div>
        </div>
    </div>

    <div class="next-wrapper mb-3 mt-5 px-2 d-flex align-items-center justify-content-center flex-column">
        @if ($order['selesai'] == null)
            <button class="btn btn-success fw-bold w-100" wire:click="countOrder">Hitung Billing</button>
        @elseif($order['status_pembayaran'] == 0 && $order['selesai'] != null)
            <div id="card" class="w-100">
                <paper-card heading="">
                    <div class="card-content">
                        <paper-progress id="progress" indeterminate></paper-progress>
                    </div>
                </paper-card>
                <paper-card class="d-none">
                    <div class="card-content">
                        <paper-textarea id="message" label="Enter Message">
                            text
                        </paper-textarea>
                    </div>
                </paper-card>
                <paper-card class="w-100">
                    <div class="card-content">
                        <paper-button id="print" class="w-100 btn btn-primary" raised class="colorful"
                            wire:click="bayar" onclick="showLoading()">Bayar & Cetak</paper-button>
                    </div>
                </paper-card>
            </div>
        @elseif($order['status_pembayaran'] == 1)
            <div id="card" class="w-100">
                <paper-card heading="">
                    <div class="card-content">
                        <paper-progress id="progress" indeterminate></paper-progress>
                    </div>
                </paper-card>
                <paper-card class="d-none">
                    <div class="card-content">
                        <paper-textarea id="message" label="Enter Message">
                            text
                        </paper-textarea>
                    </div>
                </paper-card>
                <paper-card>
                    <div class="card-content">
                        <paper-button id="print" onclick="showLoading()" class="btn btn-secondary w-100 fw-bold"
                            raised class="colorful">Cetak Struk</paper-button>
                    </div>
                </paper-card>
            </div>
        @endif
    </div>
</div>
@push('js')
    <script>
        Livewire.on("counted_order", (status) => {
            alertMessage(status)
        })
    </script>
    <script>
        'use strict';
        $(document).ready(function() {
            let progress = document.querySelector('#progress');
            let dialog = document.querySelector('#dialog');
            var message = '';
            console.log('msg', message);
            let printButton = document.querySelector('#print');
            let printCharacteristic;
            let index = 0;
            let data;
            // progress.hidden = true;

            var order = JSON.parse(`{!! json_encode($order) !!}`);

            console.log('order', order);

            var itemOrder = JSON.parse(`{!! json_encode($items) !!}`);

            console.log('order item', itemOrder);

            function numberFormat(x) {
                var y = x
                if (x !== '') {
                    y = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                return y;
            }

            function payment_method(val) {
                if (val != null) {
                    return val.toUpperCase();
                } else {
                    return '-';
                }
            }

            var user = `{{ auth()->user()->name }}`.toUpperCase()

            console.log('name', user);

            function header() {
                var code = '\x1B' + '\x61' + '\x31' // center align
                    +
                    '\x1B' + '\x45' + '\x0D' // bold on
                    +
                    '\x1D' + '\x21' + '\x00' + `{{ \App\CPU\Helpers::appName() }}` + '\n' // double font size
                    +
                    '\x1B' + '\x45' + '\x0A' // bold off
                return code;
            }

            function subheader() {
                var code = '\x1D' + '\x21' + '\x00' + '-------------------------------\n' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + 'Pelanggan  : ' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + order['penyewa'].replace('_', ' ').toUpperCase() + '.-\n' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + 'Order ID   : ' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + '#' + order['id'] + '.-\n' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + 'Mulai      : ' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + `{{ \App\CPU\Helpers::dateFormat2($waktu_mulai, 'dateTime') }}` +
                    '.-\n' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + 'Selesai    : ' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + `{{ \App\CPU\Helpers::dateFormat2($waktu_selesai, 'dateTime') }}` +
                    '.-\n' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + 'Meja       : ' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + order['meja'] + '.-\n' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + 'Kasir      : ' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + user + '.-\n' +
                    '\x1D' + '\x21' + '\x00' + '------------------------------- .-\n'

                return code;
            }

            console.log('item', itemOrder);

            function body() {
                var code = [];


                for (let i = 0; i < itemOrder.length; i++) {

                    var item = '\x1B' + '\x61' + '\x30' +
                        '\x1D' + '\x21' + '\x00' + itemOrder[i]['produk']['nama'] + ' (Rp. ' + numberFormat(
                            itemOrder[i]['harga']) + ' x ' + itemOrder[i]['jumlah'] + ')\n' +
                        '\x1B' + '\x61' + '\x32' +
                        '\x1D' + '\x21' + '\x00' + 'Rp. ' + numberFormat(itemOrder[i]['sub_total']) + '.-\n'


                    var merge = item;

                    var mergeComma = merge;

                    console.log('merge', mergeComma);

                    code.push(mergeComma);
                }
                console.log('code1', code);

                console.log('code2', code.join(''));
                console.log('code3', code, code.join(''));

                code = (code.join(''))

                console.log('code4', code);

                return code;
            }

            function count_subtotal() {
                var val = `{{ round(($harga_per_jam / 60) * $waktu_running) }}`;

                return numberFormat(val);
            }

            function getNote(val) {
                if (val == null) {
                    return '-';
                } else {
                    return val;
                }
            }

            function summary() {
                var code =
                    '\x1D' + '\x21' + '\x00' + '-------------------------------\n' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + 'Meja              : ' + 'Rp. ' + count_subtotal() + '.-\n' +
                    '\x1B' + '\x61' + '\x32' +
                    '\x1D' + '\x21' + '\x00' + '-------------------------------\n' +
                    '\x1B' + '\x45' + '\x0D' +
                    '\x1B' + '\x61' + '\x32' +
                    '\x1D' + '\x21' + '\x00' + 'Total             : ' + 'Rp. ' + numberFormat(
                        `{{ $running->total() }}`) + '.-\n\n'

                return code;
            }

            function footer() {
                var code = '\x1B' + '\x61' + '\x31' // center align
                    +
                    '\x1D' + '\x21' + '\x00' + `Terima kasih sudah berkunjung\n` // normal font size

                return code;
            }

            console.log('summary', summary());

            message = '' +
                header() +
                subheader() +
                body() +
                summary() +
                footer() +
                '\n\n';

            var textVal = message;

            const splitted = textVal.split(".-\n");

            // console.log('length', splitted, splitted[1].toString());

            for (let i = 0; i < splitted.length; i++) {
                console.log('string', i, splitted[i], splitted.length, splitted[3]) + `<br></br>`
            }

            var split;

            function sendTextData(resolve, reject) {
                // Get the bytes for the text
                let encoder = new TextEncoder("utf-8");
                // Add line feed + carriage return chars to text
                var toString = split.toString();

                console.log('string', toString);

                let text = encoder.encode(split.toString() + '\x0A');

                return printCharacteristic.writeValue(text).then(() => {

                    // progress.hidden = true;

                    resolve();
                }).catch(handleError);

                resolve();
            }

            function handleError(error) {
                console.log(error);
                // progress.hidden = true;
                printCharacteristic = null;
                hideLoading();
                alertMessage([0, 'Cant connect print device']);
            }

            function getText(splits) {
                split = splits;
                return new Promise(function(resolve, reject) {
                    sendTextData(resolve, reject);
                });
            }


            const loopPrint = async _ => {
                console.log('start print');
                for (let i = 0; i < splitted.length; i++) {
                    console.log('i', i)
                    await getText(splitted[i]);
                }
                // progress.hidden = true;
            }


            printButton.addEventListener('click', function() {
                // progress.hidden = false;
                console.log('printCharacter', printCharacteristic);

                hideLoading();
                if (printCharacteristic == null) {
                    navigator.bluetooth.requestDevice({
                            filters: [{
                                services: ['000018f0-0000-1000-8000-00805f9b34fb']
                            }]
                        })
                        .then(device => {
                            console.log('> Found ' + device.name);
                            console.log('Connecting to GATT Server...');
                            return device.gatt.connect();
                        })
                        .then(server => server.getPrimaryService("000018f0-0000-1000-8000-00805f9b34fb"))
                        .then(service => service.getCharacteristic("00002af1-0000-1000-8000-00805f9b34fb"))
                        .then(characteristic => {
                            // Cache the characteristic
                            printCharacteristic = characteristic;

                            loopPrint();
                        })
                        .catch(handleError);
                } else {
                    try {
                        loopPrint();
                    } catch ($e) {
                        alertMessage($e);
                    }
                }
            });

        });
    </script>
@endpush
