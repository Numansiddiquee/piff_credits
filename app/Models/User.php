<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'phone',
        'name',
        'company_name',
        'company_id',
        'email',
        'password',
        'plain_hash',
        'login_type',
        'user_type'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function freelancerQuotes()
    {
        return $this->hasMany(Quote::class, 'user_id');
    }

    public function clientQuotes()
    {
        return $this->hasMany(Quote::class, 'client_id');
    }


    public function freelancerInvoices()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }

    public function clientInvoices()
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }

    public function getTotalInvoicesAttribute()
    {
        return $this->role === 'freelancer'
            ? $this->freelancerInvoices()->count()
            : $this->clientInvoices()->count();
    }

    public function getTotalQuotesAttribute()
    {
        return $this->role === 'freelancer'
            ? $this->freelancerQuotes()->count()
            : $this->clientQuotes()->count();
    }

    public function freelancerClients()
    {
        return $this->hasMany(FreelancerClient::class, 'freelancer_id');
    }

    public function clientFreelancers()
    {
        return $this->hasMany(FreelancerClient::class, 'client_id');
    }

    public function getActiveClientsCountAttribute()
    {
        return $this->freelancerClients() // freelancer_id = this user
            ->where('status', 'active')
            ->distinct('client_id')
            ->count('client_id');
    }

    /**
     * Count of ACTIVE freelancers for a client
     */
    public function getActiveFreelancersCountAttribute()
    {
        return $this->clientFreelancers() // client_id = this user
            ->where('status', 'active')
            ->distinct('freelancer_id')
            ->count('freelancer_id');
    }

}
