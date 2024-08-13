<?php

namespace App\Filament\Resources\ProdukResource\RelationManagers;

use App\Models\Produk;
use App\Models\RunningTime;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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
                        Select::make('id_running_time')
                            ->label('Transaksi')
                            ->relationship('produk', 'nama')
                            ->preload()
                            ->required()
                            ->reactive()
                            ->getOptionLabelsUsing(function ($value) {
                                dd($value);
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
            ->recordTitleAttribute('id_produk')
            ->columns([
                TextColumn::make('runningTime.nomor_meja')
                    ->label('Nomor Meja')
                    ->searchable(),
                TextColumn::make('runningTime.id')
                    ->label('Nama Pelanggan')
                    ->formatStateUsing(function ($state) {
                        $runningTime = RunningTime::find($state);
                        if ($runningTime->nama_penyewa != null) {
                            return $runningTime->nama_penyewa;
                        } else {
                            return $runningTime->member->nama;
                        }
                    })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
