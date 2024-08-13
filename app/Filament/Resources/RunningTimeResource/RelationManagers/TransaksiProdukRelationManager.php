<?php

namespace App\Filament\Resources\RunningTimeResource\RelationManagers;

use App\Models\Produk;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiProdukRelationManager extends RelationManager
{
    protected static string $relationship = 'transaksiProduk';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Form Transaksi Produk')
                    ->schema([
                        Select::make('id_produk')
                            ->label('Produk')
                            ->relationship('produk', 'nama')
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($set, $state) {
                                $produk = Produk::find($state);
                                if ($produk) {
                                    $set('harga', $produk->harga);
                                }
                            })
                            ->searchable(),
                        TextInput::make('harga')
                            ->label('Harga')
                            ->reactive()
                            ->readOnly(),
                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function ($set, $get, $state) {
                                $set('sub_total', $get('harga') * $state);
                            })
                            ->default(0),
                        TextInput::make('sub_total')
                            ->reactive()
                            ->numeric()
                            ->default(0),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('runningTime.nomor_meja')
            ->columns([
                TextColumn::make('produk.nama')
                    ->label('Produk')
                    ->searchable(),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->formatStateUsing(function ($state) {
                        return 'Rp.' . number_format($state, 0, ',', '.');
                    })
                    ->sortable(),
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('sub_total')
                    ->label('Sub Total')
                    ->formatStateUsing(function($state){
                        return 'Rp.' . number_format($state,0,',','.');
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Order Produk')
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (CreateAction $action,$data) {
                        $produk = Produk::find($data['id_produk']);
                        if($produk){
                            $updateStock = $produk->updateStock(0, $data['jumlah']);
                            if($updateStock == false){
                                Notification::make()
                                ->title("Stock tidak mencukupi")
                                ->danger()
                                ->icon('heroicon-o-x-circle')
                                ->send();

                                $action->halt();
                            }
                        }else{
                            Notification::make()
                            ->title('Waktu mulai belum di tentukan !')
                            ->danger()
                            ->icon('heroicon-o-x-circle')
                            ->send();

                            $action->halt();
                        }
                        return $data;
                    }),
            ])
            ->actions([
                DeleteAction::make()
                ->after(function($record){
                    $produk = Produk::find($record->id_produk);
                    if(!$produk){
                        Notification::make()
                        ->title("Produk tidak ditemukan !")
                        ->danger()
                        ->icon('heroicon-o-x-circle')
                        ->send();
                    }else{
                        $produk->updateStock(1, $record->jumlah);
                    }
                }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
