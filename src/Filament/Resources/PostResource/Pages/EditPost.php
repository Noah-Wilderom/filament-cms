<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSField;
use NoahWilderom\FilamentCMS\Filament\Resources\PostResource;

class EditPost extends EditRecord
{
//    use HasPreview, HasPreviewModal;
    /**
     * The resource model.
     */
    protected static string $resource = PostResource::class;

    /**
     * The preview modal URL.
     */
//    protected function getPreviewModalUrl(): ?string
//    {
//        $this->generatePreviewSession();
//
//        return route('post.show', [
//            'post' => $this->record->slug,
//            'previewToken' => $this->previewToken,
//        ]);
//    }

    /**
     * The header actions.
     */
    protected function getHeaderActions(): array
    {
        return [
//            PreviewAction::make(),

//            Action::make('view')
//                ->label('View post')
//                ->url(fn ($record) => $record->url)
//                ->extraAttributes(['target' => '_blank']),

            DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeFill(array $data): array
    {
        foreach($data as $key => $value) {
            if($field = app(FilamentCMSField::class)->find($key)) {
                $data[$key] = $field->default;
            }
        }

        return $data;
    }

}