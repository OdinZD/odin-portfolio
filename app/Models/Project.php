<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Bind route model parameters by slug.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Localized project copy: pulls `work.{slug}.{field}` from the lang files for
     * the active locale, falling back to the stored (English) column when there is
     * no translation. Used for title, tagline, body, role, and status.
     */
    public function t(string $field): string
    {
        $key = "work.{$this->slug}.{$field}";
        $value = __($key);

        if (is_string($value) && $value !== $key) {
            return $value;
        }

        return (string) ($this->getAttribute($field) ?? '');
    }

    /**
     * Default ordering: curated sort order, newest first.
     *
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('year');
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
