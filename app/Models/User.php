<?php

namespace App\Models;

use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia

{
    use Notifiable;
    use HasFactory;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'job',
        'address',
        'email',
        'password',
        'activated',
        'pin_code',
        'public'
    ];

    protected $nullable = ['uuid'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
        'remember_token',
    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/users/'.$this->getKey());
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function registerMediaCollections(): void {
        $this->addMediaCollection('avatar')
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();
    }

}
