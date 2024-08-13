<?php

namespace App\Filament\Resources\ProdukResource\RelationManagers;

use App\Models\ProdukLog;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ProdukImageRelationManager extends RelationManager
{
    protected static string $relationship = 'produkImage';

    protected static ?string $title = 'Gambar Produk';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Form Upload Gambar')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->maxSize(2048)
                            ->required(),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('produk.nama')
            ->columns([
                ImageColumn::make('image')
                    ->size(100),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Image')
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function ($data){
                        ProdukLog::create([
                            'id_produk' => $this->ownerRecord->id,
                            'keterangan' => 'Melakukan upload image produk',
                            'id_user' => Auth::id()
                        ]);
                        return $data;
                    }),
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
