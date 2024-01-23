<?php

namespace NoahWilderom\FilamentCMS\Filament\Resources\PostResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSField;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSPost;
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
        $post = app(FilamentCMSPost::class)->find($data['id']);
        $post->loadMissing('fields');

        foreach($post->fields as $field) {
            $data[$field->field_id] = $field->value;
        }

        foreach(app(FilamentCMSField::class)->resource(static::getModel())->get() as $field) {
            if(!isset($data[$field->id])) {
                $data[$field->id] = $field->default;
            }
        }

        return $data;
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        foreach($data as $key => $value) {
            if(uuid_is_valid($key)) {
                if ($fieldValue = app(FilamentCMSField::class)->find($key)) {
                    if($fieldValueRecord = $fieldValue->values()->where('model_id', $this->record->id)->first()) {
                        if(!is_null($fieldValueRecord)) {
                            $fieldValueRecord->update([
                                'value' => $value,
                            ]);
                        }

                        continue;
                    }

                    $fieldValue->values()->create([
                        'model_id' => $this->record->id,
                        'value'    => $fieldValue->default,
                    ]);

                    unset($data[$key]);
                }
            }
        }

        return $data;
    }

}