<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InviteResource\Pages;
use App\Models\Invite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\View;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class InviteResource extends Resource
{
    protected static ?string $model = Invite::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('event_id')
                    ->relationship('event', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('guest_id')
                    ->relationship('guest', 'name', function ($query) {
                        $query->whereDoesntHave('invites');
                    })
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'declined' => 'Declined',
                    ])
                    ->default('pending')
                    ->required()
                    ->helperText('The status of the invite. Pending means the guest has not responded yet, accepted means they have confirmed attendance, and declined means they have declined the invite.'),

                TextInput::make('rsvp_count')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required()
                    ->helperText(function (\Filament\Forms\Get $get) {
                        $guest = \App\Models\Guest::find($get('guest_id'));
                        return $guest ? 'Max allowed: ' . $guest->rsvp_limit : null;
                    })
                    ->rules([
                        function (\Filament\Forms\Get $get) {
                            return function (string $attribute, $value, \Closure $fail) use ($get) {
                                $guestId = $get('guest_id');

                                if (!$guestId || !is_numeric($value)) {
                                    return;
                                }

                                $guest = \App\Models\Guest::find($guestId);
                                if ($guest && $value > $guest->rsvp_limit) {
                                    $fail("RSVP count exceeds the guest's RSVP limit of {$guest->rsvp_limit}.");
                                }
                            };
                        },
                    ]),

                Group::make([
                    TextInput::make('code')
                        ->required()
                        ->maxLength(255)
                        ->default(fn() => strtoupper(Str::uuid()))
                        ->disabled()
                        ->dehydrated(),


                    Forms\Components\View::make('filament.forms.components.qr-code'),
                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.name')->label('Event'),
                Tables\Columns\TextColumn::make('guest.name')->label('Guest'),
                Tables\Columns\TextColumn::make('status')->searchable(),
                Tables\Columns\TextColumn::make('rsvp_count')->searchable(),
                Tables\Columns\TextColumn::make('code')->copyable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvites::route('/'),
            'create' => Pages\CreateInvite::route('/create'),
            'edit' => Pages\EditInvite::route('/{record}/edit'),
        ];
    }
}
