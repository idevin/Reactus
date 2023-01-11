<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Author
 *
 * @property int $id
 * @property string $username
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $phone_more
 * @property string $auth_token
 * @property string $domain
 * @property string $password
 * @property int $superadmin
 * @property int $active
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $birthday
 * @property int|null $native_city_id
 * @property int|null $marital_status_id
 * @property int|null $work_place_id
 * @property int|null $address_id
 * @property string|null $website
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $sex 0-Мужской, 1-Женский
 * @property string|null $password_new
 * @property int|null $visibility
 * @property string|null $status
 * @property int|null $parent_id
 * @property int $rating
 * @property string|null $image
 * @property int $locked
 * @property string|null $last_login
 * @property string|null $last_logout
 * @method static Builder|\App\Models\Author whereActive($value)
 * @method static Builder|\App\Models\Author whereAddressId($value)
 * @method static Builder|\App\Models\Author whereAuthToken($value)
 * @method static Builder|\App\Models\Author whereBirthday($value)
 * @method static Builder|\App\Models\Author whereCreatedAt($value)
 * @method static Builder|\App\Models\Author whereDomain($value)
 * @method static Builder|\App\Models\Author whereEmail($value)
 * @method static Builder|\App\Models\Author whereFirstName($value)
 * @method static Builder|\App\Models\Author whereId($value)
 * @method static Builder|\App\Models\Author whereImage($value)
 * @method static Builder|\App\Models\Author whereLastLogin($value)
 * @method static Builder|\App\Models\Author whereLastLogout($value)
 * @method static Builder|\App\Models\Author whereLastName($value)
 * @method static Builder|\App\Models\Author whereLocked($value)
 * @method static Builder|\App\Models\Author whereMaritalStatusId($value)
 * @method static Builder|\App\Models\Author whereMiddleName($value)
 * @method static Builder|\App\Models\Author whereNativeCityId($value)
 * @method static Builder|\App\Models\Author whereParentId($value)
 * @method static Builder|\App\Models\Author wherePassword($value)
 * @method static Builder|\App\Models\Author wherePasswordNew($value)
 * @method static Builder|\App\Models\Author wherePhone($value)
 * @method static Builder|\App\Models\Author wherePhoneMore($value)
 * @method static Builder|\App\Models\Author whereRating($value)
 * @method static Builder|\App\Models\Author whereRememberToken($value)
 * @method static Builder|\App\Models\Author whereSex($value)
 * @method static Builder|\App\Models\Author whereStatus($value)
 * @method static Builder|\App\Models\Author whereSuperadmin($value)
 * @method static Builder|\App\Models\Author whereUpdatedAt($value)
 * @method static Builder|\App\Models\Author whereUsername($value)
 * @method static Builder|\App\Models\Author whereVisibility($value)
 * @method static Builder|\App\Models\Author whereWebsite($value)
 * @method static Builder|\App\Models\Author whereWorkPlaceId($value)
 * @mixin Eloquent
 * @property int|null $user_status_id
 * @method static Builder|\App\Models\Author whereUserStatusId($value)
 * @property string|null $phone_work
 * @property string|null $phone_home
 * @property int|null $language_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property string|null $trial_ends_at
 * @property float $balance
 * @property int $autorenew
 * @method static Builder|\App\Models\Author newModelQuery()
 * @method static Builder|\App\Models\Author newQuery()
 * @method static Builder|\App\Models\Author query()
 * @method static Builder|\App\Models\Author whereAutorenew($value)
 * @method static Builder|\App\Models\Author whereBalance($value)
 * @method static Builder|\App\Models\Author whereCardBrand($value)
 * @method static Builder|\App\Models\Author whereCardLastFour($value)
 * @method static Builder|\App\Models\Author whereLanguageId($value)
 * @method static Builder|\App\Models\Author wherePhoneHome($value)
 * @method static Builder|\App\Models\Author wherePhoneWork($value)
 * @method static Builder|\App\Models\Author whereTrialEndsAt($value)
 * @method static Builder|\App\Models\Author whereAdminAccess($value)
 * @property string|null $last_password_update
 * @method static Builder|\App\Models\Author whereLastPasswordUpdate($value)
 * @property int $admin_access
 */
class Author extends Model
{
    protected $table = 'user';
    protected $connection = 'mysqlu';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


}
