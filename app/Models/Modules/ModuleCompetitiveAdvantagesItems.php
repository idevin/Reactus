<?php namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Modules\ModuleCompetitiveAdvantagesItems
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int $advantages_id
 * @property-read \App\Models\Modules\ModuleCompetitiveAdvantages $competitiveAdvantage
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems newModelQuery()
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems newQuery()
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems query()
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems whereAdvantagesId($value)
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems whereContentOptions($value)
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems whereDescription($value)
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems whereId($value)
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems whereName($value)
 * @mixin Eloquent
 * @property int $sort_order
 * @method static Builder|\App\Models\Modules\ModuleCompetitiveAdvantagesItems whereSortOrder($value)
 */
class ModuleCompetitiveAdvantagesItems extends ModuleBase implements ModuleInterface
{
    public $table = "module_competitive_advantages_items";

    public $timestamps = false;

    public $fillable = ["content_options", "name", "description", "advantages_id", "sort_order"];

    public function competitiveAdvantage(): BelongsTo
    {
        return $this->belongsTo(ModuleCompetitiveAdvantages::class);
    }

    public static function getBlock(...$args)
    {
        // TODO: Implement getBlock() method.
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}