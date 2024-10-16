<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\Pages\ViewProduk;
use App\Filament\Resources\ProdukResource\RelationManagers\ProdukImageRelationManager;
use App\Filament\Resources\ProdukResource\RelationManagers\ProdukLogRelationManager;
use App\Filament\Resources\ProdukResource\RelationManagers\TransaksiProdukRelationManager;
use App\Models\Produk;
use App\Models\TransaksiProduk;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Data Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Form Produk')
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->label('Nama Produk')
                            ->maxLength(255),
                        TextInput::make('stock')
                            ->required()
                            ->label('Stock')
                            ->numeric(),
                        TextInput::make('harga')
                            ->required()
                            ->label('Harga')
                            ->numeric(),
                        Textarea::make('deskripsi')
                            ->nullable()
                            ->label('Deskripsi'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('harga')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->toggleable(),
                ImageColumn::make('produkImage.image')
                    ->size(100)
                    ->label('Gambar Produk')
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                ViewAction::make(),
                DeleteAction::make()
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
            ProdukImageRelationManager::class,
            TransaksiProdukRelationManager::class,
            ProdukLogRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'view' => ViewProduk::route('{record}'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
