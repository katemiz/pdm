<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Models\Company;


class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    use InteractsWithMedia;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'lastname',
        'email',
        'password',
        'status',
        'notes'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function getFullnameAttribute($value) {
        return $this->name.' '.strtoupper($this->lastname);
    }


    public function getCompanyNameAttribute($value) {
        return Company::find($this->company_id)->name;
    }


    public function getCompanyObjectAttribute($value) {
        return Company::find($this->company_id);
    }


    public function getCompanyProjectsAttribute($value) {
        return Company::find($this->company_id)->projects;
    }


    public function projects()
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }










    public static function getTableModel() {

        return  [

            'id' => [
                'label' => 'No',
                'visibility' => false,
                'sortable' => false,
                'wrapText' => true,
                'hasViewLink' => false,
            ],


            'name' => [
                'label' => 'Name',
                'visibility' => true,
                'sortable' => true,
                'wrapText' => false,
                'hasViewLink' => true,
            ],

            'lastname' => [
                'label' => 'Lastname',
                'visibility' => true,
                'sortable' => true,
                'wrapText' => true,
                'hasViewLink' => true,
            ],

            'company_id' => [
                'label' => 'Company',
                'visibility' => false,
                'sortable' => false,
                'wrapText' => true,
                'hasViewLink' => false,
            ],

            'email' => [
                'label' => 'E-Mail',
                'visibility' => true,
                'sortable' => true,
                'wrapText' => true,
                'hasViewLink' => false,
            ],


            'status' => [
                'label' => 'Status',
                'visibility' => true,
                'sortable' => false,
                'wrapText' => true,
                'hasViewLink' => false,
            ],


            'created_at' => [
                'label' => 'Created At',
                'visibility' => true,
                'sortable' => true,
                'wrapText' => true,
                'hasViewLink' => false,
            ],

            'updated_at' => [
                'label' => 'Updated At',
                'visibility' => false,
                'sortable' => false,
                'wrapText' => true,
                'hasViewLink' => false,
            ],

        ];
    }











}
