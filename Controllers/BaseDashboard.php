<?php
/**
 * @package Basic App Admin
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Admin\Controllers;

use BasicApp\Admins\Models\Admin\AdminModel;

abstract class BaseDashboard extends \BasicApp\Admin\AdminController
{

    protected static $roles = [self::ROLE_ADMIN];

    protected $viewPath = 'BasicApp\Admin\Dashboard';

    protected $returnUrl = 'admin/dashboard';

    public function index()
    {
        return $this->render('index');
    }

}