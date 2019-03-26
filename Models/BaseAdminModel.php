<?php

namespace BasicApp\Admin\Models;

use BasicApp\Core\AuthInterface;

abstract class BaseAdminModel extends \BasicApp\Core\Model implements AuthInterface
{

    use AdminAuthTrait;

	const ADMIN_ROLE = 'admin';

	protected $table = 'admins';

	protected $primaryKey = 'admin_id';

	protected $returnType = Admin::class;

	protected $useTimestamps = true;

	protected $createdField = 'admin_created_at';

	protected $updatedField = 'admin_updated_at';

    protected $labels = [
        'admin_id' => 'ID',
        'admin_email' => 'E-mail',
        'admin_name' => 'Name',
        'admin_avatar' => 'Avatar',
        'admin_role_id' => 'Role',
        'admin_created_at' => 'Created At',
        'admin_updated_at' => 'Updated At'
    ];

    protected $translations = 'admin';
    
	public static function install()
	{
		static $installed = false;

		if ($installed)
		{
			return;
		}

		$installed = true;

		AdminRoleModel::install();

		$adminsCount = static::factory()->countAllResults();

		if ($adminsCount > 0)
		{
			return;
		}

		$role = AdminRoleModel::getRole(static::ADMIN_ROLE);

        $model = static::factory();

		$model->protect(false);

		$model->insert([
			'admin_role_id' => $role->role_id,
			'admin_name' => 'admin',
			'admin_password_hash' => static::encodePassword('admin')
		]);

		$model->protect(true);
	}

    public static function userHasRole($user, string $role)
    {
        $model = static::getUserRole($user);

        if ($model && ($model->role_uid == $role))
        {
            return true;
        }

        return false;
    }    

    public static function getUserRole($user)
    {
        return AdminRoleModel::factory()->where('role_id', $user->admin_role_id)->first();
    }

}