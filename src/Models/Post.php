<?php

namespace NoahWilderom\FilamentCMS\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use NoahWilderom\FilamentCMS\Collections\PostCollection;
use NoahWilderom\FilamentCMS\Contracts\FilamentCMSPost;
use NoahWilderom\FilamentCMS\Enums\PostStatus;
use NoahWilderom\FilamentCMS\Enums\PostType;
use NoahWilderom\FilamentCMS\Traits\HasDynamicId;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements FilamentCMSPost, HasMedia
{
    use HasFactory, HasDynamicId, InteractsWithMedia;

    protected static string $configKey = 'post';
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'status',
        'type',
        'content',
        'published_at'
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'type' => PostType::class,
        'content' => 'array',
        'published_at' => 'datetime',
    ];

    public function newCollection(array $models = []): PostCollection
    {
        return new PostCollection($models);
    }

    public function scopeDrafts(Builder $query): Builder
    {
        return $query->where('status', '=', PostStatus::Draft->value);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', '=', PostStatus::Published->value)
            ->where('published_at', '<', now());
    }

    public function user(): BelongsTo {
        return $this->belongsTo(config('filament-cms.user.model'));
    }

    public function isSectionImage(int $sectionIndex): bool {
        if($this->isSectionHTML($sectionIndex)) return false;
        return $this->content[$sectionIndex]['type'] === 'image';
    }

    public function getSectionImageUrl(int $sectionIndex): string {
        return url('storage/' . $this->content[$sectionIndex]['data']['file']);
    }

    public function isSectionHTML(int $sectionIndex): bool {
        return $this->content[$sectionIndex]['type'] === 'html';
    }
    public function getSectionHTML(int $sectionIndex): string {
        return $this->content[$sectionIndex]['data']['content'];
    }

    public function sections(): ?array {
        return $this->content;
    }
}