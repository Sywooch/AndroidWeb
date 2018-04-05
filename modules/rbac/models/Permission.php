<?php

namespace modules\rbac\models;

use Yii;
use yii\base\Model;
use modules\rbac\Module;

/**
 * Class Permission
 * @package modules\rbac\models
 */
class Permission extends Model
{
    // permission
    const PERMISSION_VIEW_ADMIN_PAGE = 'viewAdminPage';
    const PERMISSION_VIEW_ADMIN_PAGE_DESCRIPTION = 'Access to the admin area';

    const PERMISSION_MANAGER_RBAC = 'managerRbac';
    const PERMISSION_MANAGER_RBAC_DESCRIPTION = 'Access to RBAC management';

    const PERMISSION_MANAGER_USERS = 'managerUsers';
    const PERMISSION_MANAGER_USERS_DESCRIPTION = 'Access to Users management';

    const PERMISSION_MANAGER_POST = 'managerPosts';
    const PERMISSION_MANAGER_POST_DESCRIPTION = 'Access to Posts management';

    // editing only their posts
    const PERMISSION_UPDATE_OWN_POST = 'updateOwnPost';
    const PERMISSION_UPDATE_OWN_POST_DESCRIPTION = 'Editing your own post';

    // scenarios
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $name;
    public $description;
    public $isNewRecord = false;

    /** @var  array $permissions Set permissions for the role */
    public $permissions;
    /** @var array $permissionItems Resolutions */
    public $permissionItems;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required', 'on' => self::SCENARIO_CREATE],
            ['name', 'string', 'max' => 64, 'on' => self::SCENARIO_CREATE],
            ['name', 'match', 'pattern' => '#^[\w_-]+$#i', 'message' => Module::t('module', 'It is allowed to use the Latin alphabet, numbers, dashes and underscores.(A-z,0-1,-,_)'), 'on' => self::SCENARIO_CREATE],
            ['name', 'validateUniqueName', 'skipOnEmpty' => false, 'skipOnError' => false, 'on' => [self::SCENARIO_CREATE]],

            [['description'], 'string'],
            [['permissionItems', 'permissions'], 'required', 'message' => Module::t('module', 'You must select in the field «{attribute}».'), 'on' => self::SCENARIO_UPDATE],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateUniqueName($attribute, $params)
    {
        if (!empty($this->name) && !$this->hasErrors()) {
            if ($this->$attribute) {
                $auth = Yii::$app->authManager;
                if ($auth->getPermission($this->name)) {
                    $this->addError($attribute, Module::t('module', 'This name is already taken.'));
                }
            } else {
                $this->addError($attribute, Module::t('module', 'Enter name permission.'));
            }
        }
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'description'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'description', 'permissionItems', 'permissions'];
        return $scenarios;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'Name'),
            'description' => Module::t('module', 'Description'),
            'rolesByPermission' => Module::t('module', 'Roles by permission'),
            'itemsRoles' => Module::t('module', 'Items roles'),
            'permissions' => Module::t('module', 'Permissions by role'),
            'permissionItems' => Module::t('module', 'Items permissions'),
        ];
    }

    /**
     * Returns children permission for the current permission
     * @return \yii\rbac\Permission[]
     */
    public function getPermissionChildren()
    {
        $auth = Yii::$app->authManager;
        $perm = $auth->getChildren($this->name);
        $arr = [];
        foreach ($perm as $value) {
            if ($value->name != $this->name) {
                $arr[$value->name] = $value->name . ' (' . $value->description . ')';
            }
        }
        return $arr;
    }

    /**
     * Returns all permissions
     * @return array
     */
    public function getItemsPermissions()
    {
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermissions();
        $arr = [];
        foreach ($perm as $value) {
            if ($value->name != $this->name) {
                $arr[$value->name] = $value->name . ' (' . $value->description . ')';
            }
        }
        $permChild = $this->getPermissionChildren();
        return array_diff($arr, $permChild);
    }
}