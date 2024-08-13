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
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="font-content">Waktu Transaksi</div>
                        <span>:</span>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <div class="font-content">
                            {{ $order['tanggal_transaksi'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($items->count() > 0)
            <div class="border-line dashed"></div>
            <div class="row py-3">
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
    </div>

    <div class="next-wrapper mb-3 mt-5 px-2 d-flex align-items-center justify-content-center flex-column">
        @if($order['status_pembayaran'] == 0)
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
            hideLoading()
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
                    '\x1D' + '\x21' + '\x00' + 'Order ID   : ' +
                    '\x1B' + '\x61' + '\x30' +
                    '\x1D' + '\x21' + '\x00' + '#' + order['id'] + '.-\n' +
                    '\x1B' + '\x61' + '\x30' +
                    '.-\n' +
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
                    '\x1B' + '\x45' + '\x0D' +
                    '\x1B' + '\x61' + '\x32' +
                    '\x1D' + '\x21' + '\x00' + 'Total  :        '+ numberFormat(
                        `{{ $order['total'] }}`) + '.-\n\n' +
                    '\x1D' + '\x21' + '\x00' + '-------------------------------\n'

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
