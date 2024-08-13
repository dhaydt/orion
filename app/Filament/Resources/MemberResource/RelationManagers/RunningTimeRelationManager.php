<?php

namespace App\Filament\Resources\MemberResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RunningTimeRelationManager extends RelationManager
{
    protected static string $relationship = 'runningTime';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id_member')
            ->columns([
                TextColumn::make('nomor_meja')
                    ->label('Nomor Meja')
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->formatStateUsing(function ($state) {
                        if ($state == 1) {
                            return 'Sudah Lunas';
                        } else {
                            return 'Belum Lunas';
                        }
                    })
                    ->color(function ($record) {
                        if ($record->status_pembayaran == 1) {
                            return 'success';
                        } else {
                            return 'secondary';
                        }
                    })
                    ->badge(),
                TextColumn::make('waktu_mulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('waktu_selesai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('waktu_running')
                    ->label('Lama Waktu Berjalan')
                    ->formatStateUsing(function ($state) {
                        return $state . ' Menit';
                    })
                    ->alignCenter()
                    ->searchable(),
                TextColumn::make('harga_per_jam')
                    ->label('Harga Per Jam')
                    ->alignEnd()
                    ->formatStateUsing(function ($state) {
                        return 'Rp.' . number_format($state, 0, ',', '.');
                    }),
                TextColumn::make('transaksiProduk')
                    ->label('Jumlah Belanja')
                    ->alignCenter()
                    ->formatStateUsing(function ($record) {
                        return $record->transaksiProduk->sum('jumlah') ?? 0;
                    }),
                TextColumn::make('id')
                    ->label('Total')
                    ->formatStateUsing(function ($record) {
                        return 'Rp.' . number_format($record->total(), 0, ',', '.');
                    }),
                TextColumn::make('deskripsi')
                    ->label('Keterangan')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('User Pembuat')
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
