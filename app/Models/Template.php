<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Template
 *
 * @property int $id
 * @property string $name
 * @property int $default
 * @property string $alias
 * @property int $hidden
 * @property-read \Baum\Extensions\Eloquent\Collection|Site[] $sites
 * @property-read Collection|TemplateScheme[] $templateSchemes
 * @method static Builder|Template newModelQuery()
 * @method static Builder|Template newQuery()
 * @method static Builder|Template query()
 * @method static Builder|Template whereAlias($value)
 * @method static Builder|Template whereDefault($value)
 * @method static Builder|Template whereHidden($value)
 * @method static Builder|Template whereId($value)
 * @method static Builder|Template whereName($value)
 * @mixin Eloquent
 * @property-read int|null $sites_count
 * @property-read int|null $template_schemes_count
 * @property int|null $template_type
 * @method static Builder|Template whereTemplateType($value)
 * @method static find(mixed $template_id)
 */
class Template extends Model
{
    const TYPE_SAVED = 0;
    const TYPE_PAID = 1;
    const TYPE_FREE = 2;
    /**
     * @todo i18n
     */
    const TEMPLATE_TYPES = [
        self::TYPE_SAVED => 'Сохраненные',
        self::TYPE_PAID => 'Оплаченые',
        self::TYPE_FREE => 'Бесплатные'
    ];
    public $timestamps = false;
    protected $table = 'template';
    protected $fillable = ['name', 'default', 'alias', 'hidden'];

    public static function selectOptions($notId = null, $empty = false): array
    {
        $data = Template::query()->orderBy('name', 'ASC');

        if ($notId) {
            $data = $data->whereNotIn('id', [$notId]);
        }

        $data = $data->get();

        if ($empty == true) {
            $allData = [null => 'Выберите шаблон...'];
        } else {
            $allData = [];
        }

        foreach ($data as $object) {
            $allData[$object->id] = $object->name;
        }

        return $allData;
    }

    public static function getForDomain()
    {
        $templateName = session('theme');

        if (!$templateName) {

            $site = Site::query()->where('domain', env('DOMAIN'))->get()->first();

            if ($site && $site->template) {
                $template = $site->template;
            } else {
                $template = Template::where('default', 1)->get()->first();

                if (!$template) {
                    $template['alias'] = 'DefaultLayout';
                } else {
                    $template->toArray();
                }
            }

            session(['theme' => $template['alias']]);
        }
        return session('theme');
    }

    public static function getSelect(): array
    {
        $templates = self::query()->orderBy('name')->get()->pluck('name', 'id')->toArray();
        return [null => 'Выберите шаблон...'] + $templates;
    }

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function templateSchemes(): BelongsToMany
    {
        return $this->belongsToMany(TemplateScheme::class, 'template_to_template_scheme');
    }

    public function templatePrototypes(): HasMany
    {
        return $this->hasMany(TemplatePrototype::class);
    }
}
