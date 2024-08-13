<?php

namespace App\Filament\Resources\ProdukResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
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

class ProdukLogRelationManager extends RelationManager
{
    protected static string $relationship = 'produkLog';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('FOrm Produk Log')
                    ->schema([
                        Select::make('id_produk')
                            ->label('Produk')
                            ->relationship(name: 'produk', titleAttribute: 'nama')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('produk.nama')
            ->columns([
                TextColumn::make('produk.nama')
                    ->label('Produk')
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Nama User')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Log')
                    ->icon('heroicon-o-plus-circle'),
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
