<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    // このサイトをポートフォリオとして公開している場合、主管理者の情報は変更できないようにする。
    public function is_admin_and_portfolio()
    {
        if(config('const.AUTH.IS_PORTFOLIO') === true && $this->id === config('const.ID.MASTER_ADMIN'))
        {
            session()->flash('message', '現在、主管理者の情報は変更できないようになっています。');
            return true;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    
}
