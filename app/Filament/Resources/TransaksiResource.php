<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Produk;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationLabel = 'Transaksi Produk';
    protected static ?string $pluralModelLabel = 'Transaksi Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make()
                    ->schema([
                        Repeater::make("transaksiProduk")
                            ->label('Transaksi Produk')
                            ->relationship()
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        Select::make('id_produk')
                                            ->label('Produk')
                                            ->searchable()
                                            ->preload()
                                            ->options(function () {
                                                return Produk::get()->pluck('nama', 'id');
                                            })
                                            ->reactive()
                                            ->afterStateUpdated(function ($set, $state) {
                                                $produk = Produk::find($state);
                                                if ($produk) {
                                                    $set('harga', $produk->harga);
                                                }
                                            })
                                            ->required()
                                            ->columns(1),
                                        TextInput::make('jumlah')
                                            ->label('Jumlah')
                                            ->numeric()
                                            ->reactive()
                                            ->afterStateUpdated(function ($set, $get, $state) {
                                                $set('sub_total', $get('harga') * $state);
                                            })
                                            ->default(0),
                                        TextInput::make('harga')
                                            ->label('Harga')
                                            ->readOnly()
                                            ->reactive()
                                            ->numeric(),
                                        TextInput::make('sub_total')
                                            ->label('Sub Total')
                                            ->default(0)
                                            ->numeric()
                                            ->reactive()
                                            ->readOnly(),
                                    ])
                            ])->columnSpan(2),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->nullable()
                            ->columnSpan(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->orderBy('created_at', 'DESC');
            })
            ->columns([
                ViewColumn::make('Produk')->view('tables.columns.transaksi-item'),
                TextColumn::make('jumlah_item')
                    ->numeric()
                    ->sortable(),
                // TextColumn::make('potongan')
                //     ->numeric()
                //     ->toggleable()
                //     ->formatStateUsing(function ($state) {
                //         return 'Rp.' . number_format($state, 0, ',', '.');
                //     })
                //     ->sortable(),
                TextColumn::make('total')
                    ->numeric()
                    ->formatStateUsing(function ($state) {
                        return 'Rp.' . number_format($state, 0, ',', '.');
                    })
                    ->sortable(),
                // TextColumn::make('deskripsi')
                //     ->label('Deskripsi')
                //     ->searchable()
                //     ->toggleable(),
                TextColumn::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->color(function ($state) {
                        if ($state == 1) {
                            return "success";
                        } else {
                            return 'danger';
                        }
                    })
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        if ($state == 1) {
                            return 'Lunas';
                        } else {
                            return 'Belum Lunas';
                        }
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('cetak')
                    ->label("Cetak Transaksi")
                    ->icon('heroicon-o-clipboard-document-list')
                    ->action(function ($record) {
                        return redirect()->route('print_transaksi', ['id' => $record->id]);
                    })
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
