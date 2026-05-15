<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('author')
                    ->required(),
                TextInput::make('category'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('old_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('condition')
                    ->required()
                    ->default('Baik'),
                FileUpload::make('cover_image')
    ->image()
    ->disk('public')
    ->directory('books'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
